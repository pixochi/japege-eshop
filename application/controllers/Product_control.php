<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product_control extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('product');
	}

//*list of all available products 
	public function index(){

		//load all products
		$data['products'] = $this->product->get_all();
		//load a view
		$this->load->admin_template('index',$data,true);
	}

//*add a new product
	public function add_product(){

		$this->load->helper('form');
		//process data from a form if the form was submitted
		if($this->input->post()){
			//try to add the product and set a message about success or failure
			$messsage = $this->product->add() ? "Product added successfully - <a href='".base_url('product_control/product_details/'.$this->db->insert_id())."''>details here</a>" : "Failed to add a new product";
			$this->session->set_flashdata('message',$messsage);
			redirect($this->uri->uri_string());
		}
		//load a view
		$this->load->admin_template('add_product',null,true);
	}

//*an overview of a single product
	public function product_details($product_id){
		//redirect to the main page if a selected product does not exist
		if($product_id == null) redirect(base_url('product_control/products'));
		$data = null;

		$this->load->helper('form');
		//process the submitted form to edit a product
		if($this->input->post()){
			//set a message about success or failure
			$message = $this->product->edit($product_id) ? 'Product edited successfully' : 'Failed to edit a product';
			$this->session->set_flashdata('message',$message);
		}
		//get information about the edited product
		$data = $this->product->get_details($product_id);
		//load a view
		$this->load->admin_template('product_details',$data,true);

	}

//*delete a selected product
	public function delete_product($product_id){
	//try to delete a product
		$this->product->delete($product_id) ? redirect(base_url('product_control/products')) : redirect('product_control/product_details/'.$product_id);
	}
}
?>