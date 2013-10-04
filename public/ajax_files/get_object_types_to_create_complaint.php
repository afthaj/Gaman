<?php

require_once('../includes/initialize.php');

$routes = BusRoute::find_all();
$stops = BusStop::find_all();
$buses = Bus::find_all();
$bus_personnel = BusPersonnel::find_all();
$object_type = new ObjectType();
$complaint_type = new ComplaintType();
$bp_role = new BusPersonnelRole();

$q = $_GET['q'];

$selected_complaint_type = $complaint_type->find_by_id($q);

$related_obj_type = $object_type->find_by_id($selected_complaint_type->related_object_type);

echo '<option value="' . $related_obj_type->id . '">' . $related_obj_type->display_name . '</option>';

?>