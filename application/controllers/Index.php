	<?php
	defined('BASEPATH') OR exit('No direct script access allowed');


	class Index extends CI_Controller {


		public function __construct(){
			parent::__construct();
			$this->load->model(['product','chat']);
		}
//main public page
		public function index(){
			//find a searched products in navbar live search
			if($search = $this->input->post('search')){
				//a selected category in the navbar select dropdown
				$category = $this->input->post('category');
				// find all products where a name, category or description contains a query from navbar
				$where = $this->product->filter_by_query($search) ;
				$search_results = $this->product->get_filtered($where);
				echo json_encode($search_results);
			} else
			{
				//load the most popular products
				$popular_products = $this->product->get_popular(['Sport','Artistic','Practical','Technology','Creative'],3);
				$discount_products = $this->product->with_biggest_discounts(6);
				$data['discount_products'] = $discount_products;
				$data['popular_products'] = $popular_products;
				//load a view
				$this->load->template('index',$data);
			}
		}
//search page with all filters
		public function search(){

			$this->load->library('Ajax_pagination');

			//pagination configuration
			$config['target']      = '.product_list';
			$config['base_url']    = base_url('index/ajaxProducts');
			$config['per_page']    = 12;
			$config['uri_segment'] = 3;
			
			//load all filtered products
			if($this->input->post('filter_products')){
				$where = $this->product->search_params();
				$totalRec = $this->db->where($where)->from('products')->count_all_results();
				$data['products'] = $this->product->advanced_search($config['per_page']);
			} 
			//load all products
			else {
				//total rows count
				$totalRec = $this->product->count_all();
				$data['products'] = $this->product->get_all($config['per_page']);
			}
			//initialize pagination
			$config['total_rows']  = $totalRec;
			$this->ajax_pagination->initialize($config);
			//load a view
			$this->load->template('search',$data);
		}

//ajax for products in the /search page
		function ajaxProducts(){

			$this->load->library('Ajax_pagination');

			 //find a current page
			$page = $this->input->post('page');
			if(!$page){
				$offset = 0;
			}else{
				$offset = $page;
			}
			//get a number of products for pagination
			if($this->input->post('filter_products')){
				//filtered products
				$where = $this->product->search_params();
				$totalRec = $this->db->where($where)->from('products')->count_all_results();
			} 
			else {
				//all products
				$totalRec = $this->product->count_all();
			}

	        //pagination configuration
			$config['target'] = '.product_list';
			$config['base_url']    = base_url('index/ajaxProducts');
			$config['total_rows']  = $totalRec;
			$config['per_page']    = 12;
			$config['uri_segment']    = 3;
			$this->ajax_pagination->initialize($config);

			//order products by price or average rating
			if($order_by = $this->input->post('order_by')){
				
				if($order_by == 'price_asc'){
					$this->db->order_by('price','ASC');
				} else if($order_by == 'price_desc'){
					$this->db->order_by('price','DESC');
				} else if($order_by == 'rating_asc'){
					$this->db->order_by('avg_rating','ASC');
				} else if($order_by == 'rating_desc'){
					$this->db->order_by('avg_rating','DESC');
				}
			}

			//get filtered products
			if($this->input->post('filter_products')){
				$where = $this->product->search_params();
				$data['products'] = $this->product->advanced_search($config['per_page'],$offset);
			} 
			else {
				//get all products
				$data['products'] = $this->product->get_all($config['per_page'],$offset);
			}

	        //load a view
			$this->load->view('public/ajaxProducts',$data);
		}
//cart page
		public function cart(){

			$data = null;
			//get data about products in the cart
			$data['products_in_cart'] = $this->product->in_cart()['products'];
			$data['quantity_in_cart'] = $this->product->in_cart()['quantity_total'];
			//load a view
			$this->load->template('cart',$data);
		}
//checkout page
		public function checkout(){

			$this->load->model(['customer','address','order']);
			//get data about products in the cart
			$data['products_in_cart'] = $this->product->in_cart()['products'];
			$data['quantity_in_cart'] = $this->product->in_cart()['quantity_total'];
			//redirect back to the cart if the cart is empty
			if($data['quantity_in_cart'] == 0) redirect(base_url('cart'));

			//process the payment after a customer fills out a form
			if($this->input->post('payment') !== null){
				//process the order
				$this->order->process();
				$this->session->set_flashdata('payment_success','true');
				$this->session->set_flashdata('products_bought',$data['products_in_cart']);
				//empty the cart
				delete_cookie('cart','japege.herokuapp.com');
				delete_cookie('quantity_cart','japege.herokuapp.com');
				//redirect to a customer's profile if logged in
				if($this->session->customer_id){
					redirect(base_url('my_profile'));
					//redirect to the page will all products if not logged in
				} else {
					redirect(base_url('search'));
				}
			}
			//set the address fields to empty strings 
			foreach ($this->address->editable_fields as $field) {
				$address[$field] = '';
			}
			$data['address'] = $address;
			//set the actual address if a customer saved it in his profile
			$customer_id = $this->session->customer_id;
			if($address = $this->customer->get_address($customer_id)){
				$data['address'] = $address;
			}
			//save a cart page't url in case a customer logs in at checkout
			$this->session->set_userdata('redirect', base_url(uri_string()));
			//load a view
			$this->load->template('checkout',$data);
		}
//page with information about a product
		public function product($id){

			$this->load->model('review');
			$this->load->helper('image');
			$this->load->library('Ajax_pagination');

		//create a new review
			if($this->input->post()){
				$this->review->add_new();
			}

			//load product data, its reviews and create pagination
			if($data['product'] = $this->product->get_by_id($id)){
			//total rows count
				$totalRec = $this->db->where('product_id',$id)->from("comments")->count_all_results();
	        //pagination configuration
				$config['target']      = '#reviews';
				$config['base_url']    = base_url('index/ajaxReviews/'.$id);
				$config['total_rows']  = $totalRec;
				$config['per_page']    = 3;
				$this->ajax_pagination->initialize($config);
	         //get the reviews data
				$where = 'product_id = '.$id;
				$data['reviews'] = $this->review->get_reviews($where, $config['per_page']);

	        //load a view
				$this->load->template('product',$data);

			} else {
				//redirect to the main page if a product does not exist
				redirect(base_url());
			}
			//save a product's url in case a customer logs in on this page
			$this->session->set_userdata('redirect', base_url(uri_string()));
		}

//ajax for a product's reviews 
		function ajaxReviews($product_id){

			$this->load->model('review');
			$this->load->library('Ajax_pagination');
			$page = $this->input->post('page');
			$filter = $this->input->post('filter');
			$where = '';
			//find a current page
			if(!$page){
				$offset = 0;
			}else{
				$offset = $page;
			}
			//load positive or negative reviews if selected
			if($filter == 'positive'){
				$this->db->where('rating >',2);
				$where .= 'rating > 2 AND ';
			} elseif($filter == 'negative') {
				$this->db->where('rating <',3);
				$where .= 'rating < 3 AND ';
			}
			//pagination configuration
			$totalRec = $this->db->where('product_id',$product_id)->from("comments")->count_all_results();
			$config['target']      = '#reviews';
			$config['base_url']    = base_url('index/ajaxreviews/'.$product_id);
			$config['total_rows']  = $totalRec;
			$config['per_page']    = 3;
			$this->ajax_pagination->initialize($config);
	        //get the reviews data
			$where .= ' product_id = '.$product_id;
			$data['reviews'] = $this->review->get_reviews($where, $config['per_page'],$offset);
	        //load a view
			$this->load->view('public/ajaxreviews',$data);
		}

//login page
		public function login($soMe = null){

			$this->load->model(['customer','login']);

		//fb api used to log in
			if($soMe == 'fb'){
				$this->login->fb_login();
		//google api used to log in
			} else if($soMe == 'google'){
				$this->login->google_login();
			}
		//login without SoMe
			if($this->input->post('submit')){
				$this->login->validate('customers');
			} 
			//load a view
			$this->load->template('login',$data = null);
		}
//customer logout
		public function logout(){

			$this->login->log_out('customer');
			redirect(base_url());
		}
//customer registration page
		public function register(){

			$this->load->model('customer');
			if($this->input->post('submit')){
				//log in a customer and redirect to the main page if registration is successful
				if($this->customer->add()){	
					$this->login->customer_log_in($this->db->insert_id(),false);
					redirect(base_url());
				}
			}
			//load a view
			$this->load->template('register',$data=null);
		}
	}
	?>