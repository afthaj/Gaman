<?php
require_once("../../includes/initialize.php");

if ($session->is_logged_in() && $session->object_type == 5){
	
	$user = AdminUser::find_by_id($_SESSION['id']);
	$p = new Photograph();
	$profile_picture = $p->get_profile_picture($session->object_type, $user->id);
	
	$stops = BusStop::find_all();
	
	if (isset($_POST['submit'])) {
	
		$route_to_create = new Route();
	
		$route_to_create->route_number = $_POST['route_number'];
		$route_to_create->length = $_POST['length'];
		$route_to_create->trip_time = $_POST['trip_time'];
		$route_to_create->begin_stop = $_POST['begin_stop'];
		$route_to_create->end_stop = $_POST['end_stop'];
	
		if ($route_to_create->create()){
			$session->message("Success! The new Route has been added. ");
			redirect_to('admin_list_routes.php');
		} else {
			$session->message("Error! The Route could not be added. ");
		}
	}
	
} else {
	redirect_to("login.php");
}

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Add Bus Route &middot; <?php echo WEB_APP_NAME; ?></title>
    <?php require_once('../../includes/layouts/header_admin.php');?>
  </head>

  <body>


    <!-- Part 1: Wrap all page content here -->
    <div id="wrap">

      <!-- Fixed navbar -->
      <?php require_once('../../includes/layouts/navbar_admin.php');?>
      
      <header class="jumbotron subhead">
        <div class="container-fluid">
        	<h1>Add New Bus Route</h1>
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
        
        <form class="form-horizontal" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
            
            <div class="control-group">
            <label for="route_number" class="control-label">Route Number</label>
	            <div class="controls">
	            	<input type="text" value="" name="route_number">
	            </div>
            </div>
            
            <div class="control-group">
        	<label for="length" class="control-label">Length</label>
	        	<div class="controls">
	        		<input type="text" name="length">
	        	</div>
        	</div>
            
            <div class="control-group">
            <label for="trip_time" class="control-label">Trip Time</label>
	            <div class="controls">
	            	<input type="text" value="" name="trip_time">
	            </div>
            </div>
            
            <div class="control-group">
            <label for="begin_stop" class="control-label">Begin Stop</label>
            <div class="controls">
	            <select name="begin_stop">
	            <?php 
	            foreach($stops as $stop){
	            ?>
	            	<option value="<?php echo $stop->name; ?>"><?php echo $stop->name; ?></option>
	            <?php
	            }
	            ?>
				</select>
	            </div>
            </div>
            
            <div class="control-group">
            <label for="end_stop" class="control-label">End Stop</label>
	            <div class="controls">
		            <select name="end_stop">
		            <?php 
		            foreach($stops as $stop){
		            ?>
		            	<option value="<?php echo $stop->name; ?>"><?php echo $stop->name; ?></option>
		            <?php
		            }
		            ?>
					</select>
	            </div>
            </div>
            
          	<div class="form-actions">
        	    <button class="btn btn-primary" name="submit">Submit</button>
        	</div>
        </form>
	  	
	  	</section>
	  	
	  	</div>
	  	
	  	<!-- End Content -->
	  	
	  	</div>
	  	
	  	</div>

        <!-- End page content -->
        
      
      <div class="clearfix">&nbsp;</div>

      <div id="push"></div>
    </div>

    <?php require_once('../../includes/layouts/footer_admin.php');?>

    <?php require_once('../../includes/layouts/scripts_admin.php');?>

  </body>
</html>