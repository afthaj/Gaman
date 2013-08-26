<?php
require_once("../../includes/initialize.php");

if (!$session->is_logged_in()){
	redirect_to("login.php");
} else {
	$user = User::find_by_id($_SESSION['user_id']);
}

if (empty($_GET['id'])){
	$session->message("Eror. No comment ID was provided. ");
	redirect_to("index.php");
}

$comment = Comment::find_by_id($_GET['id']);

if ($comment && $comment->delete()){
	$session->message("Success! The comment was deleted. ");
	redirect_to("photo_admin.php?id={$comment->photograph_id}");
} else {
	$session->message("Error. The comment could not be deleted. ");
	redirect_to("photo_admin.php?id={$comment->photograph_id}");
}

?>
