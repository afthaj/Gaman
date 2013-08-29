<?php

require_once("database.php");

class BusStop extends DatabaseObject {
	
	protected static $table_name = "stops";
	protected static $db_fields = array('id', 'name', 'location_latitude', 'location_longitude');
	
	public $id;
	public $name;
	public $location_latitude;
	public $location_longitude;
	
}


?>