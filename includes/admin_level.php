<?php

require_once("database.php");

class AdminLevel extends DatabaseObject {
	
	protected static $table_name = "admin_levels";
	protected static $db_fields = array('id', 'admin_level_name');
	
	public $id;
	public $admin_level_name;
	
	public function get_admin_level($level_number){
		global $database;
		
		$sql  = "SELECT * FROM " . static::$table_name;
		$sql .= " WHERE id = " . $level_number;
		$sql .= " LIMIT 1";
		
		$result_array = self::find_by_sql($sql);
		
		return !empty($result_array) ? array_shift($result_array) : false;

	}
	
}


?>