<?php
require_once("../includes/initialize.php");

if (!$session->is_logged_in()){
	redirect_to("login.php");
} else {
	
	$admin_user = Admin::find_by_id($_SESSION['id']);
	$stops = BusStop::find_all();
	
	if (isset($_GET['stopid'])){
		$stop_to_read_update = BusStop::find_by_id($_GET['stopid']);
		
		$stops_routes = StopRoute::get_routes_for_stop($stop_to_read_update->id);
		
	} else {
		$session->message("No Stop ID provided to view.");
		redirect_to("admin_stops_list.php");
	}
	
	if (isset($_POST['submit'])){
		$route_to_read_update->route_number = $_POST['route_number'];
		$route_to_read_update->length = $_POST['length'];
		$route_to_read_update->trip_time = $_POST['trip_time'];
		$route_to_read_update->begin_stop = $_POST['begin_stop'];
		$route_to_read_update->end_stop = $_POST['end_stop'];
	
		if ($route_to_read_update->update()){
			$session->message("Success! The Route details were updated. ");
			redirect_to('admin_routes_list.php');
		} else {
			$session->message("Error! The Route details could not be updated. ");
		}
	}
	
}

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Route Details &middot; Photo Gallery</title>
    <?php require_once('../includes/layouts/header_admin.php');?>
  </head>

  <body>


    <!-- Part 1: Wrap all page content here -->
    <div id="wrap">

      <!-- Fixed navbar -->
      <?php require_once('../includes/layouts/navbar_admin.php');?>
      
      <header class="jumbotron subhead">
		 <div class="container-fluid">
		   <h1>Bus Stop Profile</h1>
		 </div>
	  </header>
      
      <!-- Begin page content -->
      
      <div class="container-fluid">
      
      <div class="row-fluid">
      
        <div class="span3">
	        <div class="sidenav" data-spy="affix" data-offset-top="200">
	        	<a href="admin_stops_list.php" class="btn btn-primary"> &larr; Back to Stops List</a>
	        </div>
        </div>
        
        <!-- Start Content -->

        <div class="span9">
        
        <section>
        
        <?php echo $session->message; ?>
        
        <ul class="nav nav-tabs">
	      <li class="active"><a href="#route_stops_list" data-toggle="tab">List of Routes</a></li>
	      <li><a href="#route_profile" data-toggle="tab">Bus Stop Profile</a></li>
	    </ul>
	    
	    <div id="tab_content" class="tab-content">
	      	
	      	<div class="tab-pane fade" id="route_profile">
	      	
	      	<form class="form-horizontal" action="admin_read_update_route.php?routeid=<?php echo $_GET['routeid']; ?>" method="POST">
            
	            <div class="control-group">
	            <label for="name" class="control-label">Name of Bus Stop</label>
		            <div class="controls">
		            	<input type="text" value="<?php echo $stop_to_read_update->name; ?>" name="name">
		            </div>
	            </div>
	            
	          	<div class="form-actions">
	        	    <button class="btn btn-primary" name="submit">Submit</button>
	        	</div>
	        </form>
	      
	      	</div>
	      
	      	<div class="tab-pane active in" id="route_stops_list">
	      		
	      		<div class="clearfix">&nbsp;</div>
	      		
	      		<div>
	      			<ul class="bus-stops-list">
	      				<li class=""><h4>List of Routes that pass through <? echo $stop_to_read_update->name; ?></h4></li>
	      				<li class="">&nbsp;</li>
	      				
	      				<?php for ($i = 0; $i < count($stops_routes); $i++){ ?>
	      				
	      				<? $route = BusRoute::find_by_id($stops_routes[$i]->route_id); ?>
			        		<li><a href="admin_read_update_route.php?routeid=<?php echo $route->id; ?>" class="btn btn-info"><?php echo $route->route_number; ?></a> going from <a href="admin_read_update_stop.php?stopid=<?php echo BusStop::find_by_id($route->begin_stop)->id; ?>" class="btn btn-info"><?php echo BusStop::find_by_id($route->begin_stop)->name; ?></a> to <a href="admin_read_update_stop.php?stopid=<?php echo BusStop::find_by_id($route->end_stop)->id; ?>" class="btn btn-info"><?php echo BusStop::find_by_id($route->end_stop)->name; ?></a></li>
			        		<li>&nbsp;</li>
		        		<?php } ?>
		        		
	      			</ul>
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