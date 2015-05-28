<?php

require_once("database.php");

class StopActivity extends DatabaseObject {
	
	protected static $table_name = "stop_activities";
	protected static $db_fields = array('id', 'trip_id', 'stop_id', 'alighted_commuters', 'boarded_commuters', 'arrival_time', 'departure_time');
	
	public $id;
	public $trip_id;
	public $stop_id;
	public $alighted_commuters;
	public $boarded_commuters;
	public $arrival_time;
	public $departure_time;
	
	
	public function get_stop_activities_for_trip($tripid){
		global $database;
		
		$sql  = "SELECT * FROM " . static::$table_name;
		$sql .= " WHERE trip_id = " . $tripid;
		$sql .= " ORDER BY arrival_time DESC ";
		
		$result_array = self::find_by_sql($sql);
		
		return !empty($result_array) ? $result_array : false;
		
	}
	
}


?>