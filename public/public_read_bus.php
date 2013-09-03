<?php
require_once("../includes/initialize.php");

if ($session->is_logged_in() && $session->object_type == 6){

	$user = Commuter::find_by_id($_SESSION['id']);
	$p = new Photograph();
	$profile_picture = $p->get_profile_picture($user->id, "commuter");


} else if ($session->is_logged_in() && $session->object_type != 6) {

	//redirect_to("login.php");

}

$routes = BusRoute::find_all();
$buses = Bus::find_all();
$bus_personnel = BusPersonnel::find_all();

$related_object = "bus";
$pt = new PhotoType();
$photo_types = $pt->get_photo_types($related_object);

$p2 = new Photograph();
$photos_of_bus = $p2->get_photos_for_bus($_GET['busid']);

if (isset($_GET['busid'])){
	$bus_to_read_update = Bus::find_by_id($_GET['busid']);

} else {
	$session->message("No Bus ID provided to view.");
	redirect_to("public_list_buses.php");
}

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Bus Details &middot; <?php echo WEB_APP_NAME;?></title>
    <?php require_once('../includes/layouts/header.php');?>
  </head>

  <body>


    <!-- Part 1: Wrap all page content here -->
    <div id="wrap">

      <!-- Fixed navbar -->
      <?php require_once('../includes/layouts/navbar.php');?>
      
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
	        	<a href="public_list_buses.php" class="btn btn-primary"> &larr; Back to Buses List</a>
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
	      	
	      	<form class="form-horizontal" action="" method="POST">
            
	            <div class="control-group">
            	<label for="route_id" class="control-label">Route Number</label>
	            <div class="controls">
	            	<select name="route_id" disabled >
					<?php foreach($routes as $route){ ?>
	            		<option value="<?php echo $route->id; ?>"<?php if ($bus_to_read_update->route_id == $route->id){ echo ' selected="selected"';} ?>><?php echo $route->route_number; ?></option>
	            	<?php } ?>
					</select>
	            </div>
            </div>
            
            <div class="control-group">
        	<label for="reg_number" class="control-label">Registration Number</label>
	        	<div class="controls">
	        		<input type="text" name="reg_number" disabled value="<?php echo $bus_to_read_update->reg_number; ?>" />
	        	</div>
        	</div>
            
            <div class="control-group">
            <label for="name" class="control-label">Name of Bus</label>
	            <div class="controls">
	            	<input type="text" name="name" disabled value="<?php echo $bus_to_read_update->name; ?>">
	            </div>
            </div>
            
	        </form>
	      
	      	</div>
	      
	      	<div class="tab-pane fade" id="bus_personnel_list">
	      	
	      	<div class="row-fluid">
      			<h4>List of Personnel</h4>
      			<br />
      		</div>
      		
      		<div class="row-fluid">
      		
		      <?php 
		      
		      $bbp_object = new BusBusPersonnel();
		      $buses_bus_personnel = $bbp_object->get_personnel_for_bus($bus_to_read_update->id);
		      
		      if ($buses_bus_personnel) { ?>
		      
		      <table class="table table-bordered table-hover">
	          <thead align="center">
		        <tr>
			        <td>Profile Picture</td>
			        <td>First Name</td>
			        <td>Last Name</td>
			        <td>Role</td>
		        </tr>
		      </thead>
		      
		      <tbody align="center">
		      
		      <?php foreach($buses_bus_personnel as $bbp){
		      
		      	$bus_personnel_object = new BusPersonnel();
		      	$assigned_bus_personnel = $bus_personnel_object->find_by_id($bbp->bus_personnel_id);
		      	
		      	?>
	        		<tr>
		        		<td>
	        			<?php 
	        			
		        		$pic = new Photograph();
		        		
		        		$bus_personnel_profile_picture = $pic->get_profile_picture($assigned_bus_personnel->id, "bus_personnel");
		        		
		        		if (!empty($bus_personnel_profile_picture->filename)) {
		        			echo '<img src="../' . $bus_personnel_profile_picture->image_path() . '" width="100" class="img-rounded" />';
		        		} else {
		        			echo '<img src="img/default-prof-pic.jpg" width="100" class="img-rounded" alt="Please upload a profile picture" />';
		        		}
		        		
		        		?>
	        			</td>
	        			<td><?php echo $assigned_bus_personnel->first_name; ?></td>
		        		<td><?php echo $assigned_bus_personnel->last_name; ?></td>
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
	      	
	   		</div>
	   		
	   		<div class="tab-pane active in" id="bus_pictures">

			<?php if (!empty($photos_of_bus)) { ?>
				<div class="callbacks_container">
		        <ul class="rslides" id="responsive_slider">
		        
		        <?php for ( $i = 0; $i < count($photos_of_bus); $i++ ) { ?>
		        
					<li>
					<img src="<?php echo '../'.$photos_of_bus[$i]->image_path(); ?>" alt="">
					<p class="caption"><?php echo PhotoType::find_by_id($photos_of_bus[$i]->photo_type)->photo_type_name; ?></p>
					</li>
				
		        <?php } ?>
		        
		        </ul>
		        </div>
			      
			<?php } else { ?>
			
			<h5>No photos of the Bus have been uploaded yet!</h5>
			<br /><br />
			<?php } ?>
	  	
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
    
    <?php require_once('../includes/layouts/scripts.php');?>
    
    <?php require_once('../includes/layouts/footer.php');?>
    
  </body>
</html>