<?php
class Dbobject extends CI_Model{


	public function __construct()
	{
		parent::__construct();
	}

//get all rows from a selected table
	public function get_all($limit = null,$offset = null){
		$dataset = $this->db->get($this->db_table,$limit,$offset);
		return $dataset->result();
	}

//count all rows in a selected table
	public function count_all(){
		return $this->db->count_all_results($this->db_table);
	}

//find a specific row in a selected table by id
	public function get_by_id($id){

		$query = $this->db->get_where($this->db_table,['id' => $id],1);
		if($query->num_rows() > 0){
			$result = $query->result()[0];

			return get_object_vars($result);
		}
		return false;
	}
//return filtered rows from a selected table
	function get_filtered($where,$limit = null,$offset = null){

		$this->db->order_by('id','DESC');
		$query = $this->db->get_where($this->db_table,$where,$limit,$offset);

		return $query->result();
	}

//add a new row to a selected table
	public function add(){
		//prepare an array of data for adding to a DB table
		$data = $this->instantiate();

		$this->db->insert($this->db_table,$data);
		//save an image if a product is added
		if($this->db_table == 'products' && $this->db->affected_rows() > 0){
			$insert_id = $this->db->insert_id();
			$this->save_img($insert_id,true,$this->db_table);
		}

		return $this->db->affected_rows() > 0 ? true : false;
	}


//edit a specific row in a selected table
	public function edit($id,$object = null){
		//prepare an array of data for adding to a DB table
		$data = $this->instantiate();
		//edit a customer_id if an adress is edited
		if($object == "address"){
			$this->db->update($this->db_table,$data,['customer_id' => $id]);
		} else {
			$this->db->update($this->db_table,$data,['id' => $id]);
		}
		//upload an image to a server if a new row was successfully edited
		if($this->db->affected_rows() >= 0){
			if(!empty($_FILES['image']['name'])){
				$this->save_img($id,false,$this->db_table);
			}
			return true;
		}
		return false;
	}
//delete a row from a selected table
	public function delete($id){
		$this->db->delete($this->db_table,['id' => $id],1);
		//set a message whether an item was successfully deleted or not
		if($this->db->affected_rows() > 0){
			$message =  'Successfully deleted';
			$this->session->set_flashdata(['message' => $message]);
			return true;
		} else {
			$message =  'Failed to delete';
			$this->session->set_flashdata(['message' => $message]);
			return false;
		}
	}

//prepare data before adding to DB or updating items in DB 
	public function instantiate(){

		foreach ($this->editable_fields as $field)
		{
			if(!empty($post_field = $this->input->post($field))) {
				if($field == "bio") $post_field = strip_tags($post_field);
				$data[$field] = $post_field;	
			}
			if($field == 'image' && !empty($_FILES['image']['name'])) {
				$data[$field] = preg_replace('/[^A-Za-z0-9.-]/', "", $_FILES['image']['name']);
			}
		}
		//hash a password before it is saved to DB
		if(!empty($data['password'])) $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT, ['cost' => 11]);

		return $data;
	}

//upload an image to server
	public function save_img($id,$new_item,$object){
		//choose a directory for product or customer images
		if($object == 'products'){
			$directory = './assets/images/uploads/products/';
		} else if($object == 'customers') {
			$directory = './assets/images/uploads/customers/';
		}
		//create a directory for a customer or a product if it does not exist yet
		if (!is_dir($directory.$id)) {
			mkdir($directory.$id, 0777, TRUE);
		}
		//image upload configuration
		$upload_path = $directory.$id;
		$config = array(
			'upload_path'   => $upload_path,
			'allowed_types' => 'gif|jpg|jpeg|png|bmp|svg',
			'max_size'      => 0,
			'overwrite'     => TRUE,
			'file_name'     => preg_replace('/[^A-Za-z0-9.-]/', "", $_FILES['image']['name'])
			);
		$this->load->library('upload', $config);

		//set a message in case of failure
		if ( ! $this->upload->do_upload('image'))
		{
			$this->session->set_flashdata('message_img','Failed to upload a photo');
		}
		//success
		else
		{
			$data = array('upload_data' => $this->upload->data());
		}
	}
}
?>