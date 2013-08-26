<?php
require_once("../includes/initialize.php");

if (!$session->is_logged_in()){
	redirect_to("login.php");
} else {
	$admin_user = Admin::find_by_id($_SESSION['id']);
	$stops = BusStop::find_all();
}

if (isset($_POST['submit'])) {
	
	$route_to_create = new Route();
	
	$route_to_create->route_number = $_POST['route_number'];
	$route_to_create->length = $_POST['length'];
	$route_to_create->trip_time = $_POST['trip_time'];
	$route_to_create->begin_stop = $_POST['begin_stop'];
	$route_to_create->end_stop = $_POST['end_stop'];
	
	if ($route_to_create->create()){
		$session->message("Success! The new Route has been added. ");
		redirect_to('admin_routes_list.php');
	} else {
		$session->message("Error! The Route could not be added. ");
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
      
      <div class="container">
        <div class="page-header">
          <h1>Add New Bus Stop</h1>
        </div>
        
        <!-- Start Content -->
        
        <?php echo $session->message; ?>
        
        <div class="col-lg-6">
        <form action="admin_create_admin_user.php" method="POST">
            
            <div class="form-group">
            <label for="route_number">Route Number</label>
            <input type="text" value="" name="route_number" class="form-control">
            </div>
            
            <div class="form-group">
        	<label for="length">Length</label>
        	<input type="text" name="length" class="form-control">
        	</div>
            
            <div class="form-group">
            <label for="trip_time">Trip Time</label>
            <input type="text" value="" name="trip_time" class="form-control">
            </div>
            
            <div class="form-group">
            <label for="begin_stop">Begin Stop</label>
            <select name="begin_stop" class="form-control">
            <?php 
            foreach($stops as $stop){
            ?>
            	<option value="<?php echo $stop->name; ?>"><?php echo $stop->name; ?></option>
            <?php
            }
            ?>
			</select>
            </div>
            
            <div class="form-group">
            <label for="end_stop">End Stop</label>
            <select name="end_stop" class="form-control">
            <?php 
            foreach($stops as $stop){
            ?>
            	<option value="<?php echo $stop->name; ?>"><?php echo $stop->name; ?></option>
            <?php
            }
            ?>
			</select>
            </div>
            
          	<div>
        	    <button class="btn btn-primary" name="submit">Submit</button>
        	</div>
        </form>
	  	</div>

        <!-- End Content -->
        
      </div>

      <div id="push"></div>
    </div>

    <?php require_once('../includes/layouts/footer_admin.php');?>

    <?php require_once('../includes/layouts/bootstrap_scripts_admin.php');?>

  </body>
</html>