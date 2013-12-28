<?php
require_once("../includes/initialize.php");

//init code
$photo_object = new Photograph();
$admin_user_object = new AdminUser();

$route_object = new BusRoute();
$stop_object = new BusStop();
$bus_object = new Bus();
$bus_personnel_object = new BusPersonnel();

$object_type_object = new ObjectType();

$stop_route_object = new StopRoute();

$complaint_object = new Complaint();
$complaint_status_object = new ComplaintStatus();
$complaint_type_object = new ComplaintType();
$feedback_item_object = new FeedbackItem();

$stops = BusStop::find_all();

//check login
if ($session->is_logged_in()){
	
	if ($session->object_type == 5){
		//admin user
	
		$user = $admin_user_object->find_by_id($_SESSION['id']);
		$profile_picture = $photo_object->get_profile_picture($session->object_type, $user->id);
	
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
	
	} else if ($session->object_type == 4) {
		//bus personnel
		
		$user = $bus_personnel_object->find_by_id($_SESSION['id']);
		$profile_picture = $photo_object->get_profile_picture($session->object_type, $user->id);
		
	} else {
		$session->message("Error! You must login to view the requested page. ");
		redirect_to("login.php");
	}
	
} else {
	$session->message("Error! You must login to view the requested page. ");
	redirect_to("login.php");
}

