<?php
require_once('Dbobject.php');
class Order extends Dbobject{

	public $id;
	public $customer_id;
	public $order_date;
	public $required_date;
	public $ship_date;
	public $ship_name;
	public $ship_street;
	public $ship_city;
	public $ship_zip_code;
	public $db_table = "orders";
	public $editable_fields = ['ship_first_name','ship_last_name','ship_street','ship_zip_code','ship_city','ship_country'];

	public function __construct(){
		parent::__construct();

	}
//process a new order
	public function process(){

		$CI =& get_instance();
	 	//prepare date for inserting
		$data = $this->instantiate();
		//save a customer's id and a date when the order is placed
		$data['customer_id'] = !empty($this->session->customer_id) ? $this->session->customer_id : "";
		$data['order_date'] = strftime("%Y-%m-%d %H:%M:%S",time());

		$this->db->insert($this->db_table,$data);

		//update product data if the order is successful
		if($this->db->affected_rows() > 0){
			$data = [];
			$order_id = $this->db->insert_id();
			$products_in_cart = $CI->product->in_cart()['products'];

			foreach ($products_in_cart as $product) {
				$product_quantity = $CI->product->in_cart()['quantity_total'][$product->id];;
				//save a product's quantity from the cart
				$update_product['id'] = $product->id;
				$update_product['quantity'] = $product_quantity;
				//save order details
				$order_details['order_id'] = $order_id;
				$order_details['product_id'] = $product->id;
				$order_details['unit_price'] = $product->price;
				$order_details['quantity'] = $product_quantity;
				$order_details['receipient_age'] = $this->session->age;
				
				$data[] = $order_details;
				$update_products[] = $update_product;
			}
			//insert all order details to DB
			$this->db->insert_batch('order_details', $data);
			foreach ($update_products as $product) {
			 	//calculate product's quantity in DB
				$quantity = 'quantity - '. $product['quantity'];
			 	//update a number of sold products
				$amount_sold = 'amount_sold + '.$product['quantity'];
			 	//get a customer's age if it is saved in their profile
				$curr_time = new DateTime(strftime("%Y-%m-%d",time()));
				if($this->session->birthdate){
					$birthdate = new DateTime($this->session->birthdate);
					$customer_age = abs($birthdate->diff($curr_time)->y); 
			 	} else { //get an average age of a buyer if a customer does not have a saved age
			 		$this->db->select(['amount_sold','age_total'])->from('products')->where('id',$product['id']);
			 		$row = $this->db->get()->row();
			 		$customer_age = $row->age_total/$row->amount_sold;
			 	}
			 	//update product's data in DB
			 	$age_total = 'age_total + '. $customer_age*$product['quantity'];
			 	$this->db->set('age_total',$age_total,FALSE);
			 	$this->db->set('amount_sold',$amount_sold,FALSE);
			 	$this->db->set('quantity',$quantity,FALSE);
			 	$this->db->where('id',$product['id']);
			 	$this->db->update('products');
			 	$this->db->reset_query();
			 	//update customer's owned products
			 	if(isset($this->session->customer_id)){
			 		$this->db->query("update customers set owned=concat(owned, '".",".$product['id']."') where id = '".$this->session->customer_id."'");
			 	}
			 	$this->db->reset_query();
			 }
			}
		}

//get details about an order
		public function get_all_order_details($order_id){
		//redirect to all orders if an order_id does not exist
			if($order_id == null) redirect(base_url('order_control/orders'));

			$query = $this->db->get_where('order_details',['order_id' => $order_id]);
			if($query->num_rows() > 0){
				$this->load->model('product');
				$CI =& get_instance();
				$result['order_details'] = $query->result();

				for ($i = 0; $i < count($result['order_details']); $i++)
				{
					$products[] =$CI->product->get_details($result['order_details'][$i]->product_id);
				}

				$result['products_info'] = $products;

				return $result;
		} else { //redirect to all orders if a selected order does not exist
			redirect(base_url('order_control/orders'));
		}
	}
}

?>