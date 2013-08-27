<?php

require_once("database.php");

class BusBusPersonnel extends DatabaseObject {
	
	protected static $table_name = "buses_bus_personnel";
	protected static $db_fields = array('id', 'bus_id', 'bus_personnel_id');
	
	public $id;
	public $bus_id;
	public $bus_personnel_id;
	
	public function get_stops_for_route($id=0){
		global $database;
	
		$sql  = "SELECT * FROM " . static::$table_name;
		$sql .= " WHERE route_id = " . $id;
	
		return static::find_by_sql($sql);
	}
	
	public function get_routes_for_stop($id=0){
		global $database;
	
		$sql  = "SELECT * FROM " . static::$table_name;
		$sql .= " WHERE stop_id = " . $id;
	
		return static::find_by_sql($sql);
	}
	
	
}


?>