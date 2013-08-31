<?php
require_once("../includes/initialize.php");

if (!$session->is_logged_in()){
	redirect_to("login.php");
} else {
	
	$admin_user = AdminUser::find_by_id($_SESSION['id']);
	$p = new Photograph();
	$profile_picture = $p->get_profile_picture($admin_user->id, "admin");
	
	$admin_levels = AdminLevel::find_all();
	
	if (isset($_POST['submit'])){
		$admin_user->username = $_POST['username'];
		$admin_user->first_name = $_POST['first_name'];
		$admin_user->last_name = $_POST['last_name'];
		$admin_user->email_address = $_POST['email_address'];
		$admin_user->admin_level = $_POST['admin_level'];
	
		if ($admin_user->update()){
			$session->message("Success! The user details were updated. ");
			redirect_to('admin_view_profile.php');
		} else {
			$session->message("Error! The user details could not be updated. ");
		}
	}
	
	if (isset($_POST['update'])){
		
		if ($_POST['old_password'] == $admin_user->password){
			
			$admin_user->password = $_POST['new_password'];
			
			if ($admin_user->update()){
				$session->message("Success! The password was updated. ");
				redirect_to('admin_view_profile.php');
			} else {
				$session->message("Error! The user details could not be updated. ");
			}
		} else {
			$session->message("Error! The existing password did not match. ");
		}

	}
	
	if (isset($_POST['upload'])){
		
		$photo = new Photograph();
		
		$photo->admin_id = $admin_user->id;
		$photo->photo_type = 9; // photo_type 9 is "User Profile"
		$photo->attach_file_admin_user($_FILES['file_upload'], $admin_user->id, $admin_user->first_name, $admin_user->last_name);
	
		if ($photo->save()){
			$session->message("Success! The photo was uploaded successfully. ");
			redirect_to('admin_list_admin_users.php');
		} else {
			$message = join("<br />", $photo->errors);
		}
	
	}
	
	
}

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <title>User Profile &middot; <?php echo WEB_APP_NAME; ?></title>
    <?php require_once('../includes/layouts/header_admin.php');?>
  </head>

  <body>


    <!-- Part 1: Wrap all page content here -->
    <div id="wrap">

      <!-- Fixed navbar -->
      <?php require_once('../includes/layouts/navbar_admin.php');?>
      
      <header class="jumbotron subhead">
		 <div class="container-fluid">
		   <h1>Admin User Profile</h1>
		   <h3><?php echo $admin_user->full_name();?></h3>
		 </div>
	  </header>

      <!-- Begin page content -->
      
      <div class="container-fluid">
        
        <!-- Start Content -->
        
        <div class="row-fluid">
        
        <div class="span3">
	        <div class="sidenav" data-spy="affix" data-offset-top="200">
	        	<a href="admin_list_admin_users.php" class="btn btn-primary"> &larr; Back to Admin Users List</a>
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
	            	<label for="profile_picture" class="control-label">Profile Picture</label>
	            
		            <div class="controls">
		            	<?php 
		            	if (!empty($profile_picture->filename)) {
		            		echo '<img src="../' . $profile_picture->image_path() . '" width="250" class="img-rounded" />'; 
		            	} else {
		            		echo '<img src="../img/default-prof-pic.jpg" width="250" class="img-rounded" alt="Please upload a profile picture" />';
		            		echo '<p>Please upload a profile picture</p>';
		            	} 
		            	?>
		            </div>
	            </div>
	            
	            <div class="control-group">
	            	<label for="username" class="control-label">Username</label>
	            
		            <div class="controls">
		            	<input type="text" value="<?php echo $admin_user->username; ?>" name="username">
		            </div>
	            </div>
	            
	            <div class="control-group">
	            	<label for="admin_level" class="control-label">Admin Level</label>
	            
		            <div class="controls">
			            <select name="admin_level">
			            <?php for ($i = 0; $i < count($admin_levels); $i++) {?>
			            	<option value="<?php echo $admin_levels[$i]->id; ?>"<?php if (!empty($admin_user->admin_level) && $admin_user->admin_level == $admin_levels[$i]->id) echo ' selected = "selected"'; ?>><?php echo $admin_levels[$i]->admin_level_name; ?></option>
			            <?php } ?>
						</select>
		            </div>
	            </div>
	            
	            <div class="control-group">
	            	<label for="first_name" class="control-label">First Name</label>
	            
		            <div class="controls">
		            	<input type="text" value="<?php echo $admin_user->first_name; ?>" name="first_name">
		            </div>
	            </div>
	            
	            <div class="control-group">
	            	<label for="last_name" class="control-label">Last Name</label>
	            
		            <div class="controls">
		            	<input type="text" value="<?php echo $admin_user->last_name; ?>" name="last_name">
		            </div>
	            </div>
	            
	            <div class="control-group">
	            	<label for="email_address" class="control-label">Email Address</label>
	            
		            <div class="controls">
		            	<input type="text" value="<?php echo $admin_user->email_address; ?>" name="email_address">
		            </div>
	           </div>
	            
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
		  <form action="<?php echo $_SERVER['PHP_SELF']; ?>?adminid=<?php echo $_GET['adminid']; ?>" method="POST" enctype="multipart/form-data">
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

    <?php require_once('../includes/layouts/footer_admin.php');?>

    <?php require_once('../includes/layouts/scripts_admin.php');?>

  </body>
</html>