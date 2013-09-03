<?php
require_once("../includes/initialize.php");

if ($session->is_logged_in() && $session->object_type == 6){
	
	$user = Commuter::find_by_id($_SESSION['id']);
	$p = new Photograph();
	$profile_picture = $p->get_profile_picture($user->id, "commuter");
	
	
} else if ($session->is_logged_in() && $session->object_type != 6) {
	
	//redirect_to("login.php");
	
}

$stops = BusStop::find_all();

if (isset($_GET['routeid'])) {
	$route_to_read_update = BusRoute::find_by_id($_GET['routeid']);

	$sr = new StopRoute();

	$stops_routes = $sr->get_stops_for_route($route_to_read_update->id);

} else {
	$session->message("No Route ID provided to view.");
	redirect_to("public_list_routes.php");
}

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Route Details &middot; <?php echo WEB_APP_NAME; ?></title>
    <?php require_once('../includes/layouts/header.php');?>
  </head>

  <body>

    <!-- Part 1: Wrap all page content here -->
    <div id="wrap">

      <!-- Fixed navbar -->
      <?php require_once('../includes/layouts/navbar.php');?>
      
      <header class="jumbotron subhead">
		 <div class="container-fluid">
		   <h1>Route Profile</h1>
		   <h3>Route Number: <?php echo $route_to_read_update->route_number;?></h3>
		 </div>
	  </header>
      
      <!-- Begin page content -->
      
      <div class="container-fluid">
      
      <div class="row-fluid">
      
        <div class="span3">
	        <div class="sidenav" data-spy="affix" data-offset-top="200">
	        	<a href="public_list_routes.php" class="btn btn-primary"> &larr; Back to Routes List</a>
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
	      	
	      	<form class="form-horizontal" action="" method="POST">
            
	            <div class="control-group">
	            <label for="route_number" class="control-label">Route Number</label>
		            <div class="controls">
		            	<input type="text" name="route_number" class="uneditable-input" id="disabledInput" disabled value="<?php echo $route_to_read_update->route_number; ?>">
		            </div>
	            </div>
	            
	            <div class="control-group">
	        	<label for="length" class="control-label">Route Length<br />(in km)</label>
		        	<div class="controls">
		        		<input type="text" name="length" class="uneditable-input" id="disabledInput" disabled value="<?php echo $route_to_read_update->length; ?>">
		        	</div>
	        	</div>
	        	
	        	<div class="control-group">
	        	<label for="trip_time" class="control-label">Trip Time<br />(Format = HH:MM:SS)</label>
		        	<div class="controls">
		        		<input type="text" name="trip_time" class="uneditable-input" id="disabledInput" disabled value="<?php echo $route_to_read_update->trip_time; ?>">
		        	</div>
	        	</div>
	            
	            <div class="control-group">
	            <label for="begin_stop" class="control-label">Begin Stop</label>
		            <div class="controls">
		            <select name="begin_stop" disabled >
		            <?php foreach($stops as $stop){ ?>
		            	<option value="<?php echo $stop->id; ?>"<?php if (!empty($route_to_read_update->begin_stop) && $route_to_read_update->begin_stop == $stop->id) echo ' selected = "selected"'; ?>><?php echo $stop->name; ?></option>
		            <?php } ?>
					</select>
		            </div>
	            </div>
	            
	            <div class="control-group">
	            <label for="end_stop" class="control-label">End Stop</label>
		            <div class="controls">
			            <select name="end_stop" disabled >
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

	        </form>
	      
	      	</div>
	      
	      	<div class="tab-pane active in" id="route_stops_list">
	      		
	      		<div>
	      			<ul class="bus-stops-list">
	      				<li class=""><h2>Route Number: <?php echo $route_to_read_update->route_number; ?></h2></li>
	      				<li class="">&nbsp;</li>
	      				
	      				<?php for ($i = 0; $i < count($stops_routes); $i++){ ?>
			        		<li><a href="public_read_stop.php?stopid=<?php echo BusStop::find_by_id($stops_routes[$i]->stop_id)->id; ?>" class="btn btn-success"><?php echo BusStop::find_by_id($stops_routes[$i]->stop_id)->name; ?></a></li>
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

    <?php require_once('../includes/layouts/footer.php');?>

    <?php require_once('../includes/layouts/scripts.php');?>

  </body>
</html>