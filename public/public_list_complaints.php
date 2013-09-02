<?php
require_once("../includes/initialize.php");

if ($session->is_logged_in() && $session->object_type == 6) {
	
	$user = Commuter::find_by_id($_SESSION['id']);
	$p = new Photograph();
	$profile_picture = $p->get_profile_picture($user->id, "commuter");
	
	$c = new Complaint();
	$complaints = $c->find_all();
	
} else if ($session->is_logged_in() && $session->object_type != 6) {
	
	redirect_to("login.php");
	
} else if (!$session->is_logged_in() && $session->object_type != 6) {
	
	redirect_to("login.php");
	
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Complaints List &middot; <?php echo WEB_APP_NAME; ?></title>
    <?php require_once('../includes/layouts/header.php');?>
  </head>

  <body>


    <!-- Part 1: Wrap all page content here -->
    <div id="wrap">

      <!-- Fixed navbar -->
      <?php $page = 'list_complaints';?>
      <?php require_once('../includes/layouts/navbar.php');?>
      
      <header class="jumbotron subhead">
		 <div class="container-fluid">
		   <h1>List of Complaints</h1>
		 </div>
	  </header>

      <!-- Begin page content -->
        
      <!-- Start Content -->
      
      <div class="container-fluid">
      	
      	<div class="row-fluid">
	        <br />
	        <a href="public_create_complaint.php" class="btn btn-primary">Add New Complaint</a>
	        <br/> <br />
        </div>
        
        <div class="row-fluid">
        <?php if (!empty($session->message)) {echo $session->message; echo "<br /><br />";} ?>
        
        <table class="table table-bordered table-hover">
          <thead>
	        <tr align="center">
		        <td>Complaint Type</td>
		        <td>Bus Route</td>
		        <td>Bus Stop</td>
		        <td>Bus Registration Number</td>
		        <td>Name of Bus Personnel</td>
		        <td>Complaint Status</td>
		        <td>Complaint Details</td>
		        <td>&nbsp;</td>
		        <td>&nbsp;</td>
	        </tr>
	      </thead>
	      <tbody>
        	
        	<?php foreach($complaints as $complaint){ ?>
        		<tr align="center">
	        		<td>Complaint Type</td>
			        <td>Bus Route</td>
			        <td>Bus Stop</td>
			        <td>Bus Registration Number</td>
			        <td>Name of Bus Personnel</td>
			        <td>Complaint Status</td>
			        <td>Complaint Details</td>
	        		<td><a href="public_read_update_complaint.php?complaintid=<?php echo $complaint->id; ?>" class="btn btn-warning btn-block">Edit</a></td>
	        		<td><a href="public_delete_complaint.php?complaintid=<?php echo $complaint->id; ?>" class="btn btn-danger btn-block">Delete</a></td>        		
        		</tr>
        	<?php }?>
        	
          </tbody>
        </table>
        
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
