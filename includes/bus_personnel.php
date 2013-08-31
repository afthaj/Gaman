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
	
}


?>