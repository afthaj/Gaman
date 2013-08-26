<?php

require_once("database.php");

class Bus extends DatabaseObject {
	
	protected static $table_name = "buses";
	protected static $db_fields = array('id', 'route_id');
	
	public $id;
	public $name;
	
	
}


?>