<?php
require_once("../../includes/initialize.php");

if ($session->is_logged_in() && $session->object_type == 5){
	
	$user = AdminUser::find_by_id($_SESSION['id']);
	$p = new Photograph();
	$profile_picture = $p->get_profile_picture($session->object_type, $user->id);
	
	if (isset($_POST['submit'])) {
	
		$bus_to_create = new Bus();
	
		$bus_to_create->route_id = $_POST['route_id'];
		$bus_to_create->reg_number = $_POST['reg_number'];
		$bus_to_create->name = $_POST['name'];
	
		if ($bus_to_create->create()){
			$session->message("Success! The new Bus has been added. ");
			redirect_to('admin_list_buses.php');
		} else {
			$session->message("Error! The Bus could not be added. ");
		}
	}
	
} else {
	redirect_to("login.php");
}

$routes = BusRoute::find_all();

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
          <h1>Add New Bus</h1>
        </div>
      </header>
      
      <div class="container-fluid">
      
      <div class="row-fluid">
      
        <!-- Start Content -->
        
        <div class="span3">
        	<div class="sidenav" data-spy="affix" data-offset-top="200">
        		<a href="admin_list_buses.php" class="btn btn-primary"> &larr; Back to Buses List</a>
        	</div>
        </div>

        <div class="span9">
        
        <section>
        
        <?php echo $session->message; ?>
        
        <form class="form-horizontal" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
            
            <div class="control-group">
            <label for="route_id" class="control-label">Route Number</label>
	            <div class="controls">
	            	<select name="route_id">
					<?php foreach($routes as $route){ ?>
	            		<option value="<?php echo $route->id; ?>"><?php echo $route->route_number; ?></option>
	            	<?php } ?>
					</select>
	            </div>
            </div>
            
            <div class="control-group">
        	<label for="reg_number" class="control-label">Registration Number</label>
	        	<div class="controls">
	        		<input type="text" name="reg_number">
	        	</div>
        	</div>
            
            <div class="control-group">
            <label for="name" class="control-label">Name of Bus</label>
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

        <!-- End Content -->
        
        </div>
        
        </div>

      <div id="push"></div>
    </div>

    <?php require_once('../../includes/layouts/footer_admin.php');?>

    <?php require_once('../../includes/layouts/scripts_admin.php');?>

  </body>
</html>