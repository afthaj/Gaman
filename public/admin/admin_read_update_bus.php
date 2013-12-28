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
$photo_type_object = new PhotoType();

$bus_bus_personnel_object = new BusBusPersonnel();

$complaint_object = new Complaint();
$complaint_status_object = new ComplaintStatus();
$complaint_type_object = new ComplaintType();
$feedback_item_object = new FeedbackItem();

// this is to check if the user is the (owner), (owner + driver), or (owner + conductor)
$bp = new BusPersonnel();

$routes = BusRoute::find_all();
$buses = Bus::find_all();
$bus_personnel = BusPersonnel::find_all();

$photo_types = $photo_type_object->get_photo_types("bus");
$photos_of_bus = $photo_object->get_photos('3', $_GET['busid']);

//GET request stuff
if (isset($_GET['busid'])){
	$bus_to_read_update = $bus_object->find_by_id($_GET['busid']);
	$complaints_of_bus = $complaint_object->get_complaints_for_object(3, $_GET['busid']);
	$feedback_on_bus = $feedback_item_object->get_feedback_items_for_object(3, $_GET['busid']);

} else {
	$session->message("No Bus ID provided to view.");
	redirect_to("admin_list_buses.php");
}

//check login
if ($session->is_logged_in()){
	
	if ($session->object_type == 5){
		//admin user
	
		$user = $admin_user_object->find_by_id($_SESSION['id']);
		$profile_picture = $photo_object->get_profile_picture($session->object_type, $user->id);
	
		if (isset($_POST['submit'])){
			$bus_to_read_update->route_id = $_POST['route_id'];
			$bus_to_read_update->reg_number = $_POST['reg_number'];
			$bus_to_read_update->name = $_POST['name'];
	
			if ($bus_to_read_update->update()){
				$session->message("Success! The Bus details were updated. ");
				redirect_to('admin_list_buses.php');
			} else {
				$session->message("Error! The Bus details could not be updated. ");
			}
		}
	
		if (isset($_POST['upload'])){
	
			$photo_to_upload = new Photograph();
	
			$photo_to_upload->related_object_type = '3';
			$photo_to_upload->related_object_id = $_GET['busid'];
			$photo_to_upload->photo_type = $_POST['photo_type'];
	
			$photo_to_upload->attach_file_bus($_FILES['file_upload'], $photo_to_upload->bus_id, $photo_to_upload->photo_type);
	
			if ($photo_to_upload->save()){
				$session->message("Success! The photo was uploaded successfully. ");
				redirect_to('admin_list_buses.php');
			} else {
				$message = join("<br />", $photo_to_upload->errors);
			}
	
		}
	
		if (isset($_POST['assign'])){
	
			$buses_bus_personnel_to_read_update = new BusBusPersonnel();
	
			$buses_bus_personnel_to_read_update->bus_id = $_GET['busid'];
			$buses_bus_personnel_to_read_update->bus_personnel_id = $_POST['bus_personnel_id'];
	
			if ($buses_bus_personnel_to_read_update->create()){
				$session->message("Success! The Bus Personnel was assigned to the given Bus. ");
				redirect_to('admin_list_buses.php');
			} else {
				$session->message("Error! The Bus Personnel was not assigned to the given Bus. ");
			}
		}
	
	} else if ($session->object_type == 4){
		//bus personnel
	
		$user = $bus_personnel_object->find_by_id($_SESSION['id']);
		$profile_picture = $photo_object->get_profile_picture($session->object_type, $user->id);
	
		if (isset($_POST['submit'])){
			$bus_to_read_update->route_id = $_POST['route_id'];
			$bus_to_read_update->reg_number = $_POST['reg_number'];
			$bus_to_read_update->name = $_POST['name'];
	
			if ($bus_to_read_update->update()){
				$session->message("Success! The Bus details were updated. ");
				redirect_to('admin_list_buses.php');
			} else {
				$session->message("Error! The Bus details could not be updated. ");
			}
		}
	
		if (isset($_POST['upload'])){
	
			$photo_to_upload = new Photograph();
	
			$photo_to_upload->related_object_type = '3';
			$photo_to_upload->related_object_id = $_GET['busid'];
			$photo_to_upload->photo_type = $_POST['photo_type'];
	
			$photo_to_upload->attach_file_bus($_FILES['file_upload'], $photo_to_upload->bus_id, $photo_to_upload->photo_type);
	
			if ($photo_to_upload->save()){
				$session->message("Success! The photo was uploaded successfully. ");
				redirect_to('admin_list_buses.php');
			} else {
				$message = join("<br />", $photo_to_upload->errors);
			}
	
		}
	
		if (isset($_POST['assign'])){
	
			$buses_bus_personnel_to_read_update = new BusBusPersonnel();
	
			$buses_bus_personnel_to_read_update->bus_id = $_GET['busid'];
			$buses_bus_personnel_to_read_update->bus_personnel_id = $_POST['bus_personnel_id'];
	
			if ($buses_bus_personnel_to_read_update->create()){
				$session->message("Success! The Bus Personnel was assigned to the given Bus. ");
				redirect_to('admin_list_buses.php');
			} else {
				$session->message("Error! The Bus Personnel was not assigned to the given Bus. ");
			}
		}
	
	} else {
		//everyone else
	
		$session->message("Error! You do not have sufficient priviledges to view the requested page. ");
		redirect_to("index.php");
	}
	
} else {
	//not logged in... GTFO!
	
	$session->message("Error! You must login to view the requested page. ");
	redirect_to("login.php");
}

