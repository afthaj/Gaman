<?php
require_once("../includes/initialize.php");

//init code
$photo_object = new Photograph();
$commuter_object = new Commuter();
$photo_type_object = new PhotoType();
$stop_object = new BusStop();
$stop_route_object = new StopRoute();
$bus_route_object = new BusRoute();

$stops = $stop_object->find_all();

$photo_types = $photo_type_object->get_photo_types("bus_stop");
$photos_of_stop = $photo_object->get_photos(2, $_GET['stopid']);

//check login
if ($session->is_logged_in()){
	
	if ($session->object_type == 6){
		//commuter
	
		$user = $commuter_object->find_by_id($_SESSION['id']);
		$profile_picture = $photo_object->get_profile_picture($session->object_type, $user->id);
		
	}
	
}

//GET request stuff
if (!empty($_GET['stopid'])){
	$stop_to_read_update = $stop_object->find_by_id($_GET['stopid']);
	$stops_routes = $stop_route_object->get_routes_for_stop($stop_to_read_update->id);

} else {
	$session->message("No Stop ID provided to view.");
	redirect_to("public_list_stops.php");
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
		   <h1>Bus Stop Profile</h1>
		   <h3><?php echo $stop_to_read_update->name; ?></h3>
		 </div>
	  </header>
      
      <!-- Begin page content -->
      
      <div class="container-fluid">
      
      <div class="row-fluid">
      
        <div class="span3">
	        <div class="sidenav" data-spy="affix" data-offset-top="200">
	        	<a href="public_list_stops.php" class="btn btn-primary btn-block"><i class="icon-arrow-left icon-white"></i> Back to Stops List</a>
	        </div>
        </div>
        
        <!-- Start Content -->

        <div class="span9">
        
        <section>
        
        <?php 
        
        if(!empty($session->message)){
        	
        	echo '<div class="alert">';
        	echo '<button type="button" class="close" data-dismiss="alert">&times;</button>';
        	//echo '<p>';
        	echo $session->message;
        	//echo '</p>';
        	echo '</div>';
        }
        
        ?>
        
        <ul class="nav nav-tabs">
	      <li class="active"><a href="#stop_pictures" data-toggle="tab">Pictures of Bus Stop</a></li>
	      <li><a href="#map_location" data-toggle="tab">Map Location</a></li>
	      <li><a href="#route_profile" data-toggle="tab">Bus Stop Profile</a></li>
	      <li><a href="#route_stops_list" data-toggle="tab">List of Routes</a></li>
	    </ul>
	    
	    <div id="tab_content" class="tab-content">
	      	
	      	<div class="tab-pane fade" id="route_profile">
	      	
	      	<form class="form-horizontal" action="" method="POST">
            
	            <div class="control-group">
	            <label for="name" class="control-label">Name of Bus Stop</label>
		            <div class="controls">
		            	<input type="text" class="uneditable-input" id="disabledInput" disabled name="name" value="<?php echo $stop_to_read_update->name; ?>">
		            </div>
	            </div>
	            
	            <?php if (!empty($stop_to_read_update->location_latitude)) { ?>
	            
	            <div class="control-group">
	            <label for="location_latitude" class="control-label">Geo Coordinates:<br />Latitude</label>
		            <div class="controls">
		            	<input type="text" name="location_latitude" class="uneditable-input" id="disabledInput" disabled value="<?php echo $stop_to_read_update->location_latitude; ?>">
		            </div>
	            </div>
	            
	            <div class="control-group">
	            <label for="location_longitude" class="control-label">Geo Coordinates:<br />Longitude</label>
		            <div class="controls">
		            	<input type="text" name="location_longitude" class="uneditable-input" id="disabledInput" disabled value="<?php echo $stop_to_read_update->location_longitude; ?>">
		            </div>
	            </div>
	            
	            <?php } ?>
	            
	        </form>
	      
	      	</div>
	      
	      	<div class="tab-pane fade" id="route_stops_list">
	      		
	      		<div class="clearfix">&nbsp;</div>
	      		
	      		<div>
	      			<ul class="bus-stops-list">
	      				<li class=""><h4>Routes that pass through <?php echo $stop_to_read_update->name; ?></h4></li>
	      				<li class="">&nbsp;</li>
	      				
	      				<?php for ($i = 0; $i < count($stops_routes); $i++){
	      					
	      					$route = $bus_route_object->find_by_id($stops_routes[$i]->route_id);
	      					
							?>
							
			        		<li><a href="public_read_route.php?routeid=<?php echo $route->id; ?>" class="btn btn-info"><?php echo $route->route_number; ?></a> from <a href="<?php echo $_SERVER['PHP_SELF']; ?>?stopid=<?php echo $stop_object->find_by_id($route->begin_stop)->id; ?>" class="btn btn-info"><?php echo $stop_object->find_by_id($route->begin_stop)->name; ?></a> to <a href="<?php echo $_SERVER['PHP_SELF']; ?>?stopid=<?php echo $stop_object->find_by_id($route->end_stop)->id; ?>" class="btn btn-info"><?php echo $stop_object->find_by_id($route->end_stop)->name; ?></a></li>
			        		<li>&nbsp;</li>
			        		
		        		<?php } ?>
		        		
	      			</ul>
	      		</div>
	      	
	   		</div>
			
			<div class="tab-pane fade" id="map_location">
	  	
				<section>
				<?php if (!empty($stop_to_read_update->location_latitude)) { ?>
					<iframe width="100%" height="400" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://www.google.com/maps?q=<?php echo $stop_to_read_update->location_latitude; ?>,<?php echo $stop_to_read_update->location_longitude; ?>&amp;num=1&amp;ie=UTF8&amp;ll=<?php echo $stop_to_read_update->location_latitude; ?>,<?php echo $stop_to_read_update->location_longitude; ?>&amp;spn=0.003105,0.004796&amp;t=m&amp;z=17&amp;output=embed"></iframe>
					<br />
					<small>
						<a href="https://www.google.com/maps?q=<?php echo $stop_to_read_update->location_latitude; ?>,<?php echo $stop_to_read_update->location_longitude; ?>&amp;num=1&amp;ie=UTF8&amp;<?php echo $stop_to_read_update->location_latitude; ?>,<?php echo $stop_to_read_update->location_longitude; ?>&amp;spn=0.003105,0.004796&amp;t=m&amp;z=14&amp;source=embed" style="color:#0000FF;text-align:left" target="_blank">View Larger Map</a>
					</small>
				<?php } else {?>
					<h5>Map data currently unavailable</h5>
				<?php } ?>
				</section>
	  	
			</div>
			
			<div class="tab-pane active in" id="stop_pictures">
			
			<section>
			
			<?php if (!empty($photos_of_stop)) { ?>
			
			<div class="callbacks_container">
		        <ul class="rslides" id="responsive_slider">
				    <?php foreach($photos_of_stop as $photo_of_stop) { ?>
					    <li>
							<img src="<?php echo '../' . $photo_of_stop->image_path(); ?>" alt="">
							<p class="caption"><?php echo $photo_type_object->find_by_id($photo_of_stop->photo_type)->photo_type_name; ?></p>
						</li>
				    <?php } ?>
				</ul>
	        </div>
	        
			<?php } else { ?>
			
			<h5>No photos of the Bus Stop have been uploaded yet!</h5>
			
			<?php } ?>
			
			</section>
			
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