<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Admin extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('admininfo');
	}

//admin login page
	public function login()
	{
		$data = null;
		//validate admin login data
		if($this->input->post('submit')){
			$this->login->validate('admins');
		}
		//load views for /admin/login page
		$this->load->view('admin/login',$data);
		$this->load->view('templates/admin/footer',$data);
	}

	//log out an admin
	public function logout(){
		$this->login->log_out('admin');
		redirect(base_url('admin/login'));
	}


//list of all admins
	public function admins(){
		//load all admins
		$data['admins'] = $this->admininfo->get_all();
		//load a view
		$this->load->admin_template('admins',$data,true);
	}

//information about a single admin
	public function admin_details($admin_id){
		//redirect to the list of all admins if a selected admin does not exist
		if(!($data = $this->admininfo->get_by_id($admin_id))) redirect(base_url('admin/admins'));

		//edit admin information
		if($this->input->post()){
			//try to edit an admin a set a message about success or failure
			$messsage = $this->admininfo->edit($admin_id) ? "Admin edited successfully" : "Failed to edit this admin";
			$this->session->set_flashdata('message',$messsage);
			redirect($this->uri->uri_string());
		}
		//load a view
		$this->load->admin_template('admin_details',$data,true);
	}

//delete an admin
	public function delete_admin($admin_id){
		$this->admininfo->delete($admin_id) ? redirect(base_url('admin/admins')) : redirect(base_url('admin/admin_details/'.$admin_id));
	}

//add a new admin
	public function add_admin(){

		if($this->input->post()){
			//try to add a new admin and set a message
			$messsage = $this->admininfo->add() ? "Admin added successfully" : "Failed to add a new admin";
			$this->session->set_flashdata('message',$messsage);
			redirect($this->uri->uri_string());
		}
		//load a view
		$this->load->admin_template('add_admin', null, true);
	}

}