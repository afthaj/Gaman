<?php
require_once("../includes/initialize.php");

if (!$session->is_logged_in()){
	redirect_to("login.php");
} else {
	$admin_user = AdminUser::find_by_id($_SESSION['id']);
	
	$users = AdminUser::find_all();
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Admin User List &middot; <?php echo WEB_APP_NAME; ?></title>
    <?php require_once('../includes/layouts/header_admin.php');?>
  </head>

  <body>


    <!-- Part 1: Wrap all page content here -->
    <div id="wrap">

      <!-- Fixed navbar -->
      <?php $page = 'admin_user_list';?>
      <?php require_once('../includes/layouts/navbar_admin.php');?>
      
      <header class="jumbotron subhead">
		 <div class="container-fluid">
		   <h1>Admin User List</h1>
		 </div>
	  </header>

      <!-- Begin page content -->
        
        <!-- Start Content -->
        <div class="container-fluid">
        
        <div class="row-fluid">
	        <br />
	        <a href="admin_create_admin_user.php" class="btn btn-primary">Add New Admin User</a>
	        <br /><br />
        </div>
        
        <div class="row-fluid">
        <?php if (!empty($session->message)) {echo $session->message; echo "<br /><br />";} ?>
        
        <table class="table table-bordered table-hover">
	        <tr align="center">
	        <td>Full Name</td>
	        <td>User Name</td>
	        <td>Email Address</td>
	        <td>Admin Level</td>
	        <td>&nbsp;</td>
	        <td>&nbsp;</td>
	        </tr>
        	
        	<?php foreach($users as $user){ ?>
        		<tr align="center">
        		<td><?php echo $user->full_name(); ?></td>
        		<td><?php echo $user->username; ?></td>
        		<td><?php echo $user->email_address; ?></td>
        		<td><?php echo $user->admin_level($user->admin_level); ?></td>
        		<td><a href="admin_read_update_admin_user.php?adminid=<?php echo $user->id; ?>" class="btn btn-warning btn-block">Edit</a></td>
        		<td><a href="admin_delete_admin_user.php?adminid=<?php echo $user->id; ?>" class="btn btn-danger btn-block">Delete</a></td>        		
        		</tr>
        	<?php }?>
        	
        </table>
        
        </div>
        <!-- End Content -->
        
      </div>

      <div id="push"></div>
    </div>

    <?php require_once('../includes/layouts/footer_admin.php');?>

    <?php require_once('../includes/layouts/bootstrap_scripts_admin.php');?>

  </body>
</html>
