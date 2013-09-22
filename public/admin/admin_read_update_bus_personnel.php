<?php
require_once("../../includes/initialize.php");

//init code
$photo_object = new Photograph();
$admin_user_object = new AdminUser();

$route_object = new BusRoute();
$stop_object = new BusStop();
$bus_object = new Bus();
$bus_personnel_object = new BusPersonnel();

$object_type_object = new ObjectType();

$bus_personnel_role_object = new BusPersonnelRole();
$bus_bus_personnel_object = new BusBusPersonnel();

$complaint_object = new Complaint();
$complaint_status_object = new ComplaintStatus();
$complaint_type_object = new ComplaintType();
$feedback_item_object = new FeedbackItem();

$roles = BusPersonnelRole::find_all();
$buses = Bus::find_all();

//check login
if ($session->is_logged_in()){
	
	if ($session->object_type == 5){
		//admin user
	
		$user = $admin_user_object->find_by_id($_SESSION['id']);
		$profile_picture = $photo_object->get_profile_picture($session->object_type, $user->id);
	
		if (isset($_GET['personnelid'])){
			$bus_personnel_to_read_update = $bus_personnel_object->find_by_id($_GET['personnelid']);
			$profile_picture_of_bus_personnel = $photo_object->get_profile_picture('4', $bus_personnel_to_read_update->id);
			$complaints_of_bus_personnel = $complaint_object->get_complaints_for_object(4, $_GET['personnelid']);
			$feedback_on_bus_personnel = $feedback_item_object->get_feedback_items_for_object(4, $_GET['personnelid']);
	
		} else {
			$session->message("No Bus Personnel ID provided to view.");
			redirect_to("admin_list_bus_personnel.php");
		}
	
		if (isset($_POST['submit'])){
			$bus_personnel_to_read_update->role = $_POST['role'];
			$bus_personnel_to_read_update->username = $_POST['username'];
			$bus_personnel_to_read_update->first_name = $_POST['first_name'];
			$bus_personnel_to_read_update->last_name = $_POST['last_name'];
			$bus_personnel_to_read_update->nic_number = $_POST['nic_number'];
	
			if ($bus_personnel_to_read_update->update()){
				$session->message("Success! The Bus Personnel details were updated. ");
				redirect_to('admin_list_bus_personnel.php');
			} else {
				$session->message("Error! The Bus details could not be updated. ");
			}
		}
	
		if (isset($_POST['assign'])){
	
			$buses_bus_personnel_to_read_update = new BusBusPersonnel();
	
			$buses_bus_personnel_to_read_update->bus_id = $_POST['bus_id'];
			$buses_bus_personnel_to_read_update->bus_personnel_id = $bus_personnel_to_read_update->id;
	
			if ($buses_bus_personnel_to_read_update->create()){
				$session->message("Success! The Bus Personnel was assigned to the given Bus. ");
				redirect_to('admin_list_bus_personnel.php');
			} else {
				$session->message("Error! The Bus Personnel was not assigned to the given Bus. ");
			}
		}
	
		if (isset($_POST['update'])){
			if ($_POST['old_password'] == $bus_personnel_to_read_update->password) {
	
				$bus_personnel_to_read_update->password = $_POST['new_password'];
	
				if ($bus_personnel_to_read_update->update()){
					$session->message("Success! The user's password was updated. ");
					redirect_to('admin_list_bus_personnel.php');
				} else {
					$session->message("Error! The user's password could not be updated. ");
				}
	
			} else {
				$session->message("Error! The existing password did not match. ");
			}
		}
	
		if (isset($_POST['upload'])){
	
			$photo_to_upload = new Photograph();
	
			$photo_to_upload->related_object_type = '4';
			$photo_to_upload->related_object_id = $_GET['personnelid'];
			$photo_to_upload->photo_type = '9'; // photo_type 9 is "User Profile"
	
			$photo_to_upload->attach_file_bus_personnel($_FILES['file_upload'], $bus_personnel_to_read_update->id, $bus_personnel_to_read_update->first_name, $bus_personnel_to_read_update->last_name);
	
			if ($photo_to_upload->save()){
				$session->message("Success! The photo was uploaded successfully. ");
				redirect_to('admin_list_bus_personnel.php');
			} else {
				$message = join("<br />", $photo_to_upload->errors);
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

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Bus Personnel Details &middot; <?php echo WEB_APP_NAME; ?></title>
    <?php require_once('../../includes/layouts/header_admin.php');?>
  </head>

  <body>


    <!-- Part 1: Wrap all page content here -->
    <div id="wrap">

      <!-- Fixed navbar -->
      <?php require_once('../../includes/layouts/navbar_admin.php');?>
      
      <header class="jumbotron subhead">
		 <div class="container-fluid">
		 
		 <div class="span3">
		 
		 <?php 
         if (!empty($profile_picture_of_bus_personnel->filename)) {
         	echo '<img src="../../' . $profile_picture_of_bus_personnel->image_path() . '" width="200" class="img-rounded" />'; 
         } else {
         	echo '<img src="../img/default-prof-pic.jpg" width="200" class="img-rounded" alt="Please upload a profile picture" />';
         } 
         ?>
		 
		 </div>
		 
		 <div class="span9">
		   <h1><?php echo $bus_personnel_to_read_update->full_name();?></h1>
		   <h3><?php echo $bus_personnel_role_object->find_by_id($bus_personnel_to_read_update->role)->role_name;?></h3>
		 </div>
		 
		 </div>
	  </header>
      
      <!-- Begin page content -->
      
      <div class="container-fluid">
      
      <div class="row-fluid">
      
        <div class="span3">
	        <div class="sidenav" data-spy="affix" data-offset-top="250">
	        	<a href="admin_list_bus_personnel.php" class="btn btn-primary btn-block"><i class="icon-arrow-left icon-white"></i> Back to List of Bus Personnel</a>
	        	<br />
	        	<a href="admin_create_feedback.php" class="btn btn-success btn-block"><i class="icon-thumbs-up icon-white"></i> Give Feedback</a>
	        	<a href="admin_create_complaint.php" class="btn btn-danger btn-block"><i class="icon-exclamation-sign icon-white"></i> Create Complaint</a>
	        	<br />
	        	<div class="well">Feedback <span class="badge badge-success"><?php echo count($feedback_on_bus_personnel); ?></span></div>
	        	<div class="well">Complaints <span class="badge badge-important"><?php echo count($complaints_of_bus_personnel); ?></span></div>
	        </div>
        </div>
        
        <!-- Start Content -->

        <div class="span9">
        
        <section>
        
        <?php echo $session->message; ?>
        
        <ul class="nav nav-tabs">
	      <li class="active"><a href="#personnel_profile" data-toggle="tab">Profile</a></li>
	      <li><a href="#password_update" data-toggle="tab">Password</a></li>
	      <li><a href="#profile_picture" data-toggle="tab">Profile Picture</a></li>
	      <li><a href="#assigned_buses_list" data-toggle="tab">Bus Assignment</a></li>
	      <li><a href="#feedback" data-toggle="tab">Feedback </a></li>
	      <li><a href="#complaints" data-toggle="tab">Complaints </a></li>
	    </ul>
	    
	    <div id="tab_content" class="tab-content">
	      	
	      	<div class="tab-pane active in" id="personnel_profile">
	      	
	      	<form class="form-horizontal" action="<?php echo $_SERVER['PHP_SELF']; ?>?personnelid=<?php echo $_GET['personnelid']; ?>" method="POST">
            
            <div class="control-group">
            	<label for="role" class="control-label">Role</label>
	            <div class="controls">
	            	<select name="role">
					<?php foreach($roles as $role){ ?>
	            		<option value="<?php echo $role->id; ?>"<?php if ($bus_personnel_to_read_update->role == $role->id){ echo ' selected="selected"';} ?>><?php echo $role->role_name; ?></option>
	            	<?php } ?>
					</select>
	            </div>
            </div>
            
            <div class="control-group">
        	<label for="username" class="control-label">Username</label>
	        	<div class="controls">
	        		<input type="text" name="username" value="<?php echo $bus_personnel_to_read_update->username; ?>" />
	        	</div>
        	</div>
            
            <div class="control-group">
        	<label for="first_name" class="control-label">First Name</label>
	        	<div class="controls">
	        		<input type="text" name="first_name" value="<?php echo $bus_personnel_to_read_update->first_name; ?>" />
	        	</div>
        	</div>
            
            <div class="control-group">
            <label for="last_name" class="control-label">Last Name</label>
	            <div class="controls">
	            	<input type="text" name="last_name" value="<?php echo $bus_personnel_to_read_update->last_name; ?>" />
	            </div>
            </div>
            
            <div class="control-group">
        	<label for="nic_number" class="control-label">NIC Number</label>
	        	<div class="controls">
	        		<input type="text" name="nic_number" value="<?php echo $bus_personnel_to_read_update->nic_number; ?>" />
	        	</div>
        	</div>
	            
          	<div class="form-actions">
        	    <button class="btn btn-primary" name="submit">Submit</button>
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
			        <td>Registration Number</td>
			        <td>Route Number</td>
			        <td>Name (Optional)</td>
		        </tr>
		      </thead>
		      
		      <tbody align="center">
	        	
	        	<?php
	        	
	        	$buses_bus_personnel = $bus_bus_personnel_object->get_buses_for_personnel($bus_personnel_to_read_update->id);
	        	
	        	foreach($buses_bus_personnel as $bbp){ 
	        	
	        	$assigned_bus = $bus_object->find_by_id($bbp->bus_id);
	        		
	        	?>
        		<tr>
	        		<td><a href="admin_read_update_bus.php?busid=<?php echo $assigned_bus->id; ?>" class="btn btn-block btn-info"><?php echo $assigned_bus->reg_number; ?></a></td>
	        		<td><?php echo $route_object->find_by_id($assigned_bus->route_id)->route_number; ?></td>
	        		<td><?php echo $assigned_bus->name; ?></td>
        		</tr>
	        	<?php } ?>
	        	
	          </tbody>
	          
	        </table>

      		</div>
      		
      		<div class="row-fluid">
      		
      		<form class="form-horizontal" action="<?php echo $_SERVER['PHP_SELF']; ?>?personnelid=<?php echo $_GET['personnelid']; ?>" method="POST">
            
            <div class="control-group">
            <label for="bus_id" class="control-label">Assign to a  Bus</label>
	            <div class="controls">
	            	<select name="bus_id">
	            	<?php foreach($buses as $bus){ ?>
	            		<option value="<?php echo $bus->id; ?>"><?php echo $route_object->find_by_id($bus->route_id)->route_number; ?> &middot; <?php echo $bus->reg_number; ?><?php if(!empty($bus->name)){ echo ' &middot; ' . $bus->name;} ?></option>
	            	<?php } ?>
					</select>
	            </div>
            </div>
	            
          	<div class="form-actions">
        	    <button class="btn btn-primary" name="assign">Assign</button>
        	</div>
	        </form>
      		
      		</div>
	      	
	   		</div>
	   		
	   		<div class="tab-pane fade" id="password_update">
	   		
	    	<form class="form-horizontal" action="<?php echo $_SERVER['PHP_SELF']; ?>.php?personnelid=<?php echo $_GET['adminid']; ?>" method="POST" id="tab">
	    	
	    		<div class="control-group">
	        	<label for="old_password" class="control-label">Old Password</label>
		        	<div class="controls">
		        		<input type="password" name="old_password">
		        	</div>
	        	</div>
	    		
	    		<div class="control-group">
	        	<label for="new_password" class="control-label">New Password</label>
		        	<div class="controls">
		        		<input type="password" name="new_password">
		        	</div>
	        	</div>
	        	
	        	<div class="form-actions">
	        	    <button class="btn btn-primary" name="update">Update</button>
	        	</div>
	    	</form>
	    	
	      	</div>
	      	
	      	<div class="tab-pane fade" id="profile_picture">
	      
		      <?php 
	          if (!empty($profile_picture_of_bus_personnel->filename)) {
	          	echo '<h5>This User already has a Profile Picture uploaded</h5>';
	          	echo '<a href="#" class="btn btn-danger"/>Delete and Reupload</a>';
	          } else { 
	          ?>
	          
			  <form action="<?php echo $_SERVER['PHP_SELF']; ?>?personnelid=<?php echo $_GET['personnelid']; ?>" method="POST" enctype="multipart/form-data">
			      <input type="hidden" name="MAX_FILE_SIZE" value="1000000"/>
			        	
			      <div class="control-group">
			      	<input type="file" name="file_upload" />
			      </div>
			        	
			      <div class="form-actions">
			      	<button type="submit" class="btn btn-primary" name="upload">Upload</button>
			      </div>	        	
		      </form>
		      
		      <?php } ?>
		    	
		    </div>
		    
		    <div class="tab-pane fade" id="complaints">
	      	<?php if ($complaints_of_bus_personnel) { 
	      		
	      		foreach ($complaints_of_bus_personnel as $complaint) { ?>
	      		
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
	      		echo '<h4>No Complaints have been submitted on this Bus Person</h4>'; 
	      	} 
	      	
	      	?>
	      	</div>
	      	
	      	<div class="tab-pane fade" id="feedback">
	      	<?php if ($feedback_on_bus_personnel) { 
	      		
	      		foreach ($feedback_on_bus_personnel as $feedback_item) { ?>
	      		
	      		<div class="well">
	      			<p><?php echo $feedback_item->content; ?></p>
	      			<p>Submitted on <span class="badge"><?php echo date("d M Y", $feedback_item->date_time_submitted); ?></span> at <span class="badge"><?php echo date("h:i:s a", $feedback_item->date_time_submitted); ?></span>
	      			</p>
	      		</div>
	      	<?php } 
	      	
	      	} else { 
	      		echo '<h4>No Feedback has been submitted on this Bus Person</h4>'; 
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

    <?php require_once('../../includes/layouts/footer_admin.php');?>

    <?php require_once('../../includes/layouts/scripts_admin.php');?>

  </body>
</html>