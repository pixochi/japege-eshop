<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Page_info extends CI_Controller {

	public function __construct(){
		parent::__construct();
	}

	public function faq(){

		$this->load->template('faq',null);
	}

	public function about(){

		$this->load->template('about',null);
	}

	public function contact(){

		$this->load->template('contact',null);
	}

	public function error_404(){

		$this->load->template('error_404',null);
	}

}
?>