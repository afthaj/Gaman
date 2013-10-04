<?php
require_once("./includes/initialize.php");

//init code
$photo_object = new Photograph();
$commuter_object = new Commuter();

//check login
if ($session->is_logged_in()){
	
	if ($session->object_type == 6) {
		//commuter
	
		$user = $commuter_object->find_by_id($_SESSION['id']);
		$profile_picture = $photo_object->get_profile_picture($session->object_type, $user->id);
	}
	
}

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <title>User Manual &middot; <?php echo WEB_APP_NAME; ?></title>
    <?php require_once('./includes/layouts/header.php');?>
  </head>

  <body>


    <!-- Part 1: Wrap all page content here -->
    <div id="wrap">

      <!-- Fixed navbar -->
      <?php $page = 'user_manual';?>
      <?php require_once('./includes/layouts/navbar.php');?>

      <!-- Begin page content -->
      
      <header class="jumbotron subhead">
        <div class="container-fluid">
          <h1>User Manual</h1>
        </div>
      </header>
        
      <!-- Start Content -->
        
      <div class="container-fluid">
       	  
       	  <div class="row-fluid">
       	  <div class="span3">
       	  	<div class="sidenav" data-spy="affix" data-offset-top="200">
	        	<a href="index.php" class="btn btn-primary btn-block"><i class="icon-arrow-left icon-white"></i> Back to Home Page</a>
	        </div>
       	  </div>
       	  
       	  <div class="span9 marketing">
       	  
       	  <div class="row-fluid" style="text-align: justify">
	       	  <section>
	       	  
	       	  <h3>Key words/phrases</h3>
	       	  
	       	  <div class="well">
	       	  
	       	  	<h4>Bus Routes</h4>
	       	  	<p>Bus Routes refer to the routes that the buses provide the service on. They consist of a Beginning Bus Stop, an Ending Bus Stop and Bus Stops in between. One Bus Route may have many Stops. </p>
	       	  
	       	  	<h4>Bus Stops</h4>
	       	  	<p>This refers to the place allocated for a Bus to stop and drop off and/or pick up passengers. This is also known as the Bus Stand.</p>
	       	  	
	       	  	<h4>Buses</h4>
	       	  	<p>This refers to the individual Buses that operate and provide the service to the commuters. One Bus is assigned to only one Bus Route. One Bus may have many Bus Personnel attached to it. </p>
	       	  	
	       	  	<h4>Bus Personnel</h4>
	       	  	<p>This refers to the people involved with the operation of the buses. This includes the Bus Driver, the Bus Conductor and the Bus Owner. In certain instances, these roles overlap. Accordingly, there may be situations where a Bus Driver is also an Owner or a Bus Conductor who is also an Owner. Each Bus Person (singular of Personnel) is assigned to only one Bus.</p>
       	  	  
       	  	  	<h4>Feedback</h4>
	       	  	<p>This refers to general comments you may have about the bus transport service. You can submit feedback (positive or negative) regarding Bus Routes, Stops, Buses and Personnel.</p>
	       	  	
	       	  	<h4>Complaints</h4>
	       	  	<p>This refers specifically to negative feedback regarding the bus service. You can submit Complaints regarding Bus Routes, Stops, and Buses. As Bus Personnel are connected to the Buses, any Complaint submitted on the Bus will automatically be connected to the respective Bus Personnel. This foregoes the need to identify the person as the user need only remember the Bus's Registration Number to find out the respective Bus Personnel</p>
       	  	  
       	  	  </div>
       	  	  	
       	  	  </section>
       	  	  
		  </div>
       	  
       	  </div>
       	  
	      </div>
	      
      </div>

      <!-- End Content -->
        
      

      <div id="push"></div>
    </div>

    <?php require_once('./includes/layouts/footer.php');?>

    <?php require_once('./includes/layouts/scripts.php');?>

  </body>
</html>
