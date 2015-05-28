<?php

require_once("database.php");

class BusStop extends DatabaseObject {
	
	protected static $table_name = "stops";
	protected static $db_fields = array('id', 'name', 'location_latitude', 'location_longitude');
	
	public $id;
	public $name;
	public $location_latitude;
	public $location_longitude;
	
	public function get_stop_from_name($stop_name_string=""){
		global $database;
		
		$sql  = "SELECT * FROM " . static::$table_name;
		$sql .= " WHERE name = '" . $stop_name_string . "'";
		$sql .= " LIMIT 1";
		
		$result_array = self::find_by_sql($sql);
		
		return !empty($result_array) ? array_shift($result_array) : false;
		
	}
	
}


?>