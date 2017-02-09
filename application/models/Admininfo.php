<?php
 require_once('Dbobject.php');

class Admininfo extends Dbobject{

	public $name;
	public $super_admin;
	private $password;
	protected $db_table = 'admins';
	protected $editable_fields = ['name','password','super_admin'];

}
?>