<?php
require_once("../../includes/initialize.php");

//init code
$photo_object = new Photograph();
$admin_user_object = new AdminUser();

$route_object = new BusRoute();
$stop_object = new BusStop();
$bus_object = new Bus();
$bus_personnel_object = new BusPersonnel();

$object_type_object = new ObjectType();

$feedback_item_object = new FeedbackItem();

$routes = BusRoute::find_all();
$stops = BusStop::find_all();
$buses = Bus::find_all();
$bus_personnel = BusPersonnel::find_all();
$complaint_types = ComplaintType::find_all();
$complaint_status = ComplaintStatus::find_all();

//GET request stuff
$feedback_item_to_read_update = $feedback_item_object->find_by_id($_GET['feedbackitemid']);

//check login
if ($session->is_logged_in()){
	
	if ($session->object_type == 5) {
		//admin_user
	
		$user = $admin_user_object->find_by_id($_SESSION['id']);
		$profile_picture = $photo_object->get_profile_picture($session->object_type, $user->id);
	
		if (isset($_POST['submit'])){
			
			$feedback_item_to_read_update->content = $_POST['content'];
			
			if ($feedback_item_to_read_update->update()){
				$session->message("Success! The Feedback Item details have been changed. ");
				redirect_to('admin_list_feedback_items.php');
			} else {
				$session->message("Error! The details of the Feedback Item could not be changed. ");
			}
		}
	
	} else if ($session->object_type == 4) {
		//bus_personnel
		
		$user = $bus_personnel_object->find_by_id($_SESSION['id']);
		$profile_picture = $photo_object->get_profile_picture($session->object_type, $user->id);
		
		if (isset($_POST['submit'])){

			$feedback_item_to_read_update->content = $_POST['content'];
			
		if ($feedback_item_to_read_update->update()){
				$session->message("Success! The Feedback Item details have been changed. ");
				redirect_to('admin_list_feedback_items.php');
			} else {
				$session->message("Error! The details of the Feedback Item could not be changed. ");
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
    <title>Feedback &middot; <?php echo WEB_APP_NAME; ?></title>
    <?php require_once('../../includes/layouts/header_admin.php');?>
  </head>

  <body>


    <!-- Part 1: Wrap all page content here -->
    <div id="wrap">

      <!-- Fixed navbar -->
      <?php $page = 'complaints';?>
      <?php require_once('../../includes/layouts/navbar_admin.php');?>

      <!-- Begin page content -->
      
      <header class="jumbotron subhead">
        <div class="container-fluid">
        	<h1>Feedback Items</h1>
        </div>
      </header>
        
      <!-- Start Content -->
        
      <div class="container-fluid">
       	  
        <div class="row-fluid">
        
       	  <div class="span3">
       	  
	       	  <div class="sidenav" data-spy="affix" data-offset-top="200">
		      	<a href="admin_list_feedback_items.php" class="btn btn-primary"> &larr; Back to List of Feedback</a>
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
       	  	
       	  	<form action="<?php echo $_SERVER['PHP_SELF']; ?>?feedbackitemid=<?php echo $feedback_item_to_read_update->id; ?>" method="POST" class="form-horizontal">
            
	            <div class="control-group">
	            <label for="related_object_type" class="control-label">Related to:</label>
					<div class="controls">
					<input type="text" name="related_object_type" disabled="disabled" value="<?php echo $object_type_object->find_by_id($feedback_item_to_read_update->related_object_type)->display_name; ?>" />
					</div>
	            </div>
	            
	            <div class="control-group">
	            <label for="related_object_id" class="control-label">Identifier:</label>
					<div class="controls">
					<input type="text" name="related_object_id" disabled="disabled" value="<?php 
					
					if ($feedback_item_to_read_update->related_object_type == 1){
						//complaint is about a Route
						echo $route_object->find_by_id($feedback_item_to_read_update->related_object_id)->route_number;
						
					} else if ($feedback_item_to_read_update->related_object_type == 2){
						//complaint is about a Stop
						echo $stop_object->find_by_id($feedback_item_to_read_update->related_object_id)->name;
						
					} else if ($feedback_item_to_read_update->related_object_type == 3){
						//complaint is about a Bus
						echo $bus_object->find_by_id($feedback_item_to_read_update->related_object_id)->reg_number;
						
					} else if ($feedback_item_to_read_update->related_object_type == 4){
						//complaint is about a Bus Personnel
						echo $bus_personnel_object->find_by_id($feedback_item_to_read_update->related_object_id)->full_name();
						
					}
					?>" />
					</div>
	            </div>
	            
	            <div class="control-group">
	            <label for="content" class="control-label">Details of Feedback Item</label>
		            <div class="controls">
		            	<textarea rows="5" name="content"><?php echo $feedback_item_to_read_update->content; ?></textarea>
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

    <?php require_once('../../includes/layouts/footer_admin.php');?>

    <?php require_once('../../includes/layouts/scripts_admin.php');?>

  </body>
</html>
