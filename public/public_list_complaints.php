<?php
require_once("../includes/initialize.php");

//init code
$photo_object = new Photograph();
$commuter_object = new Commuter();
$complaint_object = new Complaint();

//pagination code
$current_page = !empty($_GET['page']) ? (int)$_GET['page'] : 1;
$per_page = 20;
$total_count = $complaint_object->count_all();
$pagination = new Pagination($current_page, $per_page, $total_count);

//check login
if ($session->is_logged_in()){
	
	if ($session->object_type == 6) {
		//commuter
	
		$user = $commuter_object->find_by_id($_SESSION['id']);
		$profile_picture = $photo_object->get_profile_picture($session->object_type, $user->id);
		
		$sql  = "SELECT * FROM complaints";
		$sql .= " WHERE user_object_type = " . $session->object_type;
		$sql .= " AND user_id = " . $user->id;
		$sql .= " LIMIT " . $per_page;
		if ($current_page != 1){
			$sql .= " OFFSET " . $pagination->offset();
		}
		
		$complaints = $complaint_object->find_by_sql($sql);
	
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

    <?php require_once('../includes/layouts/footer.php');?>

    <?php require_once('../includes/layouts/scripts.php');?>

  </body>
</html>
