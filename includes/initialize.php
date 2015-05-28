<?php

defined('DS') ? null : define('DS', DIRECTORY_SEPARATOR);


if (PHP_OS == 'WINNT' || PHP_OS == 'WIN32' || PHP_OS == 'Windows'){
	//windows
	
	defined('SITE_ROOT') ? null : define('SITE_ROOT', 'C:'.DS.'xampp'.DS.'htdocs'.DS.'webdev'.DS.'Gaman');
	require_once("config_windows.php");
	
} else if (PHP_OS == 'Linux') {
	//server
	require_once("config_server.php");
	
} else if (PHP_OS == 'Darwin') {
	//OS X
	
	defined('SITE_ROOT') ? null : define('SITE_ROOT', DS.'Users'.DS.'aftha'.DS.'Sites'.DS.'2. Eclipse Workspace'.DS.'Gaman'.DS.'public');
	require_once("config_mac.php");
	
}

//require_once("routes.php");

require_once("functions.php");

require_once("session.php");
require_once("database.php");
require_once("pagination.php");

require_once("database_object.php");

require_once("bus_route.php");
require_once("bus_stop.php");
require_once("bus.php");
require_once("bus_personnel.php");

$route_object = new BusRoute();
$stop_object = new BusStop();
$bus_object = new Bus();
$bus_personnel_object = new BusPersonnel();

require_once("commuter.php");
require_once("admin_user.php");
require_once("survey.php");
require_once("trip.php");

$commuter_object = new Commuter();
$admin_user_object = new AdminUser();
$survey_object = new Survey();
$trip_object = new Trip();

require_once("photograph.php");
require_once("photo_type.php");
require_once("object_type.php");

$photo_object = new Photograph();
$photo_type_object = new PhotoType();
$object_type_object = new ObjectType();

require_once("complaint.php");
require_once("complaint_type.php");
require_once("complaint_status.php");
require_once("feedback_item.php");

$complaint_object = new Complaint();
$complaint_type_object = new ComplaintType();
$complaint_status_object = new ComplaintStatus();
$feedback_item_object = new FeedbackItem();

require_once("bus_personnel_role.php");
require_once("admin_level.php");

$bus_personnel_role_object = new BusPersonnelRole();
$admin_level_object = new AdminLevel();

require_once("bus_bus_personnel.php");
require_once("stop_route.php");
require_once("stop_activity.php");

$bus_bus_personnel_object = new BusBusPersonnel();
$stop_route_object = new StopRoute();
$stop_activity_object = new StopActivity();

?>