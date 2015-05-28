<?php
require_once("../includes/initialize.php");

//init code
$photo_object = new Photograph();
$admin_user_object = new AdminUser();

$route_object = new BusRoute();
$stop_object = new BusStop();
$bus_object = new Bus();
$bus_personnel_object = new BusPersonnel();

$object_type_object = new ObjectType();

$complaint_object = new Complaint();
$complaint_type_object = new ComplaintType();
$complaint_status_object = new ComplaintStatus();

$complaint_statuses = $complaint_status_object->find_all();

//GET request stuff
$complaint_to_read_update = $complaint_object->find_by_id($_GET['complaintid']);

//check login
if ($session->is_logged_in()){
	
	if ($session->object_type == 5){
		//admin_user
	
		$user = $admin_user_object->find_by_id($_SESSION['id']);
		$profile_picture = $photo_object->get_profile_picture($session->object_type, $user->id);
	
		if (isset($_POST['submit'])){

			$complaint_to_read_update->status = $_POST['status'];
			$complaint_to_read_update->content = $_POST['content'];
	
			if ($complaint_to_read_update->update()){
				$session->message("Success! The Complaint details have been changed. ");
				redirect_to('admin_list_complaints.php');
			} else {
				$session->message("Error! The Complaint details could not be changed. ");
			}
		}
	} else if ($session->object_type == 4) {
		//bus_personnel
		
		$user = $bus_personnel_object->find_by_id($_SESSION['id']);
		$profile_picture = $photo_object->get_profile_picture($session->object_type, $user->id);
		
		if (isset($_POST['submit'])){

			$complaint_to_read_update->content = $_POST['content'];
			
			if ($complaint_to_read_update->update()){
				$session->message("Success! The Complaint details have been changed. ");
				redirect_to('admin_list_complaints.php');
			} else {
				$session->message("Error! The Complaint details could not be changed. ");
			}
		}
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
    <title>Complaint Details &middot; <?php echo WEB_APP_NAME; ?></title>
    <?php require_once('../includes/layouts/header_admin.php');?>
  </head>

  <body>


    <!-- Part 1: Wrap all page content here -->
    <div id="wrap">

      <!-- Fixed navbar -->
      <?php require_once('../includes/layouts/navbar_admin.php');?>
      
      <header class="jumbotron subhead">
		 <div class="container-fluid">
		 
		 <div class="span9">
		 	<h1>Complaint Details</h1>
		 </div>
		 
		 </div>
	  </header>

      <!-- Begin page content -->
      
      <div class="container-fluid">
        
        <!-- Start Content -->
        
        <div class="row-fluid">
        
        <div class="span3">
	        <div class="sidenav" data-spy="affix" data-offset-top="200">
	        	<?php //if ($session->is_logged_in() && $session->object_type == 5) { ?>
	        		<a href="admin_list_complaints.php" class="btn btn-primary btn-block"><i class="icon-arrow-left icon-white"></i> Back to List of Complaints</a>
	        	<?php //} else if ($session->is_logged_in() && $session->object_type == 4) {?>
	        		<!-- <a href="index.php" class="btn btn-primary btn-block"><i class="icon-arrow-left icon-white"></i> Back to Home</a>  -->
	        	<?php //} ?>
	        </div>
        </div>
        
        <div class="span9">
	    
	    <section>
	    
	    <form action="<?php echo $_SERVER['PHP_SELF']; ?>?complaintid=<?php echo $complaint_to_read_update->id; ?>" method="POST" class="form-horizontal">
            
            	<div class="control-group">
	            <label for="complaint_type" class="control-label">Complaint Type</label>
		            <div class="controls">
			            <textarea rows="3" name="complaint_type" disabled="disabled"><?php echo $complaint_type_object->find_by_id($complaint_to_read_update->complaint_type)->comp_type_name; ?></textarea>
		            </div>
	            </div>
	            
	            <div class="control-group">
	            <label for="related_object_type" class="control-label">Related to:</label>
					<div class="controls">
					<input type="text" name="related_object_type" disabled="disabled" value="<?php echo $object_type_object->find_by_id($complaint_to_read_update->related_object_type)->display_name; ?>" />
					</div>
	            </div>
	            
	            <div class="control-group">
	            <label for="related_object_id" class="control-label">Identifier:</label>
					<div class="controls">
					<input type="text" name="related_object_id" disabled="disabled" value="<?php 
					
					if ($complaint_to_read_update->related_object_type == 1){
						//complaint is about a Route
						echo $route_object->find_by_id($complaint_to_read_update->related_object_id)->route_number;
						
					} else if ($complaint_to_read_update->related_object_type == 2){
						//complaint is about a Stop
						echo $stop_object->find_by_id($complaint_to_read_update->related_object_id)->name;
						
					} else if ($complaint_to_read_update->related_object_type == 3){
						//complaint is about a Bus
						echo $bus_object->find_by_id($complaint_to_read_update->related_object_id)->reg_number;
						
					} else if ($complaint_to_read_update->related_object_type == 4){
						//complaint is about a Bus Personnel
						echo $bus_personnel_object->find_by_id($complaint_to_read_update->related_object_id)->full_name();
						
					}
					?>" />
					</div>
	            </div>
	            
	            <?php if ($session->object_type == 5) { ?>
		        <div class="control-group">
	            <label for="content" class="control-label">Details of Complaint</label>
		            <div class="controls">
	            	<select name="status">
	            	<?php foreach ($complaint_statuses as $complaint_status) { ?>
	            		<option value="<?php echo $complaint_status->id; ?>"<?php if($complaint_to_read_update->status == $complaint_status->id){echo ' selected="selected"';}?>><?php echo $complaint_status->comp_status_name; ?> </option>
	            	<?php } ?>
	            	</select>
		            </div>
	            </div>
		        <?php } ?>
				
	            
	            <div class="control-group">
	            <label for="content" class="control-label">Details of Complaint</label>
		            <div class="controls">
		            	<textarea rows="5" name="content" disabled="disabled"><?php echo $complaint_to_read_update->content; ?></textarea>
		            </div>
	            </div>
	            
	          	<div class="form-actions">
	        	    <button class="btn btn-primary" name="submit">Submit</button>
	        	</div>
	        </form>
	  	
	  	</section>
	  	
	  	</div>
	  	
	  	</div>

        <!-- End Content -->
        
      </div>
      
      <div class="clearfix">&nbsp;</div>
      
      <div id="push"></div>
    </div>

    <?php require_once('../includes/layouts/footer_admin.php');?>

    <?php require_once('../includes/layouts/scripts_admin.php');?>

  </body>
</html>