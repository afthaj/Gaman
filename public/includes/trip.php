<?php

require_once("database.php");

class Trip extends DatabaseObject {
	
	protected static $table_name = "trips";
	protected static $db_fields = array('id', 'survey_id', 'route_id', 'bus_id', 'begin_stop', 'end_stop', 'departure_from_begin_stop', 'arrival_at_end_stop');
	
	public $id;
	public $survey_id;
	public $route_id;
	public $bus_id;
	public $begin_stop;
	public $end_stop;
	public $departure_from_begin_stop;
	public $arrival_at_end_stop;
	
	public function get_trips_for_survey($surveyid){
		global $database;
		
		$sql  = "SELECT * FROM " . static::$table_name;
		$sql .= " WHERE survey_id = " . $surveyid;
		$sql .= " ORDER BY departure_from_begin_stop DESC ";
		
		$result_array = self::find_by_sql($sql);
		
		return !empty($result_array) ? $result_array : false;
		
	}
	
}


?>