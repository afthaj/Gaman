<?php
require_once("../includes/initialize.php");

if (!$session->is_logged_in()){
	redirect_to("login.php");
} else {
	$admin_user = AdminUser::find_by_id($_SESSION['id']);
	
}

if (empty($_GET['adminid'])){
	$session->message("Error. No user ID was provided. ");
	redirect_to("index.php");
}

$user_to_delete = AdminUser::find_by_id($_GET['adminid']);

if ($user_to_delete && $user_to_delete->delete()){
	$session->message("Success! The user has been deleted. ");
	redirect_to("admin_list_admin_users.php");
} else {
	$session->message("Error. The user could not be deleted. ");
	redirect_to("admin_list_admin_users.php");
}

?>
