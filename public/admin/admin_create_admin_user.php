<?php
require_once("../includes/initialize.php");

//init code
$photo_object = new Photograph();
$admin_user_object = new AdminUser();

//check login
if ($session->is_logged_in()){
	
	if ($session->object_type == 5){
		//admin user
	
		$user = $admin_user_object->find_by_id($_SESSION['id']);
		$profile_picture = $photo_object->get_profile_picture($session->object_type, $user->id);
	
		$admin_levels = AdminLevel::find_all();
	
		if (isset($_POST['submit'])) {
	
			$user_to_create = new AdminUser();
	
			$user_to_create->username = $_POST['username'];
			$user_to_create->password = $_POST['password'];
			$user_to_create->admin_level = $_POST['admin_level'];
			$user_to_create->first_name = $_POST['first_name'];
			$user_to_create->last_name = $_POST['last_name'];
			$user_to_create->email_address = $_POST['email_address'];
	
			if ($user_to_create->create()){
				$session->message("Success! The Admin User has been added. ");
				redirect_to('admin_list_admin_users.php');
			} else {
				$session->message("Error! The Admin User could not be added. ");
			}
		}
	
	} else {
		$session->message("Error! You do not have sufficient priviledges to view the requested page. ");
		redirect_to("index.php");
	}
} else {
	$session->message("Error! You must login to view the requested page. ");
	redirect_to("login.php");
}




?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Add Admin User &middot; <?php echo WEB_APP_NAME; ?></title>
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
        		<a href="admin_list_admin_users.php" class="btn btn-primary btn-block"><i class="icon-arrow-left icon-white"></i> Back to List of Admin Users</a>
        	</div>  
        </div>
                
        <div class="span9">
        
        <section>
        
        <?php echo $session->message; ?>
        
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" class="form-horizontal">
            
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
					  <?php for($i = 0; $i < count($admin_levels); $i++){ ?>
					  	<option value="<?php echo $admin_levels[$i]->id; ?>"<?php if($admin_levels[$i]->admin_level_name == 'Scheduler'){ echo ' selected="selected"'; }?>><?php echo $admin_levels[$i]->admin_level_name; ?></option>
					  <?php } ?>
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

    <?php require_once('../includes/layouts/scripts_admin.php');?>

  </body>
</html>