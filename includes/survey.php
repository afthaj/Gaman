<?php

require_once("database.php");

class Survey extends DatabaseObject {
	
	protected static $table_name = "surveys";
	protected static $db_fields = array('id', 'route_id', 'start_date', 'end_date');
	
	public $id;
	public $route_id;
	public $start_date;
	public $end_date;
	
	public function get_surveys_for_route($routeid){
		global $database;
		
		$sql  = "SELECT * FROM " . static::$table_name;
		$sql .= " WHERE route_id = " . $routeid;
		$sql .= " ORDER BY start_date DESC ";
		
		$result_array = self::find_by_sql($sql);
		
		return !empty($result_array) ? $result_array : false;
		
	}
	
}


?>