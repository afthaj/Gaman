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

$stops = BusStop::find_all();

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Stops List &middot; <?php echo WEB_APP_NAME; ?></title>
    <?php require_once('../../includes/layouts/header_admin.php');?>
  </head>

  <body>


    <!-- Part 1: Wrap all page content here -->
    <div id="wrap">

      <!-- Fixed navbar -->
      <?php $page = 'admin_stops_list';?>
      <?php require_once('../../includes/layouts/navbar_admin.php');?>
      
      <header class="jumbotron subhead">
		 <div class="container-fluid">
		   <h1>List of Bus Stops</h1>
		 </div>
	  </header>

      <!-- Begin page content -->

      <!-- Start Content -->
      
      <div class="container-fluid">
      
      <div class="row-fluid">
      
      <?php if ($session->is_logged_in() && $session->object_type == 5) { ?>
      <div class="span3">
      	<div class="sidenav" data-spy="affix" data-offset-top="200">
      		<a href="admin_create_stop.php" class="btn btn-primary">Add New Bus Stop</a>
      	</div>
      </div>
      <?php } else { ?>
      <div class="span3">
      	<div class="sidenav" data-spy="affix" data-offset-top="200">
      		<a href="index.php" class="btn btn-primary">&larr; Back to Home</a>
      	</div>
      </div>
      <?php } ?>
      <div class="span9">
      
      <section>
      
      <table class="table table-bordered table-hover">  
      
      <?php if (!empty($session->message)) {echo $session->message; echo "<br /><br />";} ?>
      
      <tr>
	   <td rowspan="2" align="center">Stop Name</td>
	   <td colspan="2" align="center">Coordinates</td>
	   <td rowspan="2">&nbsp;</td>
	   <?php if ($session->is_logged_in() && $session->object_type == 5) { ?>
	   <td rowspan="2">&nbsp;</td>
	   <?php } ?>
      </tr>
      
      <tr align="center">
      	<td>Latitude</td>
      	<td>Longitude</td>
      </tr>
       
      <?php foreach($stops as $stop){ ?>
      <tr>
	  	<td align="left"><?php echo $stop->name; ?></td>
	  	<td align="center"><?php echo $stop->location_latitude; ?></td>
	  	<td align="center"><?php echo $stop->location_longitude; ?></td>
      	<td><a href="admin_read_update_stop.php?stopid=<?php echo $stop->id; ?>" class="btn btn-warning btn-block">Details</a></td>
	  	<?php if ($session->is_logged_in() && $session->object_type == 5) { ?>
	  	<td><a href="admin_delete_stop.php?stopid=<?php echo $stop->id; ?>" class="btn btn-danger btn-block">Delete</a></td>
	  	<?php } ?>        		
      </tr>
      <?php }?>
      </table>
      
      </section>
       
      </div>
      
      </div>
      
      </div>
        
        <!-- End Content -->
        
        <div class="clearfix">&nbsp;</div>

      <div id="push"></div>
    </div>

    <?php require_once('../../includes/layouts/footer_admin.php');?>

    <?php require_once('../../includes/layouts/scripts_admin.php');?>

  </body>
</html>
