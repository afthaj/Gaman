<?php
require_once("../../includes/initialize.php");

if ($session->is_logged_in() && $session->object_type == 5){
	
	$user = AdminUser::find_by_id($_SESSION['id']);
	$p = new Photograph();
	$profile_picture = $p->get_profile_picture($session->object_type, $user->id);
	
	if (isset($_POST['submit'])){
		$stop_to_read_update->name = $_POST['name'];
		$stop_to_read_update->location_latitude = $_POST['location_latitude'];
		$stop_to_read_update->location_longitude = $_POST['location_longitude'];
	
		if ($stop_to_read_update->update()){
			$session->message("Success! The Bus Stop details were updated. ");
			redirect_to('admin_list_stops.php');
		} else {
			$session->message("Error! The Bus Stop details could not be updated. ");
		}
	}
	
	if (isset($_POST['upload'])){
	
		$photo_to_upload = new Photograph();
		
		$photo_to_upload->related_object_type = '2';
		$photo_to_upload->related_object_id = $_GET['stopid'];
		$photo_to_upload->photo_type = $_POST['photo_type'];
	
		$photo_to_upload->attach_file_bus_stop($_FILES['file_upload'], $photo_to_upload->stop_id, $photo_to_upload->photo_type);
	
		if ($photo_to_upload->save()){
			$session->message("Success! The photo was uploaded successfully. ");
			redirect_to('admin_list_stops.php');
		} else {
			$message = join("<br />", $photo_to_upload->errors);
		}
	
	}
	
} else if ($session->is_logged_in() && $session->object_type == 4) {
	
	$user = BusPersonnel::find_by_id($_SESSION['id']);
	$p = new Photograph();
	$profile_picture = $p->get_profile_picture($session->object_type, $user->id);
	
} else {
	redirect_to("login.php");
}


// GET request stuff and init code

if (isset($_GET['stopid'])){
	$stop_to_read_update = BusStop::find_by_id($_GET['stopid']);

	$sr = new StopRoute();
	$stops_routes = $sr->get_routes_for_stop($stop_to_read_update->id);

} else {
	$session->message("No Stop ID provided to view.");
	redirect_to("admin_list_stops.php");
}

$related_object = "bus_stop";
$pt = new PhotoType();
$photo_types = $pt->get_photo_types($related_object);

$p2 = new Photograph();
$photos_of_stop = $p2->get_photos('2', $_GET['stopid']);

