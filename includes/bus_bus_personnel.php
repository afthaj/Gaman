<?php

require_once("database.php");

class BusBusPersonnel extends DatabaseObject {
	
	protected static $table_name = "buses_bus_personnel";
	protected static $db_fields = array('id', 'bus_id', 'bus_personnel_id');
	
	public $id;
	public $bus_id;
	public $bus_personnel_id;
	
	public function get_buses_for_personnel($id=0){
		global $database;
	
		$sql  = 'SELECT * FROM ' . static::$table_name;
	    $sql .= ' WHERE bus_personnel_id = ' . $id;
	
		return static::find_by_sql($sql);
	}
	
	public function get_personnel_for_bus($id=0){
		global $database;
	
		$sql  = 'SELECT * FROM ' . static::$table_name;
	    $sql .= ' WHERE bus_id = ' . $id;
	
		return static::find_by_sql($sql);
	}
	
	public function check_if_user_is_personnel_for_a_bus($userid=0, $busid) {
		global $database;
		
		$sql  = 'SELECT * FROM ' . static::$table_name;
		$sql .= ' WHERE bus_personnel_id = ' . $userid . ' AND bus_id = ' . $busid;
		$sql .= ' LIMIT 1';
		
		$result_array = self::find_by_sql($sql);
		
		return !empty($result_array) ? array_shift($result_array) : false;
		
	}
	
}


?>