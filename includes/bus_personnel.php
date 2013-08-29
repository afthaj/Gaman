<?php

require_once("database.php");

class BusPersonnel extends DatabaseObject {
	
	protected static $table_name = "bus_personnel";
	protected static $db_fields = array('id', 'role', 'username', 'password', 'first_name', 'last_name', 'nic_number');
	
	public $id;
	public $role;
	public $username;
	public $password;
	public $first_name;
	public $last_name;
	public $nic_number;
	
}


?>