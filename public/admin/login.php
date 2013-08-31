<?php
require_once("../../includes/initialize.php");


 if ($session->is_logged_in()){
 	redirect_to("index.php");
 }
 
 $ot_object = new ObjectType();
 $object_type_admin = $ot_object->get_object_type_by_name("admin");
 
 $ot_object2 = new ObjectType();
 $object_type_bus_personnel = $ot_object2->get_object_type_by_name("bus_personnel");

if (isset($_POST['submit'])){
	
	$object_type = trim($_POST['object_type']);
	
	if ($object_type == $object_type_admin->id) {
		
		$username = trim($_POST['username']);
		$password = trim($_POST['password']);

		$admin_user_object = new AdminUser();
		$found_user_admin = $admin_user_object->authenticate($username, $password);
		
		if ($found_user_admin){
			$session->login($found_user_admin, $object_type_admin->id);
			redirect_to("index.php");
		} else {
			$session->message("username/password combination is incorrect. ");
		}
		
	} else if ($object_type == $object_type_bus_personnel->id) {
		
		$username = trim($_POST['username']);
		$password = trim($_POST['password']);
		
		$bus_personnel_object = new BusPersonnel();
		$found_user_bus_personnel = $bus_personnel_object->authenticate($username, $password);
		
		if ($found_user_bus_personnel){
			$session->login($found_user_bus_personnel, $object_type_bus_personnel->id);
			redirect_to("index.php");
		} else {
			$session->message("username/password combination is incorrect. ");
		}
		
	}
	
} else {
	$username = "";
	$password = "";
}


?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Login &middot; Gaman</title>
    <?php require_once('../../includes/layouts/header_admin.php');?>
    
    <style type="text/css">
      body {
        padding-top: 40px;
        padding-bottom: 40px;
        background-color: #f5f5f5;
      }

      .form-signin {
        max-width: 300px;
        padding: 19px 29px 29px;
        margin: 0 auto 20px;
        background-color: #fff;
        border: 1px solid #e5e5e5;
        -webkit-border-radius: 5px;
           -moz-border-radius: 5px;
                border-radius: 5px;
        -webkit-box-shadow: 0 1px 2px rgba(0,0,0,.05);
           -moz-box-shadow: 0 1px 2px rgba(0,0,0,.05);
                box-shadow: 0 1px 2px rgba(0,0,0,.05);
      }
      .form-signin .form-signin-heading,
      .form-signin .checkbox {
        margin-bottom: 10px;
      }
      .form-signin input[type="text"],
      .form-signin input[type="password"] {
        font-size: 16px;
        height: auto;
        margin-bottom: 15px;
        padding: 7px 9px;
      }
      
      .form-signin .control-label {
        font-size: 20px;
        height: auto;
        margin-bottom: 15px;
        padding: 7px 0px;
      }

    </style>
    
  </head>

  <body>

    <div class="container">

      <form class="form-signin" action="login.php" method="post">
        
        <div class="control-group">
        	<h2 class="form-signin-heading">Please sign in</h2>
        </div>
        
        <?php echo $session->message; ?>
        
        <div class="control-group">
        	<div class="controls">
        		<input type="text" name="username" class="form-control" placeholder="User Name" value="<?php echo htmlentities($username); ?>">
        	</div>
        </div>
        
        <div class="control-group">
        	<div class="controls">
        		<input type="password" name="password" class="form-control" placeholder="Password" value="<?php echo htmlentities($password); ?>">
        	</div>
        </div>
        
        <div class="control-group">
        	<div class="controls">
        	<label class="control-label">Login as:</label>
        		<select name="object_type">
        			<option value="<?php echo $object_type_admin->id; ?>"><?php echo $object_type_admin->display_name; ?></option>
        			<option value="<?php echo $object_type_bus_personnel->id; ?>"><?php echo $object_type_bus_personnel->display_name; ?></option>
        		</select>
        	</div>
        </div>
        
        <div class="form-actions">
        	<button class="btn btn-large btn-primary" type="submit" name="submit">Sign in</button>
        </div>
      
      </form>

    </div> <!-- /container -->

    <?php require_once('../../includes/layouts/scripts_admin.php');?>

  </body>
</html>
