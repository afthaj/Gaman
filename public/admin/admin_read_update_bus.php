<?php
require_once("../../includes/initialize.php");

//check login and POST request form processing

if ($session->is_logged_in() && $session->object_type == 5){
	
	$user = AdminUser::find_by_id($_SESSION['id']);
	$p = new Photograph();
	$profile_picture = $p->get_profile_picture($session->object_type, $user->id);
	
	if (isset($_POST['submit'])){
		$bus_to_read_update->route_id = $_POST['route_id'];
		$bus_to_read_update->reg_number = $_POST['reg_number'];
		$bus_to_read_update->name = $_POST['name'];
	
		if ($bus_to_read_update->update()){
			$session->message("Success! The Bus details were updated. ");
			redirect_to('admin_list_buses.php');
		} else {
			$session->message("Error! The Bus details could not be updated. ");
		}
	}
	
	if (isset($_POST['upload'])){
	
		$photo_to_upload = new Photograph();

		$photo_to_upload->related_object_type = '3';
		$photo_to_upload->related_object_id = $_GET['busid'];
		$photo_to_upload->photo_type = $_POST['photo_type'];
	
		$photo_to_upload->attach_file_bus($_FILES['file_upload'], $photo_to_upload->bus_id, $photo_to_upload->photo_type);
	
		if ($photo_to_upload->save()){
			$session->message("Success! The photo was uploaded successfully. ");
			redirect_to('admin_list_buses.php');
		} else {
			$message = join("<br />", $photo_to_upload->errors);
		}
	
	}
	
	if (isset($_POST['assign'])){
	
		$buses_bus_personnel_to_read_update = new BusBusPersonnel();
	
		$buses_bus_personnel_to_read_update->bus_id = $_GET['busid'];
		$buses_bus_personnel_to_read_update->bus_personnel_id = $_POST['bus_personnel_id'];
	
		if ($buses_bus_personnel_to_read_update->create()){
			$session->message("Success! The Bus Personnel was assigned to the given Bus. ");
			redirect_to('admin_list_buses.php');
		} else {
			$session->message("Error! The Bus Personnel was not assigned to the given Bus. ");
		}
	}
	
} else if ($session->is_logged_in() && $session->object_type == 4){
	
	$user = BusPersonnel::find_by_id($_SESSION['id']);
	$p = new Photograph();
	$profile_picture = $p->get_profile_picture($session->object_type, $user->id);
	
	if (isset($_POST['submit'])){
		$bus_to_read_update->route_id = $_POST['route_id'];
		$bus_to_read_update->reg_number = $_POST['reg_number'];
		$bus_to_read_update->name = $_POST['name'];
	
		if ($bus_to_read_update->update()){
			$session->message("Success! The Bus details were updated. ");
			redirect_to('admin_list_buses.php');
		} else {
			$session->message("Error! The Bus details could not be updated. ");
		}
	}
	
	if (isset($_POST['upload'])){
	
		$photo_to_upload = new Photograph();
		
		$photo_to_upload->related_object_type = '3';
		$photo_to_upload->related_object_id = $_GET['busid'];
		$photo_to_upload->photo_type = $_POST['photo_type'];
	
		$photo_to_upload->attach_file_bus($_FILES['file_upload'], $photo_to_upload->bus_id, $photo_to_upload->photo_type);
	
		if ($photo_to_upload->save()){
			$session->message("Success! The photo was uploaded successfully. ");
			redirect_to('admin_list_buses.php');
		} else {
			$message = join("<br />", $photo_to_upload->errors);
		}
	
	}
	
	if (isset($_POST['assign'])){
	
		$buses_bus_personnel_to_read_update = new BusBusPersonnel();
	
		$buses_bus_personnel_to_read_update->bus_id = $_GET['busid'];
		$buses_bus_personnel_to_read_update->bus_personnel_id = $_POST['bus_personnel_id'];
	
		if ($buses_bus_personnel_to_read_update->create()){
			$session->message("Success! The Bus Personnel was assigned to the given Bus. ");
			redirect_to('admin_list_buses.php');
		} else {
			$session->message("Error! The Bus Personnel was not assigned to the given Bus. ");
		}
	}
	
} else {
	redirect_to("login.php");
}

