<?php
require_once('Dbobject.php');

class Review extends Dbobject{

	protected $db_table = 'comments';
	public $editable_fields = ['customer_id','product_id','content'];

	public function __construct()
	{
		parent::__construct();
	}

//get all reviews for a selected product
	public function get_reviews($where,$limit = null,$offset = null){

		$this->load->helper('image');

		$reviews = $this->get_filtered($where,$limit,$offset);

		if(!empty($reviews)){
			$where = '';
			foreach ($reviews as $review) {
					$where .= 'id = '.$this->db->escape($review->customer_id).' OR ';
			}
			$where = substr($where, 0, strlen($where) - 3);

			//get info about a customer who added the review
			$this->db->select('id, first_name, last_name,image');
			$this->db->where($where);
			$customers = $this->db->get('customers')->result();
			foreach ($customers as $customer) {
				foreach ($reviews as $index => $review) {
					if($customer->id == $review->customer_id){
						$review->customer_name = $customer->first_name." ".$customer->last_name;
						$review->customer_image = user_image($customer) ;
					}
				}
			}
		}
		return $reviews;
	}

//add a new review
	public function add_new(){

		$review_text = $this->input->post('review_text');
		$stars = $this->input->post('star');
		$last = $this->uri->total_segments();
		$product_id = $this->uri->segment($last);
		if(!empty($review_text) && !empty($stars)){
			$data['rating'] = $stars;
			$data['content'] = strip_tags(trim($review_text));
			$data['product_id'] = $product_id;
			$data['customer_id'] = $this->session->customer_id;
			$data['date'] = strftime('%Y-%m-%d %H:%M:%S',time());
			$this->db->insert('comments',$data);
//get a number of reviews for a product
			$this->db->where('product_id',$product_id);
			$this->db->from($this->db_table);
			$count = $this->db->count_all_results();

//calculate average rating for a selected product 
			if($count == 1) {
				$avg_rating = $stars;
			} else {
				$avg_rating = '(avg_rating * '.($count-1) .' + '.$stars.')/'.$count;
			}
			$this->db->set('avg_rating',$avg_rating,false);
			$this->db->where('id',$product_id);
			$this->db->update('products');
		}
	}
}
?>