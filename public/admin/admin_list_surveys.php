<?php
require_once("../../includes/initialize.php");

//init code
$photo_object = new Photograph();
$admin_user_object = new AdminUser();
$route_object = new BusRoute();
$survey_object = new Survey();

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
	if (!empty($_GET['routeid'])){
		
		$route_to_read_update = $route_object->find_by_id($_GET['routeid']);
		$surveys = $survey_object->get_surveys_for_route($route_to_read_update->id);
		
	} else {
		
		$surveys = $survey_object->find_all();
		
		//$session->message("No Route ID provided to view.");
		//redirect_to("admin_list_routes.php");
	}
	
} else {
	$session->message("Error! You must login to view the requested page. ");
	redirect_to("login.php");
}

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Surveys &middot; <?php echo WEB_APP_NAME; ?></title>
    <?php require_once('../../includes/layouts/header_admin.php');?>
  </head>

  <body>


    <!-- Part 1: Wrap all page content here -->
    <div id="wrap">

      <!-- Fixed navbar -->
      <?php require_once('../../includes/layouts/navbar_admin.php');?>

      <header class="jumbotron subhead">
        <div class="container-fluid">
        	<h1>List of Surveys</h1>
        	<?php if (!empty($_GET['routeid'])) { ?>
        	<h3>Route Number: <?php echo $route_to_read_update->route_number;?></h3>
        	<?php } ?>
        </div>
      </header>
      
      <!-- Begin page content -->
      <div class="container-fluid">
      <div class="row-fluid">
        <!-- Start Content -->
        
        <div class="span3">
        	<div class="sidenav" data-spy="affix" data-offset-top="200">
        	<?php if (!empty($_GET['routeid'])) { ?>
        		<a href="admin_list_routes.php" class="btn btn-primary btn-block"><i class="icon-arrow-left icon-white"></i> Back to Routes List</a>
        	<?php } else { ?>
        		<a href="index.php" class="btn btn-primary btn-block"><i class="icon-arrow-left icon-white"></i> Back to Home Page</a>
        	<?php } ?>
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
        
        <table class="table table-bordered table-hover">
      
	      <tr>
		   <td align="center">Survey Start Date</td>
		   <td align="center">Survey End Date</td>
		   <td>&nbsp;</td>
	      </tr>
	      
	      <?php foreach($surveys as $survey) { ?>
	      <tr>
		   <td align="center"><?php echo strftime("%B %d, %Y", $survey->start_date); ?></td>
		   <td align="center"><?php echo strftime("%B %d, %Y", $survey->end_date); ?></td>
		   <td><a href="admin_list_trips.php?tripid=<?php echo $survey->id; ?>" class="btn btn-warning btn-block"><i class="icon-info-sign icon-white"></i> Details</a></td>
	      </tr>
	      <?php } ?>
	      
	    </table>
        
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