//GET request stuff
if (isset($_GET['routeid'])){
	
	$route_to_read_update = $route_object->find_by_id($_GET['routeid']);
	$stops_routes = $stop_route_object->get_stops_for_route($route_to_read_update->id);
	$complaints_of_route = $complaint_object->get_complaints_for_object(1, $_GET['routeid']);
	$feedback_on_route = $feedback_item_object->get_feedback_items_for_object(1, $_GET['routeid']);
	
} else {
	$session->message("No Route ID provided to view.");
	redirect_to("admin_list_routes.php");
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
		   <h1>Route Number: <?php echo $route_to_read_update->route_number;?></h1>
		 </div>
	  </header>
      
      <!-- Begin page content -->
      
      <div class="container-fluid">
      
      <div class="row-fluid">
      
        <div class="span3">
	        <div class="sidenav" data-spy="affix" data-offset-top="150">
	        	<a href="admin_list_routes.php" class="btn btn-primary btn-block"><i class="icon-arrow-left icon-white"></i> Back to List of Routes</a>
	        	<br />
	        	<a href="admin_create_feedback.php" class="btn btn-success btn-block"><i class="icon-thumbs-up icon-white"></i> Give Feedback</a>
	        	<a href="admin_create_complaint.php" class="btn btn-danger btn-block"><i class="icon-exclamation-sign icon-white"></i> Create Complaint</a>
	        	<br />
	        	<div class="well">Feedback <span class="badge badge-success"><?php echo count($feedback_on_route); ?></span></div>
	        	<div class="well">Complaints <span class="badge badge-important"><?php echo count($complaints_of_route); ?></span></div>
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
	      <li class="active"><a href="#route_stops_list" data-toggle="tab">List of Stops</a></li>
	      <li><a href="#route_map" data-toggle="tab">Route Map</a></li>
		  <li><a href="#route_profile" data-toggle="tab">Route Profile</a></li>
	      <li><a href="#feedback" data-toggle="tab">Feedback </a></li>
	      <li><a href="#complaints" data-toggle="tab">Complaints </a></li>
	      
	    </ul>
	    
	    <div id="tab_content" class="tab-content">
		
			<div class="tab-pane fade" id="route_map">
	  	
				<section>
					<div class="callbacks_container">
						<ul class="rslides" id="responsive_slider">
								<li>
									<img src="../img/uploads/generic-bus-route.jpg" alt="">
									<p class="caption"></p>
								</li>
						</ul>
					</div>
				</section>
	  	
			</div>
	      	
	      	<div class="tab-pane fade" id="route_profile">
	      	
	      	<form class="form-horizontal" action="<?php echo $_SERVER['PHP_SELF']; ?>?routeid=<?php echo $_GET['routeid']; ?>" method="POST">
            
	            <div class="control-group">
	            <label for="route_number" class="control-label">Route Number</label>
		            <div class="controls">
		            	<input type="text" name="route_number"<?php if ($session->object_type != 5){ echo ' class="uneditable-input" id="disabledInput" disabled'; } ?> value="<?php echo $route_to_read_update->route_number; ?>" >
		            </div>
	            </div>
	            
	            <div class="control-group">
	        	<label for="length" class="control-label">Route Length<br />(in km)</label>
		        	<div class="controls">
		        		<input type="text" name="length"<?php if ($session->object_type != 5){ echo ' class="uneditable-input" id="disabledInput" disabled'; } ?> value="<?php echo $route_to_read_update->length; ?>" />
		        	</div>
	        	</div>
	        	
	        	<div class="control-group">
	        	<label for="trip_time" class="control-label">Trip Time<br />(Format = HH:MM:SS)</label>
		        	<div class="controls">
		        		<input type="text" name="trip_time"<?php if ($session->object_type != 5){ echo ' class="uneditable-input" id="disabledInput" disabled'; } ?> value="<?php echo $route_to_read_update->trip_time; ?>" />
		        	</div>
	        	</div>
	            
	            <div class="control-group">
	            <label for="begin_stop" class="control-label">Begin Stop</label>
		            <div class="controls">
		            <select name="begin_stop"<?php if ($session->object_type != 5){ echo ' disabled'; } ?>>
		            <?php foreach($stops as $stop){ ?>
		            	<option value="<?php echo $stop->id; ?>"<?php if (!empty($route_to_read_update->begin_stop) && $route_to_read_update->begin_stop == $stop->id) echo ' selected = "selected"'; ?>><?php echo $stop->name; ?></option>
		            <?php } ?>
					</select>
		            </div>
	            </div>
	            
	            <div class="control-group">
	            <label for="end_stop" class="control-label">End Stop</label>
		            <div class="controls">
			            <select name="end_stop"<?php if ($session->object_type != 5){ echo ' disabled'; } ?>>
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
	            
	            <?php if ($session->is_logged_in() && $session->object_type == 5) { ?>
	          	<div class="form-actions">
	        	    <button class="btn btn-primary" name="submit">Submit</button>
	        	</div>
	        	<?php } ?>
	        	
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
	   		
	   		
	      	<div class="tab-pane fade" id="complaints">
	      	<?php if ($complaints_of_route) { 
	      		
	      		foreach ($complaints_of_route as $complaint) { ?>
	      		
	      		<div class="well">
	      			<h4>Complaint Type: <?php echo $complaint_type_object->find_by_id($complaint->complaint_type)->comp_type_name; ?></h4>
	      			<p>Details: <?php echo $complaint->content; ?></p>
	      			<p>Status: <span class="label 
			        <?php
			        
			        if ($complaint_status_object->find_by_id($complaint->status)->id == 1){
			        	echo ' label-info';
			        } else if ($complaint_status_object->find_by_id($complaint->status)->id == 2){
			        	echo ' label-warning';
			        } else if ($complaint_status_object->find_by_id($complaint->status)->id == 3){
			        	echo ' label-success';
			        }
			        
			        ?>"><?php echo $complaint_status_object->find_by_id($complaint->status)->comp_status_name; ?></span>
			        </p>
	      			<p>Related to: <span class="badge"><?php echo $object_type_object->find_by_id($complaint->related_object_type)->display_name; ?></span> &middot; Identifier: <span class="badge"><?php 
					switch ($complaint->related_object_type) {
					    case 1:
					        echo $route_object->find_by_id($complaint->related_object_id)->route_number;
					        break;
					    case 2:
					        echo $stop_object->find_by_id($complaint->related_object_id)->name;
					        break;
					    case 3:
					        echo $bus_object->find_by_id($complaint->related_object_id)->reg_number;
					        break;
				        case 4:
				        	echo $bus_personnel_object->find_by_id($complaint->related_object_id)->fullname();
				        	break;
					}
			        ?></span> &middot; Submitted on <span class="badge"><?php echo date("d M Y", $complaint->date_time_submitted); ?></span> at <span class="badge"><?php echo date("h:i:s a", $complaint->date_time_submitted); ?></span>
	      			</p>
	      		</div>
	      	<?php } 
	      	
	      	} else { 
	      		echo '<h4>No Complaints have been submitted on this Bus Route</h4>'; 
	      	} 
	      	
	      	?>
	      	</div>
	      	
	      	<div class="tab-pane fade" id="feedback">
	      	<?php if ($feedback_on_route) { 
	      		
	      		foreach ($feedback_on_route as $feedback_item) { ?>
	      		
	      		<div class="well">
	      			<p><?php echo $feedback_item->content; ?></p>
	      			<p>Submitted on <span class="badge"><?php echo date("d M Y", $feedback_item->date_time_submitted); ?></span> at <span class="badge"><?php echo date("h:i:s a", $feedback_item->date_time_submitted); ?></span>
	      			</p>
	      		</div>
	      	<?php } 
	      	
	      	} else { 
	      		echo '<h4>No Feedback has been submitted on this Bus Route</h4>'; 
	      	} 
	      	
	      	?>
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

    <?php require_once('../includes/layouts/scripts_admin.php');?>

  </body>
</html>