<?php
require_once("../includes/initialize.php");

//init code
$photo_object = new Photograph();
$commuter_object = new Commuter();

$route_object = new BusRoute();
$stop_object = new BusStop();
$bus_object = new Bus();
$bus_personnel_object = new BusPersonnel();

$object_type_object = new ObjectType();

$complaint_object = new Complaint();
$complaint_type_object = new ComplaintType();
$complaint_status_object = new ComplaintStatus();

//check login
if ($session->is_logged_in()){
	
	if ($session->object_type == 6) {
		//commuter
	
		$user = $commuter_object->find_by_id($_SESSION['id']);
		$profile_picture = $photo_object->get_profile_picture($session->object_type, $user->id);
		
		$complaints = $complaint_object->get_complaints_for_user($user->id, $session->object_type);
	
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
	        <a href="public_create_complaint.php" class="btn btn-primary"><i class="icon-plus icon-white"></i> Add New Complaint</a>
	        <br/> <br />
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
	        
	        if ($complaints) {
	        
		?>
        
        <table class="table table-bordered table-hover">
          <thead>
	        <tr align="center">
		        <td>Complaint Type</td>
		        <td>Related To</td>
		        <td>Identifier</td>
		        <td>Date Submitted</td>
		        <td>Time Submitted</td>
		        <td>Complaint Details</td>
		        <td>Complaint Status</td>
		        <td>&nbsp;</td>
	        </tr>
	      </thead>
	      <tbody>
        	
        	<?php foreach($complaints as $complaint){ ?>
        		<tr align="center">
	        		<td><?php echo $complaint_type_object->find_by_id($complaint->complaint_type)->comp_type_name; ?></td>
			        <td><?php echo $object_type_object->find_by_id($complaint->related_object_type)->display_name; ?></td>
			        <td>
			        <?php 
					switch ($complaint->related_object_type) {
					    case 1:
					        echo $route_object->find_by_id($complaint->related_object_id)->route_number;
					        break;
					    case 2:
					        echo $stop_object->find_by_id($complaint->related_object_id)->name;
					        break;
					    case 3:
					        echo $bus_object->find_by_id($complaint->related_object_id)->reg_number;
					        break;
				        case 4:
				        	echo $bus_personnel_object->find_by_id($complaint->related_object_id)->full_name();
				        	break;
					}
			        ?>
			        </td>
			        <td><?php echo date("d M Y", $complaint->date_time_submitted); ?></td>
			        <td><?php echo date("h:i:s a", $complaint->date_time_submitted); ?></td>
			        <td><?php echo $complaint->content; ?></td>
			        <td><span class="label 
			        <?php
			        
			        if ($complaint_status_object->find_by_id($complaint->status)->id == 1){
			        	echo ' label-info';
			        } else if ($complaint_status_object->find_by_id($complaint->status)->id == 2){
			        	echo ' label-warning';
			        } else if ($complaint_status_object->find_by_id($complaint->status)->id == 3){
			        	echo ' label-success';
			        }
			        
			        ?>
			        "><?php echo $complaint_status_object->find_by_id($complaint->status)->comp_status_name; ?></span></td>
	        		<td><a href="public_read_update_complaint.php?complaintid=<?php echo $complaint->id; ?>" class="btn btn-warning btn-block"><i class="icon-edit icon-white"></a></td>
        		</tr>
        	<?php }?>
        	
          </tbody>
        </table>
        
        <?php 
         
	        } else {
	        	echo '<h4>You have not submitted any complaints yet. </h4>';
	        }
        
        ?>
        
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
