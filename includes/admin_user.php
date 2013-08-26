<?php

require_once("database.php");

class Admin extends DatabaseObject {
	
	protected static $table_name = "admins";
	protected static $db_fields = array('id', 'username', 'password', 'admin_level', 'first_name', 'last_name', 'email_address');
	
	public $id;
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
	
		$sql = "SELECT * FROM admins WHERE username = '{$username}' AND password = '{$password}' LIMIT 1";
	
		$result_array = self::find_by_sql($sql);
		return !empty($result_array) ? array_shift($result_array) : false;
	}
	
	public function admin_level($level_number){
		if ($level_number == 1){
			return "Time Keeper";
		} else if ($level_number == 2){
			return "Stand OIC";
		} else if ($level_number == 3) {
			return "Scheduler";
		} else if ($level_number == 4){
			return "Admin Level 4";
		} else if ($level_number == 5) {
			return "Admin Level 5";
		}
	}
	
	
}


?>