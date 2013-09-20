<?php
require_once("../../includes/initialize.php");

if ($session->is_logged_in() && $session->object_type == 5){
	//admin_user
	
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
		$complaint_to_create->date_time_submitted = time();
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
	//bus_personnel
	
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
$object_type_object = new ObjectType();

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Complaints &middot; <?php echo WEB_APP_NAME; ?></title>
    <?php require_once('../../includes/layouts/header_admin.php');?>
    
    <script type="text/javascript">

	function change_related_object_type(comp_type, related_object_type) {
		
		if (comp_type == "") {
			related_object_type.innerHTML = "";
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
				related_object_type.innerHTML = request.responseText;
				}
			
			}
			
		request.open("GET","../ajax_files/get_object_types_to_create_complaint.php?q=" + comp_type, true);
		
		request.send();
		
		}

	function change_related_object_id(str, related_object_id) {
		
		if (str == "") {
			related_object_id.innerHTML = "";
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
				related_object_id.innerHTML = request.responseText;
				}
			
			}
			
		request.open("GET","../ajax_files/get_objects_to_create_complaint.php?q=" + str, true);
		
		request.send();
		
		}

	function change_related_object_type_and_id(str, related_object_type, related_object_id) {
		
		if (str == "") {
			related_object_id.innerHTML = "";
			return;
			}
			
		if (window.XMLHttpRequest) {
			// code for IE7+, Firefox, Chrome, Opera, Safari
			request = new XMLHttpRequest();
			request2 = new XMLHttpRequest();
			} else {
				// code for IE6, IE5
				request = new ActiveXObject("Microsoft.XMLHTTP");
				request2 = new ActiveXObject("Microsoft.XMLHTTP");
				}
				
		request.onreadystatechange = function() {
			
			if (request.readyState == 4 && request.status == 200) {
				related_object_id.innerHTML = request.responseText;
				}
			
			}

		request2.onreadystatechange = function() {
			
			if (request2.readyState == 4 && request2.status == 200) {
				related_object_type.innerHTML = request2.responseText;
				}
			
			}
			
		request.open("GET","../ajax_files/get_objects_to_create_complaint.php?q=" + str, true);
		
		request.send();

		request2.open("GET","../ajax_files/get_object_types_to_create_complaint.php?q=" + str, true);
		
		request2.send();
		
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
		      	<a href="admin_list_complaints.php" class="btn btn-primary btn-block"><i class="icon-arrow-left icon-white"></i> Back to List of Complaints</a>
		      </div>
       	  
       	  </div>
       	  
       	  <div class="span9">
       	  	<?php echo $session->message; ?>
       	  	
       	  	<section>
       	  	<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" class="form-horizontal">
            
            	<div class="control-group">
	            <label for="complaint_type" class="control-label">Complaint Type</label>
		            <div class="controls">
		            	<select name="complaint_type" onChange="change_related_object_type_and_id(this.value, document.getElementById('related_object_type'), document.getElementById('related_object_id'))">
		            	<option value="">Please Select</option>
		            	<?php for ($i = 0; $i < count($complaint_types); $i++){ ?>
							<option value="<?php echo $complaint_types[$i]->id; ?>"><?php echo $object_type_object->find_by_id($complaint_types[$i]->related_object_type)->display_name . ' - ' . $complaint_types[$i]->comp_type_name; ?></option>
						<?php } ?>
						</select>
		            </div>
	            </div>
	            
	            <div class="control-group">
	            <label for="related_object_type" class="control-label">Related to:</label>
					<div class="controls">
					<select name="related_object_type" id="related_object_type">
					</select>
					</div>
	            </div>
	            
	            <div class="control-group" id="related_object_id">
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
