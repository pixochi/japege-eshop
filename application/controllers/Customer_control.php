	<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	class Customer_control extends CI_Controller {

		public function __construct(){
			parent::__construct();
			$this->load->model('customer');
		}
//list of all registered customers
		public function customers(){
		//load all customers
			$data['customers'] = $this->customer->get_all();
		//load a view
			$this->load->admin_template('customers',$data,true);
		}

//information about a single customer
		public function customer_details($customer_id){

			$this->load->helper('form');
			$this->load->model('address');
		//edit a customer info
			if($this->input->post()){
			//try to edit a customer's profile
				$success = $this->customer->edit($customer_id) ? true : false;
			//check if a customer has an address saved
				$address_exists = $this->db->get_where('address',['customer_id' => $customer_id])->num_rows();

				if($address_exists > 0){
					//edit the address if it already exists
					$success = $this->address->edit($customer_id,'address') ? true : false;
				} else {
					//add a new address if a customer does not have it saved
					$success = $this->address->add() ? true : false;
				}
				//check if a customer profile was edited successfully
				$message = $success ? "Successfully edited." : "Failed to edit.";
				$this->session->set_flashdata('message',$message);		

				redirect(base_url('customer_control/customer_details/'.$customer_id));		
			}
			//load information about a customer
			$data = $this->customer->get_customer_info($customer_id);
			$data['customer_id'] = $customer_id;
			//load a view
			$this->load->admin_template('customer_details',$data,true);
		}
	}
	?>