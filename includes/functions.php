<?php

function strip_zeros_from_date($marked_string="") {
	$no_zeros = str_replace('*0', '', $marked_string);
	$cleaned_string = str_replace('*', '', $no_zeros);
	return $cleaned_string;
}

function redirect_to( $location = NULL ){
	if ( $location != NULL ){
		header("Location: {$location}");
		//exit;
	}
}

function output_message($message = ""){
	if (!empty($message)){
		return '<div class="alert"><button type="button" class="close" data-dismiss="alert">&times;</button>{$message}</div>';
		return $message;
	} else {
		return "";
	}
}

/*
function __autoload($class_name){
	$class_name = str_to_lower($class_name);
	$path = "../includes/{$class_name}.php";
	if(file_exists($path)){
		require_once($path);
	} else {
		die("The file {$class_name}.php cannot be found");
	}
}
*/

function datetime_to_text($datetime=""){
	$unixdatetime = strtotime($datetime);
	return strftime("%B %d, %Y at %I:%M %p", $unixdatetime);
}

function format_trip_time($triptime){
	
	if ($triptime < 60) {
		
		return "{$triptime} mins";
		
	} else if ($triptime == 60) {
		
		return "1 hr";
		
	} else if ($triptime > 60) {
		
		$time_in_hours = intval($triptime/60);
		$time_in_minutes = $triptime - ($time_in_hours * 60);
		
		if ($time_in_hours == 1){
			
			if ($time_in_minutes == 1){
				return "{$time_in_hours} hr and {$time_in_minutes} min";
			} else {
				return "{$time_in_hours} hr and {$time_in_minutes} mins";
			}
			
		} else {
			
			if ($time_in_minutes == 1){
				return "{$time_in_hours} hrs and {$time_in_minutes} min";
			} else {
				return "{$time_in_hours} hrs and {$time_in_minutes} mins";
			}
			
		}
		
	}
	
}

?>