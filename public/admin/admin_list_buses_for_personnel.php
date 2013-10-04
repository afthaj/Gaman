<?php
require_once("../includes/initialize.php");

//init code
$photo_object = new Photograph();
$admin_user_object = new AdminUser();
$bus_personnel_object = new BusPersonnel();

$route_object = new BusRoute();
$bus_object = new Bus();
$bus_bus_personnel_object = new BusBusPersonnel();

//check login
if ($session->is_logged_in()){
	
	if ($session->object_type == 5){
		
		$session->message("The requested page is for use by Bus Personnel only. ");
		redirect_to("index.php");
		
	} else if ($session->object_type == 4) {
		//bus personnel
		
		$user = $bus_personnel_object->find_by_id($_SESSION['id']);
		$profile_picture = $photo_object->get_profile_picture($session->object_type, $user->id);
		
		if ($user->role == 1 || $user->role == 4 || $user->role == 5){
			//bus_personnel that is logged in is an owner (role is 1 (Owner), 4 (Owner + Driver) or 5 (Owner + Conductor))
			$buses = $bus_bus_personnel_object->get_buses_for_personnel($user->id);
		} else if ($user->role == 2 || $user->role == 3) {
			//bus_personnel that is logged in is not an owner
			
			$buses = $bus_bus_personnel_object->get_buses_for_personnel($user->id);
		}
		
	} else {
		//everyone else
		
		$session->message("Error! You do not have sufficient priviledges to view the requested page. ");
		redirect_to("index.php");
	}
	
} else {
	//not logged in... GTFO!
	
	$session->message("Error! You must login to view the requested page. ");
	redirect_to("login.php");
}

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Buses List &middot; <?php echo WEB_APP_NAME; ?></title>
    <?php require_once('../includes/layouts/header_admin.php');?>
  </head>

  <body>


    <!-- Part 1: Wrap all page content here -->
    <div id="wrap">

      <!-- Fixed navbar -->
      <?php require_once('../includes/layouts/navbar_admin.php');?>

      <!-- Begin page content -->
      
      <header class="jumbotron subhead">
        <div class="container-fluid">
          <h1>List of Buses</h1>
        </div>
      </header>
        
        <!-- Start Content -->
        <div class="container-fluid">
        
        <div class="row-fluid">
        
        <div class="span12">
        
        <section>
        
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
		        <td>Route Number</td>
		        <td>Registration Number</td>
		        <td>Name (Optional)</td>
		        <?php if ($user->role == 1 || $user->role == 4 || $user->role == 5){ ?>
		        <td>&nbsp;</td>
		        <?php } ?>
	        </tr>
        	
        	<?php foreach($buses as $bus){ ?>
        		<tr align="center">
	        		<td><a href="admin_read_update_route.php?routeid=<?php echo $route_object->find_by_id($bus_object->find_by_id($bus->bus_id)->route_id)->id; ?>" class="btn btn-info btn-bloc"><?php echo $route_object->find_by_id($bus_object->find_by_id($bus->bus_id)->route_id)->route_number; ?></a></td>
	        		<td><a href="admin_read_update_bus.php?busid=<?php echo $bus->bus_id; ?>" class="btn btn-warning btn-bloc"><?php echo $bus_object->find_by_id($bus->bus_id)->reg_number; ?></a></td>
	        		<td><?php if (!empty($bus_object->find_by_id($bus->bus_id)->name)) {echo $bus_object->find_by_id($bus->bus_id)->name;} ?></td>
	        		<?php if ($user->role == 1 || $user->role == 4 || $user->role == 5){ ?>
	        		<td><a href="admin_read_update_bus.php?busid=<?php echo $bus->bus_id; ?>" class="btn btn-warning btn-block"><i class="icon-edit icon-white"></i> Edit</a></td>
	        		<?php } ?>
        		</tr>
        	<?php } ?>
        	
        </table>
        
        </section>
        
        </div>
        
        </div>
        
        </div>
        <!-- End Content -->
        

      <div id="push"></div>
    </div>

    <?php require_once('../includes/layouts/footer_admin.php');?>

    <?php require_once('../includes/layouts/scripts_admin.php');?>

  </body>
</html>
