<?php
require_once("../includes/initialize.php");

if (!$session->is_logged_in()){
	redirect_to("login.php");
} else {
	
	$admin_user = Admin::find_by_id($_SESSION['id']);
	
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
	
}

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <title>User Profile &middot; Gaman</title>
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
	    </ul>
	    
	    <div id="myTabContent" class="tab-content">
	      <div class="tab-pane active in" id="user_details">
	      
	      <?php echo $session->message; ?>
	      
	        <form action="admin_view_profile.php" method="POST" id="tab" class="form-horizontal">
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
						  <option value="3"<?php if (!empty($admin_user->admin_level) && $admin_user->admin_level == 3) echo ' selected = "selected"'; ?>>Scheduler</option>
						  <option value="1"<?php if (!empty($admin_user->admin_level) && $admin_user->admin_level == 1) echo ' selected = "selected"'; ?>>Time Keeper</option>
						  <option value="2"<?php if (!empty($admin_user->admin_level) && $admin_user->admin_level == 2) echo ' selected = "selected"'; ?>>Stand OIC</option>
						  <option value="4"<?php if (!empty($admin_user->admin_level) && $admin_user->admin_level == 4) echo ' selected = "selected"'; ?>>Admin Level 4</option>
						  <option value="5"<?php if (!empty($admin_user->admin_level) && $admin_user->admin_level == 5) echo ' selected = "selected"'; ?>>Admin Level 5</option>
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
	    	<form action="admin_view_profile.php" method="POST" id="tab2" class="form-horizontal">
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

    <?php require_once('../includes/layouts/bootstrap_scripts_admin.php');?>

  </body>
</html>