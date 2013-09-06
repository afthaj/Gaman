<?php

require_once("database.php");

class Complaint extends DatabaseObject {
	
	protected static $table_name = "complaints";
	protected static $db_fields = array('id', 'related_object_type', 'related_object_id', 'user_object_type','user_id', 'complaint_type', 'status', 'content');
	
	public $id;
	
	public $related_object_type;
	public $related_object_id;
	
	public $user_object_type;
	public $user_id;
	
	public $complaint_type;
	public $status;
	public $content;
	
	public function get_complaints_for_user($userid, $objecttype){
		global $database;
		
		$sql  = "SELECT * FROM " . static::$table_name;
		$sql .= " WHERE user_object_type = " . $objecttype;
		$sql .= " AND user_id = " . $userid;
		
		return self::find_by_sql($sql);
		
	}
	
}


?>