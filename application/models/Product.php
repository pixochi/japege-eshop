<?php

require_once('Dbobject.php');
class Product extends Dbobject{

	public $id;
	public $name;
	public $category;
	public $price;
	public $quantity;
	public $image;
	public $description;
	public $avg_rating;
	public $amount_sold;
	public $categories = ['sport','technology','creative','artistic','practical'];
	public $groups = ['kids'=>[0,13],'teens'=>[14,25],'adults'=>[26,40],'elderly'=>[41,120]];
	protected $db_table = "products";
	protected $editable_fields = ["name","category","price","discount_percentage","discount_finish","quantity","image","description"];

	public function __construct(){
		parent::__construct();
	}


//get information about a selected product
	public function get_details($product_id){

		$query = $this->db->get_where($this->db_table,['id' => $product_id],1);
		if($query->num_rows() > 0){
			$result = $query->result()[0];
			$product_vars = get_object_vars($result);

			foreach($product_vars as $name => $value){
				$product[$name] = $value;
			}
			return $product;
		} else {
			redirect('admin');
		}
	}

//find a selected number of popular products from each category
	public function get_popular($categories = array(),$number){

		$where = "";
		//choose products from chosen categories
		foreach ($categories as $category)
		{
			$this->db->or_where('category',$category);
		}
		$this->db->order_by('avg_rating','DESC');
		$all_products = $this->db->get('products')->result();

		foreach ($all_products as $product)
		{
			if(in_array($product->category,$categories)){
				$filtered_products[$product->category][] = $product;
			}
		}
		//get popular products for each category
		foreach ($filtered_products as $category => $product)
		{
			$sorted_products[$category] = array_slice($product,0,$number);
		}

		return $sorted_products;
	}


//get products with the biggest discounts

	public function with_biggest_discounts($quantity = 5){
		$this->db->select(['id','name','description','image','discount_percentage','discount_finish']);
		$this->db->where('discount_percentage!=',NULL);
		$this->db->where('discount_finish!=',NULL);
		$this->db->order_by('discount_percentage','DESC');
		$discount_products = $this->db->get('products',$quantity)->result();

		return $discount_products;
	} 

//get products owned by a customer
	public function get_owned($customer_id){
		$this->db->select('owned')->from('customers')->where('id',$customer_id);
		$product_ids = explode(",", $this->db->get()->row()->owned);
		$product_ids = array_unique($product_ids);
		$this->db->select(['id','name','image'])->from('products')->where('id',$product_ids[0]);
		if(count($product_ids) > 1){
			foreach ($product_ids as $product_id) {
				$this->db->or_where('id',$product_id);
			}
		}
		return $owned_products = $this->db->get()->result();
	}

//filter products by selected categories
	public function filter_by_category(){
		$check = 0;
		$where = '(';
		$categories = $this->product->categories;
		foreach ($categories as $category) {
			$this->session->unset_userdata($category);
			if($this->input->post($category)){
				$check++;
				$this->session->set_flashdata($category,$category);
				$this->db->escape($category);
				$where .= "category = '".$category."' OR ";
			} 
		}
		if($check > 0){
			$where = substr($where,0,strlen($where) - 3);
			return $where .= ")";
		}
	}

//filter products by a price range
	public function filter_by_price($where){

		$price = explode(',',$this->input->post('price'));

		$this->session->set_flashdata('price_bottom',intval($price[0]));
		$this->session->set_flashdata('price_top',intval($price[1]));
		$this->db->escape($price);
		if(!empty($where)) $where .=" AND";
		$where .= " price >= ".$price[0]." AND price <= ".$price[1];

		return $where;

	}

//filter products by an age group(kids,teens,...) 
	public function filter_by_age($where){
		$check = 0;
		$tmp = $where;
		if(!empty($where)) $where .= " AND (";

		$where .= "";
		foreach ($this->product->groups as $age_group => $age) {
			$this->session->unset_userdata($age_group);
			if($this->input->post($age_group)){
				$check++;
				$this->session->set_flashdata($age_group,$age_group);
				$where .= "((age_total/amount_sold) >= ".(int)$age[0];
				$where .= " && (age_total/amount_sold) <= ".(int)$age[1] . ") OR ";
			}
		}
		if($check > 0){
			$where = substr($where, 0, strlen($where) - 3);

			if(!empty($tmp)) $where .= " )";
			return $where;
		} else {
			return $tmp;
		}
	}

//filter by a text query
	public function filter_by_query($query, $where = null){

		$tmp = $where;
		$query = trim($query);
		$this->db->escape($query);
		if(!empty($where)) $where .= " AND ( ";
		$where .= " name LIKE '%".$query."%' OR description LIKE '%".$query."%' OR category LIKE '%".$query."%'";
		if(!empty($tmp)) $where .= " )";
		$this->session->set_flashdata('query', $query);
		return $where;
	}

//create a db query for filtered products
	public function search_params(){
		$this->session->unset_userdata('query');
		$where = $this->filter_by_category();
		$where = $this->filter_by_price($where);
		if($query = $this->input->post('query')){
			$where = $this->filter_by_query($query, $where);
		}
		$where = $this->filter_by_age($where);
		return $where;
	}

//use a db query and return filtered products
	public function advanced_search($limit = null,$offset = null){

		$where = $this->search_params();
		$results = $this->product->get_filtered($where,$limit,$offset);

		return $results;
	}

//get products in the cart
	public function in_cart(){

		$products_cookies = json_decode(get_cookie('cart',true));
		$price_total = 0;
		$where = '';
		//get products info if there are products in the cart
		if($products_cookies){
			foreach ($products_cookies as $index => $value) {
				$quantity_in_cart[$value->id] = $value->quantity;
				$id = $this->db->escape($value->id);
				$where .= "id = ".$id." OR ";
			}
			$where = substr($where, 0, strlen($where) - 3);

			$products = $this->get_filtered($where);
		// display products in the same order as a customer added them
			foreach ($products as $product) {
				foreach ($products_cookies as $value) {
					if($product->id == $value->id){

						$products_in_order[$value->order] = $product;
						break; 
					}
				}
			}
			ksort($products_in_order);
			$result['products'] = $products_in_order;
			$result['quantity_total'] = $quantity_in_cart;
			return $result;
		}
		return false;
	}

//check if a product is with a discount
	public function with_discount($product){

		$today_dt = new DateTime("now");
//find out if a discount is available 
		if(is_array($product)){
			if($product['discount_percentage'] != NULL && $product['discount_finish'] != NULL) {

				$expire_dt = new DateTime($product['discount_finish']);

				return $expire_dt > $today_dt ? round($product['price']*((100-$product['discount_percentage'])/100),2) : false;
			}} else if(is_object($product)){
				if($product->discount_percentage != NULL && $product->discount_finish != NULL) {

					$expire_dt = new DateTime($product->discount_finish);

					return $expire_dt > $today_dt ? round($product->price*((100-$product->discount_percentage)/100),2) : false;
				}
			}
		}
	}
	?>