<?php

require_once("database.php");

class BusRoute extends DatabaseObject {
	
	protected static $table_name = "routes";
	protected static $table_name_2 = "stops_routes";
	protected static $db_fields = array('id', 'route_number', 'length', 'trip_time', 'begin_stop', 'end_stop');
	
	public $id;
	public $route_number;
	public $length;
	public $trip_time;
	public $begin_stop;
	public $end_stop;
	
	
	
}


?>