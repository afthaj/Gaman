<?php
require_once("../includes/initialize.php");

if ($session->is_logged_in() && $session->object_type == 6) {
	
	$user = Commuter::find_by_id($_SESSION['id']);
	$p = new Photograph();
	$profile_picture = $p->get_profile_picture($user->id, "commuter");
	
} else if ($session->is_logged_in() && $session->object_type != 6) {
	
	//redirect_to("login.php");
	
}

$stops = BusStop::find_all();

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Stops List &middot; <?php echo WEB_APP_NAME; ?></title>
    <?php require_once('../includes/layouts/header.php');?>
  </head>

  <body>


    <!-- Part 1: Wrap all page content here -->
    <div id="wrap">

      <!-- Fixed navbar -->
      <?php require_once('../includes/layouts/navbar.php');?>
      
      <header class="jumbotron subhead">
		 <div class="container-fluid">
		   <h1>List of Bus Stops</h1>
		 </div>
	  </header>

      <!-- Begin page content -->

      <!-- Start Content -->
      
      <div class="container-fluid">
      
      <div class="row-fluid">
      
      <div class="span12">
      
      <section>
      
      <table class="table table-bordered table-hover">  
      
      <?php if (!empty($session->message)) {echo $session->message; echo "<br /><br />";} ?>
      
      <tr>
	   <td rowspan="2" align="center">Stop Name</td>
	   <td colspan="2" align="center">Coordinates</td>
	   <td rowspan="2">&nbsp;</td>
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
      	<td><a href="public_read_stop.php?stopid=<?php echo $stop->id; ?>" class="btn btn-warning btn-block">View Details</a></td>
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

    <?php require_once('../includes/layouts/footer.php');?>

    <?php require_once('../includes/layouts/scripts.php');?>

  </body>
</html>
