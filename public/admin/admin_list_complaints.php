<?php
require_once("../../includes/initialize.php");

//init code
$admin_user_object = new AdminUser();
$bus_personnel_object = new BusPersonnel();
$photo_object = new Photograph();
$complaint_object = new Complaint();
$comp_type = new ComplaintType();
$comp_status = new ComplaintStatus();
$obj = new ObjectType();
$route = new BusRoute();
$stop = new BusStop();
$bus = new Bus();
$bp = new BusPersonnel();

//pagination code
$current_page = !empty($_GET['page']) ? (int)$_GET['page'] : 1;
$per_page = 20;
$total_count = $complaint_object->count_all();
$pagination = new Pagination($current_page, $per_page, $total_count);


//check user login
if ($session->is_logged_in()){
	
	if ($session->object_type == 5){
		//admin_user
	
		$user = $admin_user_object->find_by_id($_SESSION['id']);
		$profile_picture = $photo_object->get_profile_picture($session->object_type, $user->id);
	
		$sql  = "SELECT * FROM complaints";
		$sql .= " LIMIT " . $per_page;
		$sql .= " OFFSET " . $pagination->offset();
	
		$complaints = $complaint_object->find_by_sql($sql);
	
	} else if ($session->is_logged_in() && $session->object_type == 4){
		//bus_personnel
	
		$user = $bus_personnel_object->find_by_id($_SESSION['id']);
		$profile_picture = $photo_object->get_profile_picture($session->object_type, $user->id);
	
		$sql  = "SELECT * FROM complaints";
		$sql .= " WHERE user_object_type = " . $session->object_type;
		$sql .= " AND user_id = " . $user->id;
		$sql .= " LIMIT " . $per_page;
		if ($current_page != 1){
			$sql .= " OFFSET " . $pagination->offset();
		}
		
		$complaints = $complaint_object->find_by_sql($sql);
	
		//$complaints = $complaint_object->get_complaints_for_user($user->id, $session->object_type);
	
	}
	
} else {
	redirect_to("login.php");
}

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
	        <a href="admin_create_complaint.php" class="btn btn-primary"><i class="icon-plus icon-white"></i> Add New Complaint</a>
	        <br/> <br />
        </div>
        
        <div class="row-fluid">
        <?php if (!empty($session->message)) {echo $session->message; echo "<br /><br />";} ?>
        
        <table class="table table-bordered table-hover">
          <thead>
	        <tr align="center">
		        <td class="span4">Complaint Type</td>
		        <td>Related To</td>
		        <td>Identfier</td>
		        <td>Date Submitted</td>
		        <td>Time Submitted</td>
		        <td>Complaint Details</td>
		        <td>Complaint Status</td>
		        <td>&nbsp;</td>
		        <td>&nbsp;</td>
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
			        <td><?php echo date("d M Y", $complaint->date_time_submitted); ?></td>
			        <td><?php echo date("h:i:s a", $complaint->date_time_submitted); ?></td>
			        <td><?php echo $complaint->content; ?></td>
			        <td><span class="label 
			        <?php
			        
			        if ($comp_status->find_by_id($complaint->status)->id == 1){
			        	echo ' label-info';
			        } else if ($comp_status->find_by_id($complaint->status)->id == 2){
			        	echo ' label-warning';
			        } else if ($comp_status->find_by_id($complaint->status)->id == 3){
			        	echo ' label-success';
			        }
			        
			        ?>
			        "><?php echo $comp_status->find_by_id($complaint->status)->comp_status_name; ?></span></td>
	        		<td><a href="admin_read_update_complaint.php?complaintid=<?php echo $complaint->id; ?>" class="btn btn-warning btn-block"><i class="icon-edit icon-white"></i></a></td>
	        		<td><a href="admin_delete_complaint.php?complaintid=<?php echo $complaint->id; ?>" class="btn btn-danger btn-block"><i class="icon-remove icon-white"></i></a></td>
        		</tr>
        	<?php }?>
        	
          </tbody>
        </table>
        
        </div>
        
        <!-- Start Pagination -->
        
		<?php 
		if ($pagination->total_pages() > 1){
			
			echo '<div class="span12 pagination pagination-centered">';
			echo '<ul>';
			
			echo $pagination->has_previous_page() ? '<li><a href="' . $_SERVER['PHP_SELF'] . '?page='.$pagination->previous_page().'">&laquo;</a></li>' : '<li class="disabled"><a href="">&laquo;</a></li>';
			
			for ($i=1; $i <= $pagination->total_pages(); $i++) {
				
				echo '<li';
				echo $i == $pagination->current_page ? ' class="active"' : '';
				echo '>';
				echo '<a href="' . $_SERVER['PHP_SELF'] . '?page=';
				echo $i;
				echo '">'.$i.'</a>';
				echo '</li>';
				
			}
			
			echo $pagination->has_next_page() ? '<li><a href="' . $_SERVER['PHP_SELF'] . '?page='.$pagination->next_page().'">&raquo;</a></li>' : '<li class="disabled"><a href="">&raquo;</a></li>';
			
			echo '</ul>';
			echo '</div>';
		}
		?>
		
		<!-- End Pagination -->
        
      </div>
      <!-- End Content -->
      
      <div class="clearfix">&nbsp;</div>

      <div id="push"></div>
    </div>

    <?php require_once('../../includes/layouts/footer_admin.php');?>

    <?php require_once('../../includes/layouts/scripts_admin.php');?>

  </body>
</html>
