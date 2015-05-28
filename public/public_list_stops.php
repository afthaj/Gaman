<?php
require_once("../includes/initialize.php");

//pagination code
$current_page = !empty($_GET['page']) ? (int)$_GET['page'] : 1;
$per_page = 30;
$total_count = $stop_object->count_all();
$pagination = new Pagination($current_page, $per_page, $total_count);

$sql  = "SELECT * FROM stops";
$sql .= " LIMIT " . $per_page;
$sql .= " OFFSET " . $pagination->offset();

$stops = $stop_object->find_by_sql($sql);

//check login
if ($session->is_logged_in()){
	
	if ($session->object_type == 6) {
		//commuter
	
		$user = $commuter_object->find_by_id($_SESSION['id']);
		$profile_picture = $photo_object->get_profile_picture($session->object_type, $user->id);
	
	}
	
}

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Stops List &middot; <?php echo WEB_APP_NAME; ?></title>
    <?php require_once('../includes/layouts/header.php');?>
  </head>

  <body>


    <!-- Part 1: Wrap all page content here -->
    <div id="wrap">

      <!-- Fixed navbar -->
      <?php require_once('../includes/layouts/navbar.php');?>
      
      <header class="jumbotron subhead">
		 <div class="container-fluid">
		   <h1>List of Bus Stops</h1>
		 </div>
	  </header>

      <!-- Begin page content -->

      <!-- Start Content -->
      
      <div class="container-fluid">
      
      <!-- Start Pagination -->
        
		<?php 
		if ($pagination->total_pages() > 1){
			
			echo '<div class="pagination pagination-centered">';
			echo '<ul>';
			
			echo $pagination->has_previous_page() ? '<li><a href="' . $_SERVER['REQUEST_URI'] . '?page='.$pagination->previous_page().'">&laquo;</a></li>' : '<li class="disabled"><a href="">&laquo;</a></li>';
			
			for ($i=1; $i <= $pagination->total_pages(); $i++) {
				
				echo '<li';
				echo $i == $pagination->current_page ? ' class="active"' : '';
				echo '>';
				echo '<a href="' . $_SERVER['REQUEST_URI'] . '?page=';
				echo $i;
				echo '">'.$i.'</a>';
				echo '</li>';
				
			}
			
			echo $pagination->has_next_page() ? '<li><a href="' . $_SERVER['REQUEST_URI'] . '?page='.$pagination->next_page().'">&raquo;</a></li>' : '<li class="disabled"><a href="">&raquo;</a></li>';
			
			echo '</ul>';
			echo '</div>';
		}
		?>
		
		<!-- End Pagination -->
      
      <div class="row-fluid">
      
      <div class="span12">
      
      <section>
      
      <!-- add in a select/search box to choose the route, so that users can easily choose the stop -->
      
      <table class="table table-bordered table-hover">  
      
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
      
      <tr>
	   <td rowspan="2" align="center">Stop Name</td>
	   <td colspan="2" align="center">Coordinates</td>
	   <td rowspan="2">&nbsp;</td>
      </tr>
      
      <tr align="center">
      	<td>Latitude</td>
      	<td>Longitude</td>
      </tr>
       
      <?php foreach($stops as $stop){ ?>
      <tr>
	  	<td align="left"><?php echo $stop->name; ?></td>
	  	<td align="center"><?php echo $stop->location_latitude; ?></td>
	  	<td align="center"><?php echo $stop->location_longitude; ?></td>
      	<td><a href="public_read_stop.php?stopid=<?php echo $stop->id; ?>" class="btn btn-warning btn-block"><i class="icon-info-sign icon-white"></i> View Details</a></td>
      </tr>
      <?php }?>
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

    <?php require_once('../includes/layouts/footer.php');?>

    <?php require_once('../includes/layouts/scripts.php');?>

  </body>
</html>
