<?php
require_once("../../includes/initialize.php");

if ($session->is_logged_in() && $session->object_type == 5){
	
	$user = AdminUser::find_by_id($_SESSION['id']);
	$p = new Photograph();
	$profile_picture = $p->get_profile_picture($session->object_type, $user->id);
	
	if (isset($_GET['personnelid'])){
		$bus_personnel_to_read_update = BusPersonnel::find_by_id($_GET['personnelid']);
	
		$pic = new Photograph();
		$profile_picture_of_bus_personnel = $pic->get_profile_picture('4', $bus_personnel_to_read_update->id);
	
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
	redirect_to("login.php");
}

$roles = BusPersonnelRole::find_all();
$buses = Bus::find_all();

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
		 
		 <div class="span9">
		   <h1>Bus Personnel Profile</h1>
		   <h3><?php echo $bus_personnel_to_read_update->full_name();?></h3>
		 </div>
		 
		 <div class="span3">
		 
		 <?php 
         if (!empty($profile_picture_of_bus_personnel->filename)) {
         	echo '<img src="../../' . $profile_picture_of_bus_personnel->image_path() . '" width="200" class="img-rounded pull-right" />'; 
         } else {
         	echo '<img src="../img/default-prof-pic.jpg" width="200" class="img-rounded pull-right" alt="Please upload a profile picture" />';
         } 
         ?>
		 
		 </div>
		 
		 </div>
	  </header>
      
      <!-- Begin page content -->
      
      <div class="container-fluid">
      
      <div class="row-fluid">
      
        <div class="span3">
	        <div class="sidenav" data-spy="affix" data-offset-top="200">
	        	<a href="admin_list_bus_personnel.php" class="btn btn-primary"> &larr; Back to Bus Personnel List</a>
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
	        	
	        	$bbp_object = new BusBusPersonnel();
	        	$bus_object = new Bus();
	        	
	        	$buses_bus_personnel = $bbp_object->get_buses_for_personnel($bus_personnel_to_read_update->id);
	        	
	        	foreach($buses_bus_personnel as $bbp){ 
	        	
	        	$assigned_bus = $bus_object->find_by_id($bbp->bus_id);
	        		
	        	?>
        		<tr>
	        		<td><a href="admin_read_update_bus.php?busid=<?php echo $assigned_bus->id; ?>" class="btn btn-block btn-info"><?php echo $assigned_bus->reg_number; ?></a></td>
	        		<td><?php echo BusRoute::find_by_id($assigned_bus->route_id)->route_number; ?></td>
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
	            		<option value="<?php echo $bus->id; ?>"><?php echo BusRoute::find_by_id($bus->route_id)->route_number; ?> &middot; <?php echo $bus->reg_number; ?><?php if(!empty($bus->name)){ echo ' &middot; ' . $bus->name;} ?></option>
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