<?php

require_once("database.php");

class ComplaintType extends DatabaseObject {
	
	protected static $table_name = "complaint_types";
	protected static $db_fields = array('id', 'related_object_type', 'comp_type_name');
	
	public $id;
	public $related_object_type;
	public $comp_type_name;
	
}

?>