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

//check login
if ($session->is_logged_in()){
	
	if ($session->object_type == 5) {
		//admin
	
		$user = $admin_user_object->find_by_id($_SESSION['id']);
		$profile_picture = $photo_object->get_profile_picture($session->object_type, $user->id);
		
		if (isset($_GET['t'])){
			//time period flag has been set
			switch ($_GET['t']) {
				case 1: //past 24 hours 
					$fromtime = strtotime("-1 day");
					$totime = time();
					$feedback_items = $feedback_item_object->get_feedback_items_within_time($fromtime, $totime);
					break;
				case 2: //past 3 days
					$fromtime = strtotime("-3 days");
					$totime = time();
					$feedback_items = $feedback_item_object->get_feedback_items_within_time($fromtime, $totime);
					break;
				case 3: //past week
					$fromtime = strtotime("-1 week");
					$totime = time();
					$feedback_items = $feedback_item_object->get_feedback_items_within_time($fromtime, $totime);
					break;
				
			}
			
		} else {
			//no time period defined, return ALL the feedback items
			
			$feedback_items = $feedback_item_object->get_all();
		}
		
		
	
	} else if ($session->is_logged_in() && $session->object_type == 4){
		//bus_personnel
	
		$user = $bus_personnel_object->find_by_id($_SESSION['id']);
		$profile_picture = $photo_object->get_profile_picture($session->object_type, $user->id);
	
		$feedback_items = $feedback_item_object->get_feedback_items_for_user($user->id, $session->object_type);
	
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
    <?php require_once('../../includes/layouts/header_admin.php');?>
  </head>

  <body>


    <!-- Part 1: Wrap all page content here -->
    <div id="wrap">

      <!-- Fixed navbar -->
      <?php $page = 'list_feedback_items';?>
      <?php require_once('../../includes/layouts/navbar_admin.php');?>
      
      <header class="jumbotron subhead">
		 <div class="container-fluid">
		   <h1>Feedback Provided</h1>
		 </div>
	  </header>

      <!-- Begin page content -->
        
      <!-- Start Content -->
      
      <div class="container-fluid">
        
        <div class="row-fluid">
	        <br />
	        <div class="well">
		        <a href="admin_create_feedback.php" class="btn btn-primary"><i class="icon-plus icon-white"></i> Provide Feedback</a>
		        <div class="pull-right">
		        	Show for &middot; <a href="#" class="btn btn-info">All</a> &middot; <a href="#" class="btn btn-info">Bus Routes</a> &middot; <a href="#" class="btn btn-info">Bus Stops</a> &middot; <a href="#" class="btn btn-info">Buses</a>
		        </div>
	        </div>
	        <br/>
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
	        
	        if ($feedback_items) {
		?>
        
        <table class="table table-bordered table-hover">
          <thead>
	        <tr align="center">
		        <td>Related To</td>
		        <td>Identifier</td>
		        <td>Date Submitted</td>
		        <td>Time Submitted</td>
		        <td>Feedback Details</td>
		        <td>&nbsp;</td>
		        <td>&nbsp;</td>
	        </tr>
	      </thead>
	      <tbody>
        	
        	<?php foreach($feedback_items as $feedback_item){ ?>
        		<tr align="center">
			        <td><?php echo $object_type_object->find_by_id($feedback_item->related_object_type)->display_name; ?></td>
			        <td>
			        <?php 
					switch ($feedback_item->related_object_type) {
					    case 1:
					        echo $route_object->find_by_id($feedback_item->related_object_id)->route_number;
					        break;
					    case 2:
					        echo $stop_object->find_by_id($feedback_item->related_object_id)->name;
					        break;
					    case 3:
					        echo $bus_object->find_by_id($feedback_item->related_object_id)->reg_number;
					        break;
				        case 4:
				        	echo $bus_personnel_object->find_by_id($feedback_item->related_object_id)->full_name();
				        	break;
					}
			        ?>
			        </td>
			        <td><?php echo date("d M Y", $feedback_item->date_time_submitted); ?></td>
			        <td><?php echo date("h:i:s a", $feedback_item->date_time_submitted); ?></td>
			        <td><?php echo $feedback_item->content; ?></td>
	        		<td><a href="admin_read_update_feedback_item.php?feedbackitemid=<?php echo $feedback_item->id; ?>" class="btn btn-warning btn-block"><i class="icon-edit icon-white"></i></a></td>
	        		<td><a href="admin_delete_feedback_item.php?feedbackitemid=<?php echo $feedback_item->id; ?>" class="btn btn-danger btn-block"><i class="icon-remove icon-white"></i></a></td>        		
        		</tr>
        	<?php } ?>
        	
          </tbody>
        </table>
        <?php 
         
	        } else {
	        	echo '<h4>You have not submitted any feedback yet. </h4>';
	        }
        
        ?>
        
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
