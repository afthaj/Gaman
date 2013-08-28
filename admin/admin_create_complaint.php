<?php
require_once("../includes/initialize.php");

if (!$session->is_logged_in()){
	redirect_to("login.php");
} else {
	$admin_user = Admin::find_by_id($_SESSION['id']);
	
	$routes = BusRoute::find_all();
	$stops = BusStop::find_all();
	$buses = Bus::find_all();
	$bus_personnel = BusPersonnel::find_all();
	$complaint_types = ComplaintType::find_all();
	$complaint_status = ComplaintStatus::find_all();
	
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Complaints &middot; <?php echo WEB_APP_NAME; ?></title>
    <?php require_once('../includes/layouts/header_admin.php');?>
  </head>

  <body>


    <!-- Part 1: Wrap all page content here -->
    <div id="wrap">

      <!-- Fixed navbar -->
      <?php $page = 'complaints';?>
      <?php require_once('../includes/layouts/navbar_admin.php');?>

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
       	  	<form action="admin_create_complaint.php" method="POST" class="form-horizontal">
            
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
	            
	            <div class="control-group">
	            <label for="bus_route_id" class="control-label">Bus Route</label>
		            <div class="controls">
		            	<select name="bus_route_id">
						  <?php foreach($routes as $route){ ?>
		            		<option value="<?php echo $route->id; ?>"><?php echo $route->route_number; ?></option>
		            	<?php } ?>
						</select>
		            </div>
		            
	            </div>
	            
	            <div class="control-group">
	            <label for="stop_id" class="control-label">Bus Stop</label>
		            <div class="controls">
		            	<select name="stop_id">
						<?php foreach($stops as $stop){ ?>
		            		<option value="<?php echo $stop->id; ?>"><?php echo $stop->name; ?></option>
		            	<?php } ?>
						</select>
		            </div>
	            </div>
	            
	            <div class="control-group">
	            <label for="bus_id" class="control-label">Bus</label>
		            <div class="controls">
		            	<select name="bus_id">
						  <?php foreach($buses as $bus){ ?>
						  	<option value="<?php echo $bus->id; ?>"><?php echo $bus->reg_number; ?></option>
						  <?php } ?>
						</select>
		            </div>
	            </div>
	            
	            <div class="control-group">
	            <label for="bus_personnel_id" class="control-label">Bus Personnel</label>
		            <div class="controls">
		            	<select name="bus_personnel_id">
		            	<?php foreach($bus_personnel as $bp){ ?>
							<option value="<?php echo $bp->id; ?>"><?php echo $bp->first_name . ' ' . $bp->last_name; ?></option>
						<?php } ?>
						</select>
		            </div>
	            </div>
	            
	            <div class="control-group">
	            <label for="status" class="control-label">Complaint Status</label>
		            <div class="controls">
		            	<select name="status">
						<?php foreach($complaint_status as $comp_status){ ?>
							<option value="<?php echo $comp_status->id; ?>"><?php echo $comp_status->comp_status_name; ?></option>
						<?php } ?>
						</select>
		            </div>
	            </div>
	            
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

    <?php require_once('../includes/layouts/footer_admin.php');?>

    <?php require_once('../includes/layouts/bootstrap_scripts_admin.php');?>

  </body>
</html>
