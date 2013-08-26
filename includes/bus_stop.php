<?php

require_once("database.php");

class BusStop extends DatabaseObject {
	
	protected static $table_name = "stops";
	protected static $db_fields = array('id', 'name');
	
	public $id;
	public $name;
	
	
}


?>