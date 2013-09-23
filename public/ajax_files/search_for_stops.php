<?php

require_once('../../includes/initialize.php');

$stop_object = new BusStop();
$stop_route_object = new StopRoute();
$route_object = new BusRoute();

$from_string = htmlentities($_GET['f']);
$to_string = htmlentities($_GET['t']);

$from_stop = $stop_object->get_stop_from_name($from_string);
$to_stop = $stop_object->get_stop_from_name($to_string);

echo $from_stop->id;
echo '<br />';
echo $to_stop->id;
echo '<br />';

$routes = $stop_route_object->get_route_from_stops($from_stop->id, $to_stop->id);

if ($routes){
	
	foreach($routes as $route){
		echo $route->route_id;
	}
	
} else {
	echo 'error...';
}

//echo $route_object->find_by_id($route->route_id)->route_number;

/*
$route1 = $stop_route_object->get_routes_for_stop($from_stop->id);
$route2 = $stop_route_object->get_routes_for_stop($to_stop->id);

print_r($route1);
echo '<br />';
print_r($route2);
*/
?>