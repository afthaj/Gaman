<?php

require_once("database.php");

class AdminLevel extends DatabaseObject {
	
	protected static $table_name = "admin_levels";
	protected static $db_fields = array('id', 'admin_level_name');
	
	public $id;
	public $admin_level_name;
	
}


?>