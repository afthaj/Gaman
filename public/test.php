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
    <title>Test &middot; <?php echo WEB_APP_NAME; ?></title>
    <?php require_once('./includes/layouts/header.php');?>
  </head>

  <body>


    <!-- Part 1: Wrap all page content here -->
    <div id="wrap">

      <!-- Fixed navbar -->
      <?php $page = 'test';?>
      <?php require_once('./includes/layouts/navbar.php');?>

      <!-- Begin page content -->
      
      <header class="jumbotron subhead">
        <div class="container-fluid">
          <h1>Test Page</h1>
        </div>
      </header>
        
      <!-- Start Content -->
        
      <div class="container-fluid">
       	  
       	  <div class="row-fluid">
       	  <div class="span3">
       	  	<div class="sidenav" data-spy="affix" data-offset-top="200">
	        	<a href="#" class="btn btn-primary btn-block"><i class="icon-arrow-left icon-white"></i> Back to Home Page</a>
	        </div>
       	  </div>
       	  
       	  <div class="span9">
       	  
       	  <div class="row-fluid">
	       	  <section>
	       	  
       	  	  	<?php echo $session->message; ?>
       	  	  	
       	  	  	<?php 
       	  	  	
       	  	  	$time = time();
       	  	  	
       	  	  	echo $time;
       	  	  	
       	  	  	echo '<br /><br />';
       	  	  	
       	  	  	print_r(getdate($time));
       	  	  	
       	  	  	echo '<br /><br />';
       	  	  	
       	  	  	print date("r", $time);
       	  	  	
       	  	  	echo '<br /><br />';
       	  	  	
       	  	  	print date("d/m/y h:i:s a", $time);
       	  	  	
       	  	  	echo '<br /><br />';
       	  	  	
       	  	  	print date("d/m/Y h:i:s a", mktime(13, 29, 45, 11, 18, 1988));
       	  	  	
       	  	  	echo '<br /><br />';
       	  	  	
       	  	  	echo mktime(00, 00, 00, 11, 18, 1988);
       	  	  	echo '<br /><br />';
       	  	  	
       	  	  	echo PHP_OS;
       	  	  	
       	  	  	echo '<br /><br />';
       	  	  	
       	  	  	echo php_uname('s');
       	  	  	
       	  	  	
       	  	  	
       	  	  	?>
       	  	  	
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
