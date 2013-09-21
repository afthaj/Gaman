<?php
require_once("../includes/initialize.php");

//init code
$photo_object = new Photograph();
$commuter_object = new Commuter();
$route_object = new BusRoute();

$buses = Bus::find_all();

//check login
if ($session->is_logged_in()){

	if ($session->object_type == 6){
		//commuter
		
		$user = $commuter_object->find_by_id($_SESSION['id']);
		$profile_picture = $photo_object->get_profile_picture($session->object_type, $user->id);	
	}
}

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Buses List &middot; <?php echo WEB_APP_NAME; ?></title>
    <?php require_once('../includes/layouts/header.php');?>
  </head>

  <body>


    <!-- Part 1: Wrap all page content here -->
    <div id="wrap">

      <!-- Fixed navbar -->
      <?php require_once('../includes/layouts/navbar.php');?>

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
        
        <table class="table table-bordered table-hover">
	        <tr align="center">
		        <td>Route Number</td>
		        <td>Registration Number</td>
		        <td>Name (Optional)</td>
		        <td>&nbsp;</td>
	        </tr>
        	
        	<?php foreach($buses as $bus){ ?>
        		<tr align="center">
	        		<td><?php echo $route_object->find_by_id($bus->route_id)->route_number; ?></td>
	        		<td><?php echo $bus->reg_number; ?></td>
	        		<td><?php if (!empty($bus->name)) {echo $bus->name;} ?></td>
	        		<td><a href="public_read_bus.php?busid=<?php echo $bus->id; ?>" class="btn btn-warning btn-block"><i class="icon-info-sign icon-white"></i> View Details</a></td>
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

    <?php require_once('../includes/layouts/footer.php');?>

    <?php require_once('../includes/layouts/scripts.php');?>

  </body>
</html>
