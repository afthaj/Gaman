<?php
require_once("../../includes/initialize.php");

//init code
$comp_object = new Complaint();
$complaint_to_read_update = $comp_object->find_by_id($_GET['complaintid']);

$routes = BusRoute::find_all();
$stops = BusStop::find_all();
$buses = Bus::find_all();
$bus_personnel = BusPersonnel::find_all();
$complaint_types = ComplaintType::find_all();
$complaint_status = ComplaintStatus::find_all();
$object_types = ObjectType::find_all();
$object_type_object = new ObjectType();

//check login
if ($session->is_logged_in() && $session->object_type == 5){
	//admin_user
	
	$user = AdminUser::find_by_id($_SESSION['id']);
	$p = new Photograph();
	$profile_picture = $p->get_profile_picture($session->object_type, $user->id);
	
	if (isset($_POST['submit'])){
		
		if (isset($_POST['bus_route_id'])) {
				
			$complaint_to_read_update->related_object_type = 1;
			$complaint_to_read_update->related_object_id = $_POST['bus_route_id'];
				
		} else if (isset($_POST['stop_id'])) {
				
			$complaint_to_read_update->related_object_type = 2;
			$complaint_to_read_update->related_object_id = $_POST['stop_id'];
				
		} else if (isset($_POST['bus_id'])) {
				
			$complaint_to_read_update->related_object_type = 3;
			$complaint_to_read_update->related_object_id = $_POST['bus_id'];
				
		} else if (isset($_POST['bus_personnel_id'])) {
				
			$complaint_to_read_update->related_object_type = 4;
			$complaint_to_read_update->related_object_id = $_POST['bus_personnel_id'];
				
		}
		
		$complaint_to_read_update->complaint_type = $_POST['complaint_type'];
		$complaint_to_read_update->status = $_POST['status'];
		$complaint_to_read_update->content = $_POST['content'];
		
		if ($complaint_to_read_update->update()){
			$session->message("Success! The Complaint details have been changed. ");
			redirect_to('admin_list_complaints.php');
		} else {
			$session->message("Error! The Complaint details could not be changed. ");
		}
	}
	
} else if ($session->is_logged_in() && $session->object_type == 4) {
	//bus_personnel
	
	$user = BusPersonnel::find_by_id($_SESSION['id']);
	$p = new Photograph();
	$profile_picture = $p->get_profile_picture($session->object_type, $user->id);
	
	if (isset($_POST['submit'])){
		
		if (isset($_POST['bus_route_id'])) {
				
			$complaint_to_read_update->related_object_type = 1;
			$complaint_to_read_update->related_object_id = $_POST['bus_route_id'];
				
		} else if (isset($_POST['stop_id'])) {
				
			$complaint_to_read_update->related_object_type = 2;
			$complaint_to_read_update->related_object_id = $_POST['stop_id'];
				
		} else if (isset($_POST['bus_id'])) {
				
			$complaint_to_read_update->related_object_type = 3;
			$complaint_to_read_update->related_object_id = $_POST['bus_id'];
				
		} else if (isset($_POST['bus_personnel_id'])) {
				
			$complaint_to_read_update->related_object_type = 4;
			$complaint_to_read_update->related_object_id = $_POST['bus_personnel_id'];
				
		}
		
		$complaint_to_read_update->complaint_type = $_POST['complaint_type'];
		$complaint_to_read_update->status = $_POST['status'];
		$complaint_to_read_update->content = $_POST['content'];
		
		if ($complaint_to_read_update->update()){
			$session->message("Success! The Complaint details have been changed. ");
			redirect_to('admin_list_complaints.php');
		} else {
			$session->message("Error! The Complaint details could not be changed. ");
		}
	}
	
} else {
	redirect_to("login.php");
}

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Complaint Details &middot; <?php echo WEB_APP_NAME; ?></title>
    <?php require_once('../../includes/layouts/header_admin.php');?>
  </head>
  
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
			
		request.open("GET","../ajax_files/get_object_types_to_read_update_complaint.php?q=" + comp_type, true);
		
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
			
		request.open("GET","../ajax_files/get_objects_to_read_update_complaint.php?q=" + str, true);
		
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
			
		request.open("GET","../ajax_files/get_objects_to_read_update_complaint.php?q=" + str, true);
		
		request.send();

		request2.open("GET","../ajax_files/get_object_types_to_read_update_complaint.php?q=" + str, true);
		
		request2.send();
		
		}
	
	</script>

  <body>


    <!-- Part 1: Wrap all page content here -->
    <div id="wrap">

      <!-- Fixed navbar -->
      <?php require_once('../../includes/layouts/navbar_admin.php');?>
      
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
	        	<?php if ($session->is_logged_in() && $session->object_type == 5) { ?>
	        		<a href="admin_list_complaints.php" class="btn btn-primary btn-block"><i class="icon-arrow-left icon-white"></i> Back to Complaints' List</a>
	        	<?php } else if ($session->is_logged_in() && $session->object_type == 4) {?>
	        		<a href="index.php" class="btn btn-primary btn-block"><i class="icon-arrow-left icon-white"></i> Back to Home</a>
	        	<?php } ?>
	        </div>
        </div>
        
        <div class="span9">
	    
	    <section>
	    
	    <form action="<?php echo $_SERVER['PHP_SELF']; ?>?complaintid=<?php echo $complaint_to_read_update->id; ?>" method="POST" class="form-horizontal">
            
            	<div class="control-group">
	            <label for="complaint_type" class="control-label">Complaint Type</label>
		            <div class="controls">
		            	<select name="complaint_type" onChange="change_related_object_type_and_id(this.value, document.getElementById('related_object_type'), document.getElementById('related_object_id'))">
		            	<option value="">Please Select</option>
		            	<?php for ($i = 0; $i < count($complaint_types); $i++){ ?>
							<option value="<?php echo $complaint_types[$i]->id; ?>"<?php if($complaint_types[$i]->id == $complaint_to_read_update->complaint_type){echo ' selected="selected"';} ?>><?php echo $object_type_object->find_by_id($complaint_types[$i]->related_object_type)->display_name . ' - ' . $complaint_types[$i]->comp_type_name; ?></option>
						<?php } ?>
						</select>
		            </div>
	            </div>
	            
	            <div class="control-group">
	            <label for="related_object_type" class="control-label">Related to:</label>
					<div class="controls">
					<select name="related_object_type" id="related_object_type" >
					
					</select>
					</div>
	            </div>
	            
	            <div class="control-group" id="related_object_id">
	            </div>
	            
		        <input type="hidden" name="status" value="1">
				
	            
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

        <!-- End Content -->
        
      </div>
      
      <div class="clearfix">&nbsp;</div>
      
      <div id="push"></div>
    </div>

    <?php require_once('../../includes/layouts/footer_admin.php');?>

    <?php require_once('../../includes/layouts/scripts_admin.php');?>

  </body>
</html>