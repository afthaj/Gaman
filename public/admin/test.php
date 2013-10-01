<?php
require_once("../../includes/initialize.php");

//init code
$photo_object = new Photograph();
$admin_user_object = new AdminUser();
$bus_personnel_object = new BusPersonnel();

//check login
if ($session->is_logged_in()){
	
	if ($session->object_type == 5){
		//admin user
	
		$user = $admin_user_object->find_by_id($_SESSION['id']);
		$profile_picture = $photo_object->get_profile_picture($session->object_type, $user->id);
	
	} else if ($session->object_type == 4){
		//bus personnel
	
		$user = $bus_personnel_object->find_by_id($_SESSION['id']);
		$profile_picture = $photo_object->get_profile_picture($session->object_type, $user->id);
	
	} else {
		//everyone else
		
		$session->message("Error! You do not have sufficient priviledges to view the requested page. ");
		redirect_to("index.php");
	}
	
} else {
	//not logged in... GTFO!
	
	$session->message("Error! You must login to view the requested page. ");
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
		        	<a href="index.php" class="btn btn-primary btn-block"><i class="icon-arrow-left icon-white"></i> Back to Home Page</a>
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
       	  	  	
       	  	  	echo '<br /><hr /><br />';
       	  	  	
       	  	  	echo PHP_OS;
       	  	  	
       	  	  	echo '<br /><br />';
       	  	  	
       	  	  	echo php_uname('s');
       	  	  	
       	  	  	echo '<br /><hr /><br />';
       	  	  	echo 'now: '. date("d M Y h:i:s a", strtotime("now"));
       	  	  	echo '<br />';
       	  	  	echo '10th sept 2000: '. date("d/m/Yd M Y h:i:s a", strtotime("10 September 2000"));
       	  	  	echo '<br />';
       	  	  	echo '-1 day: '. date("d M Y h:i:s a", strtotime("-1 day"));
       	  	  	echo '<br />';
       	  	  	echo '-3 days: '. date("d M Y h:i:s a", strtotime("-3 days"));
       	  	  	echo '<br />';
       	  	  	echo '-1 week: '. date("d M Y h:i:s a", strtotime("-1 week"));
       	  	  	echo '<br />';
       	  	  	echo '+1 week 2 days 4 hours 2 seconds: '. date("d M Y h:i:s a", strtotime("+1 week 2 days 4 hours 2 seconds"));
       	  	  	echo '<br />';
       	  	  	echo 'next Thursday: '. date("d M Y h:i:s a", strtotime("next Thursday"));
       	  	  	echo '<br />';
       	  	  	echo 'last Monday: '. date("d M Y h:i:s a", strtotime("last Monday"));
       	  	  	
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
