<?php
require_once('Dbobject.php');

class Login extends CI_Model{

	public $customer_logged = false;
	public $admin_logged = false;
	public $admin_id;
	public $customer_id;

	const HASH = PASSWORD_DEFAULT;
	const COST = 11;

	public function __construct()
	{
		parent::__construct();
		$this->check_login();
	}

	private function check_login(){
		//check if an admin is logged in
		if (isset($this->session->admin_id))
		{
			$this->admin_logged = true;
			return $this->admin_logged;
		//check if a customer is logged in
		} elseif(isset($this->session->customer_id)){
			$this->customer_logged = true;
			return $this->customer_logged;
		} else {
			return false;
		}
	}

	public function is_admin_logged(){
		//redirect to the admin login page if not logged in
		if(!$this->admin_logged){
			redirect(base_url('admin/login'));
		}
	}

	public function is_customer_logged(){
		//redirect to the main page if not logged in
		if(!$this->session->customer_id){
			redirect(base_url());
		}
	}

//log in an admin
	public function admin_log_in($admin){
		if ($admin)
		{
			$this->admin_id = $admin->id;
			$this->session->set_userdata('admin_id',$admin->id);
			$this->admin_logged = true;
		}
	}

	public function customer_log_in($id,$soMe = false){
		if ($id)
		{
			$this->load->model('customer');

			$this->customer_id = $id;
			$this->session->set_userdata('customer_id',$id);

			$customer = $this->customer->get_by_id($id);

			foreach ($this->customer->personal_info as $info_field) {
				$user[$info_field] = $customer[$info_field]; 
				$this->session->set_userdata($user);
			}
			set_cookie('locale',$customer['locale'],60*60*24*2);

			$this->customer_logged = true;
			$redirect = $this->session->redirect != null ? $this->session->redirect : base_url();
			redirect($redirect);
		}
	}

//log out an admin or a customer
	public function log_out($who){
		//log out an admin
		if($who == 'admin'){
			$this->admin_logged = false;
			unset($this->admin_id);
			//delete admin_id from session
			$this->session->unset_userdata('admin_id');
			//log out a customer
		} else if($who == 'customer') {
			$this->customer_logged = false;
			unset($this->customer_id);
			//delete everything from session except admin_id
			$keep_session = 'admin_id';
			$sessionData = $this->session->all_userdata();
			foreach($sessionData as $key =>$val){
				if($key != $keep_session){
					$this->session->unset_userdata($key);
				}
			}
		}

	}
//validate customer or admin login
	public function validate($users){

		//customers logs in with an email_address and admins with a name
		$login_name = $users == 'admins' ? $this->input->post('name') : $this->input->post('email_address');

		$password = $this->input->post('password');

		$query = $this->db->get($users);
		// check if a login_name exists
		foreach ($query->result() as $user)
		{
			$login_info = $users == 'admins' ? $user->name : $user->email_address;
			if( $login_info === $login_name){
				//check if a login_name and password match
				if(password_verify($password, $user->password)){

					//authenticate an admin
					if($users == 'admins'){
						$this->session->set_userdata(['admin_id' => $user->id]);
						redirect(base_url('product_control/products'),'refresh');
						//authenticate a customer
					} else {
						$this->customer_log_in($user->id);
					}
				} else{
					$this->session->set_flashdata(["login_message" => "Username/Password combination is incorrect"]);
				}
			} else {
				$this->session->set_flashdata(["login_message" => "Username/Password combination is incorrect"]);

			}
		}
	}

//Fb SoMe used to log in
	public function fb_login(){
	// Include the fb api php library
		include_once APPPATH."libraries/facebook.php";

//Call Facebook API
		$facebook = new Facebook(array(
			'appId'  => 'sorry but this is secret :)',
			'secret' => 'sorry but this is secret :)'
			));

        // Facebook API Configuration
		$redirectUrl = base_url('login/fb');
		$fbPermissions = 'email';

		$fbuser = $facebook->getUser();

		if ($fbuser) {
			 try {
	    $userProfile = $facebook->api('/me?fields=id,first_name,last_name,email,gender,locale');
	     // Preparing data before inserting to DB
			$userData['oauth_uid'] = $userProfile['id'];
			$userData['image'] = "https://graph.facebook.com/".$userProfile['id']."/picture?type=large";
			$userData['oauth_provider'] = 'facebook';
			$userData['email_address'] = $userProfile['email'];
			$userData['first_name'] = $userProfile['first_name'];
			$userData['last_name'] = $userProfile['last_name'];
			$userData['gender'] = $userProfile['gender'];
			$userData['locale'] = $userProfile['locale'];

			$this->session->set_userdata($userData);
			$userID = $this->customer->checkUser($userData);
  } catch (FacebookApiException $e) {
    $userID = null;
  }
         
		 //a customer has logged in with fb before
			if(!empty($userID)){
				$this->customer_log_in($userID,true);
			} 
			//a customer logs in with fb 1st time
		} else {
			$fbuser = '';
			$authUrl = $facebook->getLoginUrl(array('redirect_uri'=>$redirectUrl,'scope'=>$fbPermissions));

			redirect($authUrl);
		}
	}

//Google SoMe used to log in
	public function google_login(){
	 // Include the google api php libraries
		include_once APPPATH."libraries/google-api-php-client/Google_Client.php";
		include_once APPPATH."libraries/google-api-php-client/contrib/Google_Oauth2Service.php";
	 // Google Project API Credentials
		$clientId = 'sorry but this is secret :)';
		$clientSecret = 'sorry but this is secret :)';
		$redirectUrl = base_url() . 'login/google/';

        	 // Google Client Configuration
		$gClient = new Google_Client();
		$gClient->setApplicationName('Login to japege.herokuapp.com');
		$gClient->setClientId($clientId);
		$gClient->setClientSecret($clientSecret);
		$gClient->setRedirectUri($redirectUrl);
		$google_oauthV2 = new Google_Oauth2Service($gClient);

		if (isset($_REQUEST['code'])) {
			$gClient->authenticate();
			$this->session->set_userdata('token', $gClient->getAccessToken());
			redirect($redirectUrl);
		}

		$token = $this->session->userdata('token');
		if (!empty($token)) {
			$gClient->setAccessToken($token);
		}

		if ($gClient->getAccessToken()) {
			$userProfile = $google_oauthV2->userinfo->get();
            // Preparing data before inserting to DB
			$userData['oauth_provider'] = 'google';
			$userData['oauth_uid'] = $userProfile['id'];
			$userData['first_name'] = $userProfile['given_name'];
			$userData['last_name'] = $userProfile['family_name'];
			$userData['email_address'] = $userProfile['email'];
			$userData['gender'] = $userProfile['gender'];
			$userData['locale'] = $userProfile['locale'];
			$userData['image'] = $userProfile['picture'];

			$this->session->set_userdata($userData);
			$userID = $this->customer->checkUser($userData);
			 //a customer has logged in with google account before
			if(!empty($userID)){

				$this->login->customer_log_in($userID,true);
			} //a customer logs in with gogle 1st time
		} else {
			redirect($gClient->createAuthUrl());
		}
	}
}
?>

