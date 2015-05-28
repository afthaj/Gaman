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
	
	public function get_route_from_stops($from_stop, $to_stop){
		global $database;
		
		$sql  = "SELECT * FROM " . static::$table_name;
		$sql .= " WHERE stop_id = " . $from_stop;
		$sql .= " UNION ";
		$sql  = "SELECT * FROM " . static::$table_name;
		$sql .= " WHERE stop_id = " . $to_stop;
		
		return self::find_by_sql($sql);
		
	}
	
	public function check_stop_for_route($stopid, $routeid){
		global $database;
		
		$sql  = "SELECT * FROM " . static::$table_name;
		$sql .= " WHERE stop_id = " . $stopid;
		$sql .= " AND route_id = " . $routeid;
		
		$result_array = self::find_by_sql($sql);
		
		return !empty($result_array) ? true : false;
		
	}

}


?>