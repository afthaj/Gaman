<?php

require_once('../../includes/initialize.php');

$routes = BusRoute::find_all();
$stops = BusStop::find_all();
$buses = Bus::find_all();
$bus_personnel = BusPersonnel::find_all();
$object_type = new ObjectType();

$q = $_GET['q'];

$selected_object_type = $object_type->find_by_id($q);

if ($selected_object_type->object_type_name == 'bus_route') {
	
	echo '<label for="bus_route_id" class="control-label">Bus Route</label>';
	echo '<div class="controls">';
	echo '<select name="bus_route_id">';
	
	foreach ($routes as $route){
		echo '<option value="' . $route->id . '">';
		echo $route->route_number;
		echo '</option>';
	}
	
	echo '</select>';
	echo '</div>';
	
} else if ($selected_object_type->object_type_name == 'stop') {
	
	echo '<label for="stop_id" class="control-label">Bus Stop</label>';
	echo '<div class="controls">';
	echo '<select name="stop_id">';
	
	foreach ($stops as $stop){
		echo '<option value="' . $stop->id . '">';
		echo $stop->name;
		echo '</option>';
	}
	
	echo '</select>';
	echo '</div>';
	
} else if ($selected_object_type->object_type_name == 'bus') {
	
	echo '<label for="bus_id" class="control-label">Bus</label>';
	echo '<div class="controls">';
	echo '<select name="bus_id">';
	
	foreach ($buses as $bus){
		echo '<option value="' . $bus->id . '">';
		echo $bus->reg_number;
		echo '</option>';
	}
	
	echo '</select>';
	echo '</div>';
	
} else if ($selected_object_type->object_type_name == 'bus_personnel') {
	
	echo '<label for="bus_personnel_id" class="control-label">Bus Personnel</label>';
	echo '<div class="controls">';
	echo '<select name="bus_personnel_id">';
	
	foreach ($bus_personnel as $bp){
		echo '<option value="' . $bp->id . '">';
		echo $bp->full_name();
		echo '</option>';
	}
	
	echo '</select>';
	echo '</div>';
	
}

?>