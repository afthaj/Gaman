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
	
	$routes_of_from_stop = $stop_route_object->get_routes_for_stop($from_stop->id);
	$routes_of_to_stop = $stop_route_object->get_routes_for_stop($to_stop->id);
	
	echo '<div class="well">';
	echo '<a href="public_read_stop.php?stopid=' . $stop_object->find_by_id($from_stop->id)->id . '" class="btn btn-info">' . $stop_object->find_by_id($from_stop->id)->name . '</a>';
	echo ' <i class="icon-arrow-right"></i> ';
	echo '<a href="public_read_stop.php?stopid=' . $stop_object->find_by_id($to_stop->id)->id . '" class="btn btn-info">' . $stop_object->find_by_id($to_stop->id)->name . '</a>';
	echo '<br /><br />';
	//echo 'Common Route(s): ';
	//echo '<br />';
	
	
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
				} else { }
				$flag = 1;
				//return;
			} else {
				//echo 'No Bus Routes were found :(';
				//return;
			}
	
			/*else {
				$stops1 = $stop_route_object->get_stops_for_route($routes_of_from_stop[$i]->route_id);
			$stops2 = $stop_route_object->get_stops_for_route($routes_of_to_stop[$j]->route_id);
			for ($k = 0; $k < count($stops1); $k++){
			for ($l = 0; $l < count($stops2); $l++){
			if ($stops1[$k]->stop_id == $stops2[$l]->stop_id){ // two bus
			echo 'Intersection Stop: <br />' . $stop_object->find_by_id($stops1[$k]->stop_id)->name . '<br /><br />';
	
			$intersection_stop_id = $stops1[$k]->stop_id;
	
	
			/**** new ****/
			/*
			 echo 'Take ' . $route_object->find_by_id($routes_of_from_stop[$i]->route_id)->route_number .
			' to ' . $stop_object->find_by_id($intersection_stop_id)->name . ' then switch to ' .
			$route_object->find_by_id($routes_of_to_stop[$j]->route_id)->route_number . '<br />';
	
			}
			}
			}
			}
			/*
			else {
				
			$stops1 = $stop_route_object->get_stops_for_route($routes_of_from_stop[$i]->route_id);
			$stops2 = $stop_route_object->get_stops_for_route($routes_of_to_stop[$j]->route_id);
				
			for ($k = 0; $k < count($stops1); $k++){
			for ($l = 0; $l < count($stops2); $l++){
				
			if ($stops1[$k]->stop_id == $stops2[$l]->stop_id){
	
			echo 'Intersection Stop: <br />' . $stop_object->find_by_id($stops1[$k]->stop_id)->name . '<br /><br />';
	
			$intersection_stop_id = $stops1[$k]->stop_id;
	
			$routes_passing_through_intersection = $stop_route_object->get_routes_for_stop($intersection_stop_id);
	
			echo 'Routes passing through Intersection Stop: <br />';
	
			foreach ($routes_passing_through_intersection as $route){
			echo $route_object->find_by_id($route->route_id)->route_number . '<br />';
			}
	
			//return;
	
			/*
			$routes_passing_through_from_stop_and_intersection = $stop_route_object->get_routes_for_stop($stops1[$k]->stop_id);
			$routes_passing_through_to_stop_and_intersection = $stop_route_object->get_routes_for_stop($stops2[$l]->stop_id);
			*/
			/*
			 echo 'k = '.$k;
			echo '<br />';
			echo 'l = '.$l;
			echo '<br /><br /><br />';
			*/
			/*
			 }
			}
			}
			}*/
		}
	}
	
	echo '</div>';
	
} else {
	echo '<div class="well">';
	echo '<h4>Please select both the origin AND the destination Bus Stops.</h4>';
	echo '</div>';
}

?>

