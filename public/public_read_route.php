<?php
require_once("./includes/initialize.php");

//init code
$photo_object = new Photograph();
$commuter_object = new Commuter();

$route_object = new BusRoute();
$stop_object = new BusStop();
$bus_object = new Bus();
$bus_personnel_object = new BusPersonnel();

$object_type_object = new ObjectType();

$stop_route_object = new StopRoute();

$complaint_object = new Complaint();
$complaint_type_object = new ComplaintType();
$complaint_status_object = new ComplaintStatus();
$feedback_item_object = new FeedbackItem();

$routes = BusRoute::find_all();
$stops = BusStop::find_all();

//check login
if ($session->is_logged_in()){

	if ($session->object_type == 6){
		//commuter
		
		$user = $commuter_object->find_by_id($_SESSION['id']);
		$profile_picture = $photo_object->get_profile_picture($session->object_type, $user->id);
	}
}

if (isset($_GET['routeid'])) {
	$route_to_read_update = $route_object->find_by_id($_GET['routeid']);
	$stops_routes = $stop_route_object->get_stops_for_route($route_to_read_update->id);
	if (!empty($user->id)){
		
		$feedback_by_user = $feedback_item_object->get_feedback_items_submitted_by_user_for_object($user->id, $session->object_type, 1, $route_to_read_update->id);
		$complaints_by_user = $complaint_object->get_complaints_submitted_by_user_for_object($user->id, $session->object_type, 1, $route_to_read_update->id);
		
	}
} else {
	$session->message("No Route ID provided to view.");
	redirect_to("public_list_routes.php");
}

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Route Details &middot; <?php echo WEB_APP_NAME; ?></title>
    <?php require_once('./includes/layouts/header.php');?>
  </head>

  <body>

    <!-- Part 1: Wrap all page content here -->
    <div id="wrap">

      <!-- Fixed navbar -->
      <?php require_once('./includes/layouts/navbar.php');?>
      
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
	        	<a href="public_list_routes.php" class="btn btn-primary btn-block"><i class="icon-arrow-left icon-white"></i> Back to List of Bus Routes</a>
	        	<?php if (!empty($user->id)){ ?>
	        	<br />
	        	<a href="public_create_feedback.php" class="btn btn-success btn-block"><i class="icon-thumbs-up icon-white"></i> Give Feedback</a>
	        	<a href="public_create_complaint.php" class="btn btn-danger btn-block"><i class="icon-exclamation-sign icon-white"></i> Create Complaint</a>
	        	<br />
	        	<div class="well">Feedback <span class="badge badge-success"><?php echo count($feedback_by_user); ?></span></div>
	        	<div class="well">Complaints <span class="badge badge-important"><?php echo count($complaints_by_user); ?></span></div>
	        	<?php } ?>
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
	      <?php if (!empty($user->id)){ ?>
	      <li><a href="#feedback" data-toggle="tab">Feedback</a></li>
	      <li><a href="#complaints" data-toggle="tab">Complaints</a></li>
	      <?php } ?>
	    </ul>
	    
	    <div id="tab_content" class="tab-content">
	    
	    	<div class="tab-pane active in" id="route_stops_list">
	      		
	      		<div>
	      			<ul class="bus-stops-list">
	      				<li class=""><h2>Route Number: <?php echo $route_to_read_update->route_number; ?></h2></li>
	      				<li class="">&nbsp;</li>
	      				
	      				<?php for ($i = 0; $i < count($stops_routes); $i++){ ?>
			        		<li><a href="public_read_stop.php?stopid=<?php echo $stop_object->find_by_id($stops_routes[$i]->stop_id)->id; ?>" class="btn btn-success"><?php echo $stop_object->find_by_id($stops_routes[$i]->stop_id)->name; ?></a></li>
			        		<?php if ( $i != count($stops_routes)-1 ) { echo '<li>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="icon-arrow-down"></i></li>'; } ?>
		        		<?php } ?>
		        		
	      			</ul>
	      		</div>
	      	
	   		</div>
			
			<div class="tab-pane fade" id="route_map">
	  	
				<section>
					<div class="callbacks_container">
						<ul class="rslides" id="responsive_slider">
								<li>
									<img src="img/uploads/generic-bus-route.jpg" alt="">
									<p class="caption"></p>
								</li>
						</ul>
					</div>
				</section>
	  	
			</div>
	      	
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
	        	<label for="trip_time" class="control-label">Trip Time<br /></label>
		        	<div class="controls">
		        		<input type="text" name="trip_time" disabled="disabled" value="<?php echo format_trip_time($route_to_read_update->trip_time); ?>">
		        	</div>
	        	</div>
	            
	            <div class="control-group">
	            <label for="begin_stop" class="control-label">Begin Stop</label>
		            <div class="controls">
		            	<textarea rows="3" name="begin_stop" disabled="disabled"><?php echo $stop_object->find_by_id($route_to_read_update->begin_stop)->name; ?></textarea>
		            </div>
	            </div>
	            
	            <div class="control-group">
	            <label for="end_stop" class="control-label">End Stop</label>
		            <div class="controls">
			            <textarea rows="3" name="begin_stop" disabled="disabled"><?php echo $stop_object->find_by_id($route_to_read_update->end_stop)->name; ?></textarea>
		            </div>
	            </div>

	        </form>
	      
	      	</div>
	      	
	      	<?php if (!empty($user->id)){ ?>
	      	
	      	<div class="tab-pane fade" id="feedback">
	      	<?php if ($feedback_by_user) { 
	      		
	      		foreach ($feedback_by_user as $feedback_item) { ?>
	      		
	      		<div class="well">
	      			<p><?php echo $feedback_item->content; ?></p>
	      			<p>Submitted on <span class="badge"><?php echo date("d M Y", $feedback_item->date_time_submitted); ?></span> at <span class="badge"><?php echo date("h:i:s a", $feedback_item->date_time_submitted); ?></span>
	      			</p>
	      		</div>
	      	<?php } 
	      	
	      	} else { 
	      		echo '<h4>You have not provided any Feedback on this Bus Route</h4>'; 
	      	} 
	      	
	      	?>
	      	</div>
	      	
	      	<div class="tab-pane fade" id="complaints">
	      	<?php if ($complaints_by_user) { 
	      		
	      		foreach ($complaints_by_user as $complaint) { ?>
	      		
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
	      		echo '<h4>You have not submitted any Complaints on this Bus Route</h4>'; 
	      	} ?>	
	      	</div>
	      	<?php } ?>
	      	
	    </div>
	    
	    </section>
	    
	  	</div>
        
        </div>
        
        <!-- End Content -->
        
      </div>
      
      <div class="clearfix">&nbsp;</div>

      <div id="push"></div>
    </div>

    <?php require_once('./includes/layouts/footer.php');?>

    <?php require_once('./includes/layouts/scripts.php');?>

  </body>
</html>