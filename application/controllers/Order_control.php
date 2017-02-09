<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Order_control extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('order');
	}
//list of all orders
	public function orders(){
		//load all orders
		$data['orders'] = $this->order->get_all();
		//load a view
		$this->load->admin_template('orders',$data,true);
	}

//list of ordered products in a single order
	public function order_details($order_id){
		$data = null;

		//get all data about an order
		$all_info = $this->order->get_all_order_details($order_id);
		//info about an order
		$data['order_details'] = $all_info['order_details'];
		//info about a customer who made the order
		$data['products_info'] = $all_info['products_info'];
		//load a view
		$this->load->admin_template('order_details',$data,true);
	}
}
?>