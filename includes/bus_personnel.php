<?php

require_once("database.php");

class BusPersonnel extends DatabaseObject {
	
	protected static $table_name = "bus_personnel";
	protected static $db_fields = array('id', 'bus_id', 'role', 'first_name', 'last_name');
	
	public $id;
	public $bus_id;
	public $role;
	public $first_name;
	public $last_name;
	
}


?>