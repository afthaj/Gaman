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
	
		if (isset($_POST['submit'])) {
	
			$stop_to_create = new BusStop();
	
			$stop_to_create->name = $_POST['name'];
			$stop_to_create->location_latitude = $_POST['location_latitude'];
			$stop_to_create->location_longitude = $_POST['location_longitude'];
	
			if ($stop_to_create->create()){
				$session->message("Success! The new Bus Stop has been added. ");
				redirect_to('admin_list_stops.php');
			} else {
				$session->message("Error! The Bus Stop could not be added. ");
			}
		}
	
	} else {
		$session->message("Error! You do not have sufficient priviledges to view the requested page. ");
		redirect_to("index.php");
	}
	
} else {
	$session->message("Error! You must login to view the requested page. ");
	redirect_to("login.php");
}

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Add Bus Stop &middot; <?php echo WEB_APP_NAME; ?></title>
    <?php require_once('../../includes/layouts/header_admin.php');?>
  </head>

  <body>


    <!-- Part 1: Wrap all page content here -->
    <div id="wrap">

      <!-- Fixed navbar -->
      <?php require_once('../../includes/layouts/navbar_admin.php');?>

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
	        	<a href="admin_list_stops.php" class="btn btn-primary btn-block"><i class="icon-arrow-left icon-white"></i> Back to Stops List</a>
	        </div>
        </div>
        
        
        <div class="span9">
        
        <section>
        
        <?php echo $session->message; ?>
        
        <form class="form-horizontal" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
            
            <div class="control-group">
            <label for="name" class="control-label">Name of Bus Stop</label>
	            <div class="controls">
	            	<input type="text" value="" name="name">
	            </div>
            </div>
            
            <div class="control-group">
            <label for="location_latitude" class="control-label">Geo Location:<br />Latitude</label>
	            <div class="controls">
	            	<input type="text" value="" name="location_latitude">
	            </div>
            </div>
            
            <div class="control-group">
            <label for="location_longitude" class="control-label">Geo Location:<br />Longitude</label>
	            <div class="controls">
	            	<input type="text" value="" name="location_longitude">
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

    <?php require_once('../../includes/layouts/footer_admin.php');?>

    <?php require_once('../../includes/layouts/scripts_admin.php');?>

  </body>
</html>