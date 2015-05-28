<?php
require_once("../../includes/initialize.php");

//init code
$photo_object = new Photograph();
$admin_user_object = new AdminUser();
$bus_personnel_object = new BusPersonnel();

$feedback_item_object = new FeedbackItem();
$complaint_object = new Complaint();

$feedback_items = 

$fromtime1 = strtotime("-1 day");
$fromtime2 = strtotime("-3 day");
$fromtime3 = strtotime("-1 week");
$totime = time();

$feedback_items1 = $feedback_item_object->get_feedback_items_within_time($fromtime1, $totime);
$feedback_items2 = $feedback_item_object->get_feedback_items_within_time($fromtime2, $totime);
$feedback_items3 = $feedback_item_object->get_feedback_items_within_time($fromtime3, $totime);

$complaints1 = $complaint_object->get_complaints_within_time($fromtime1, $totime);
$complaints2 = $complaint_object->get_complaints_within_time($fromtime2, $totime);
$complaints3 = $complaint_object->get_complaints_within_time($fromtime3, $totime);

if ($session->is_logged_in()){
	// object_type = 5 is admin, 4 is bus_personnel, 6 is commuter
	
	if ($_SESSION['object_type'] == 5 ){
		//admin user
		 
		$user = $admin_user_object->find_by_id($_SESSION['id']);
		$profile_picture = $photo_object->get_profile_picture($session->object_type, $user->id);
	
	} else if ($_SESSION['object_type'] == 4 ){
		//bus_personnel
	
		$user = $bus_personnel_object->find_by_id($_SESSION['id']);
		$profile_picture = $photo_object->get_profile_picture($session->object_type, $user->id);
	
	} else {
		//everybody else
		
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
    <title>Admin Home &middot; <?php echo WEB_APP_NAME; ?></title>
    <?php require_once('../../includes/layouts/header_admin.php');?>
    
  </head>

  <body>
  
    <!-- Part 1: Wrap all page content here -->
    <div id="wrap">

      <!-- Fixed navbar -->
      <?php $page = 'index';?>
      <?php require_once('../../includes/layouts/navbar_admin.php');?>

      	<div class="jumbotron masthead">
		  <div class="container">
		    <h1><?php echo WEB_APP_NAME; ?></h1>
		    <p><?php echo WEB_APP_CATCH_PHRASE; ?></p>
		  </div>
		</div>
      
      <!-- Begin page content -->      
      <div class="container">

        <!-- Start Content -->
        
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
        
        <div class="marketing">
        
        <div class="row-fluid">
        
        <?php if ($session->object_type == 5) { //admin_user ?>
        <div class="span6">
	        <h2>Feedback</h2>
	        <div class="well">
	        	<table class="table table-bordered table-hover">
		        	
		        	<tbody>
		        		<tr>
		        			<td colspan="3"><h3>For all Entities</h3></td>
		        		</tr>
		        		<tr>
		        			<td align="right">Past 24 hours</td>
		        			<td align="center"><span class="badge badge-success"><?php echo count($feedback_items1); ?></span></td>
		        			<td align="center"><a href="admin_list_feedback_items.php?t=1" class="btn btn-success">View</a></td>
		        		</tr>
		        		<tr>
		        			<td align="right">Past 3 days</td>
		        			<td align="center"><span class="badge badge-success"><?php echo count($feedback_items2); ?></span></td>
		        			<td align="center"><a href="admin_list_feedback_items.php?t=2" class="btn btn-success">View</a></td>
		        		</tr>
		        		<tr>
		        			<td align="right">Past week</td>
		        			<td align="center"><span class="badge badge-success"><?php echo count($feedback_items3); ?></span></td>
		        			<td align="center"><a href="admin_list_feedback_items.php?t=3" class="btn btn-success">View</a></td>
		        		</tr>
		        		<tr>
		        			<td colspan="3"><h3>Bus Routes</h3></td>
		        		</tr>
		        		<tr>
		        			<td align="right">Past 24 hours</td>
		        			<td align="center"><span class="badge badge-success"><?php echo count($feedback_items1); ?></span></td>
		        			<td align="center"><a href="admin_list_feedback_items.php?t=1" class="btn btn-success">View</a></td>
		        		</tr>
		        		<tr>
		        			<td align="right">Past 3 days</td>
		        			<td align="center"><span class="badge badge-success"><?php echo count($feedback_items2); ?></span></td>
		        			<td align="center"><a href="admin_list_feedback_items.php?t=2" class="btn btn-success">View</a></td>
		        		</tr>
		        		<tr>
		        			<td align="right">Past week</td>
		        			<td align="center"><span class="badge badge-success"><?php echo count($feedback_items3); ?></span></td>
		        			<td align="center"><a href="admin_list_feedback_items.php?t=3" class="btn btn-success">View</a></td>
		        		</tr>
		        		<tr>
		        			<td colspan="3"><h3>Bus Stops</h3></td>
		        		</tr>
		        		<tr>
		        			<td align="right">Past 24 hours</td>
		        			<td align="center"><span class="badge badge-success"><?php echo count($feedback_items1); ?></span></td>
		        			<td align="center"><a href="admin_list_feedback_items.php?t=1" class="btn btn-success">View</a></td>
		        		</tr>
		        		<tr>
		        			<td align="right">Past 3 days</td>
		        			<td align="center"><span class="badge badge-success"><?php echo count($feedback_items2); ?></span></td>
		        			<td align="center"><a href="admin_list_feedback_items.php?t=2" class="btn btn-success">View</a></td>
		        		</tr>
		        		<tr>
		        			<td align="right">Past week</td>
		        			<td align="center"><span class="badge badge-success"><?php echo count($feedback_items3); ?></span></td>
		        			<td align="center"><a href="admin_list_feedback_items.php?t=3" class="btn btn-success">View</a></td>
		        		</tr>
		        		<tr>
		        			<td colspan="3"><h3>Buses</h3></td>
		        		</tr>
		        		<tr>
		        			<td align="right">Past 24 hours</td>
		        			<td align="center"><span class="badge badge-success"><?php echo count($feedback_items1); ?></span></td>
		        			<td align="center"><a href="admin_list_feedback_items.php?t=1" class="btn btn-success">View</a></td>
		        		</tr>
		        		<tr>
		        			<td align="right">Past 3 days</td>
		        			<td align="center"><span class="badge badge-success"><?php echo count($feedback_items2); ?></span></td>
		        			<td align="center"><a href="admin_list_feedback_items.php?t=2" class="btn btn-success">View</a></td>
		        		</tr>
		        		<tr>
		        			<td align="right">Past week</td>
		        			<td align="center"><span class="badge badge-success"><?php echo count($feedback_items3); ?></span></td>
		        			<td align="center"><a href="admin_list_feedback_items.php?t=3" class="btn btn-success">View</a></td>
		        		</tr>
		        	</tbody>
	        	
	        	</table>
	        </div>
        </div>
        
        <div class="span6">
	        <h2>Complaints</h2>
	        <div class="well">
		        <table class="table table-bordered table-hover">
			        	
			        	<tbody>
				        	<tr>
			        			<td colspan="3"><h3>For all Entities</h3></td>
			        		</tr>
			        		<tr>
			        			<td align="right">Past 24 hours</td>
			        			<td align="center"><span class="badge badge-important"><?php echo count($complaints1); ?></span></td>
			        			<td align="center"><a href="admin_list_complaints.php?t=1" class="btn btn-danger">View</a></td>
			        		</tr>
			        		<tr>
			        			<td align="right">Past 3 days</td>
			        			<td align="center"><span class="badge badge-important"><?php echo count($complaints2); ?></span></td>
			        			<td align="center"><a href="admin_list_complaints.php?t=2" class="btn btn-danger">View</a></td>
			        		</tr>
			        		<tr>
			        			<td align="right">Past week</td>
			        			<td align="center"><span class="badge badge-important"><?php echo count($complaints3); ?></span></td>
			        			<td align="center"><a href="admin_list_complaints.php?t=3" class="btn btn-danger">View</a></td>
			        		</tr>
			        		<tr>
			        			<td colspan="3"><h3>Bus Routes</h3></td>
			        		</tr>
			        		<tr>
			        			<td align="right">Past 24 hours</td>
			        			<td align="center"><span class="badge badge-important"><?php echo count($complaints1); ?></span></td>
			        			<td align="center"><a href="admin_list_complaints.php?t=1" class="btn btn-danger">View</a></td>
			        		</tr>
			        		<tr>
			        			<td align="right">Past 3 days</td>
			        			<td align="center"><span class="badge badge-important"><?php echo count($complaints2); ?></span></td>
			        			<td align="center"><a href="admin_list_complaints.php?t=2" class="btn btn-danger">View</a></td>
			        		</tr>
			        		<tr>
			        			<td align="right">Past week</td>
			        			<td align="center"><span class="badge badge-important"><?php echo count($complaints3); ?></span></td>
			        			<td align="center"><a href="admin_list_complaints.php?t=3" class="btn btn-danger">View</a></td>
			        		</tr>
			        		<tr>
			        			<td colspan="3"><h3>Bus Stops</h3></td>
			        		</tr>
			        		<tr>
			        			<td align="right">Past 24 hours</td>
			        			<td align="center"><span class="badge badge-important"><?php echo count($complaints1); ?></span></td>
			        			<td align="center"><a href="admin_list_complaints.php?t=1" class="btn btn-danger">View</a></td>
			        		</tr>
			        		<tr>
			        			<td align="right">Past 3 days</td>
			        			<td align="center"><span class="badge badge-important"><?php echo count($complaints2); ?></span></td>
			        			<td align="center"><a href="admin_list_complaints.php?t=2" class="btn btn-danger">View</a></td>
			        		</tr>
			        		<tr>
			        			<td align="right">Past week</td>
			        			<td align="center"><span class="badge badge-important"><?php echo count($complaints3); ?></span></td>
			        			<td align="center"><a href="admin_list_complaints.php?t=3" class="btn btn-danger">View</a></td>
			        		</tr>
			        		<tr>
			        			<td colspan="3"><h3>Buses</h3></td>
			        		</tr>
			        		<tr>
			        			<td align="right">Past 24 hours</td>
			        			<td align="center"><span class="badge badge-important"><?php echo count($complaints1); ?></span></td>
			        			<td align="center"><a href="admin_list_complaints.php?t=1" class="btn btn-danger">View</a></td>
			        		</tr>
			        		<tr>
			        			<td align="right">Past 3 days</td>
			        			<td align="center"><span class="badge badge-important"><?php echo count($complaints2); ?></span></td>
			        			<td align="center"><a href="admin_list_complaints.php?t=2" class="btn btn-danger">View</a></td>
			        		</tr>
			        		<tr>
			        			<td align="right">Past week</td>
			        			<td align="center"><span class="badge badge-important"><?php echo count($complaints3); ?></span></td>
			        			<td align="center"><a href="admin_list_complaints.php?t=3" class="btn btn-danger">View</a></td>
			        		</tr>
			        	</tbody>
		        	
		        	</table>
	        </div>
        </div>
        <?php } else if ($session->object_type == 4) { //bus_personnel ?>
        
        
        
        <?php } ?>
        
        
        </div>
        
        </div>
        <!-- End Content -->
        
      </div>

      <div id="push"></div>
    </div>

    <?php require_once('../../includes/layouts/footer_admin.php');?>

    <?php require_once('../../includes/layouts/scripts_admin.php');?>

  </body>
</html>
