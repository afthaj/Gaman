<?php
require_once("../includes/initialize.php");

if ($session->is_logged_in() && $session->object_type == 6){
	
	$user = Commuter::find_by_id($_SESSION['id']);
	$p = new Photograph();
	$profile_picture = $p->get_profile_picture($user->id, "commuter");
	
} else if ($session->is_logged_in() && $session->object_type != 6) {
	
	//redirect_to("login.php");
	
}

$routes = BusRoute::find_all();
$stop = new BusStop();

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Routes List &middot; <?php echo WEB_APP_NAME; ?></title>
    <?php require_once('../includes/layouts/header.php');?>
  </head>

  <body>


    <!-- Part 1: Wrap all page content here -->
    <div id="wrap">

      <!-- Fixed navbar -->
      <?php require_once('../includes/layouts/navbar.php');?>
      
      <header class="jumbotron subhead">
		 <div class="container-fluid">
		   <h1>List of Bus Routes</h1>
		 </div>
	  </header>

      <!-- Begin page content -->
        
      <!-- Start Content -->
      
      <div class="container-fluid">
        
        <div class="row-fluid">
        
        <div class="span12">
        
        <section>
        
        <table class="table table-bordered table-hover">
          <thead>
	        <tr align="center">
		        <td>Route Number</td>
		        <td>Begin Stop</td>
		        <td>End Stop</td>
		        <td>Length (km)</td>
		        <td>Trip Time (hh:mm:ss)</td>
		        <td>&nbsp;</td>
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
	        		<td><a href="public_read_route.php?routeid=<?php echo $route->id; ?>" class="btn btn-warning btn-block">Route Profile</a></td>        		
        		</tr>
        	<?php }?>
        	
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

    <?php require_once('../includes/layouts/footer.php');?>

    <?php require_once('../includes/layouts/scripts.php');?>

  </body>
</html>
