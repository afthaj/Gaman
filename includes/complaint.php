<?php

require_once("database.php");

class Complaint extends DatabaseObject {
	
	protected static $table_name = "complaints";
	protected static $db_fields = array('id', 'related_object_type', 'related_object_id', 'user_object_type','user_id', 'complaint_type', 'date_time_submitted', 'status', 'content');
	
	public $id;
	
	public $related_object_type;
	public $related_object_id;
	
	public $user_object_type;
	public $user_id;
	
	public $complaint_type;
	public $date_time_submitted;
	public $status;
	public $content;
	
	public function get_complaints_for_user($userid, $objecttype){
		global $database;
		
		$sql  = "SELECT * FROM " . static::$table_name;
		$sql .= " WHERE user_object_type = " . $objecttype;
		$sql .= " AND user_id = " . $userid;
		
		return self::find_by_sql($sql);
	}
	
	public function get_complaints_for_object($relatedobjecttype, $relatedobjectid){
		global $database;
	
		$sql  = "SELECT * FROM " . static::$table_name;
		$sql .= " WHERE related_object_type = " . $relatedobjecttype;
		$sql .= " AND related_object_id = " . $relatedobjectid;
	
		return self::find_by_sql($sql);
	}
	
}


?>