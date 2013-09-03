<?php
require_once("../includes/initialize.php");

if ($session->is_logged_in() && $session->object_type == 6){

	$user = Commuter::find_by_id($_SESSION['id']);
	$p = new Photograph();
	$profile_picture = $p->get_profile_picture($user->id, "commuter");


} else if ($session->is_logged_in() && $session->object_type != 6) {

	//redirect_to("login.php");

}

$roles = BusPersonnelRole::find_all();
$buses = Bus::find_all();

if (isset($_GET['personnelid'])){
	$bus_personnel_to_read_update = BusPersonnel::find_by_id($_GET['personnelid']);

	$pic = new Photograph();
	$profile_picture_of_bus_personnel = $pic->get_profile_picture($bus_personnel_to_read_update->id, "bus_personnel");

} else {
	$session->message("No Bus Personnel ID provided to view.");
	redirect_to("admin_list_bus_personnel.php");
}

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Bus Personnel Details &middot; <?php echo WEB_APP_NAME; ?></title>
    <?php require_once('../includes/layouts/header.php');?>
  </head>

  <body>


    <!-- Part 1: Wrap all page content here -->
    <div id="wrap">

      <!-- Fixed navbar -->
      <?php require_once('../includes/layouts/navbar.php');?>
      
      <header class="jumbotron subhead">
		 <div class="container-fluid">
		   <h1>Bus Personnel Profile</h1>
		   <h3><?php echo $bus_personnel_to_read_update->first_name . ' ' . $bus_personnel_to_read_update->last_name;?></h3>
		 </div>
	  </header>
      
      <!-- Begin page content -->
      
      <div class="container-fluid">
      
      <div class="row-fluid">
      
        <div class="span3">
	        <div class="sidenav" data-spy="affix" data-offset-top="200">
	        	<a href="public_list_bus_personnel.php" class="btn btn-primary"> &larr; Back to Bus Personnel List</a>
	        </div>
        </div>
        
        <!-- Start Content -->

        <div class="span9">
        
        <section>
        
        <?php echo $session->message; ?>
        
        <ul class="nav nav-tabs">
	      <li class="active"><a href="#personnel_profile" data-toggle="tab">Profile</a></li>
	      <li><a href="#assigned_buses_list" data-toggle="tab">Bus Assignment</a></li>
	    </ul>
	    
	    <div id="tab_content" class="tab-content">
	      	
	      	<div class="tab-pane active in" id="personnel_profile">
	      	
	      	<form class="form-horizontal" action="" method="POST">
            
            <div class="control-group">
            	<label for="profile_picture" class="control-label">Profile Picture</label>
            
	            <div class="controls">
	            	<?php 
	            	if (!empty($profile_picture_of_bus_personnel->filename)) {
	            		echo '<img src="../' . $profile_picture_of_bus_personnel->image_path() . '" width="250" class="img-rounded" />'; 
	            	} else {
	            		echo '<input type="text" value="" name="" placeholder="No profile picture uploaded" >'; 
	            	} 
	            	?>
	            </div>
            </div>
            
            <div class="control-group">
            	<label for="role" class="control-label">Role</label>
	            <div class="controls">
	            	<select name="role" disabled>
					<?php foreach($roles as $role){ ?>
	            		<option value="<?php echo $role->id; ?>"<?php if ($bus_personnel_to_read_update->role == $role->id){ echo ' selected="selected"';} ?>><?php echo $role->role_name; ?></option>
	            	<?php } ?>
					</select>
	            </div>
            </div>
            
            <div class="control-group">
        	<label for="first_name" class="control-label">First Name</label>
	        	<div class="controls">
	        		<input type="text" name="first_name" disabled value="<?php echo $bus_personnel_to_read_update->first_name; ?>" />
	        	</div>
        	</div>
            
            <div class="control-group">
            <label for="last_name" class="control-label">Last Name</label>
	            <div class="controls">
	            	<input type="text" name="last_name" disabled value="<?php echo $bus_personnel_to_read_update->last_name; ?>" />
	            </div>
            </div>
            
            <div class="control-group">
        	<label for="nic_number" class="control-label">NIC Number</label>
	        	<div class="controls">
	        		<input type="text" name="nic_number" disabled value="<?php echo $bus_personnel_to_read_update->nic_number; ?>" />
	        	</div>
        	</div>

	        </form>
	      
	      	</div>
	      
	      	<div class="tab-pane fade" id="assigned_buses_list">
	      		
      		<div class="row-fluid">
      			<h4>Assigned Bus/Buses</h4>
      			<br />
      		</div>
      		
      		<div class="row-fluid">
      		
      		<table class="table table-bordered table-hover">
	          <thead align="center">
		        <tr>
			        <td>Route Number</td>
			        <td>Registration Number</td>
			        <td>Name (Optional)</td>
		        </tr>
		      </thead>
		      
		      <tbody align="center">
	        	
	        	<?php
	        	
	        	$bbp_object = new BusBusPersonnel();
	        	$bus_object = new Bus();
	        	
	        	$buses_bus_personnel = $bbp_object->get_buses_for_personnel($bus_personnel_to_read_update->id);
	        	
	        	foreach($buses_bus_personnel as $bbp){ 
	        	
	        	$assigned_bus = $bus_object->find_by_id($bbp->bus_id);
	        		
	        	?>
        		<tr>
	        		<td><?php echo BusRoute::find_by_id($assigned_bus->route_id)->route_number; ?></td>
	        		<td><?php echo $assigned_bus->reg_number; ?></td>
	        		<td><?php echo $assigned_bus->name; ?></td>
        		</tr>
	        	<?php } ?>
	        	
	          </tbody>
	          
	        </table>

      		</div>
	      	
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

    <?php require_once('../includes/layouts/footer.php');?>

    <?php require_once('../includes/layouts/scripts.php');?>

  </body>
</html>