<?php

require_once("database.php");

class Complaint extends DatabaseObject {
	
	protected static $table_name = "complaints";
	protected static $db_fields = array('id', 'complaint_type', 'bus_route_id', 'stop_id', 'bus_id', 'bus_personnel_id', 'status', 'content');
	
	public $id;
	public $complaint_type;
	public $bus_route_id;
	public $stop_id;
	public $bus_id;
	public $bus_personnel_id;
	public $status;
	public $content;
	
	
}


?>