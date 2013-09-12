<?php
require_once("../../includes/initialize.php");

if ($session->is_logged_in() && $session->object_type == 5){
	
	$user = AdminUser::find_by_id($_SESSION['id']);
	$p = new Photograph();
	$profile_picture = $p->get_profile_picture($session->object_type, $user->id);
	
} else if ($session->is_logged_in() && $session->object_type == 4) {
	
	$user = BusPersonnel::find_by_id($_SESSION['id']);
	$p = new Photograph();
	$profile_picture = $p->get_profile_picture($session->object_type, $user->id);
	
} else {
	redirect_to("login.php");
}

$buses = Bus::find_all();

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
      <?php require_once('../../includes/layouts/navbar_admin.php');?>

      <!-- Begin page content -->
      
      <header class="jumbotron subhead">
        <div class="container-fluid">
          <h1>List of Buses</h1>
        </div>
      </header>
        
        <!-- Start Content -->
        <div class="container-fluid">
        
        <?php if ($session->is_logged_in() && $session->object_type == 5) { ?>
        <div class="row-fluid">
        	<br />
	        <a href="admin_create_bus.php" class="btn btn-primary">Add New Bus</a>
	        <br />
        </div>
        <?php } ?>
        
        <div class="row-fluid">
        
        <div class="span12">
        
        <section>
        
        <?php if (!empty($session->message)) {echo $session->message; echo "<br /><br />";} ?>
        
        <table class="table table-bordered table-hover">
	        <tr align="center">
		        <td>Route Number</td>
		        <td>Registration Number</td>
		        <td>Name (Optional)</td>
		        <td>&nbsp;</td>
		        <td>&nbsp;</td>
	        </tr>
        	
        	<?php foreach($buses as $bus){ ?>
        		<tr align="center">
	        		<td><?php echo BusRoute::find_by_id($bus->route_id)->route_number; ?></td>
	        		<td><?php echo $bus->reg_number; ?></td>
	        		<td><?php if (!empty($bus->name)) {echo $bus->name;} ?></td>
	        		<td><a href="admin_read_update_bus.php?busid=<?php echo $bus->id; ?>" class="btn btn-warning btn-block">Edit</a></td>
	        		<td><a href="admin_delete_bus.php?busid=<?php echo $bus->id; ?>" class="btn btn-danger btn-block">Delete</a></td>        		
        		</tr>
        	<?php }?>
        	
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
