<?php

defined('DS') ? null : define('DS', DIRECTORY_SEPARATOR);

defined('SITE_ROOT') ? null : define('SITE_ROOT', DS.'Users'.DS.'aftha'.DS.'Sites'.DS.'2. Eclipse Workspace'.DS.'Gaman'.DS.'public');
//defined('SITE_ROOT') ? null : define('SITE_ROOT', 'C:'.DS.'xampp'.DS.'htdocs'.DS.'webdev'.DS.'Gaman');

require_once("config_mac.php");
//require_once("config_windows.php");

require_once("functions.php");

require_once("session.php");
require_once("database.php");
require_once("pagination.php");

require_once("database_object.php");

require_once("admin_level.php");
require_once("admin_user.php");
require_once("bus_bus_personnel.php");
require_once("bus_personnel_role.php");
require_once("bus_personnel.php");
require_once("bus_route.php");
require_once("bus_stop.php");
require_once("bus.php");
require_once("commuter.php");
require_once("complaint_status.php");
require_once("complaint_type.php");
require_once("complaint.php");
require_once("object_type.php");
require_once("photo_type.php");
require_once("photograph.php");
require_once("stop_route.php");

?>