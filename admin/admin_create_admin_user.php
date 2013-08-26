<?php
require_once("../includes/initialize.php");

if (!$session->is_logged_in()){
	redirect_to("login.php");
} else {
	$admin_user = Admin::find_by_id($_SESSION['id']);
}

if (isset($_POST['submit'])) {
	
	$user_to_create = new Admin();
	
	$user_to_create->username = $_POST['username'];
	$user_to_create->password = $_POST['password'];
	$user_to_create->admin_level = $_POST['admin_level'];
	$user_to_create->first_name = $_POST['first_name'];
	$user_to_create->last_name = $_POST['last_name'];
	$user_to_create->email_address = $_POST['email_address'];
	
	if ($user_to_create->create()){
		$session->message("Success! The Admin User has been added. ");
		redirect_to('admin_admin_users_list.php');
	} else {
		$session->message("Error! The Admin User could not be added. ");
	}
}

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Add Admin User &middot; Gaman</title>
    <?php require_once('../includes/layouts/header_admin.php');?>
  </head>

  <body>


    <!-- Part 1: Wrap all page content here -->
    <div id="wrap">

      <!-- Fixed navbar -->
      <?php require_once('../includes/layouts/navbar_admin.php');?>
      
      <header class="jumbotron subhead">
	      <div class="container-fluid">
	        <h1>Add Admin User</h1>
	      </div>
      </header>

      <!-- Begin page content -->
      
      <!-- Start Content -->
      
      <div class="container-fluid">
      
      <div class="row-fluid">
      
        <div class="span3">
        	<div class="sidenav" data-spy="affix" data-offset-top="200">
        		<a href="admin_admin_users_list.php" class="btn btn-primary"> &larr; Back to Admin Users List</a>
        	</div>  
        </div>
                
        <div class="span9">
        
        <section>
        
        <?php echo $session->message; ?>
        
        <form action="admin_create_admin_user.php" method="POST" class="form-horizontal">
            
            <div class="control-group">
            <label for="username" class="control-label">Username</label>
	            <div class="controls">
	            	<input type="text" value="" name="username">
	            </div>
            </div>
            
            <div class="control-group">
        	<label for="old_password" class="control-label">Password</label>
	        	<div class="controls">
	        		<input type="password" name="password">
	        	</div>
        	</div>
            
            <div class="control-group">
            <label for="admin_level" class="control-label">Admin Level</label>
	            <div class="controls">
		            <select name="admin_level">
					  <option value="3" selected="selected" >Scheduler</option>
					  <option value="1">Time Keeper</option>
					  <option value="2">Stand OIC</option>
					  <option value="4">Admin Level 4</option>
					  <option value="5">Admin Level 5</option>
					</select>
				</div>
            </div>
            
            <div class="control-group">
            <label for="first_name" class="control-label">First Name</label>
	            <div class="controls">
	            	<input type="text" value="" name="first_name">
	            </div>
            </div>
            
            <div class="control-group">
            <label for="last_name" class="control-label">Last Name</label>
	            <div class="controls">
	            	<input type="text" value="" name="last_name">
	            </div>
            </div>
            
            <div class="control-group">
            <label for="email_address" class="control-label">Email Address</label>
	            <div class="controls">
	            	<input type="text" value="" name="email_address">
	            </div>
            </div>
            
          	<div class="form-actions">
        	    <button class="btn btn-primary" name="submit">Submit</button>
        	</div>
        </form>
	  	
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