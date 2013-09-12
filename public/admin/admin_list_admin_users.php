<?php
require_once("../../includes/initialize.php");

if ($session->is_logged_in() && $session->object_type == 5) {
	
	$user = AdminUser::find_by_id($_SESSION['id']);
	$p = new Photograph();
	$profile_picture = $p->get_profile_picture($session->object_type, $user->id);
	
	$users = AdminUser::find_all();

} else {
	redirect_to("login.php");
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Admin User List &middot; <?php echo WEB_APP_NAME; ?></title>
    <?php require_once('../../includes/layouts/header_admin.php');?>
  </head>

  <body>


    <!-- Part 1: Wrap all page content here -->
    <div id="wrap">

      <!-- Fixed navbar -->
      <?php $page = 'admin_user_list';?>
      <?php require_once('../../includes/layouts/navbar_admin.php');?>
      
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
	        <td>Profile Picture</td>
	        <td>Full Name</td>
	        <td>User Name</td>
	        <td>Email Address</td>
	        <td>Admin Level</td>
	        <td>&nbsp;</td>
	        <td>&nbsp;</td>
	        </tr>
        	
        	<?php for ($i = 0; $i < count($users); $i++ ){ 
        	
        		if ($users[$i]->id != $user->id){ ?>
        	
        		<tr align="center">
        		<td>
        		<?php 
        		
        		$admin_level = new AdminLevel();
        		
        		$pic = new Photograph();
        		
        		$user_profile_picture = $pic->get_profile_picture('5', $users[$i]->id);
        		
        		if (!empty($user_profile_picture->filename)) {
        			echo '<img src="../../' . $user_profile_picture->image_path() . '" width="100" class="img-rounded" />';
        		} else {
        			echo '<img src="../img/default-prof-pic.jpg" width="100" class="img-rounded" alt="Please upload a profile picture" />';
        		}
        		
        		?>
        		</td>
        		<td><?php echo $users[$i]->full_name(); ?></td>
        		<td><?php echo $users[$i]->username; ?></td>
        		<td><?php echo $users[$i]->email_address; ?></td>
        		<td><?php echo $admin_level->get_admin_level($users[$i]->admin_level)->admin_level_name; ?></td>
        		<td><a href="admin_read_update_admin_user.php?adminid=<?php echo $users[$i]->id; ?>" class="btn btn-warning btn-block">Edit</a></td>
        		<td><a href="admin_delete_admin_user.php?adminid=<?php echo $user->id; ?>" class="btn btn-danger btn-block">Delete</a></td>        		
        		</tr>
        		
        	<?php 
        		} 
        	}
        	?>
        	
        </table>
        
        </div>
        <!-- End Content -->
        
      </div>

      <div id="push"></div>
    </div>

    <?php require_once('../../includes/layouts/footer_admin.php');?>

    <?php require_once('../../includes/layouts/scripts_admin.php');?>

  </body>
</html>
