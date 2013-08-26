<?php

require_once("database.php");

class Bus extends DatabaseObject {
	
	protected static $table_name = "buses";
	protected static $db_fields = array('id', 'route_id', 'reg_number', 'name');
	
	public $id;
	public $route_id;
	public $reg_number;
	public $name;
	
	
}


?>