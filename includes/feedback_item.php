<?php

require_once("database.php");

class FeedbackItem extends DatabaseObject {
	
	protected static $table_name = "feedback_items";
	protected static $db_fields = array('id', 'related_object_type', 'related_object_id', 'user_object_type','user_id', 'date_time_submitted', 'content');
	
	public $id;
	
	public $related_object_type;
	public $related_object_id;
	
	public $user_object_type;
	public $user_id;
	
	public $date_time_submitted;
	public $content;
	
	public function get_feedback_items_for_user($userid, $objecttype){
		global $database;
		
		$sql  = "SELECT * FROM " . static::$table_name;
		$sql .= " WHERE user_object_type = " . $objecttype;
		$sql .= " AND user_id = " . $userid;
		$sql .= " ORDER BY date_time_submitted DESC";
		
		return self::find_by_sql($sql);
	}
	
	public function get_feedback_items_submitted_by_user_for_object($userid, $userobjecttype, $relatedobjecttype, $relatedobjectid){
		global $database;
	
		$sql  = "SELECT * FROM " . static::$table_name;
		$sql .= " WHERE user_object_type = " . $userobjecttype;
		$sql .= " AND user_id = " . $userid;
		$sql .= " AND related_object_type = " . $relatedobjecttype;
		$sql .= " AND related_object_id = " . $relatedobjectid;
		$sql .= " ORDER BY date_time_submitted DESC";
	
		return self::find_by_sql($sql);
	}
	
	public function get_feedback_items_for_object($relatedobjecttype, $relatedobjectid){
		global $database;
	
		$sql  = "SELECT * FROM " . static::$table_name;
		$sql .= " WHERE related_object_type = " . $relatedobjecttype;
		$sql .= " AND related_object_id = " . $relatedobjectid;
		$sql .= " ORDER BY date_time_submitted DESC";
	
		return self::find_by_sql($sql);
	}
	
}


?>