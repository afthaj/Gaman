<?php
require_once("../includes/initialize.php");

if (!$session->is_logged_in()){
	redirect_to("login.php");
} else {
	$admin_user = AdminUser::find_by_id($_SESSION['id']);
}

if (empty($_GET['routeid'])){
	$session->message("Eror. No Route ID was provided. ");
	redirect_to("index.php");
}

$route_to_delete = BusRoute::find_by_id($_GET['routeid']);

if ($route_to_delete && $route_to_delete->delete()){
	$session->message("Success! The Bus Route has been deleted. ");
	redirect_to("admin_list_routes.php");
} else {
	$session->message("Error. The Bus Route could not be deleted. ");
}

?>
