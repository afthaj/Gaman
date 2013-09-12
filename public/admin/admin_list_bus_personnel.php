<?php
require_once("../../includes/initialize.php");

if ($session->is_logged_in() && $session->object_type == 5){
	
	$user = AdminUser::find_by_id($_SESSION['id']);
	$p = new Photograph();
	$profile_picture = $p->get_profile_picture($session->object_type, $user->id);
	
} else if ($session->is_logged_in() && $session->object_type == 4){
	
	$user = BusPersonnel::find_by_id($_SESSION['id']);
	$p = new Photograph();
	$profile_picture = $p->get_profile_picture($session->object_type, $user->id);
	
} else {
	redirect_to("login.php");
}

$bus_personnel = BusPersonnel::find_all();

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Buses List &middot; <?php echo WEB_APP_NAME; ?></title>
    <?php require_once('../../includes/layouts/header_admin.php');?>
  </head>

  <body>


    <!-- Part 1: Wrap all page content here -->
    <div id="wrap">

      <!-- Fixed navbar -->
      <?php $page = 'admin_buses_list';?>
      <?php require_once('../../includes/layouts/navbar_admin.php');?>

      <!-- Begin page content -->
      
      <header class="jumbotron subhead">
        <div class="container-fluid">
          <h1>List of Bus Personnel</h1>
        </div>
      </header>
        
        <!-- Start Content -->
        <div class="container-fluid">
        
        <?php if ($session->is_logged_in() && $session->object_type == 5){ ?>
        <div class="row-fluid">
        	<br />
	        <a href="admin_create_bus_personnel.php" class="btn btn-primary">Add New Bus Personnel</a>
	        <br />
        </div>
        <?php } ?>
        
        <div class="row-fluid">
        
        <div class="span12">
        
        <section>
        
        <?php if (!empty($session->message)) {echo $session->message; echo "<br /><br />";} ?>
        
        <table class="table table-bordered table-hover">
	        <tr align="center">
	        	<td>Profile Picture</td>
		        <td>First Name</td>
		        <td>Last Name</td>
		        <td>Role</td>
		        <td>Username</td>
		        <td>NIC Number</td>
		        <?php if ($session->is_logged_in() && $session->object_type == 5) { ?>
		        <td>&nbsp;</td>
		        <td>&nbsp;</td>
		        <?php } ?>
	        </tr>
        	
        	<?php for($i = 0; $i < count($bus_personnel) ; $i++){ 
        	
        		if ($bus_personnel[$i]->id != $user->id) { ?>
        		
        		<tr align="center">
        			<td>
        			<?php 
        		
	        		$bus_personnel_role = new BusPersonnelRole();
	        		
	        		$pic = new Photograph();
	        		
	        		$bus_personnel_profile_picture = $pic->get_profile_picture('4', $bus_personnel[$i]->id);
	        		
	        		if (!empty($bus_personnel_profile_picture->filename)) {
	        			echo '<img src="../../' . $bus_personnel_profile_picture->image_path() . '" width="100" class="img-rounded" />';
	        		} else {
	        			echo '<img src="../img/default-prof-pic.jpg" width="100" class="img-rounded" alt="Please upload a profile picture" />';
	        		}
	        		
	        		?>
        			</td>
	        		<td><?php echo $bus_personnel[$i]->first_name; ?></td>
	        		<td><?php echo $bus_personnel[$i]->last_name; ?></td>
	        		<td><?php echo $bus_personnel_role->find_by_id($bus_personnel[$i]->role)->role_name; ?></td>
	        		<td><?php echo $bus_personnel[$i]->username; ?></td>
	        		<td><?php echo $bus_personnel[$i]->nic_number; ?></td>
	        		<?php if ($session->is_logged_in() && $session->object_type == 5) { ?>
	        		<td><a href="admin_read_update_bus_personnel.php?personnelid=<?php echo $bus_personnel[$i]->id; ?>" class="btn btn-warning btn-block">Edit</a></td>
	        		<td><a href="admin_delete_bus_personnel.php?personnelid=<?php echo $bus_personnel[$i]->id; ?>" class="btn btn-danger btn-block">Delete</a></td>
	        		<?php } ?>        		
        		</tr>
        		
        	<?php } }?>
        	
        </table>
        
        </section>
        
        </div>
        
        </div>
        
        </div>
        <!-- End Content -->
        

      <div id="push"></div>
    </div>

    <?php require_once('../../includes/layouts/footer_admin.php');?>

    <?php require_once('../../includes/layouts/scripts_admin.php');?>

  </body>
</html>
