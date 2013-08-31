<?php
require_once("../includes/initialize.php");

if (!$session->is_logged_in()){
	//redirect_to("login.php");
} else {
	$admin_user = AdminUser::find_by_id($_SESSION['id']);
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Test &middot; <?php echo WEB_APP_NAME; ?></title>
    <?php require_once('../includes/layouts/header.php');?>
  </head>

  <body>


    <!-- Part 1: Wrap all page content here -->
    <div id="wrap">

      <!-- Fixed navbar -->
      <?php $page = 'test';?>
      <?php require_once('../includes/layouts/navbar.php');?>

      <!-- Begin page content -->
      
      <header class="jumbotron subhead">
        <div class="container-fluid">
          <h1>Test Page</h1>
        </div>
      </header>
        
      <!-- Start Content -->
        
      <div class="container-fluid">
       	  
       	  <div class="row-fluid">
       	  	<div class="sidenav" data-spy="affix" data-offset-top="200">
	        	<a href="#" class="btn btn-primary"> &larr; Back </a>
	        </div>
       	  <div class="span3">
       	  </div>
       	  
       	  <div class="span6">
       	  	<?php echo $session->message; ?>
       	  	
       	  	
       	  	
       	  </div>
       	  
	      </div>
	      
      </div>

      <!-- End Content -->
        
      

      <div id="push"></div>
    </div>

    <?php require_once('../includes/layouts/footer.php');?>

    <?php require_once('../includes/layouts/scripts.php');?>

  </body>
</html>
