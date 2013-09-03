<?php

require_once("database.php");

class Complaint extends DatabaseObject {
	
	protected static $table_name = "complaints";
	protected static $db_fields = array('id', 'object_type_id', 'object_id', 'complaint_type', 'status', 'content');
	
	public $id;
	
	public $object_type_id;
	public $object_id;
	
	public $complaint_type;
	public $status;
	public $content;
	
	public function get_complaints_for_user($userid){
		global $database;
		
		
		
	}
	
}


?>