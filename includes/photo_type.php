<?php

require_once("database.php");

class PhotoType extends DatabaseObject {
	
	protected static $table_name = "photo_types";
	protected static $db_fields = array('id', 'related_object', 'photo_type_name');
	
	public $id;
	public $related_object;
	public $photo_type_name;
	
	public function get_photo_types($related_object){
		global $database;
		
		$sql  = "SELECT * FROM " . static::$table_name;
		$sql  .= " WHERE related_object = '{$related_object}'";
		
		return static::find_by_sql($sql);
	}
	
}


?>