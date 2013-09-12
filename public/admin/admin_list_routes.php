<?php
require_once("../../includes/initialize.php");

if ($session->is_logged_in() && $session->object_type == 5) {
	
	$user = AdminUser::find_by_id($_SESSION['id']);
	$p = new Photograph();
	$profile_picture = $p->get_profile_picture($session->object_type, $user->id);
	
} else if ($session->is_logged_in() && $session->object_type == 4) {
	
	$user = BusPersonnel::find_by_id($_SESSION['id']);
	$p = new Photograph();
	$profile_picture = $p->get_profile_picture($session->object_type, $user->id);
	
} else {
	redirect_to("login.php");
}

$routes = BusRoute::find_all();
$stop = new BusStop();

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Routes List &middot; <?php echo WEB_APP_NAME; ?></title>
    <?php require_once('../../includes/layouts/header_admin.php');?>
  </head>

  <body>


    <!-- Part 1: Wrap all page content here -->
    <div id="wrap">

      <!-- Fixed navbar -->
      <?php $page = 'admin_routes_list';?>
      <?php require_once('../../includes/layouts/navbar_admin.php');?>
      
      <header class="jumbotron subhead">
		 <div class="container-fluid">
		   <h1>List of Bus Routes</h1>
		 </div>
	  </header>

      <!-- Begin page content -->
        
      <!-- Start Content -->
      
      <div class="container-fluid">
      	
      	<?php if ($session->is_logged_in() && $session->object_type == 5) { ?>
      	<div class="row-fluid">
	        <br />
	        <a href="admin_create_route.php" class="btn btn-primary">Add New Route</a>
	        <br />
        </div>
        <?php } ?>
        
        <div class="row-fluid">
        
        <div class="span12">
        
        <section>
        
        <?php if (!empty($session->message)) {echo $session->message; echo "<br /><br />";} ?>
        
        <table class="table table-bordered table-hover">
          <thead>
	        <tr align="center">
		        <td>Route Number</td>
		        <td>Begin Stop</td>
		        <td>End Stop</td>
		        <td>Length (km)</td>
		        <td>Trip Time (hh:mm:ss)</td>
		        <td>&nbsp;</td>
		        <?php if ($session->is_logged_in() && $session->object_type == 5) { ?>
		        <td>&nbsp;</td>
		        <td>&nbsp;</td>
		        <?php } ?>
	        </tr>
	      </thead>
	      <tbody>
        	
        	<?php foreach($routes as $route){ ?>
        		<tr align="center">
	        		<td><?php echo $route->route_number; ?></td>
	        		<td><?php echo $stop->find_by_id($route->begin_stop)->name; ?></td>
	        		<td><?php echo $stop->find_by_id($route->end_stop)->name; ?></td>
	        		<td><?php echo $route->length; ?></td>
	        		<td><?php echo $route->trip_time; ?></td>
	        		<td><a href="admin_read_update_route.php?routeid=<?php echo $route->id; ?>" class="btn btn-warning btn-block">Route Profile</a></td>
	        		<?php if ($session->is_logged_in() && $session->object_type == 5) { ?>
	        		<td><a href="admin_view_route_data.php?routeid=<?php echo $route->id; ?>" class="btn btn-success btn-block">Route Data</a></td>
	        		<td><a href="admin_delete_route.php?routeid=<?php echo $route->id; ?>" class="btn btn-danger btn-block">Delete Route</a></td>
	        		<?php } ?>        		
        		</tr>
        	<?php } ?>
        	
          </tbody>
          
        </table>
        
        </section>
        
        </div>
        
        </div>
        
      </div>
      <!-- End Content -->
      
      <div class="clearfix">&nbsp;</div>

      <div id="push"></div>
    </div>

    <?php require_once('../../includes/layouts/footer_admin.php');?>

    <?php require_once('../../includes/layouts/scripts_admin.php');?>

  </body>
</html>
