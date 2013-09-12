<?php
require_once("../../includes/initialize.php");

if ($session->is_logged_in() && $session->object_type == 5){
	
	$user = AdminUser::find_by_id($_SESSION['id']);
	$p = new Photograph();
	$profile_picture = $p->get_profile_picture($session->object_type, $user->id);
	
	$c = new Complaint();
	$complaints = $c->find_all();
	
} else if ($session->is_logged_in() && $session->object_type == 4){
	
	$user = BusPersonnel::find_by_id($_SESSION['id']);
	$p = new Photograph();
	$profile_picture = $p->get_profile_picture($session->object_type, $user->id);
	
	$c = new Complaint();
	$complaints = $c->get_complaints_for_user($user->id, $session->object_type);
	
} else {
	redirect_to("login.php");
}

$comp_type = new ComplaintType();
$comp_status = new ComplaintStatus();
$obj = new ObjectType();
$route = new BusRoute();
$stop = new BusStop();
$bus = new Bus();
$bp = new BusPersonnel();

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Complaints List &middot; <?php echo WEB_APP_NAME; ?></title>
    <?php require_once('../../includes/layouts/header_admin.php');?>
  </head>

  <body>


    <!-- Part 1: Wrap all page content here -->
    <div id="wrap">

      <!-- Fixed navbar -->
      <?php $page = 'list_complaints';?>
      <?php require_once('../../includes/layouts/navbar_admin.php');?>
      
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
	        <a href="admin_create_complaint.php" class="btn btn-primary">Add New Complaint</a>
	        <br/> <br />
        </div>
        
        <div class="row-fluid">
        <?php if (!empty($session->message)) {echo $session->message; echo "<br /><br />";} ?>
        
        <table class="table table-bordered table-hover">
          <thead>
	        <tr align="center">
		        <td>Complaint Type</td>
		        <td>Related To</td>
		        <td>Identfier</td>
		        <td>Complaint Details</td>
		        <td>Complaint Status</td>
		        <?php if ($session->is_logged_in() && $session->object_type == 5) { ?>
		        <td>&nbsp;</td>
		        <td>&nbsp;</td>
		        <?php } ?>
	        </tr>
	      </thead>
	      <tbody>
        	
        	<?php foreach($complaints as $complaint){ ?>
        		<tr align="center">
	        		<td><?php echo $comp_type->find_by_id($complaint->complaint_type)->comp_type_name; ?></td>
			        <td><?php echo $obj->find_by_id($complaint->related_object_type)->display_name; ?></td>
			        <td>
			        <?php 
					switch ($complaint->related_object_type) {
					    case 1:
					        echo $route->find_by_id($complaint->related_object_id)->route_number;
					        break;
					    case 2:
					        echo $stop->find_by_id($complaint->related_object_id)->name;
					        break;
					    case 3:
					        echo $bus->find_by_id($complaint->related_object_id)->reg_number;
					        break;
				        case 4:
				        	echo $bp->find_by_id($complaint->related_object_id)->fullname();
				        	break;
					}
			        ?>
			        </td>
			        <td><?php echo $complaint->content; ?></td>
			        <td><span class="btn btn-block
			        <?php
			        
			        if ($comp_status->find_by_id($complaint->status)->id == 1){
			        	echo ' btn-info';
			        } else if ($comp_status->find_by_id($complaint->status)->id == 2){
			        	echo ' btn-warning';
			        } else if ($comp_status->find_by_id($complaint->status)->id == 3){
			        	echo ' btn-success';
			        }
			        
			        ?>
			        "><?php echo $comp_status->find_by_id($complaint->status)->comp_status_name; ?></span></td>
			        <?php if ($session->is_logged_in() && $session->object_type == 5) { ?>
	        		<td><a href="admin_read_update_complaint.php?complaintid=<?php echo $complaint->id; ?>" class="btn btn-warning btn-block">Edit</a></td>
	        		<td><a href="admin_delete_complaint.php?complaintid=<?php echo $complaint->id; ?>" class="btn btn-danger btn-block">Delete</a></td>
	        		<?php } ?>        		
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

    <?php require_once('../../includes/layouts/footer_admin.php');?>

    <?php require_once('../../includes/layouts/scripts_admin.php');?>

  </body>
</html>
