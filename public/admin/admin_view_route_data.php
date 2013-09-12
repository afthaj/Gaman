<?php
require_once("../../includes/initialize.php");

if ($session->is_logged_in() && $session->object_type == 5){
	
	$user = AdminUser::find_by_id($_SESSION['id']);
	$p = new Photograph();
	$profile_picture = $p->get_profile_picture($session->object_type, $user->id);
	
	if (isset($_GET['routeid'])){
		$route_to_read_update = BusRoute::find_by_id($_GET['routeid']);
	} else {
		$session->message("No Route ID provided to view.");
		redirect_to("admin_list_routes.php");
	}
	
} else {
	redirect_to("login.php");
}

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Route Data &middot; <?php echo WEB_APP_NAME; ?></title>
    <?php require_once('../../includes/layouts/header_admin.php');?>
  </head>

  <body>


    <!-- Part 1: Wrap all page content here -->
    <div id="wrap">

      <!-- Fixed navbar -->
      <?php require_once('../../includes/layouts/navbar_admin.php');?>

      <header class="jumbotron subhead">
        <div class="container-fluid">
        	<h1>Route Data</h1>
        	<h3>Route Number: <?php echo $route_to_read_update->route_number;?></h3>
        </div>
      </header>
      
      <!-- Begin page content -->
      <div class="container-fluid">
      <div class="row-fluid">
        <!-- Start Content -->
        
        <div class="span3">
        	<div class="sidenav" data-spy="affix" data-offset-top="200">
        		<a href="admin_list_routes.php" class="btn btn-primary"> &larr; Back to Routes List</a>
        	</div>
        </div>
        
        <div class="span9">
        
        <section>
        
        <?php echo $session->message; ?>
        
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