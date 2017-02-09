<?php
 require_once('Dbobject.php');
class Address extends Dbobject{

	public $customer_id;
	public $street;
	public $zip_code;
	public $city;
	public $country;
	protected $db_table = 'address';
	public $editable_fields = ['customer_id','street','zip_code','city','country'];

        public function __construct()
        {
                parent::__construct();
        }
  }
?>