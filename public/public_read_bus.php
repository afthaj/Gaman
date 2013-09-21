<?php
require_once("../includes/initialize.php");

//init code
$photo_object = new Photograph();
$commuter_object = new Commuter();
$photo_type_object = new PhotoType();
$bus_object = new Bus();
$bus_personnel_role_object = new BusPersonnelRole();
$bus_bus_personnel_object = new BusBusPersonnel();
$bus_personnel_object = new BusPersonnel();

$routes = BusRoute::find_all();
$buses = Bus::find_all();
$bus_personnel = BusPersonnel::find_all();

$photo_types = $photo_type_object->get_photo_types("bus");
$photos_of_bus = $photo_object->get_photos(3, $_GET['busid']);

//GET request stuff
if (!empty($_GET['busid'])){
	$bus_to_read_update = $bus_object->find_by_id($_GET['busid']);

} else {
	$session->message("No Bus ID provided to view.");
	redirect_to("public_list_buses.php");
}

//check login
if ($session->is_logged_in()){
	
	if ($session->object_type == 6){
		//commuter
		
		$user = $commuter_object->find_by_id($_SESSION['id']);
		$profile_picture = $photo_object->get_profile_picture($session->object_type, $user->id);
		
	}
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
	        	<a href="public_list_buses.php" class="btn btn-primary btn-block"><i class="icon-arrow-left icon-white"></i> Back to List of Buses</a>
	        </div>
        </div>
        
        <!-- Start Content -->

        <div class="span9">
        
        <section>
        
        <?php 
        
        if(!empty($session->message)){
        	
        	echo '<div class="alert">';
        	echo '<button type="button" class="close" data-dismiss="alert">&times;</button>';
        	//echo '<p>';
        	echo $session->message;
        	//echo '</p>';
        	echo '</div>';
        }
        
        ?>
        
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
		      
		      $buses_bus_personnel = $bus_bus_personnel_object->get_personnel_for_bus($bus_to_read_update->id);
		      
		      if ($buses_bus_personnel) { ?>
		      
		      <table class="table table-bordered table-hover">
	          <thead align="center">
		        <tr>
			        <td>Profile Picture</td>
			        <td>Name</td>
			        <td>Role</td>
		        </tr>
		      </thead>
		      
		      <tbody align="center">
		      
		      <?php foreach($buses_bus_personnel as $bbp){
		      	
		      	$assigned_bus_personnel = $bus_personnel_object->find_by_id($bbp->bus_personnel_id);
		      	
		      	?>
	        		<tr>
		        		<td>
	        			<?php 
		        		
		        		$bus_personnel_profile_picture = $photo_object->get_profile_picture(4, $assigned_bus_personnel->id);
		        		
		        		if (!empty($bus_personnel_profile_picture->filename)) {
		        			echo '<a href="public_read_bus_personnel.php?personnelid=' . $assigned_bus_personnel->id . '"><img src="../' . $bus_personnel_profile_picture->image_path() . '" width="100" class="img-rounded" /></a>';
		        		} else {
		        			echo '<img src="img/default-prof-pic.jpg" width="100" class="img-rounded" alt="Please upload a profile picture" />';
		        		}
		        		
		        		?>
	        			</td>
	        			<td><a href="public_read_bus_personnel.php?personnelid=<?php echo $assigned_bus_personnel->id; ?>" class="btn btn-info btn-block"><?php echo $assigned_bus_personnel->full_name(); ?></a></td>
		        		<td>
		        		<?php
			        	
		        		echo $bus_personnel_role_object->find_by_id($assigned_bus_personnel->role)->role_name;
		        		
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
					<p class="caption"><?php echo $photo_type_object->find_by_id($photos_of_bus[$i]->photo_type)->photo_type_name; ?></p>
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