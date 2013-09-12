<?php
require_once("../../includes/initialize.php");

if ($session->is_logged_in() && $session->object_type == 5){
	
	$user = AdminUser::find_by_id($_SESSION['id']);
	$p = new Photograph();
	$profile_picture = $p->get_profile_picture($session->object_type, $user->id);
	
} else if ($session->is_logged_in() && $session->object_type == 4){
	
	$user = BusPersonnel::find_by_id($_SESSION['id']);
	$p = new Photograph();
	$profile_picture = $p->get_profile_picture($session->object_type, $user->id);
	
} else {
	redirect_to("login.php");
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Test &middot; <?php echo WEB_APP_NAME; ?></title>
    <?php require_once('../../includes/layouts/header_admin.php');?>
  </head>

  <body>


    <!-- Part 1: Wrap all page content here -->
    <div id="wrap">

      <!-- Fixed navbar -->
      <?php $page = 'test';?>
      <?php require_once('../../includes/layouts/navbar_admin.php');?>

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
		        	<a href="#" class="btn btn-primary"> &larr; Back </a>
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
       	  	  	
       	  	  	?>
       	  	  	
       	  	  </section>
       	  	  
       	  	  </div>
       	  	  
       	  	  <div class="row-fluid">
       	  	  <section>
       	  	  	<div id="chart_div" style="width: 100%;"></div>
       	  	  </section>
       	  	  </div>
       	  	  
       	  	  <div class="row-fluid">
       	  	  <section>
       	  	  	<div id="chart_2_div" style="width: 100%;"></div>
       	  	  </section>
       	  	  </div>
       	  	  
       	  	  <div class="row-fluid">
       	  	  <section>
       	  	  	<div id="chart_3_div" style="width: 100%;"></div>
       	  	  </section>
       	  	  </div>
	       	  
	       	  </div>
       	  
	      </div>
	      
      </div>

      <!-- End Content -->
        
      

      <div id="push"></div>
    </div>

    <?php require_once('../../includes/layouts/footer_admin.php');?>

    <?php require_once('../../includes/layouts/scripts_admin.php');?>

  </body>
</html>
