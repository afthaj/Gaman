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
    <title>Survey Info &middot; <?php echo WEB_APP_NAME; ?></title>
    <?php require_once('./includes/layouts/header.php');?>
  </head>

  <body>


    <!-- Part 1: Wrap all page content here -->
    <div id="wrap">

      <!-- Fixed navbar -->
      <?php $page = 'survey_info';?>
      <?php require_once('./includes/layouts/navbar.php');?>

      <!-- Begin page content -->
      
      <header class="jumbotron subhead">
        <div class="container-fluid">
          <h1>Survey Info</h1>
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
	       	  
	       	  <div class="well">
	       	  
	       	  	<p>Thank you for taking the time to complete a short survey on this system. As this is a research prototype, your feedback is important to me in my research efforts.</p>
	       	  	
				<p>This survey should only take about 5 minutes of your time. Your answers will be completely anonymous and by filling out the survey you will be contributing to the improvement of the Bus Passenger Transport Service. All survey results will be used for my research thesis alone and no information will be used for commercial purposes. Click the button below to visit the survey, or scroll down if you prefer to complete the survey without leaving this site.</p>
				
				<p>If you have any questions about the survey, please contact me at gamantransport@gmail.com. I will reply to your emails as soon as I can. </p>
				
				<a href="https://docs.google.com/forms/d/100pWQ4476Mo4tqn3SHLmVO1r8cB-ayuQEdai8xWyjCI/viewform" class="btn btn-info btn-block" target="_blank">Click me!</a><br />
				
				<h3 style="text-align: center">Thank You :)</h3>
       	  	  
       	  	  </div>
       	  	  
       	  	  <div>
       	  	  
       	  	  <iframe class="span12" height="3000" src="https://docs.google.com/forms/d/100pWQ4476Mo4tqn3SHLmVO1r8cB-ayuQEdai8xWyjCI/viewform?embedded=true" frameborder="0" marginheight="0" marginwidth="0">Loading...</iframe>
       	  	  
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
