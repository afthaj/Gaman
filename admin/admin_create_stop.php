<?php
require_once("../includes/initialize.php");

if (!$session->is_logged_in()){
	redirect_to("login.php");
} else {
	$admin_user = Admin::find_by_id($_SESSION['id']);
	$stops = BusStop::find_all();
}

if (isset($_POST['submit'])) {
	
	$stop_to_create = new BusStop();
	
	$stop_to_create->name = $_POST['name'];
	
	if ($stop_to_create->create()){
		$session->message("Success! The new Bus Stop has been added. ");
		redirect_to('admin_stops_list.php');
	} else {
		$session->message("Error! The Bus Stop could not be added. ");
	}
}

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Add Bus Stop &middot; Gaman</title>
    <?php require_once('../includes/layouts/header_admin.php');?>
  </head>

  <body>


    <!-- Part 1: Wrap all page content here -->
    <div id="wrap">

      <!-- Fixed navbar -->
      <?php require_once('../includes/layouts/navbar_admin.php');?>

      <!-- Begin page content -->
      
      <header class="jumbotron subhead">
        <div class="container-fluid">
          <h1>Add New Bus Stop</h1>
        </div>
      </header>
        
        <!-- Start Content -->
        
        <div class="container-fluid">
        
        <div class="row-fluid">
        
        <div class="span3">
	        <div class="sidenav" data-spy="affix" data-offset-top="200">
	        	<a href="admin_stops_list.php" class="btn btn-primary"> &larr; Back to Stops List</a>
	        </div>
        </div>
        
        
        <div class="span9">
        
        <section>
        
        <?php echo $session->message; ?>
        
        <form class="form-horizontal" action="admin_create_stop.php" method="POST">
            
            <div class="control-group">
            <label for="name" class="control-label">Name of Bus Stop</label>
	            <div class="controls">
	            	<input type="text" value="" name="name">
	            </div>
            </div>
            
          	<div class="form-actions">
        	    <button class="btn btn-primary" name="submit">Submit</button>
        	</div>
        </form>
        
        </section>
        
	  	</div>
	  	
	  	</div>

        <!-- End Content -->
        
      </div>
      
      <div class="clearfix">&nbsp;</div>
      
      <div id="push"></div>
    </div>

    <?php require_once('../includes/layouts/footer_admin.php');?>

    <?php require_once('../includes/layouts/bootstrap_scripts_admin.php');?>

  </body>
</html>