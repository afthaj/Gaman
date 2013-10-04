<?php
require_once("../includes/initialize.php");

//init code
$photo_object = new Photograph();
$admin_user_object = new AdminUser();

$users = $admin_user_object->find_all();

//check login
if ($session->is_logged_in()){
	
	if ($session->object_type == 5) {
		//admin user
	
		$user = $admin_user_object->find_by_id($_SESSION['id']);
		$profile_picture = $photo_object->get_profile_picture($session->object_type, $user->id);
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
	        <a href="admin_create_admin_user.php" class="btn btn-primary"><i class="icon-plus icon-white"></i> Add New Admin User</a>
	        <br /><br />
        </div>
        
        <div class="row-fluid">
        
        <?php 
        
        if(!empty($session->message)){
        	
        	echo '<div class="alert">';
        	echo '<button type="button" class="close" data-dismiss="alert">&times;</button>';
        	//echo '<p>';
        	echo $session->message;
        	//echo '</p>';
        	echo '</div>';
        }
        
        ?>
        
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
        		<td><a href="admin_read_update_admin_user.php?adminid=<?php echo $users[$i]->id; ?>" class="btn btn-warning btn-block"><i class="icon-edit icon-white"></i> Edit</a></td>
        		<td><a href="admin_delete_admin_user.php?adminid=<?php echo $user->id; ?>" class="btn btn-danger btn-block"><i class="icon-remove icon-white"></i> Delete</a></td>        		
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

    <?php require_once('../includes/layouts/footer_admin.php');?>

    <?php require_once('../includes/layouts/scripts_admin.php');?>

  </body>
</html>
