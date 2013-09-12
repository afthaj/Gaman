<?php
require_once("../../includes/initialize.php");

if ($session->is_logged_in() && $session->object_type == 5){
	
	$user = AdminUser::find_by_id($_SESSION['id']);
	$p = new Photograph();
	$profile_picture = $p->get_profile_picture($session->object_type, $user->id);
	
	if (isset($_POST['submit'])){
		
		$complaint_to_create = new Complaint();
		
		if (isset($_POST['bus_route_id'])) {
			
			$complaint_to_create->related_object_type = 1;
			$complaint_to_create->related_object_id = $_POST['bus_route_id'];
			
		} else if (isset($_POST['stop_id'])) {
			
			$complaint_to_create->related_object_type = 2;
			$complaint_to_create->related_object_id = $_POST['stop_id'];
			
		} else if (isset($_POST['bus_id'])) {
			
			$complaint_to_create->related_object_type = 3;
			$complaint_to_create->related_object_id = $_POST['bus_id'];
			
		} else if (isset($_POST['bus_personnel_id'])) {
			
			$complaint_to_create->related_object_type = 4;
			$complaint_to_create->related_object_id = $_POST['bus_personnel_id'];
			
		}
	
		$complaint_to_create->user_object_type = $session->object_type;
		$complaint_to_create->user_id = $user->id;
		$complaint_to_create->complaint_type = $_POST['complaint_type'];
		$complaint_to_create->status = $_POST['status'];
		$complaint_to_create->content = $_POST['content'];
		
		if ($complaint_to_create->create()){
			$session->message("Success! The Complaint has been submitted. ");
			redirect_to('admin_list_complaints.php');
		} else {
			$session->message("Error! The Complaint could not be submitted. ");
		}
	
	}
	
} else if ($session->is_logged_in() && $session->object_type == 4){
	
	$user = BusPersonnel::find_by_id($_SESSION['id']);
	$p = new Photograph();
	$profile_picture = $p->get_profile_picture($session->object_type, $user->id);
	
	if (isset($_POST['submit'])){
	
		$complaint_to_create = new Complaint();
	
		if (isset($_POST['bus_route_id'])) {
				
			$complaint_to_create->related_object_type = 1;
			$complaint_to_create->related_object_id = $_POST['bus_route_id'];
				
		} else if (isset($_POST['stop_id'])) {
				
			$complaint_to_create->related_object_type = 2;
			$complaint_to_create->related_object_id = $_POST['stop_id'];
				
		} else if (isset($_POST['bus_id'])) {
				
			$complaint_to_create->related_object_type = 3;
			$complaint_to_create->related_object_id = $_POST['bus_id'];
				
		} else if (isset($_POST['bus_personnel_id'])) {
				
			$complaint_to_create->related_object_type = 4;
			$complaint_to_create->related_object_id = $_POST['bus_personnel_id'];
				
		}
	
		$complaint_to_create->user_object_type = $session->object_type;
		$complaint_to_create->user_id = $user->id;
		$complaint_to_create->complaint_type = $_POST['complaint_type'];
		$complaint_to_create->status = $_POST['status'];
		$complaint_to_create->content = $_POST['content'];
		
		if ($complaint_to_create->create()){
			$session->message("Success! The Complaint has been submitted. ");
			redirect_to('admin_list_complaints.php');
		} else {
			$session->message("Error! The Complaint could not be submitted. ");
		}
		
	}
	
} else {
	redirect_to("login.php");
}

// GET request stuff and initialization code

$routes = BusRoute::find_all();
$stops = BusStop::find_all();
$buses = Bus::find_all();
$bus_personnel = BusPersonnel::find_all();
$complaint_types = ComplaintType::find_all();
$complaint_status = ComplaintStatus::find_all();
$object_types = ObjectType::find_all();

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Complaints &middot; <?php echo WEB_APP_NAME; ?></title>
    <?php require_once('../../includes/layouts/header_admin.php');?>
    
    <script type="text/javascript">

	function change_object_type(str, related_object) {
		
		if (str == "") {
			related_object.innerHTML = "";
			return;
			}
			
		if (window.XMLHttpRequest) {
			// code for IE7+, Firefox, Chrome, Opera, Safari
			request = new XMLHttpRequest();
			} else {
				// code for IE6, IE5
				request = new ActiveXObject("Microsoft.XMLHTTP");
				}
				
		request.onreadystatechange = function() {
			
			if (request.readyState == 4 && request.status == 200) {
				related_object.innerHTML = request.responseText;
				}
			
			}
			
		request.open("GET","../ajax_files/get_object_types.php?q=" + str, true);
		
		request.send();
		
		}
	
	</script>
    
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
        	<h1>Complaints</h1>
        </div>
      </header>
        
      <!-- Start Content -->
        
      <div class="container-fluid">
       	  
        <div class="row-fluid">
        
       	  <div class="span3">
       	  
	       	  <div class="sidenav" data-spy="affix" data-offset-top="200">
		      	<a href="index.php" class="btn btn-primary"> &larr; Back to Home Page</a>
		      </div>
       	  
       	  </div>
       	  
       	  <div class="span9">
       	  	<?php echo $session->message; ?>
       	  	
       	  	<section>
       	  	<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" class="form-horizontal">
            
            	<div class="control-group">
	            <label for="object_type_id" class="control-label">Related to:</label>
		            <div class="controls">
		            	<select name="object_type_id" id="object_type_id" onChange="change_object_type(this.value, document.getElementById('related_object'))">
		            		<option value="">Please select an option</option>
							<?php for($i = 0; $i <= 3; $i++){ ?>
			            		<option value="<?php echo $object_types[$i]->id; ?>"><?php echo $object_types[$i]->display_name; ?></option>
			            	<?php } ?>
						</select>
		            </div>
	            </div>
	            
	            <div class="control-group" id="related_object">
	            </div>
	            
	            <div class="control-group">
	            <label for="complaint_type" class="control-label">Complaint Type</label>
		            <div class="controls">
		            	<select name="complaint_type">
		            	<?php foreach($complaint_types as $complaint_type){ ?>
						  <option value="<?php echo $complaint_type->id; ?>"><?php echo $complaint_type->name; ?></option>
						<?php } ?>
						</select>
		            </div>
	            </div>
	            
	            
		        <input type="hidden" name="status" value="1">
				
	            
	            <div class="control-group">
	            <label for="content" class="control-label">Details of Complaint</label>
		            <div class="controls">
		            	<textarea rows="5" name="content"></textarea>
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
