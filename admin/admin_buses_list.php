<?php
require_once("../includes/initialize.php");

if (!$session->is_logged_in()){
	redirect_to("login.php");
} else {
	$admin_user = Admin::find_by_id($_SESSION['id']);
	
	$routes = BusRoute::find_all();
	
	$stop = new BusStop();
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Stops List &middot; Gaman</title>
    <?php require_once('../includes/layouts/header_admin.php');?>
  </head>

  <body>


    <!-- Part 1: Wrap all page content here -->
    <div id="wrap">

      <!-- Fixed navbar -->
      <?php $page = admin_stops_list;?>
      <?php require_once('../includes/layouts/navbar_admin.php');?>

      <!-- Begin page content -->
      
      <div class="container">
        <div class="page-header">
          <h1>List of Bus Stops</h1>
        </div>
        
        <!-- Start Content -->
        
        <a href="admin_create_stop.php" class="btn btn-primary">Add New Bus Stop</a>
        <br /><br />
        
        <?php if (!empty($session->message)) {echo $session->message; echo "<br /><br />";} ?>
        
        <table class="table table-bordered table-hover">
	        <tr align="center">
		        <td>Route Number</td>
		        <td>Begin Stop</td>
		        <td>End Stop</td>
		        <td>Length (km)</td>
		        <td>Trip Time (hh:mm:ss)</td>
		        <td>&nbsp;</td>
		        <td>&nbsp;</td>
	        </tr>
        	
        	<?php foreach($routes as $route){ ?>
        		<tr align="center">
	        		<td><?php echo $route->route_number; ?></td>
	        		<td><?php echo $stop->find_by_id($route->begin_stop)->name; ?></td>
	        		<td><?php echo $stop->find_by_id($route->end_stop)->name; ?></td>
	        		<td><?php echo $route->length; ?></td>
	        		<td><?php echo $route->trip_time; ?></td>
	        		<td><a href="admin_read_update_route.php?routeid=<?php echo $route->id; ?>" class="btn btn-warning btn-block">Edit</a></td>
	        		<td><a href="admin_delete_route.php?routeid=<?php echo $route->id; ?>" class="btn btn-danger btn-block">Delete</a></td>        		
        		</tr>
        	<?php }?>
        	
        </table>
        
        <!-- End Content -->
        
      </div>

      <div id="push"></div>
    </div>

    <?php require_once('../includes/layouts/footer_admin.php');?>

    <?php require_once('../includes/layouts/bootstrap_scripts_admin.php');?>

  </body>
</html>