$bus_bus_personnel = $bus_bus_personnel_object->check_if_user_is_personnel_for_a_bus($user->id, $bus_to_read_update->id); //$personnel_for_bus

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Bus Details &middot; <?php echo WEB_APP_NAME;?></title>
    <?php require_once('../includes/layouts/header_admin.php');?>
  </head>

  <body>


    <!-- Part 1: Wrap all page content here -->
    <div id="wrap">

      <!-- Fixed navbar -->
      <?php require_once('../includes/layouts/navbar_admin.php');?>
      
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
	        	<a href="admin_list_buses.php" class="btn btn-primary btn-block"><i class="icon-arrow-left icon-white"></i> Back to List of Buses</a>
	        	<br />
	        	<a href="admin_create_feedback.php" class="btn btn-success btn-block"><i class="icon-thumbs-up icon-white"></i> Give Feedback</a>
	        	<a href="admin_create_complaint.php" class="btn btn-danger btn-block"><i class="icon-exclamation-sign icon-white"></i> Create Complaint</a>
	        	<br />
	        	<div class="well">Feedback <span class="badge badge-success"><?php echo count($feedback_on_bus); ?></span></div>
	        	<div class="well">Complaints <span class="badge badge-important"><?php echo count($complaints_of_bus); ?></span></div>
	        </div>
        </div>
        
        <!-- Start Content -->

        <div class="span9">
        
        <section>
        
        <?php echo $session->message; ?>
        
        <ul class="nav nav-tabs">
	      <li class="active"><a href="#bus_pictures" data-toggle="tab">Pictures of the Bus</a></li>
	      <li><a href="#bus_profile" data-toggle="tab">Bus Profile</a></li>
	      <li><a href="#bus_personnel_list" data-toggle="tab">List of Personnel</a></li>
	      <li><a href="#feedback" data-toggle="tab">Feedback </a></li>
	      <li><a href="#complaints" data-toggle="tab">Complaints </a></li>
	    </ul>
	    
	    <div id="tab_content" class="tab-content">
	      	
	      	<div class="tab-pane fade" id="bus_profile">
	      	
	      	<form class="form-horizontal" action="<?php echo $_SERVER['PHP_SELF']; ?>?busid=<?php echo $_GET['busid']; ?>" method="POST">
            
	            <div class="control-group">
            	<label for="route_id" class="control-label">Route Number</label>
	            <div class="controls">
	            	<select name="route_id"<?php if (!($session->is_logged_in() && $session->object_type == 5)){ echo ' disabled'; } ?>>
					<?php foreach($routes as $route){ ?>
	            		<option value="<?php echo $route->id; ?>"<?php if ($bus_to_read_update->route_id == $route->id){ echo ' selected="selected"';} ?>><?php echo $route->route_number; ?></option>
	            	<?php } ?>
					</select>
	            </div>
            </div>
            
            <div class="control-group">
        	<label for="reg_number" class="control-label">Registration Number</label>
	        	<div class="controls">
	        		<input type="text" name="reg_number"<?php if (!($session->is_logged_in() && $session->object_type == 5)){ echo ' disabled'; } ?> value="<?php echo $bus_to_read_update->reg_number; ?>" />
	        	</div>
        	</div>
            
            <div class="control-group">
            <label for="name" class="control-label">Name of Bus</label>
	            <div class="controls">
	            	<input type="text" name="name"<?php
		      		
		      		if($bus_bus_personnel) { 
		      		
		      			if ($bp->check_personnel_owner($bus_bus_personnel->bus_personnel_id) || $bp->check_personnel_owner_driver($bus_bus_personnel->bus_personnel_id) || $bp->check_personnel_owner_conductor($bus_bus_personnel->bus_personnel_id)) {
		      				
		      			} else {
		      				echo ' disabled';
		      			}
		      		} else {
		      			echo ' disabled';
		      		}
      				?> value="<?php echo $bus_to_read_update->name; ?>" />
	            </div>
            </div>
            
            <?php
      		
      		if($bus_bus_personnel) { 
      		
      			if ($bp->check_personnel_owner($bus_bus_personnel->bus_personnel_id) || $bp->check_personnel_owner_driver($bus_bus_personnel->bus_personnel_id) || $bp->check_personnel_owner_conductor($bus_bus_personnel->bus_personnel_id)){
      			
      			?>
          	<div class="form-actions">
        	    <button class="btn btn-primary" name="submit">Submit</button>
        	</div>
        	<?php } } ?>
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
			        <td>Full Name</td>
			        <td>Role</td>
		        </tr>
		      </thead>
		      
		      <tbody align="center">
		      
		      <?php foreach($buses_bus_personnel as $bbp){

		      	$assigned_bus_personnel = $bus_personnel_object->find_by_id($bbp->bus_personnel_id);
		      	
		      	?>
	        		<tr>
		        		<td>
		        		<a href="admin_read_update_bus_personnel.php?personnelid=<?php echo $assigned_bus_personnel->id; ?>">
	        			<?php 
	        			
		        		$pic = new Photograph();
		        		
		        		$bus_personnel_profile_picture = $pic->get_profile_picture('4', $assigned_bus_personnel->id);
		        		
		        		if (!empty($bus_personnel_profile_picture->filename)) {
		        			echo '<img src="../../' . $bus_personnel_profile_picture->image_path() . '" width="100" class="img-rounded" />';
		        		} else {
		        			echo '<img src="../img/default-prof-pic.jpg" width="100" class="img-rounded" alt="Please upload a profile picture" />';
		        		}
		        		
		        		?>
		        		</a>
	        			</td>
	        			<td><a class="btn btn-block btn-info" href="admin_read_update_bus_personnel.php?personnelid=<?php echo $assigned_bus_personnel->id; ?>"><?php echo $assigned_bus_personnel->full_name(); ?></a></td>
		        		<td>
		        		<?php			        	
			        	
			        	$bus_personnel_role = new BusPersonnelRole();
			        	
		        		echo $bus_personnel_role->find_by_id($assigned_bus_personnel->role)->role_name;
		        		
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
      		
      		<?php 
      		
      		$bus_bus_personnel = $bus_bus_personnel_object->check_if_user_is_personnel_for_a_bus($user->id, $bus_to_read_update->id); //$personnel_for_bus
      		
      		if($bus_bus_personnel) { 
      		
      			if ($bp->check_personnel_owner($bus_bus_personnel->bus_personnel_id) || $bp->check_personnel_owner_driver($bus_bus_personnel->bus_personnel_id) || $bp->check_personnel_owner_conductor($bus_bus_personnel->bus_personnel_id)){
      			
      			?>
      		
      		<div class="row-fluid">
      		
      		<form class="form-horizontal" action="<?php echo $_SERVER['PHP_SELF']; ?>?busid=<?php echo $_GET['busid']; ?>" method="POST">
            
            <div class="control-group">
            <label for="bus_personnel_id" class="control-label">Assign to this Bus</label>
	            <div class="controls">
	            	<select name="bus_personnel_id">
	            	<?php foreach($bus_personnel as $bus_person){ 
	            	
	            		$bp_object = new BusPersonnel();
	            		$bpr_object = new BusPersonnelRole();
	            		
	            		?>
	            		<option value="<?php echo $bus_person->id; ?>">Name: <?php echo $bp_object->find_by_id($bus_person->id)->first_name; ?> <?php echo $bp_object->find_by_id($bus_person->id)->last_name; ?> &middot; NIC Number: <?php echo $bp_object->find_by_id($bus_person->id)->nic_number; ?> &middot; Role: <?php echo $bpr_object->find_by_id($bp_object->find_by_id($bus_person->id)->role)->role_name; ?></option>
	            	<?php } ?>
					</select>
	            </div>
            </div>
	            
          	<div class="form-actions">
        	    <button class="btn btn-primary" name="assign">Assign</button>
        	</div>
        	
	        </form>
	        
      		</div>
      		<?php } } ?>
	      	
	   		</div>
	   		
	   		<div class="tab-pane active in" id="bus_pictures">

			<?php if (!empty($photos_of_bus)) { ?>
				<div class="callbacks_container">
		        <ul class="rslides" id="responsive_slider">
		        
		        <?php for ( $i = 0; $i < count($photos_of_bus); $i++ ) { ?>
		        
					<li>
					<img src="<?php echo '../../'.$photos_of_bus[$i]->image_path(); ?>" alt="">
					<p class="caption"><?php echo $photo_type_object->find_by_id($photos_of_bus[$i]->photo_type)->photo_type_name; ?></p>
					</li>
				
		        <?php } ?>
		        
		        </ul>
		        </div>
			      
			<?php } else { ?>
			
			<h5>No photos of the Bus have been uploaded yet!</h5>
			<br /><br />
			<?php } ?>
			
			
			<?php 
      		
      		$bus_bus_personnel = $bus_bus_personnel_object->check_if_user_is_personnel_for_a_bus($user->id, $bus_to_read_update->id); //$personnel_for_bus
      		
      		if($bus_bus_personnel) { 
      		
      			if ($bp->check_personnel_owner($bus_bus_personnel->bus_personnel_id) || $bp->check_personnel_owner_driver($bus_bus_personnel->bus_personnel_id) || $bp->check_personnel_owner_conductor($bus_bus_personnel->bus_personnel_id)){
      			
      			?>
      			
			  <form class="form-horizontal" action="<?php echo $_SERVER['PHP_SELF']; ?>?busid=<?php echo $_GET['busid']; ?>" method="POST" enctype="multipart/form-data">
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
	  	<?php } } ?>
			</div>
			
			<div class="tab-pane fade" id="complaints">
	      	<?php if ($complaints_of_bus) { 
	      		
	      		foreach ($complaints_of_bus as $complaint) { ?>
	      		
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
	      		echo '<h4>No Complaints have been submitted on this Bus</h4>'; 
	      	} 
	      	
	      	?>
	      	</div>
	      	
	      	<div class="tab-pane fade" id="feedback">
	      	<?php if ($feedback_on_bus) { 
	      		
	      		foreach ($feedback_on_bus as $feedback_item) { ?>
	      		
	      		<div class="well">
	      			<p><?php echo $feedback_item->content; ?></p>
	      			<p>Submitted on <span class="badge"><?php echo date("d M Y", $feedback_item->date_time_submitted); ?></span> at <span class="badge"><?php echo date("h:i:s a", $feedback_item->date_time_submitted); ?></span>
	      			</p>
	      		</div>
	      	<?php } 
	      	
	      	} else { 
	      		echo '<h4>No Feedback has been submitted on this Bus</h4>'; 
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
    
    <?php require_once('../includes/layouts/scripts_admin.php');?>
    
    <?php require_once('../includes/layouts/footer_admin.php');?>
    
  </body>
</html>