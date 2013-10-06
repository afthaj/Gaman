<?php

require_once('../includes/initialize.php');

$stop_object = new BusStop();
$stop_route_object = new StopRoute();
$route_object = new BusRoute();

$flag = 0;
$intersection_stop = 0;

$from_string = htmlentities($_GET['f']);
$to_string = htmlentities($_GET['t']);

if (!empty($from_string) && !empty($to_string)){
	
	$from_stop = $stop_object->get_stop_from_name($from_string);
	$to_stop = $stop_object->get_stop_from_name($to_string);
	
	if ($from_stop && $to_stop) {
		
		$routes_of_from_stop = $stop_route_object->get_routes_for_stop($from_stop->id);
		$routes_of_to_stop = $stop_route_object->get_routes_for_stop($to_stop->id);
		
		echo '<div class="well">';
		echo '<a href="public_read_stop.php?stopid=' . $stop_object->find_by_id($from_stop->id)->id . '" class="btn btn-info">' . $stop_object->find_by_id($from_stop->id)->name . '</a>';
		echo ' <i class="icon-arrow-right"></i> ';
		echo '<a href="public_read_stop.php?stopid=' . $stop_object->find_by_id($to_stop->id)->id . '" class="btn btn-info">' . $stop_object->find_by_id($to_stop->id)->name . '</a>';
		echo '<br /><br />';
		
		
		//first check if the "from" and the "to" stops are on the same route
		
		//if so, return the route
		
		//if not, find routes so that the commuter passes through 1 intersection point
		
		
		for($i = 0; $i < count($routes_of_from_stop); $i++){
		
			for($j = 0; $j < count($routes_of_to_stop); $j++){
		
				if ($routes_of_from_stop[$i]->route_id == $routes_of_to_stop[$j]->route_id){
					//one bus
					$option_count = $j+1;
					echo 'Option ' . $option_count . ' - ' . '<a href="public_read_route.php?routeid=' . $route_object->find_by_id($routes_of_to_stop[$j]->route_id)->id . '" class="btn btn-primary">' . $route_object->find_by_id($routes_of_to_stop[$j]->route_id)->route_number . '</a>';
					if ($j < count($routes_of_to_stop)-1){
						echo '<br /><br />';
					} else {
						
					}
					
					$flag = 1;
					
				}
			}
		}
		
		echo '</div>';
		
	} else {
		
		echo '<div class="well">';
		echo '<h4>Please select origin and destination Bus Stops from the dropdown list only.</h4>';
		echo '</div>';
		
	}
	
} else {
	echo '<div class="well">';
	echo '<h4>Please select both the origin AND the destination Bus Stops.</h4>';
	echo '</div>';
}

?>

