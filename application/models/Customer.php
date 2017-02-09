<?php
require_once('Dbobject.php');
class Customer extends Dbobject{

	public $id;
	public $first_name;
	public $last_name;
	public $age;
	public $phone_num;
	public $email_address;
	public $street;
	public $zip_code;
	public $city;
	public $country;
	protected $db_table = 'customers';
	public $personal_info = ['first_name','last_name','birthdate','phone_num','email_address','gender','image'];
	public $editable_fields = ['first_name','last_name','birthdate','phone_num','email_address','gender','image','password','bio'];


	public function __construct()
	{
		parent::__construct();
		$this->primaryKey = 'id';
	}
//check if a user is registered with SoMe
	public function checkUser($data = array()){

		$this->db->select($this->primaryKey);
		$this->db->from($this->db_table);
		$this->db->where(array('oauth_provider'=>$data['oauth_provider'],'oauth_uid'=>$data['oauth_uid']));
		$prevQuery = $this->db->get();
		$prevCheck = $prevQuery->num_rows();
		//load a user's info if the user exists
		if($prevCheck > 0){
			$prevResult = $prevQuery->row_array();
			$data['modified'] = date("Y-m-d H:i:s");
			$customer_info = $this->get_customer_info($prevResult['id']);
			$this->session->set_userdata($customer_info);
			$userID = $prevResult['id'];
		}//save a new user if the user logs in with SoMe 1st time
		else{
			$data['created'] = date("Y-m-d H:i:s");
			$data['modified'] = date("Y-m-d H:i:s");
			$insert = $this->db->insert($this->db_table,$data);
			$userID = $this->db->insert_id();
		}
		return $userID?$userID:FALSE;
	}

//get a customer's info with an address
	public function get_customer_info($customer_id){
		//get a customer's personal info
		if(($customer = $this->get_by_id($customer_id))){
			//get a customer's address if exists
			$address = $this->get_address($customer_id);
			if(!empty($address)) $customer = array_merge($customer,$address);
			unset($customer['password']);
			return $customer;
		}
	}

//get a customer's address
	public function get_address($customer_id){
		$query = $this->db->get_where('address',['customer_id' => $customer_id],1);
		if($query->num_rows() > 0){
			$result = $query->result()[0];
			$address_object = get_object_vars($result);

			return $address_object;
		} return false;
	}
}
?>