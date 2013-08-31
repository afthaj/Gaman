<?php
require_once("../../includes/initialize.php");

if (!$session->is_logged_in()){
	redirect_to("login.php");
} else {
	$admin_user = AdminUser::find_by_id($_SESSION['id']);
	$p = new Photograph();
	$profile_picture = $p->get_profile_picture_of_admin_user($admin_user->id, "admin");
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
	       	  
	       	  <div class="span6">
	       	  	<?php echo $session->message; ?>
	       	  	
	       	  	
	       	  	
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