// GET request stuff and object initialization code

$routes = BusRoute::find_all();
$buses = Bus::find_all();
$bus_personnel = BusPersonnel::find_all();

// this is for the loop to display the list of bus personnel assigned to the bus
$bbp_object = new BusBusPersonnel();

// for the foreach loop wthin the list of bus personnel assigned to the bus
$bus_personnel_object = new BusPersonnel();

// this is to check if the user is the (owner), (owner + driver), or (owner + conductor)  
$bp = new BusPersonnel();
$bbp_obj = new BusBusPersonnel();

$related_object = "bus";
$pt = new PhotoType();
$photo_types = $pt->get_photo_types($related_object);

$p2 = new Photograph();
$photos_of_bus = $p2->get_photos('3', $_GET['busid']);

if (isset($_GET['busid'])){
	$bus_to_read_update = Bus::find_by_id($_GET['busid']);

} else {
	$session->message("No Bus ID provided to view.");
	redirect_to("admin_list_buses.php");
}

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Bus Details &middot; <?php echo WEB_APP_NAME;?></title>
    <?php require_once('../../includes/layouts/header_admin.php');?>
  </head>

  <body>


    <!-- Part 1: Wrap all page content here -->
    <div id="wrap">

      <!-- Fixed navbar -->
      <?php require_once('../../includes/layouts/navbar_admin.php');?>
      
      <header class="jumbotron subhead">
		 <div class="container-fluid">
		   <h1>Bus Profile</h1>
		   <h3><?php echo $bus_to_read_update->reg_number; ?></h3>
		 </div>
	  </header>
      
      <!-- Begin page content -->
      
      <div class="container-fluid">
      
      <div class="row-fluid">
      
        <div class="span3">
	        <div class="sidenav" data-spy="affix" data-offset-top="200">
	        	<a href="admin_list_buses.php" class="btn btn-primary"> &larr; Back to Buses List</a>
	        </div>
        </div>
        
        <!-- Start Content -->

        <div class="span9">
        
        <section>
        
        <?php echo $session->message; ?>
        
        <ul class="nav nav-tabs">
	      <li class="active"><a href="#bus_pictures" data-toggle="tab">Pictures of the Bus</a></li>
	      <li><a href="#bus_profile" data-toggle="tab">Bus Profile</a></li>
	      <li><a href="#bus_personnel_list" data-toggle="tab">List of Personnel</a></li>
	    </ul>
	    
	    <div id="tab_content" class="tab-content">
	      	
	      	<div class="tab-pane fade" id="bus_profile">
	      	
	      	<form class="form-horizontal" action="<?php echo $_SERVER['PHP_SELF']; ?>?busid=<?php echo $_GET['busid']; ?>" method="POST">
            
	            <div class="control-group">
            	<label for="route_id" class="control-label">Route Number</label>
	            <div class="controls">
	            	<select name="route_id"<?php if (!($session->is_logged_in() && $session->object_type == 5)){ echo ' disabled'; } ?>>
					<?php foreach($routes as $route){ ?>
	            		<option value="<?php echo $route->id; ?>"<?php if ($bus_to_read_update->route_id == $route->id){ echo ' selected="selected"';} ?>><?php echo $route->route_number; ?></option>
	            	<?php } ?>
					</select>
	            </div>
            </div>
            
            <div class="control-group">
        	<label for="reg_number" class="control-label">Registration Number</label>
	        	<div class="controls">
	        		<input type="text" name="reg_number"<?php if (!($session->is_logged_in() && $session->object_type == 5)){ echo ' disabled'; } ?> value="<?php echo $bus_to_read_update->reg_number; ?>" />
	        	</div>
        	</div>
            
            <div class="control-group">
            <label for="name" class="control-label">Name of Bus</label>
	            <div class="controls">
	            	<input type="text" name="name"<?php 

		      		$bus_bp = $bbp_obj->check_if_user_is_personnel_for_a_bus($user->id, $bus_to_read_update->id); //$personnel_for_bus
		      		
		      		if($bus_bp) { 
		      		
		      			if ($bp->check_personnel_owner($bus_bp->bus_personnel_id) || $bp->check_personnel_owner_driver($bus_bp->bus_personnel_id) || $bp->check_personnel_owner_conductor($bus_bp->bus_personnel_id)) {
		      				
		      			} else {
		      				echo ' disabled';
		      			}
		      		} else {
		      			echo ' disabled';
		      		}
      				?> value="<?php echo $bus_to_read_update->name; ?>" />
	            </div>
            </div>
            
            <?php
      		
      		if($bus_bp) { 
      		
      			if ($bp->check_personnel_owner($bus_bp->bus_personnel_id) || $bp->check_personnel_owner_driver($bus_bp->bus_personnel_id) || $bp->check_personnel_owner_conductor($bus_bp->bus_personnel_id)){
      			
      			?>
          	<div class="form-actions">
        	    <button class="btn btn-primary" name="submit">Submit</button>
        	</div>
        	<?php } } ?>
	        </form>
	      
	      	</div>
	      
	      	<div class="tab-pane fade" id="bus_personnel_list">
	      	
	      	<div class="row-fluid">
      			<h4>List of Personnel</h4>
      			<br />
      		</div>
      		
      		<div class="row-fluid">
      		
		      <?php 
		      
		      $buses_bus_personnel = $bbp_object->get_personnel_for_bus($bus_to_read_update->id);
		      
		      if ($buses_bus_personnel) { ?>
		      
		      <table class="table table-bordered table-hover">
	          <thead align="center">
		        <tr>
			        <td>Profile Picture</td>
			        <td>Full Name</td>
			        <td>Role</td>
		        </tr>
		      </thead>
		      
		      <tbody align="center">
		      
		      <?php foreach($buses_bus_personnel as $bbp){

		      	$assigned_bus_personnel = $bus_personnel_object->find_by_id($bbp->bus_personnel_id);
		      	
		      	?>
	        		<tr>
		        		<td>
		        		<a href="admin_read_update_bus_personnel.php?personnelid=<?php echo $assigned_bus_personnel->id; ?>">
	        			<?php 
	        			
		        		$pic = new Photograph();
		        		
		        		$bus_personnel_profile_picture = $pic->get_profile_picture('4', $assigned_bus_personnel->id);
		        		
		        		if (!empty($bus_personnel_profile_picture->filename)) {
		        			echo '<img src="../../' . $bus_personnel_profile_picture->image_path() . '" width="100" class="img-rounded" />';
		        		} else {
		        			echo '<img src="../img/default-prof-pic.jpg" width="100" class="img-rounded" alt="Please upload a profile picture" />';
		        		}
		        		
		        		?>
		        		</a>
	        			</td>
	        			<td><a class="btn btn-block btn-info" href="admin_read_update_bus_personnel.php?personnelid=<?php echo $assigned_bus_personnel->id; ?>"><?php echo $assigned_bus_personnel->full_name(); ?></a></td>
		        		<td>
		        		<?php			        	
			        	
			        	$bus_personnel_role = new BusPersonnelRole();
			        	
		        		echo $bus_personnel_role->find_by_id($assigned_bus_personnel->role)->role_name;
		        		
		        		?>
		        		</td>
		        		
	        		</tr>
	          
	          <?php } ?>
	          
	          </tbody>
	          </table>
	        		
	          <?php } else { ?>
	          <h5>No Personnel have been assigned to this Bus yet!</h5>
	          <br />
	          <?php } ?>
	          
      		</div>
      		
      		<?php 
      		
      		$bus_bp = $bbp_obj->check_if_user_is_personnel_for_a_bus($user->id, $bus_to_read_update->id); //$personnel_for_bus
      		
      		if($bus_bp) { 
      		
      			if ($bp->check_personnel_owner($bus_bp->bus_personnel_id) || $bp->check_personnel_owner_driver($bus_bp->bus_personnel_id) || $bp->check_personnel_owner_conductor($bus_bp->bus_personnel_id)){
      			
      			?>
      		
      		<div class="row-fluid">
      		
      		<form class="form-horizontal" action="<?php echo $_SERVER['PHP_SELF']; ?>?busid=<?php echo $_GET['busid']; ?>" method="POST">
            
            <div class="control-group">
            <label for="bus_personnel_id" class="control-label">Assign to this Bus</label>
	            <div class="controls">
	            	<select name="bus_personnel_id">
	            	<?php foreach($bus_personnel as $bus_person){ 
	            	
	            		$bp_object = new BusPersonnel();
	            		$bpr_object = new BusPersonnelRole();
	            		
	            		?>
	            		<option value="<?php echo $bus_person->id; ?>">Name: <?php echo $bp_object->find_by_id($bus_person->id)->first_name; ?> <?php echo $bp_object->find_by_id($bus_person->id)->last_name; ?> &middot; NIC Number: <?php echo $bp_object->find_by_id($bus_person->id)->nic_number; ?> &middot; Role: <?php echo $bpr_object->find_by_id($bp_object->find_by_id($bus_person->id)->role)->role_name; ?></option>
	            	<?php } ?>
					</select>
	            </div>
            </div>
	            
          	<div class="form-actions">
        	    <button class="btn btn-primary" name="assign">Assign</button>
        	</div>
        	
	        </form>
	        
      		</div>
      		<?php } } ?>
	      	
	   		</div>
	   		
	   		<div class="tab-pane active in" id="bus_pictures">

			<?php if (!empty($photos_of_bus)) { ?>
				<div class="callbacks_container">
		        <ul class="rslides" id="responsive_slider">
		        
		        <?php for ( $i = 0; $i < count($photos_of_bus); $i++ ) { ?>
		        
					<li>
					<img src="<?php echo '../../'.$photos_of_bus[$i]->image_path(); ?>" alt="">
					<p class="caption"><?php echo PhotoType::find_by_id($photos_of_bus[$i]->photo_type)->photo_type_name; ?></p>
					</li>
				
		        <?php } ?>
		        
		        </ul>
		        </div>
			      
			<?php } else { ?>
			
			<h5>No photos of the Bus have been uploaded yet!</h5>
			<br /><br />
			<?php } ?>
			
			
			<?php 
      		
      		$bus_bp = $bbp_obj->check_if_user_is_personnel_for_a_bus($user->id, $bus_to_read_update->id); //$personnel_for_bus
      		
      		if($bus_bp) { 
      		
      			if ($bp->check_personnel_owner($bus_bp->bus_personnel_id) || $bp->check_personnel_owner_driver($bus_bp->bus_personnel_id) || $bp->check_personnel_owner_conductor($bus_bp->bus_personnel_id)){
      			
      			?>
      			
			  <form class="form-horizontal" action="<?php echo $_SERVER['PHP_SELF']; ?>?busid=<?php echo $_GET['busid']; ?>" method="POST" enctype="multipart/form-data">
			      <input type="hidden" name="MAX_FILE_SIZE" value="1000000"/>
			        	
			      <div class="control-group">
			      	<input type="file" name="file_upload" />
			      </div>
			      
			      <div class="control-group">
			      <label for="photo_type" class="control-label">Photo Type</label>
				      <div class="controls">
					      <select name="photo_type">
					      	<?php foreach($photo_types as $photo_type) { ?>
					      	<option value="<?php echo $photo_type->id; ?>"><?php echo $photo_type->photo_type_name; ?></option>
					      	<?php } ?>
					      </select>
				      </div>
			      </div>
			        	
			      <div class="form-actions">
			      	<button type="submit" class="btn btn-primary" name="upload">Upload</button>
			      </div>	        	
		      </form>
	  	<?php } } ?>
			</div>
	      
	    </div>
	    
	    </section>
	    
	  	</div>
        
        </div>
        
        <!-- End Content -->
        
      </div>
      
      <div class="clearfix">&nbsp;</div>

      <div id="push"></div>
    </div>
    
    <?php require_once('../../includes/layouts/scripts_admin.php');?>
    
    <?php require_once('../../includes/layouts/footer_admin.php');?>
    
  </body>
</html>