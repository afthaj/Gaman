<?php
require_once("../../includes/initialize.php");

if ($session->is_logged_in() && $session->object_type == 5){
	
	$user = AdminUser::find_by_id($_SESSION['id']);
	$p = new Photograph();
	$profile_picture = $p->get_profile_picture($session->object_type, $user->id);
	
	$admin_levels = AdminLevel::find_all();
	
	if (isset($_POST['submit'])){
		$user->username = $_POST['username'];
		$user->first_name = $_POST['first_name'];
		$user->last_name = $_POST['last_name'];
		$user->email_address = $_POST['email_address'];
		$user->admin_level = $_POST['admin_level'];
	
		if ($user->update()){
			$session->message("Success! Your details were updated. ");
			redirect_to('admin_view_profile.php');
		} else {
			$session->message("Error! Your details could not be updated. ");
		}
	}
	
	if (isset($_POST['update'])){
	
		if ($_POST['old_password'] == $user->password){
				
			$user->password = $_POST['new_password'];
				
			if ($user->update()){
				$session->message("Success! Your password was updated. ");
				redirect_to('admin_view_profile.php');
			} else {
				$session->message("Error! Your password could not be updated. ");
			}
		} else {
			$session->message("Error! The existing password did not match. ");
		}
	
	}
	
	if (isset($_POST['upload'])){
	
		$photo = new Photograph();
		
		$photo->related_object_type = '5';
		$photo->related_object_id = $user->id;
		$photo->photo_type = 9; // photo_type 9 is "User Profile"
		$photo->attach_file_admin_user($_FILES['file_upload'], $user->id, $user->first_name, $user->last_name);
	
		if ($photo->save()){
			$session->message("Success! The photo was uploaded successfully. ");
			redirect_to('admin_list_admin_users.php');
		} else {
			$message = join("<br />", $photo->errors);
		}
	
	}
	
} else if ($session->is_logged_in() && $session->object_type == 4) {
	
	$user = BusPersonnel::find_by_id($_SESSION['id']);
	$p = new Photograph();
	$profile_picture = $p->get_profile_picture($session->object_type, $user->id);
	
	$roles = BusPersonnelRole::find_all();
	$buses = Bus::find_all();
	
	if (isset($_POST['submit'])){
		$user->username = $_POST['username'];
		$user->first_name = $_POST['first_name'];
		$user->last_name = $_POST['last_name'];
		$user->nic_number = $_POST['nic_number'];
		$user->telephone_number = $_POST['telephone_number'];
	
		if ($user->update()){
			$session->message("Success! Your details were updated. ");
			redirect_to('admin_view_profile.php');
		} else {
			$session->message("Error! Your details could not be updated. ");
		}
	}
	
	if (isset($_POST['update'])){
	
		if ($_POST['old_password'] == $user->password){
	
			$user->password = $_POST['new_password'];
	
			if ($user->update()){
				$session->message("Success! Your password was updated. ");
				redirect_to('admin_view_profile.php');
			} else {
				$session->message("Error! Your password could not be updated. ");
			}
		} else {
			$session->message("Error! The existing password did not match. ");
		}
	
	}
	
	if (isset($_POST['upload'])){
	
		$photo = new Photograph();
		
		$photo->related_object_type = '4';
		$photo->related_object_id = $user->id;
		$photo->photo_type = 9; // photo_type 9 is "User Profile"
		$photo->attach_file_bus_personnel($_FILES['file_upload'], $user->id, $user->first_name, $user->last_name);
	
		if ($photo->save()){
			$session->message("Success! The photo was uploaded successfully. ");
			redirect_to('admin_view_profile.php');
		} else {
			$message = join("<br />", $photo->errors);
		}
	
	}
	
} else {
	redirect_to("login.php");
}

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <title>User Profile &middot; <?php echo WEB_APP_NAME; ?></title>
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
		 	<h1>User Profile</h1>
		 	<h3><?php echo $user->full_name();?></h3>
		 </div>
		 
		 <div class="span3">
		 
		 <?php 
         if (!empty($profile_picture->filename)) {
         	echo '<img src="../../' . $profile_picture->image_path() . '" width="200" class="img-rounded pull-right" />'; 
         } else {
         	echo '<img src="../img/default-prof-pic.jpg" width="200" class="img-rounded pull-right" alt="Please upload a profile picture" />';
         }
         ?>
		 
		 </div>
		 
		 </div>
	  </header>

      <!-- Begin page content -->
      
      <div class="container-fluid">
        
        <!-- Start Content -->
        
        <div class="row-fluid">
        
        <div class="span3">
	        <div class="sidenav" data-spy="affix" data-offset-top="200">
	        	<?php if ($session->is_logged_in() && $session->object_type == 5) { ?>
	        		<a href="admin_list_admin_users.php" class="btn btn-primary"> &larr; Back to Admin Users List</a>
	        	<?php } else if ($session->is_logged_in() && $session->object_type == 4) {?>
	        		<a href="index.php" class="btn btn-primary"> &larr; Back to Home</a>
	        	<?php } ?>
	        </div>
        </div>
        
        <div class="span9">
	    
	    <section>
	    
	    <ul class="nav nav-tabs">
	      <li class="active"><a href="#user_details" data-toggle="tab">Profile</a></li>
	      <li><a href="#password_update" data-toggle="tab">Password</a></li>
	      <li><a href="#profile_picture" data-toggle="tab">Profile Picture</a></li>
	    </ul>
	    
	    <div id="myTabContent" class="tab-content">
	      <div class="tab-pane active in" id="user_details">
	      
	      <?php echo $message; ?>
	      	      
	        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" id="tab" class="form-horizontal">
	            
	            <div class="control-group">
	            	<label for="username" class="control-label">Username</label>
	            
		            <div class="controls">
		            	<input type="text" name="username" value="<?php echo $user->username; ?>" />
		            </div>
	            </div>
	            
	            <?php if ($session->is_logged_in() && $session->object_type == 5) { ?>
	            <div class="control-group">
	            	<label for="admin_level" class="control-label">Admin Level</label>
	            
		            <div class="controls">
			            <select name="admin_level">
			            <?php for ($i = 0; $i < count($admin_levels); $i++) {?>
			            	<option value="<?php echo $admin_levels[$i]->id; ?>"<?php if (!empty($user->admin_level) && $user->admin_level == $admin_levels[$i]->id) echo ' selected = "selected"'; ?>><?php echo $admin_levels[$i]->admin_level_name; ?></option>
			            <?php } ?>
						</select>
		            </div>
	            </div>
	            <?php } else if ($session->is_logged_in() && $session->object_type == 4) {?>
	            <div class="control-group">
	            <label for="role" class="control-label">Role</label>
		            <div class="controls">
		            	<select name="role"<?php if (!($session->is_logged_in() && $session->object_type == 5)){ echo ' disabled';}?>>
		            	<?php foreach($roles as $role){ ?>
		            		<option value="<?php echo $role->id; ?>"<?php if($user->role==$role->id){echo ' selected="selected"';}?>><?php echo $role->role_name; ?></option>
		            	<?php } ?>
						</select>
		            </div>
	            </div>
	            <?php } ?>
	            
	            <div class="control-group">
	            	<label for="first_name" class="control-label">First Name</label>
	            
		            <div class="controls">
		            	<input type="text" name="first_name" value="<?php echo $user->first_name; ?>" />
		            </div>
	            </div>
	            
	            <div class="control-group">
	            	<label for="last_name" class="control-label">Last Name</label>
	            
		            <div class="controls">
		            	<input type="text" name="last_name" value="<?php echo $user->last_name; ?>" />
		            </div>
	            </div>
	            
	            <?php if ($session->is_logged_in() && $session->object_type == 5) { ?>
	            <div class="control-group">
	            	<label for="email_address" class="control-label">Email Address</label>
		            <div class="controls">
		            	<input type="text" name="email_address" value="<?php echo $user->email_address; ?>" />
		            </div>
	           </div>
	           <?php } else if ($session->is_logged_in() && $session->object_type == 4) {?>
	           <div class="control-group">
	            	<label for="nic_number" class="control-label">NIC Number</label>
		            <div class="controls">
		            	<input type="text" name="nic_number" value="<?php echo $user->nic_number; ?>" />
		            </div>
	           </div>
	           
	           <div class="control-group">
	            	<label for="telephone_number" class="control-label">Telephone Number</label>
		            <div class="controls">
		            	<input type="text" name="telephone_number" value="<?php echo $user->telephone_number; ?>" />
		            </div>
	           </div>
	            <?php } ?> 
	            
	           <div class="form-actions">
	           		<button class="btn btn-primary" name="submit">Submit</button>
	           </div>
	        </form>
	        
	      </div>
	      
	      <div class="tab-pane fade" id="password_update">
	    	
	    	<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" id="tab" class="form-horizontal">
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
          if (!empty($profile_picture->filename)) {
          	echo '<h5>You have already uploaded a Profile Picture</h5>';
          	echo '<a href="#" class="btn btn-danger"/>Delete and Reupload</a>';
          } else { 
          ?>
		  <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data">
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