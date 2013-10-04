<?php
require_once("./includes/initialize.php");

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

$routes = BusRoute::find_all();
$stops = BusStop::find_all();
$buses = Bus::find_all();
$bus_personnel = BusPersonnel::find_all();
$complaint_types = ComplaintType::find_all();
$complaint_status = ComplaintStatus::find_all();

//GET request stuff
$complaint_to_read_update = $complaint_object->find_by_id($_GET['complaintid']);

//check login
if ($session->is_logged_in()){
	
	if ($session->object_type == 6) {
	
		$user = $commuter_object->find_by_id($_SESSION['id']);
		$profile_picture = $photo_object->get_profile_picture($session->object_type, $user->id);
		
		if (isset($_POST['submit'])){
			$complaint_to_read_update->status = $_POST['status'];
			$complaint_to_read_update->content = $_POST['content'];
			
			if ($complaint_to_read_update->update()){
				$session->message("Success! The Complaint details have been changed. ");
				redirect_to('public_list_complaints.php');
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
    <title>Complaints &middot; <?php echo WEB_APP_NAME; ?></title>
    <?php require_once('./includes/layouts/header.php');?>
  </head>

  <body>


    <!-- Part 1: Wrap all page content here -->
    <div id="wrap">

      <!-- Fixed navbar -->
      <?php $page = 'complaints';?>
      <?php require_once('./includes/layouts/navbar.php');?>

      <!-- Begin page content -->
      
      <header class="jumbotron subhead">
        <div class="container-fluid">
        	<h1>Complaints</h1>
        </div>
      </header>
        
      <!-- Start Content -->
        
      <div class="container-fluid">
       	  
        <div class="row-fluid">
        
       	  <div class="span3">
       	  
	       	  <div class="sidenav" data-spy="affix" data-offset-top="200">
		      	<a href="public_list_complaints.php" class="btn btn-primary"><i class="icon-arrow-left icon-white"></i> Back to List of Complaints</a>
		      </div>
       	  
       	  </div>
       	  
       	  <div class="span9">
       	  	
       	  	<section>
       	  	
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
       	  	
       	  	<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" class="form-horizontal">
            
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
	            
		        <div class="control-group">
	            <label for="content" class="control-label">Details of Complaint</label>
		            <div class="controls">
		            	<textarea rows="5" name="content"><?php echo $complaint_to_read_update->content; ?></textarea>
		            </div>
	            </div>
		        
	          	<div class="form-actions">
	        	    <button class="btn btn-primary" name="submit">Submit</button>
	        	</div>
	        </form>
	        </section>
       	  	
       	  </div>
       	  
	    </div>
	      
      </div>
        
        
      <!-- End Content -->
        
      

      <div id="push"></div>
    </div>

    <?php require_once('./includes/layouts/footer.php');?>

    <?php require_once('./includes/layouts/scripts.php');?>

  </body>
</html>
