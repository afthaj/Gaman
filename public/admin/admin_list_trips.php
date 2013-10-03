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
	if (!empty($_GET['surveyid'])){
		
		$survey = $survey_object->find_by_id($_GET['surveyid']);
		$trips = $trip_object->get_trips_for_survey($survey->id);
		
	} else {
		
		$session->message("No Survey was selected.");
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
    <title>Survey Info &middot; <?php echo WEB_APP_NAME; ?></title>
    <?php require_once('../../includes/layouts/header_admin.php');?>
  </head>

  <body>


    <!-- Part 1: Wrap all page content here -->
    <div id="wrap">

      <!-- Fixed navbar -->
      <?php require_once('../../includes/layouts/navbar_admin.php');?>

      <header class="jumbotron subhead">
        <div class="container-fluid">
        	<h1>Survey Information</h1>
        	<h3>Started on <?php echo strftime("%d %b %Y", $survey->start_date); ?> &middot; Ended on <?php echo strftime("%d %b %Y", $survey->end_date); ?></h3>
        </div>
      </header>
      
      <!-- Begin page content -->
      <div class="container-fluid">
      <div class="row-fluid">
        <!-- Start Content -->
        
        <div class="span3">
        	<div class="sidenav" data-spy="affix" data-offset-top="200">
        		<a href="admin_list_surveys.php?routeid=<?php echo $survey->route_id; ?>" class="btn btn-primary btn-block"><i class="icon-arrow-left icon-white"></i> Back to List of Surveys</a>
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
        
        <?php if ($trips) { ?>
        
        <table class="table table-bordered table-hover">
      
	      <tr>
		   <td align="center">Route Number</td>
		   <td align="center">Bus Registration Number</td>
		   <td align="center">Begin Stop</td>
		   <td align="center">End Stop</td>
		   <td align="center">Departure from Begin Stop</td>
		   <td align="center">Arrival at End Stop</td>
		   <td>&nbsp;</td>
	      </tr>
	      
	      <?php foreach($trips as $trip) { ?>
	      <tr>
		   <td align="center"><?php echo $route_object->find_by_id($trip->route_id)->route_number; ?></td>
		   <td align="center"><?php echo $bus_object->find_by_id($trip->bus_id)->reg_number; ?></td>
		   <td align="center"><?php echo $stop_object->find_by_id($trip->begin_stop)->name; ?></td>
		   <td align="center"><?php echo $stop_object->find_by_id($trip->end_stop)->name; ?></td>
		   <td align="center"><?php echo strftime("%I:%M:%S %p", $trip->departure_from_begin_stop); ?></td>
		   <td align="center"><?php echo strftime("%I:%M:%S %p", $trip->arrival_at_end_stop); ?></td>
		   <td><a href="admin_view_trip_info.php?tripid=<?php echo $trip->id; ?>" class="btn btn-warning btn-block"><i class="icon-info-sign icon-white"></i> Trip Info</a></td>
	      </tr>
	      <?php } ?>
	      
	    </table>
	    
	    <?php } else { ?>
	      <div class="alert">
	      No Trips recorded
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