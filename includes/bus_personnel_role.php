<?php

require_once("database.php");

class BusPersonnelRole extends DatabaseObject {
	
	protected static $table_name = "bus_personnel_roles";
	protected static $db_fields = array('id', 'role_name');
	
	public $id;
	public $role_name;

}


?>