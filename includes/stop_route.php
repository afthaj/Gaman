<?php

require_once("database.php");

class StopRoute extends DatabaseObject {
	
	protected static $table_name = "stops_routes";
	protected static $db_fields = array('id', 'route_id', 'stop_id');
	
	public $id;
	public $route_id;
	public $stop_id;
	
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