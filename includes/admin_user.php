<?php

require_once("database.php");

class AdminUser extends DatabaseObject {
	
	protected static $table_name = "user_admins";
	protected static $db_fields = array('id', 'object_type', 'username', 'password', 'admin_level', 'first_name', 'last_name', 'email_address');
	
	public $id;
	public $object_type;
	public $username;
	public $password;
	public $admin_level;
	public $first_name;
	public $last_name;
	public $email_address;
	
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