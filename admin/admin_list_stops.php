<?php
require_once("../includes/initialize.php");

if (!$session->is_logged_in()){
	redirect_to("login.php");
} else {
	$admin_user = Admin::find_by_id($_SESSION['id']);
	
	$stops = BusStop::find_all();
	
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Stops List &middot; <?php echo WEB_APP_NAME; ?></title>
    <?php require_once('../includes/layouts/header_admin.php');?>
  </head>

  <body>


    <!-- Part 1: Wrap all page content here -->
    <div id="wrap">

      <!-- Fixed navbar -->
      <?php $page = admin_stops_list;?>
      <?php require_once('../includes/layouts/navbar_admin.php');?>
      
      <header class="jumbotron subhead">
		 <div class="container-fluid">
		   <h1>List of Bus Stops</h1>
		 </div>
	  </header>

      <!-- Begin page content -->

      <!-- Start Content -->
      
      <div class="container-fluid">
      
      <div class="row-fluid">
      
      <div class="span3">
      	<div class="sidenav" data-spy="affix" data-offset-top="200">
      		<a href="admin_create_stop.php" class="btn btn-primary">Add New Bus Stop</a>
      	</div>
      </div>
      
      <div class="span9">
      
      <section>
      
      <table class="table table-bordered table-hover">  
      
      <?php if (!empty($session->message)) {echo $session->message; echo "<br /><br />";} ?>
      
      <tr align="center">
	   <td>Stop Name</td>
	   <td>&nbsp;</td>
	   <td>&nbsp;</td>
      </tr>
       
      <?php foreach($stops as $stop){ ?>
      <tr>
	  	<td align="left"><?php echo $stop->name; ?></td>
      	<td><a href="admin_read_update_stop.php?stopid=<?php echo $stop->id; ?>" class="btn btn-warning btn-block">Edit</a></td>
	  	<td><a href="admin_delete_stop.php?stopid=<?php echo $stop->id; ?>" class="btn btn-danger btn-block">Delete</a></td>        		
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

    <?php require_once('../includes/layouts/footer_admin.php');?>

    <?php require_once('../includes/layouts/bootstrap_scripts_admin.php');?>

  </body>
</html>
