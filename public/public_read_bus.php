<?php
require_once("./includes/initialize.php");

//init code
$photo_object = new Photograph();
$commuter_object = new Commuter();

$photo_type_object = new PhotoType();

$route_object = new BusRoute();
$bus_object = new Bus();
$bus_personnel_object = new BusPersonnel();

$object_type_object = new ObjectType();

$bus_personnel_role_object = new BusPersonnelRole();
$bus_bus_personnel_object = new BusBusPersonnel();

$complaint_object = new Complaint();
$complaint_type_object = new ComplaintType();
$complaint_status_object = new ComplaintStatus();
$feedback_item_object = new FeedbackItem();

$routes = BusRoute::find_all();
$buses = Bus::find_all();
$bus_personnel = BusPersonnel::find_all();

$photo_types = $photo_type_object->get_photo_types("bus");
$photos_of_bus = $photo_object->get_photos(3, $_GET['busid']);

//check login
if ($session->is_logged_in()){
	
	if ($session->object_type == 6){
		//commuter
		
		$user = $commuter_object->find_by_id($_SESSION['id']);
		$profile_picture = $photo_object->get_profile_picture($session->object_type, $user->id);
		
	}
}

//GET request stuff
if (!empty($_GET['busid'])){
	$bus_to_read_update = $bus_object->find_by_id($_GET['busid']);
	if (!empty($user->id)){
		$feedback_by_user = $feedback_item_object->get_feedback_items_submitted_by_user_for_object($user->id, $session->object_type, 3, $bus_to_read_update->id);
		$complaints_by_user = $complaint_object->get_complaints_submitted_by_user_for_object($user->id, $session->object_type, 3, $bus_to_read_update->id);
	}
} else {
	$session->message("No Bus ID provided to view.");
	redirect_to("public_list_buses.php");
}

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Bus Details &middot; <?php echo WEB_APP_NAME;?></title>
    <?php require_once('./includes/layouts/header.php');?>
  </head>

  <body>


    <!-- Part 1: Wrap all page content here -->
    <div id="wrap">

      <!-- Fixed navbar -->
      <?php require_once('./includes/layouts/navbar.php');?>
      
      <header class="jumbotron subhead">
		 <div class="container-fluid">
		   <h1><?php echo $bus_to_read_update->reg_number; ?></h1>
		   <h3>Route Number: <?php echo $route_object->find_by_id($bus_to_read_update->route_id)->route_number; ?></h3>
		 </div>
	  </header>
      
      <!-- Begin page content -->
      
      <div class="container-fluid">
      
      <div class="row-fluid">
      
        <div class="span3">
	        <div class="sidenav" data-spy="affix" data-offset-top="200">
	        	<a href="public_list_buses.php" class="btn btn-primary btn-block"><i class="icon-arrow-left icon-white"></i> Back to List of Buses</a>
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
	      <li class="active"><a href="#bus_pictures" data-toggle="tab">Pictures of the Bus</a></li>
	      <li><a href="#bus_profile" data-toggle="tab">Bus Profile</a></li>
	      <li><a href="#bus_personnel_list" data-toggle="tab">List of Personnel</a></li>
	      <?php if (!empty($user->id)){ ?>
	      <li><a href="#feedback" data-toggle="tab">Feedback </a></li>
	      <li><a href="#complaints" data-toggle="tab">Complaints</a></li>
	      <?php } ?>
	    </ul>
	    
	    <div id="tab_content" class="tab-content">
	      	
	      	<div class="tab-pane fade" id="bus_profile">
	      	
	      	<form class="form-horizontal" action="" method="POST">
            
	            <div class="control-group">
            	<label for="route_id" class="control-label">Route Number</label>
	            <div class="controls">
	            	<input type="text" name="route_id" disabled value="<?php echo $route_object->find_by_id($bus_to_read_update->route_id)->route_number; ?>" />
	            </div>
            </div>
            
            <div class="control-group">
        	<label for="reg_number" class="control-label">Registration Number</label>
	        	<div class="controls">
	        		<input type="text" name="reg_number" disabled value="<?php echo $bus_to_read_update->reg_number; ?>" />
	        	</div>
        	</div>
            
            <div class="control-group">
            <label for="name" class="control-label">Name of Bus</label>
	            <div class="controls">
	            	<input type="text" name="name" disabled value="<?php echo $bus_to_read_update->name; ?>">
	            </div>
            </div>
            
	        </form>
	      
	      	</div>
	      
	      	<div class="tab-pane fade" id="bus_personnel_list">
	      	
	      	<div class="row-fluid">
      			<h4>List of Personnel</h4>
      			<br />
      		</div>
      		
      		<div class="row-fluid">
      		
		      <?php
		      
		      $buses_bus_personnel = $bus_bus_personnel_object->get_personnel_for_bus($bus_to_read_update->id);
		      
		      if ($buses_bus_personnel) { ?>
		      
		      <table class="table table-bordered table-hover">
	          <thead align="center">
		        <tr>
			        <td>Profile Picture</td>
			        <td>Name</td>
			        <td>Role</td>
		        </tr>
		      </thead>
		      
		      <tbody align="center">
		      
		      <?php foreach($buses_bus_personnel as $bbp){
		      	
		      	$assigned_bus_personnel = $bus_personnel_object->find_by_id($bbp->bus_personnel_id);
		      	
		      	?>
	        		<tr>
		        		<td>
	        			<?php 
		        		
		        		$bus_personnel_profile_picture = $photo_object->get_profile_picture(4, $assigned_bus_personnel->id);
		        		
		        		if (!empty($bus_personnel_profile_picture->filename)) {
		        			echo '<a href="public_read_bus_personnel.php?personnelid=' . $assigned_bus_personnel->id . '"><img src="../' . $bus_personnel_profile_picture->image_path() . '" width="100" class="img-rounded" /></a>';
		        		} else {
		        			echo '<img src="img/default-prof-pic.jpg" width="100" class="img-rounded" alt="Please upload a profile picture" />';
		        		}
		        		
		        		?>
	        			</td>
	        			<td><a href="public_read_bus_personnel.php?personnelid=<?php echo $assigned_bus_personnel->id; ?>" class="btn btn-info btn-block"><?php echo $assigned_bus_personnel->full_name(); ?></a></td>
		        		<td>
		        		<?php
			        	
		        		echo $bus_personnel_role_object->find_by_id($assigned_bus_personnel->role)->role_name;
		        		
		        		?>
		        		</td>
		        		
	        		</tr>
        	  
        	  <?php } ?>
	          
	          </tbody>
	          
	          </table>
	        		
	          <?php } else { ?>
	          <h5>No Personnel have been assigned to this Bus yet!</h5>
	          <br />
	          <?php } ?>
	          
      		</div>
	      	
	   		</div>
	   		
	   		<div class="tab-pane active in" id="bus_pictures">

			<?php if (!empty($photos_of_bus)) { ?>
				<div class="callbacks_container">
		        <ul class="rslides" id="responsive_slider">
		        
		        <?php for ( $i = 0; $i < count($photos_of_bus); $i++ ) { ?>
		        
					<li>
					<img src="<?php echo '../'.$photos_of_bus[$i]->image_path(); ?>" alt="">
					<p class="caption"><?php echo $photo_type_object->find_by_id($photos_of_bus[$i]->photo_type)->photo_type_name; ?></p>
					</li>
				
		        <?php } ?>
		        
		        </ul>
		        </div>
			      
			<?php } else { ?>
			
			<h5>No photos of the Bus have been uploaded yet!</h5>
			<br /><br />
			<?php } ?>
	  	
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
	      		echo '<h4>You have not provided Feedback on this Bus</h4>'; 
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
	      		echo '<h4>You have not submitted any Complaints on this Bus</h4>'; 
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
    
    <?php require_once('./includes/layouts/scripts.php');?>
    
    <?php require_once('./includes/layouts/footer.php');?>
    
  </body>
</html>