<?php
require_once("./includes/initialize.php");

//init code
$photo_object = new Photograph();
$commuter_object = new Commuter();
$stop = new BusStop();
$route_object = new BusRoute();

//pagination code
$current_page = !empty($_GET['page']) ? (int)$_GET['page'] : 1;
$per_page = 20;
$total_count = $route_object->count_all();
$pagination = new Pagination($current_page, $per_page, $total_count);

//$routes = BusRoute::find_all();

$sql  = "SELECT * FROM routes";
$sql .= " LIMIT " . $per_page;
$sql .= " OFFSET " . $pagination->offset();

$routes = $route_object->find_by_sql($sql);

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
    <title>Routes List &middot; <?php echo WEB_APP_NAME; ?></title>
    <?php require_once('./includes/layouts/header.php');?>
  </head>

  <body>


    <!-- Part 1: Wrap all page content here -->
    <div id="wrap">

      <!-- Fixed navbar -->
      <?php require_once('./includes/layouts/navbar.php');?>
      
      <header class="jumbotron subhead">
		 <div class="container-fluid">
		   <h1>List of Bus Routes</h1>
		 </div>
	  </header>

      <!-- Begin page content -->
        
      <!-- Start Content -->
      
      <div class="container-fluid">
        
        <div class="row-fluid">
        
        <div class="span12">
        
        <section>
        
        <table class="table table-bordered table-hover">
          <thead>
	        <tr align="center">
		        <td>Route Number</td>
		        <td>Begin Stop</td>
		        <td>End Stop</td>
		        <td>Length (km)</td>
		        <td>Trip Time</td>
		        <td>&nbsp;</td>
	        </tr>
	      </thead>
	      <tbody>
        	
        	<?php foreach($routes as $route){ ?>
        		<tr align="center">
	        		<td><?php echo $route->route_number; ?></td>
	        		<td><?php echo $stop->find_by_id($route->begin_stop)->name; ?></td>
	        		<td><?php echo $stop->find_by_id($route->end_stop)->name; ?></td>
	        		<td><?php echo $route->length; ?></td>
	        		<td><?php echo format_trip_time($route->trip_time); ?></td>
	        		<td><a href="public_read_route.php?routeid=<?php echo $route->id; ?>" class="btn btn-warning btn-block"><i class="icon-info-sign icon-white"></i> Route Profile</a></td>        		
        		</tr>
        	<?php }?>
        	
          </tbody>
          
        </table>
        
        </section>
        
        </div>
        
        </div>
        
        <!-- Start Pagination -->
        
		<?php 
		if ($pagination->total_pages() > 1){
			
			echo '<div class="span12 pagination pagination-centered">';
			echo '<ul>';
			
			echo $pagination->has_previous_page() ? '<li><a href="' . $_SERVER['PHP_SELF'] . '?page='.$pagination->previous_page().'">&laquo;</a></li>' : '<li class="disabled"><a href="">&laquo;</a></li>';
			
			for ($i=1; $i <= $pagination->total_pages(); $i++) {
				
				echo '<li';
				echo $i == $pagination->current_page ? ' class="active"' : '';
				echo '>';
				echo '<a href="' . $_SERVER['PHP_SELF'] . '?page=';
				echo $i;
				echo '">'.$i.'</a>';
				echo '</li>';
				
			}
			
			echo $pagination->has_next_page() ? '<li><a href="' . $_SERVER['PHP_SELF'] . '?page='.$pagination->next_page().'">&raquo;</a></li>' : '<li class="disabled"><a href="">&raquo;</a></li>';
			
			echo '</ul>';
			echo '</div>';
		}
		?>
		
		<!-- End Pagination -->
        
      </div>
      <!-- End Content -->
      
      <div class="clearfix">&nbsp;</div>

      <div id="push"></div>
    </div>

    <?php require_once('./includes/layouts/footer.php');?>

    <?php require_once('./includes/layouts/scripts.php');?>

  </body>
</html>
