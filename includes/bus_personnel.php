<?php

require_once("database.php");

class BusPersonnel extends DatabaseObject {
	
	protected static $table_name = "bus_personnel";
	protected static $db_fields = array('id', 'object_type', 'role', 'username', 'password', 'first_name', 'last_name', 'nic_number', 'telephone_number');
	
	public $id;
	public $object_type;
	public $role;
	public $username;
	public $password;
	public $first_name;
	public $last_name;
	public $nic_number;
	public $telephone_number;
	
	public function full_name(){
		if (isset($this->first_name) && isset($this->last_name)){
			return $this->first_name . " " . $this->last_name;
		} else {
			return "";
		}
	}
	
	public static function authenticate($username="", $password=""){
		global $database;
	
		$username = $database->escape_value($username);
		$password = $database->escape_value($password);
	
		$sql  = "SELECT * FROM " . static::$table_name;
		$sql .= " WHERE username = '{$username}' AND password = '{$password}'";
		$sql .= " LIMIT 1";
	
		$result_array = self::find_by_sql($sql);
	
		return !empty($result_array) ? array_shift($result_array) : false;
	}
	
	public function check_personnel_owner($buspersonnelid=0) {
		global $database;
	
		$sql  = 'SELECT * FROM ' . static::$table_name;
		$sql .= ' WHERE id = ' . $buspersonnelid . ' AND role = 1';
		$sql .= ' LIMIT 1';
	
		$result_array = self::find_by_sql($sql);
	
		return !empty($result_array) ? array_shift($result_array) : false;
	
	}
	
	public function check_personnel_owner_driver($buspersonnelid=0) {
		global $database;
	
		$sql  = 'SELECT * FROM ' . static::$table_name;
		$sql .= ' WHERE id = ' . $buspersonnelid . ' AND role = 4';
		$sql .= ' LIMIT 1';
	
		$result_array = self::find_by_sql($sql);
	
		return !empty($result_array) ? array_shift($result_array) : false;
	
	}
	
	public function check_personnel_owner_conductor($buspersonnelid=0) {
		global $database;
	
		$sql  = 'SELECT * FROM ' . static::$table_name;
		$sql .= ' WHERE id = ' . $buspersonnelid . ' AND role = 5';
		$sql .= ' LIMIT 1';
	
		$result_array = self::find_by_sql($sql);
	
		return !empty($result_array) ? array_shift($result_array) : false;
	
	}
	
}


?>