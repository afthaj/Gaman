<?php
require_once("./includes/initialize.php");

//init code
$photo_object = new Photograph();
$commuter_object = new Commuter();

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

$roles = BusPersonnelRole::find_all();
$buses = Bus::find_all();

//check login
if ($session->is_logged_in()){

	if ($session->object_type == 6){
		//commuter

		$user = $commuter_object->find_by_id($_SESSION['id']);
		$profile_picture = $photo_object->get_profile_picture($session->object_type, $user->id);
	}
}

//GET request stuff
if (!empty($_GET['personnelid'])){
	$bus_personnel_to_read_update = $bus_personnel_object->find_by_id($_GET['personnelid']);
	$profile_picture_of_bus_personnel = $photo_object->get_profile_picture(4, $bus_personnel_to_read_update->id);
	$buses_bus_personnel = $bus_bus_personnel_object->get_buses_for_personnel($bus_personnel_to_read_update->id);
	if (!empty($user->id)){
		$feedback_by_user = $feedback_item_object->get_feedback_items_submitted_by_user_for_object($user->id, $session->object_type, 4, $bus_personnel_to_read_update->id);
		$complaints_by_user = $complaint_object->get_complaints_submitted_by_user_for_object($user->id, $session->object_type, 4, $bus_personnel_to_read_update->id);
	}

} else {
	$session->message("No Bus Personnel ID provided to view.");
	redirect_to("public_list_bus_personnel.php");
}

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Bus Personnel Details &middot; <?php echo WEB_APP_NAME; ?></title>
    <?php require_once('./includes/layouts/header.php');?>
  </head>

  <body>


    <!-- Part 1: Wrap all page content here -->
    <div id="wrap">

      <!-- Fixed navbar -->
      <?php require_once('./includes/layouts/navbar.php');?>
      
      <header class="jumbotron subhead">
		 <div class="container-fluid">
		 
		 <div class="span3">
		 
		 <?php 
         if (!empty($profile_picture_of_bus_personnel->filename)) {
         	echo '<img src="../' . $profile_picture_of_bus_personnel->image_path() . '" width="200" class="img-rounded" />'; 
         } else {
         	echo '<img src="img/default-prof-pic.jpg" width="200" class="img-rounded" alt="Please upload a profile picture" />';
         }
         ?>
		 
		 </div>
		 
		 <div class="span9">
		 
			 <h1><?php echo $bus_personnel_to_read_update->full_name(); ?></h1>
			 <h3><?php echo $bus_personnel_role_object->find_by_id($bus_personnel_to_read_update->role)->role_name; ?></h3>
		 
		 </div>

		 </div>
	  </header>
      
      <!-- Begin page content -->
      
      <div class="container-fluid">
      
      <div class="row-fluid">
      
        <div class="span3">
	        <div class="sidenav" data-spy="affix" data-offset-top="300">
	        	<a href="public_list_bus_personnel.php" class="btn btn-primary btn-block"><i class="icon-arrow-left icon-white"></i> Back to List of Bus Personnel</a>
	        	<?php if (!empty($user->id)){ ?>
	        	<br />
	        	<a href="admin_create_feedback.php" class="btn btn-success btn-block"><i class="icon-thumbs-up icon-white"></i> Give Feedback</a>
	        	<a href="admin_create_complaint.php" class="btn btn-danger btn-block"><i class="icon-exclamation-sign icon-white"></i> Create Complaint</a>
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
	      <li class="active"><a href="#personnel_profile" data-toggle="tab">Profile</a></li>
	      <li><a href="#assigned_buses_list" data-toggle="tab">Bus Assignment</a></li>
	      <?php if (!empty($user->id)){ ?>
	      <li><a href="#feedback" data-toggle="tab">Feedback </a></li>
	      <li><a href="#complaints" data-toggle="tab">Complaints</a></li>
	      <?php } ?>
	    </ul>
	    
	    <div id="tab_content" class="tab-content">
	      	
	      	<div class="tab-pane active in" id="personnel_profile">
	      	
	      	<form class="form-horizontal" action="" method="POST">
            
            <div class="control-group">
            	<label for="role" class="control-label">Role</label>
	            <div class="controls">
	            	<input type="text" name="first_name" disabled value="<?php echo $bus_personnel_role_object->find_by_id($bus_personnel_to_read_update->role)->role_name; ?>" />
	            </div>
            </div>
            
            <div class="control-group">
        	<label for="first_name" class="control-label">First Name</label>
	        	<div class="controls">
	        		<input type="text" name="first_name" disabled value="<?php echo $bus_personnel_to_read_update->first_name; ?>" />
	        	</div>
        	</div>
            
            <div class="control-group">
            <label for="last_name" class="control-label">Last Name</label>
	            <div class="controls">
	            	<input type="text" name="last_name" disabled value="<?php echo $bus_personnel_to_read_update->last_name; ?>" />
	            </div>
            </div>
            
            <div class="control-group">
        	<label for="nic_number" class="control-label">NIC Number</label>
	        	<div class="controls">
	        		<input type="text" name="nic_number" disabled value="<?php echo $bus_personnel_to_read_update->nic_number; ?>" />
	        	</div>
        	</div>

	        </form>
	      
	      	</div>
	      
	      	<div class="tab-pane fade" id="assigned_buses_list">
	      		
      		<div class="row-fluid">
      			<h4>Assigned Bus/Buses</h4>
      			<br />
      		</div>
      		
      		<div class="row-fluid">
      		
      		<table class="table table-bordered table-hover">
	          <thead align="center">
		        <tr>
			        <td>Route Number</td>
			        <td>Registration Number</td>
			        <td>Name (Optional)</td>
		        </tr>
		      </thead>
		      
		      <tbody align="center">
	        	
	        	<?php
	        	
	        	foreach($buses_bus_personnel as $bbp){ 
	        	
	        	$assigned_bus = $bus_object->find_by_id($bbp->bus_id);
	        		
	        	?>
        		<tr>
	        		<td><a href="public_read_route.php?routeid=<?php echo $route_object->find_by_id($assigned_bus->route_id)->id; ?>" class="btn btn-primary btn-block"><?php echo $route_object->find_by_id($assigned_bus->route_id)->route_number; ?></a></td>
	        		<td><a href="public_read_bus.php?busid=<?php echo $assigned_bus->id; ?>" class="btn btn-success btn-block"><?php echo $assigned_bus->reg_number; ?></a></td>
	        		<td><?php echo $assigned_bus->name; ?></td>
        		</tr>
	        	<?php } ?>
	        	
	          </tbody>
	          
	        </table>

      		</div>
	      	
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
	      		echo '<h4>You have not provided Feedback on this Bus Person</h4>'; 
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
	      		echo '<h4>You have not submitted any Complaints on this Bus Person</h4>'; 
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