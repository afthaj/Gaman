<?php
require_once("../includes/initialize.php");

if (!$session->is_logged_in()){
	redirect_to("login.php");
} else {
	
	$admin_user = Admin::find_by_id($_SESSION['id']);
	$routes = BusRoute::find_all();
	$buses = Bus::find_all();
	
	if (isset($_GET['busid'])){
		$bus_to_read_update = Bus::find_by_id($_GET['busid']);
		
	} else {
		$session->message("No Bus ID provided to view.");
		redirect_to("admin_list_buses.php");
	}
	
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
	
}

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Bus Details &middot; <?php echo WEB_APP_NAME;?></title>
    <?php require_once('../includes/layouts/header_admin.php');?>
  </head>

  <body>


    <!-- Part 1: Wrap all page content here -->
    <div id="wrap">

      <!-- Fixed navbar -->
      <?php require_once('../includes/layouts/navbar_admin.php');?>
      
      <header class="jumbotron subhead">
		 <div class="container-fluid">
		   <h1>Bus Profile</h1>
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
	      <li class="active"><a href="#bus_personnel_list" data-toggle="tab">List of Personnel</a></li>
	      <li><a href="#bus_profile" data-toggle="tab">Bus Profile</a></li>
	    </ul>
	    
	    <div id="tab_content" class="tab-content">
	      	
	      	<div class="tab-pane fade" id="bus_profile">
	      	
	      	<form class="form-horizontal" action="admin_read_update_bus.php?busid=<?php echo $_GET['busid']; ?>" method="POST">
            
	            <div class="control-group">
            	<label for="route_id" class="control-label">Route Number</label>
	            <div class="controls">
	            	<select name="route_id">
					<?php foreach($routes as $route){ ?>
	            		<option value="<?php echo $route->id; ?>"<?php if ($bus_to_read_update->route_id == $route->id){ echo ' selected="selected"';} ?>><?php echo $route->route_number; ?></option>
	            	<?php } ?>
					</select>
	            </div>
            </div>
            
            <div class="control-group">
        	<label for="reg_number" class="control-label">Registration Number</label>
	        	<div class="controls">
	        		<input type="text" name="reg_number" value="<?php echo $bus_to_read_update->reg_number; ?>">
	        	</div>
        	</div>
            
            <div class="control-group">
            <label for="name" class="control-label">Name of Bus</label>
	            <div class="controls">
	            	<input type="text" name="name" value="<?php echo $bus_to_read_update->name; ?>">
	            </div>
            </div>
	            
	          	<div class="form-actions">
	        	    <button class="btn btn-primary" name="submit">Submit</button>
	        	</div>
	        </form>
	      
	      	</div>
	      
	      	<div class="tab-pane active in" id="bus_personnel_list">
	      	
	      	<div class="row-fluid">
      			<h4>List of Personnel</h4>
      			<br />
      		</div>
      		
      		<div class="row-fluid">
      		
      		<table class="table table-bordered table-hover">
	          <thead align="center">
		        <tr>
			        <td>Role</td>
			        <td>First Name</td>
			        <td>Last Name</td>
		        </tr>
		      </thead>
		      
		      <tbody align="center">
	        	
	        	<?php
	        	
	        	$sql  = 'SELECT * FROM buses_bus_personnel ';
	        	$sql .= 'WHERE bus_id = ' . $bus_to_read_update->id;
	        	
	        	$buses_bus_personnel = BusBusPersonnel::find_by_sql($sql);
	        	
	        	foreach($buses_bus_personnel as $bbp){ 
	        	
	        		$assigned_bus_personnel = BusPersonnel::find_by_id($bbp->bus_personnel_id);
	        		
	        		?>
	        		<tr>
		        		<td><?php echo BusPersonnelRole::find_by_id($assigned_bus_personnel->role)->role_name; ?></td>
		        		<td><?php echo $assigned_bus_personnel->first_name; ?></td>
		        		<td><?php echo $assigned_bus_personnel->last_name; ?></td>
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

    <?php require_once('../includes/layouts/footer_admin.php');?>

    <?php require_once('../includes/layouts/bootstrap_scripts_admin.php');?>

  </body>
</html>