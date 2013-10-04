<?php

if (PHP_OS == 'WINNT' || PHP_OS == 'WIN32' || PHP_OS == 'Windows'){
	//windows
	
	require_once("config_windows.php");
	
} else if (PHP_OS == 'Linux') {
	//server
	
	require_once("config_server.php");
	
} else if (PHP_OS == 'Darwin') {
	//OS X
	
	require_once("config_mac.php");
	
}

class MySQLDatabase{

	private $connection;
	public $last_query;
	private $magic_quotes_active;
	private $real_escape_string_exists;

	function __construct(){
		$this->open_connection();
		$this->magic_quotes_active = get_magic_quotes_gpc();
		$this->real_escape_string_exists = function_exists("mysql_real_escape_string");
	}

	public function open_connection(){
		$this->connection = mysql_connect(DB_SERVER, DB_USER, DB_PASS);
		if (!$this->connection){
			die("Database connection failed: ". mysql_error());
		} else {
			$db_select = mysql_select_db(DB_NAME, $this->connection);
			if (!$this->connection){
				die("Database selection failed: ". mysql_error());
			}
		}
	}

	public function close_connection(){
		if (isset($this->connection)){
			mysql_close($this->connection);
			unset($this->connection);
		}
	}

	public function query($sql){
		$this->last_query = $sql;
		$result = mysql_query($sql, $this->connection);
		$this->confirm_query($result);
		return $result;
	}

	public function escape_value($value){
		if ($this->real_escape_string_exists){
			if ( $this->magic_quotes_active ){
				$value = stripslashes($value);
			}
			$value = mysql_real_escape_string($value);
			
		} else {
			if (!$this->magic_quotes_active){
				$value = addslashes($value);
			}
		}
		return $value;
	}

	private function confirm_query($result){
		if (!$result){
			$output = "Database connection failed: ". mysql_error();
			$output.= "<br /><br />";
			$output.= "Last SQL Query: ". $this->last_query;
			die($output);
		}
	}

	public function fetch_array($result_set){
		return mysql_fetch_array($result_set);
	}
	
	public function num_rows($result_set){
		return mysql_num_rows($result_set);
	}
		
	public function insert_id(){
		return mysql_insert_id($this->connection);
	}
		
	public function affected_rows(){
		return mysql_affected_rows($this->connection);
	}
	
}

$database = new MySQLDatabase();
$db =& $databse;

?>