<?php
require_once("../../includes/initialize.php");

//init code
$photo_object = new Photograph();
$admin_user_object = new AdminUser();

$route_object = new BusRoute();
$stop_object = new BusStop();
$bus_object = new Bus();

$survey_object = new Survey();
$trip_object = new Trip();
$stop_activity_object = new StopActivity();

//check login
if ($session->is_logged_in()){
	
	if ($session->object_type == 5){
		//admin user
	
		$user = $admin_user_object->find_by_id($_SESSION['id']);
		$profile_picture = $photo_object->get_profile_picture($session->object_type, $user->id);
	
	} else {
		$session->message("Error! You must login to view the requested page. ");
		redirect_to("login.php");
	}
	
	//GET request stuff
	if (!empty($_GET['tripid'])){
		
		$trip_to_read = $trip_object->find_by_id($_GET['tripid']);
		$stop_activities = $stop_activity_object->get_stop_activities_for_trip($trip_to_read->id);
		
	} else {
		
		$session->message("No Trip was selected.");
		redirect_to("admin_list_routes.php");
		
	}
	
} else {
	$session->message("Error! You must login to view the requested page. ");
	redirect_to("login.php");
}

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Trip Info &middot; <?php echo WEB_APP_NAME; ?></title>
    <?php require_once('../../includes/layouts/header_admin.php');?>
  </head>

  <body>


    <!-- Part 1: Wrap all page content here -->
    <div id="wrap">

      <!-- Fixed navbar -->
      <?php require_once('../../includes/layouts/navbar_admin.php');?>

      <header class="jumbotron subhead">
        <div class="container-fluid">
        	<h1>Trip Information</h1>
        	<h3>Started from <?php echo $stop_object->find_by_id($trip_to_read->begin_stop)->name; ?> &middot; Ended at <?php echo $stop_object->find_by_id($trip_to_read->end_stop)->name; ?></h3>
        	<h4>Started at <?php echo strftime("%I:%M:%S %p", $trip_to_read->departure_from_begin_stop); ?> &middot; Ended at <?php echo strftime("%I:%M:%S %p", $trip_to_read->arrival_at_end_stop); ?></h4>
        </div>
      </header> 
      
      <!-- Begin page content -->
      <div class="container-fluid">
      <div class="row-fluid">
        <!-- Start Content -->
        
        <div class="span3">
        	<div class="sidenav" data-spy="affix" data-offset-top="200">
        		<a href="admin_list_routes.php" class="btn btn-primary btn-block"><i class="icon-arrow-left icon-white"></i> Back to Routes List</a>
        	</div>
        </div>
        
        <div class="span9">
        
        <section>
        
        <?php 
        
        if(!empty($session->message)){
        	
        	echo '<div class="alert">';
        	echo '<button type="button" class="close" data-dismiss="alert">&times;</button>';
        	//echo '<p>';
        	echo $session->message;
        	//echo '</p>';
        	echo '</div>';
        }
        
        ?>
        
        <?php if ($stop_activities) { ?>
        
        <table class="table table-bordered table-hover">
      
	      <tr>
		   <td align="center">Bus Stop</td>
		   <td align="center">Alighted Commuters</td>
		   <td align="center">Boarded Commuters</td>
		   <td align="center">Time Arrived at Stop</td>
		   <td align="center">Time Departed from Stop</td>
	      </tr>
	      
	      <?php foreach($stop_activities as $sa) { ?>
	      <tr>
		   <td align="center"><?php echo $stop_object->find_by_id($sa->stop_id)->name; ?></td>
		   <td align="center"><?php echo $sa->alighted_commuters; ?></td>
		   <td align="center"><?php echo $sa->boarded_commuters; ?></td>
		   <td align="center"><?php if (!empty($sa->arrival_time)) { echo strftime("%I:%M:%S %p", $sa->arrival_time); } else {echo '0'; } ?></td>
		   <td align="center"><?php if (!empty($sa->departure_time)) { echo strftime("%I:%M:%S %p", $sa->departure_time);  } else {echo '0'; } ?></td>
	      </tr>
	      <?php } ?>
	      
	    </table>
	    
	    <?php } else { ?>
	      <div class="alert">
	      No Stop Activities recorded
	      <button type="button" class="close" data-dismiss="alert">&times;</button>
	      </div>
      	<?php } ?>
        
        </section>
        	
        </div>

        <!-- End Content -->
      </div>
      </div>
      <!-- End page content --> 
      
      <div id="push"></div>
    </div>

    <?php require_once('../../includes/layouts/footer_admin.php');?>

    <?php require_once('../../includes/layouts/scripts_admin.php');?>

  </body>
</html>