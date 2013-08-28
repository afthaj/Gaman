<?php
require_once("../includes/initialize.php");

if (!$session->is_logged_in()){
	redirect_to("login.php");
} else {
	
	$admin_user = Admin::find_by_id($_SESSION['id']);
	
	$roles = BusPersonnelRole::find_all();
	$buses = Bus::find_all();
	
	if (isset($_GET['personnelid'])){
		$bus_personnel_to_read_update = BusPersonnel::find_by_id($_GET['personnelid']);
		
	} else {
		$session->message("No Bus Personnel ID provided to view.");
		redirect_to("admin_list_bus_personnel.php");
	}
	
	if (isset($_POST['submit'])){
		$bus_personnel_to_read_update->role = $_POST['role'];
		$bus_personnel_to_read_update->first_name = $_POST['first_name'];
		$bus_personnel_to_read_update->last_name = $_POST['last_name'];
	
		if ($bus_personnel_to_read_update->update()){
			$session->message("Success! The Bus Personnel details were updated. ");
			redirect_to('admin_list_bus_personnel.php');
		} else {
			$session->message("Error! The Bus details could not be updated. ");
		}
	}
	
	if (isset($_POST['assign'])){
		
		$buses_bus_personnel_to_read_update = new BusBusPersonnel();
		
		$buses_bus_personnel_to_read_update->bus_id = $_POST['bus_id'];
		$buses_bus_personnel_to_read_update->bus_personnel_id = $bus_personnel_to_read_update->id;
	
		if ($buses_bus_personnel_to_read_update->create()){
			$session->message("Success! The Bus Personnel was assigned to the given Bus. ");
			redirect_to('admin_list_bus_personnel.php');
		} else {
			$session->message("Error! The Bus Personnel was not assigned to the given Bus. ");
		}
	}
	
}

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Bus Personnel Details &middot; <?php echo WEB_APP_NAME; ?></title>
    <?php require_once('../includes/layouts/header_admin.php');?>
  </head>

  <body>


    <!-- Part 1: Wrap all page content here -->
    <div id="wrap">

      <!-- Fixed navbar -->
      <?php require_once('../includes/layouts/navbar_admin.php');?>
      
      <header class="jumbotron subhead">
		 <div class="container-fluid">
		   <h1>Bus Personnel Profile</h1>
		 </div>
	  </header>
      
      <!-- Begin page content -->
      
      <div class="container-fluid">
      
      <div class="row-fluid">
      
        <div class="span3">
	        <div class="sidenav" data-spy="affix" data-offset-top="200">
	        	<a href="admin_list_bus_personnel.php" class="btn btn-primary"> &larr; Back to Bus Personnel List</a>
	        </div>
        </div>
        
        <!-- Start Content -->

        <div class="span9">
        
        <section>
        
        <?php echo $session->message; ?>
        
        <ul class="nav nav-tabs">
	      <li class="active"><a href="#assigned_buses_list" data-toggle="tab">Bus Assignment</a></li>
	      <li><a href="#personnel_profile" data-toggle="tab">Personnel Profile</a></li>
	    </ul>
	    
	    <div id="tab_content" class="tab-content">
	      	
	      	<div class="tab-pane fade" id="personnel_profile">
	      	
	      	<form class="form-horizontal" action="<?php echo $_SERVER['PHP_SELF']; ?>?personnelid=<?php echo $_GET['personnelid']; ?>" method="POST">
            
	            <div class="control-group">
            	<label for="role" class="control-label">Route Number</label>
	            <div class="controls">
	            	<select name="role">
					<?php foreach($roles as $role){ ?>
	            		<option value="<?php echo $role->id; ?>"<?php if ($bus_personnel_to_read_update->role == $role->id){ echo ' selected="selected"';} ?>><?php echo $role->role_name; ?></option>
	            	<?php } ?>
					</select>
	            </div>
            </div>
            
            <div class="control-group">
        	<label for="first_name" class="control-label">First Name</label>
	        	<div class="controls">
	        		<input type="text" name="first_name" value="<?php echo $bus_personnel_to_read_update->first_name; ?>" />
	        	</div>
        	</div>
            
            <div class="control-group">
            <label for="last_name" class="control-label">Last Name</label>
	            <div class="controls">
	            	<input type="text" name="last_name" value="<?php echo $bus_personnel_to_read_update->last_name; ?>" />
	            </div>
            </div>
	            
	          	<div class="form-actions">
	        	    <button class="btn btn-primary" name="submit">Submit</button>
	        	</div>
	        </form>
	      
	      	</div>
	      
	      	<div class="tab-pane active in" id="assigned_buses_list">
	      		
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
	        	
	        	$sql  = 'SELECT * FROM buses_bus_personnel ';
	        	$sql .= 'WHERE bus_personnel_id = ' . $bus_personnel_to_read_update->id;
	        	
	        	$buses_bus_personnel = BusBusPersonnel::find_by_sql($sql);
	        	
	        	foreach($buses_bus_personnel as $bbp){ 
	        	
	        		$assigned_bus = Bus::find_by_id($bbp->bus_id);
	        		
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
      		
      		<div class="row-fluid">
      		
      		<form class="form-horizontal" action="<?php echo $_SERVER['PHP_SELF']; ?>?personnelid=<?php echo $_GET['personnelid']; ?>" method="POST">
            
            <div class="control-group">
            <label for="bus_id" class="control-label">Assign to a  Bus</label>
	            <div class="controls">
	            	<select name="bus_id">
	            	<?php foreach($buses as $bus){ ?>
	            		<option value="<?php echo $bus->id; ?>"><?php echo BusRoute::find_by_id($bus->route_id)->route_number; ?> &middot; <?php echo $bus->reg_number; ?><?php if(!empty($bus->name)){ echo ' &middot; ' . $bus->name;} ?></option>
	            	<?php } ?>
					</select>
	            </div>
            </div>
	            
          	<div class="form-actions">
        	    <button class="btn btn-primary" name="assign">Assign</button>
        	</div>
	        </form>
      		
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