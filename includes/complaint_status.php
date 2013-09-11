<?php

require_once("database.php");

class ComplaintStatus extends DatabaseObject {
	
	protected static $table_name = "complaint_status";
	protected static $db_fields = array('id', 'comp_status_name');
	
	public $id;
	public $comp_status_name;
	
}


?>