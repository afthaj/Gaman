<?php 

require_once('../includes/initialize.php');

$stop_object = new BusStop();

$stops = $stop_object->find_all();


for ($i = 0; $i < count($stops); $i++){
	if ($i == 0){
		$stop_in_json = '[';
		$stop_in_json .= json_encode($stops[$i]->name);
	} else {
		$stop_in_json .= json_encode($stops[$i]->name);
	}
		
	if ($i == count($stops)-1){
		$stop_in_json .= ']';
	} else {
		$stop_in_json .= ',';
	}
}

echo $stop_in_json;


?>