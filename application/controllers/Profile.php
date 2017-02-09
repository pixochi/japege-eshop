<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Profile extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->login->is_customer_logged();
		$this->load->model('customer');
	}

//page for each user
	public function user($id){

		$this->load->helper('image');
		//get customer info
		$data['user'] = $this->customer->get_by_id($id);
		//redirect to the main page if a customer does not exist
		if(empty($data['user'])) redirect(base_url());
		//get a customer's image
		$data['user']['image'] = user_image($data['user']);
		//get products owned by a customer
		$data['owned_products'] = $this->product->get_owned($id);
		//load a view
		$this->load->template('user_profile',$data);
	}

//an overview of products owned by a logged in customer
	public function my_profile(){

		$this->load->helper('image');
		//find users who owned the same product as a logged in customer
		if($product_id = $this->input->post('product_id')){

			$this->db->select(['id','first_name','last_name','image'])->from('customers');
			$this->db->like('owned',$product_id);
			$this->db->where_not_in('id', [$this->session->customer_id]);

			$users = $this->db->get()->result();
			echo json_encode($users);
		} //load only products owned by a logged in customer
		else {

			$data['owned_products'] = $this->product->get_owned($this->session->customer_id);
			$data['image'] = profile_image();
			//load a view
			$this->load->profile_template('my_profile',$data);
		}

	}

//page for editing a customer's profile
	public function edit_profile(){

		$this->load->helper(['form','image']);
		$this->load->model('address');

		$data['image'] = profile_image();
		//profile editing
		if($customer_id = $this->input->post('customer_id')){
			//try to edit a customer's profile
			$success = $this->customer->edit($customer_id) ? true : false;

			$address_exists = $this->db->get_where('address',['customer_id' => $customer_id])->num_rows();
			//add a new address if a customer does not have it yet or just edit an existing address
			if($address_exists > 0){
				$success = $this->address->edit($customer_id,'address') ? true : false;
			} else {
				$success = $this->address->add() ? true : false;
			}
			//load a customer's data
			$customer_info = $this->customer->get_customer_info($customer_id);
			$this->session->set_userdata($customer_info);
			//set a message about success or failure
			$message = $success ? "Your profile has been successfully edited." : "Sorry, but something went wrong and we couldn't edit your profile. Try it later.";
			$this->session->set_flashdata('message',$message);	
			redirect(base_url('edit_profile'));		
		}
		foreach ($this->address->editable_fields as $field) {
			$address[$field] = '';
		}

		$data['address'] = $address;
		$customer_id = $this->session->customer_id;
		if($address = $this->customer->get_address($customer_id)){
			$data['address'] = $address;
		}
		//load a view
		$this->load->profile_template('edit_profile',$data);
	}

//page with all messages
	public function messages(){

		$this->load->helper(['image']);
		$this->load->model(['address','chat']);
		//set a customer's profile image
		$data['image'] = profile_image();
		//get inbox
		$data['inbox_units'] = $this->chat->get_inbox();
		//check if a user has some new messages
		$data['unseen_chats'] = $this->chat->has_new_messages();
		//display information about users who sent messages to a logged in user
		if(!empty($data['inbox_units'])){
			$data['chat_id'] = $data['inbox_units'][0]['chat_id'];
			$data['user_image'] = user_image($data['inbox_units'][0]);
			//2nd parameter is true because we need to load all messages
			$data['messages'] = json_decode($this->_get_messages($data['chat_id'],true));
		} 
		//load a view
		$this->load->profile_template('messages',$data);
	}
//sent a new message
	function ajax_add_message(){

		$this->load->model('chat');
		//get a user's id
		$to_user = $this->input->post('to_user');
		//2nd parameter is true for XSS cleaning
		$content = $this->input->post('message_content',true);
		//get an id of a logged in user
		$my_id = $this->session->customer_id;
		//sent a new message and display it
		$this->db->select('chat_id')
		->where(['from_user'=>$my_id, 'to_user'=>$to_user])
		->or_where('(from_user = '.$this->db->escape($to_user).' AND to_user = '.$this->db->escape($my_id).')');
		$chat_id = $this->db->get('messages',0,1)->row()->chat_id;

		$this->chat->add_message($to_user,$content);
		echo $this->_get_messages($chat_id);
	}

//check if there are new messages
	function ajax_get_messages(){

		$chat_id = $this->input->post('chat_id');
		$load_all = $this->input->post('all');

		echo $this->_get_messages($chat_id,$load_all);
	}

	function _get_messages($chat_id,$all_messages = false){

		$this->load->model(['chat','address']);
		//first load all messages and then only new ones
		$last_message_id = $all_messages == 'true' ? 0 : (int)$this->session->userdata('last_message_id_'.$chat_id);
		//load messages
		$messages_data = $this->chat->get_messages($chat_id,$last_message_id);
		//display messages if there are any
		if(count($messages_data['messages']) > 0){
			//find id of a last message
			$last_message_id = $messages_data['messages'][count($messages_data['messages']) - 1]->id;
			//message was seen
			$this->db->set('seen',1)->where('chat_id',$chat_id)->where('to_user',$this->session->customer_id)->update('messages');
			//save an id of the last seen message in session
			$this->session->set_userdata('last_message_id_'.$chat_id,$last_message_id);

			return json_encode($messages_data);
		}
	}

	//check if a new message arrived
	public function ajax_check_inbox(){
		echo $this->_check_inbox();
	}

	function _check_inbox(){
		$this->load->model('chat');
		$unseen_chats = $this->chat->has_new_messages();
		return json_encode($unseen_chats);
	}
}