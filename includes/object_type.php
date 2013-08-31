<?php

require_once("database.php");

class ObjectType extends DatabaseObject {
	
	protected static $table_name = "object_types";
	protected static $db_fields = array('id', 'object_type_name');
	
	public $id;
	public $object_type_name;
	
	
}


?>