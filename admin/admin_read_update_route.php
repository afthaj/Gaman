<?php
require_once("../includes/initialize.php");

if (!$session->is_logged_in()){
	redirect_to("login.php");
} else {
	
	$admin_user = Admin::find_by_id($_SESSION['id']);
	$stops = BusStop::find_all();
	
	if (isset($_GET['routeid'])){
		$route_to_read_update = BusRoute::find_by_id($_GET['routeid']);
		
		$sr = new StopRoute();
		
		$stops_routes = $sr->get_stops_for_route($route_to_read_update->id);
		
	} else {
		$session->message("No Route ID provided to view.");
		redirect_to("admin_list_routes.php");
	}
	
	if (isset($_POST['submit'])){
		$route_to_read_update->route_number = $_POST['route_number'];
		$route_to_read_update->length = $_POST['length'];
		$route_to_read_update->trip_time = $_POST['trip_time'];
		$route_to_read_update->begin_stop = $_POST['begin_stop'];
		$route_to_read_update->end_stop = $_POST['end_stop'];
	
		if ($route_to_read_update->update()){
			$session->message("Success! The Route details were updated. ");
			redirect_to('admin_list_routes.php');
		} else {
			$session->message("Error! The Route details could not be updated. ");
		}
	}
	
}

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Route Details &middot; <?php echo WEB_APP_NAME; ?></title>
    <?php require_once('../includes/layouts/header_admin.php');?>
  </head>

  <body>


    <!-- Part 1: Wrap all page content here -->
    <div id="wrap">

      <!-- Fixed navbar -->
      <?php require_once('../includes/layouts/navbar_admin.php');?>
      
      <header class="jumbotron subhead">
		 <div class="container-fluid">
		   <h1>Route Profile</h1>
		 </div>
	  </header>
      
      <!-- Begin page content -->
      
      <div class="container-fluid">
      
      <div class="row-fluid">
      
        <div class="span3">
	        <div class="sidenav" data-spy="affix" data-offset-top="200">
	        	<a href="admin_list_routes.php" class="btn btn-primary"> &larr; Back to Routes List</a>
	        </div>
        </div>
        
        <!-- Start Content -->

        <div class="span9">
        
        <section>
        
        <?php echo $session->message; ?>
        
        <ul class="nav nav-tabs">
	      <li class="active"><a href="#route_stops_list" data-toggle="tab">List of Stops</a></li>
	      <li><a href="#route_profile" data-toggle="tab">Route Profile</a></li>
	    </ul>
	    
	    <div id="tab_content" class="tab-content">
	      	
	      	<div class="tab-pane fade" id="route_profile">
	      	
	      	<form class="form-horizontal" action="admin_read_update_route.php?routeid=<?php echo $_GET['routeid']; ?>" method="POST">
            
	            <div class="control-group">
	            <label for="route_number" class="control-label">Route Number</label>
		            <div class="controls">
		            	<input type="text" name="route_number" value="<?php echo $route_to_read_update->route_number; ?>">
		            </div>
	            </div>
	            
	            <div class="control-group">
	        	<label for="length" class="control-label">Route Length<br />(in km)</label>
		        	<div class="controls">
		        		<input type="text" name="length" value="<?php echo $route_to_read_update->length; ?>">
		        	</div>
	        	</div>
	        	
	        	<div class="control-group">
	        	<label for="trip_time" class="control-label">Trip Time<br />(Format = HH:MM:SS)</label>
		        	<div class="controls">
		        		<input type="text" name="trip_time" value="<?php echo $route_to_read_update->trip_time; ?>">
		        	</div>
	        	</div>
	            
	            <div class="control-group">
	            <label for="begin_stop" class="control-label">Begin Stop</label>
		            <div class="controls">
		            <select name="begin_stop">
		            <?php foreach($stops as $stop){ ?>
		            	<option value="<?php echo $stop->id; ?>"<?php if (!empty($route_to_read_update->begin_stop) && $route_to_read_update->begin_stop == $stop->id) echo ' selected = "selected"'; ?>><?php echo $stop->name; ?></option>
		            <?php } ?>
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
			            	<option value="<?php echo $stop->id; ?>"<?php if (!empty($route_to_read_update->end_stop) && $route_to_read_update->end_stop == $stop->id) echo ' selected = "selected"'; ?>><?php echo $stop->name; ?></option>
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
	      
	      	</div>
	      
	      	<div class="tab-pane active in" id="route_stops_list">
	      		
	      		<div>
	      			<ul class="bus-stops-list">
	      				<li class=""><h2>Route Number: <?php echo $route_to_read_update->route_number; ?></h2></li>
	      				<li class="">&nbsp;</li>
	      				
	      				<?php for ($i = 0; $i < count($stops_routes); $i++){ ?>
			        		<li><a href="admin_read_update_stop.php?stopid=<?php echo BusStop::find_by_id($stops_routes[$i]->stop_id)->id; ?>" class="btn btn-success"><?php echo BusStop::find_by_id($stops_routes[$i]->stop_id)->name; ?></a></li>
			        		<?php if ( $i != count($stops_routes)-1 ) { echo '<li>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="icon-arrow-down"></i></li>'; } ?>
		        		<?php } ?>
		        		
	      			</ul>
	      		</div>
	      	
	   		</div>
	      
	    </div>
	    
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