$stops = BusStop::find_all();

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Route Details &middot; <?php echo WEB_APP_NAME; ?></title>
    <?php require_once('../../includes/layouts/header_admin.php');?>
    
  </head>

  <body>


    <!-- Part 1: Wrap all page content here -->
    <div id="wrap">

      <!-- Fixed navbar -->
      <?php require_once('../../includes/layouts/navbar_admin.php');?>
      
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
	        	<a href="admin_list_stops.php" class="btn btn-primary"> &larr; Back to Stops List</a>
	        </div>
        </div>
        
        <!-- Start Content -->

        <div class="span9">
        
        <section>
        
        <?php echo $session->message; ?>
        
        <ul class="nav nav-tabs">
	      <li class="active"><a href="#stop_pictures" data-toggle="tab">Pictures of Bus Stop</a></li>
	      <li><a href="#map_location" data-toggle="tab">Map Location</a></li>
	      <li><a href="#route_profile" data-toggle="tab">Bus Stop Profile</a></li>
	      <li><a href="#route_stops_list" data-toggle="tab">List of Routes</a></li>
	    </ul>
	    
	    <div id="tab_content" class="tab-content">
	      	
	      	<div class="tab-pane fade" id="route_profile">
	      	
	      	<form class="form-horizontal" action="<?php echo $_SERVER['PHP_SELF']; ?>?stopid=<?php echo $_GET['stopid']; ?>" method="POST">
            
	            <div class="control-group">
	            <label for="name" class="control-label">Name of Bus Stop</label>
		            <div class="controls">
		            	<input type="text" name="name"<?php if ($session->object_type != 5){ echo ' class="uneditable-input" id="disabledInput" disabled'; } ?> value="<?php echo $stop_to_read_update->name; ?>" />
		            </div>
	            </div>
	            
	            <?php if (!empty($stop_to_read_update->location_latitude)) { ?>
	            
	            <div class="control-group">
	            <label for="location_latitude" class="control-label">Geo Coordinates:<br />Latitude</label>
		            <div class="controls">
		            	<input type="text" name="location_latitude"<?php if ($session->object_type != 5){ echo ' class="uneditable-input" id="disabledInput" disabled'; } ?> value="<?php echo $stop_to_read_update->location_latitude; ?>" />
		            </div>
	            </div>
	            
	            <div class="control-group">
	            <label for="location_longitude" class="control-label">Geo Coordinates:<br />Longitude</label>
		            <div class="controls">
		            	<input type="text" name="location_longitude"<?php if ($session->object_type != 5){ echo ' class="uneditable-input" id="disabledInput" disabled'; } ?> value="<?php echo $stop_to_read_update->location_longitude; ?>" />
		            </div>
	            </div>
	            
	            <?php } ?>
				
				<?php if ($session->is_logged_in() && $session->object_type == 5) { ?>
	          	<div class="form-actions">
	        	    <button class="btn btn-primary" name="submit">Submit</button>
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
	      				
	      				<?php for ($i = 0; $i < count($stops_routes); $i++){ ?>
	      				
	      				<?php
						
						$br = new BusRoute();
						
						$route = $br->find_by_id($stops_routes[$i]->route_id); ?>
			        		<li><a href="admin_read_update_route.php?routeid=<?php echo $route->id; ?>" class="btn btn-info"><?php echo $route->route_number; ?></a> from <a href="admin_read_update_stop.php?stopid=<?php echo BusStop::find_by_id($route->begin_stop)->id; ?>" class="btn btn-info"><?php echo BusStop::find_by_id($route->begin_stop)->name; ?></a> to <a href="admin_read_update_stop.php?stopid=<?php echo BusStop::find_by_id($route->end_stop)->id; ?>" class="btn btn-info"><?php echo BusStop::find_by_id($route->end_stop)->name; ?></a></li>
			        		<li>&nbsp;</li>
		        		<?php } ?>
		        		
	      			</ul>
	      		</div>
	      	
	   		</div>
			
			<div class="tab-pane fade" id="map_location">
	  	
				<section>
				<?php if (!empty($stop_to_read_update->location_latitude)) { ?>

					<iframe width="100%" height="400" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://www.google.com/maps?q=<?php echo $stop_to_read_update->location_latitude; ?>,<?php echo $stop_to_read_update->location_longitude; ?>&amp;num=1&amp;ie=UTF8&amp;ll=<?php echo $stop_to_read_update->location_latitude; ?>,<?php echo $stop_to_read_update->location_longitude; ?>&amp;t=m&amp;z=17&amp;output=embed"></iframe>
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
							<img src="<?php echo '../../'.$photo_of_stop->image_path(); ?>" alt="">
							<p class="caption"><?php echo PhotoType::find_by_id($photo_of_stop->photo_type)->photo_type_name; ?></p>
						</li>
				    <?php } ?>
				</ul>
	        </div>
	        
			<?php } else { ?>
			
			<h5>No photos of the Bus Stop have been uploaded yet!</h5>
			<br /><br />
			<?php } ?>
			
			<?php if ($session->is_logged_in() && $session->object_type == 5) { ?>
			  <form class="form-horizontal" action="<?php echo $_SERVER['PHP_SELF']; ?>?stopid=<?php echo $_GET['stopid']; ?>" method="POST" enctype="multipart/form-data">
			      <input type="hidden" name="MAX_FILE_SIZE" value="1000000"/>
			        	
			      <div class="control-group">
			      	<input type="file" name="file_upload" />
			      </div>
			      
			      <div class="control-group">
			      <label for="photo_type" class="control-label">Photo Type</label>
				      <div class="controls">
					      <select name="photo_type">
					      	<?php foreach($photo_types as $photo_type) { ?>
					      	<option value="<?php echo $photo_type->id; ?>"><?php echo $photo_type->photo_type_name; ?></option>
					      	<?php } ?>
					      </select>
				      </div>
			      </div>
			        	
			      <div class="form-actions">
			      	<button type="submit" class="btn btn-primary" name="upload">Upload</button>
			      </div>	        	
		      </form>
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
    
    <?php require_once('../../includes/layouts/footer_admin.php');?>
    
    <?php require_once('../../includes/layouts/scripts_admin.php');?>
    
  </body>
</html>