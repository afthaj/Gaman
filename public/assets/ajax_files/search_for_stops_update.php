<?php
if ($routes_of_from_stop[$i]->route_id == $routes_of_to_stop[$j]->route_id){
	//one bus

	echo $route_object->find_by_id($routes_of_to_stop[$j]->route_id)->route_number . '<br />';
	$flag = 1;
	//return;
} else {
	$stops1 = $stop_route_object->get_stops_for_route($routes_of_from_stop[$i]->route_id);
	$stops2 = $stop_route_object->get_stops_for_route($routes_of_to_stop[$j]->route_id);
	for ($k = 0; $k < count($stops1); $k++){
		for ($l = 0; $l < count($stops2); $l++){
			if ($stops1[$k]->stop_id == $stops2[$l]->stop_id){ // two bus
				echo 'Intersection Stop: <br />' . $stop_object->find_by_id($stops1[$k]->stop_id)->name . '<br /><br />';
				
				$intersection_stop_id = $stops1[$k]->stop_id;
				
				/** new */
				echo 'Take ' . $route_object->find_by_id($routes_of_from_stop[$i]->route_id)->route_number . 
				' to ' . $stop_object->find_by_id($intersection_stop_id)->name . ' then switch to ' .
				$route_object->find_by_id($routes_of_to_stop[$j]->route_id)->route_number;
			}
		}
	}
}
?>
