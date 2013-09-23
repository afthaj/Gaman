<?php
require_once("../includes/initialize.php");

//init code
$photo_object = new Photograph();
$commuter_object = new Commuter();

$stop_route_object = new StopRoute();

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
    <title>Home &middot; <?php echo WEB_APP_NAME; ?></title>
    <?php require_once('../includes/layouts/header.php');?>
    
    <script>
    $(document).ready(function() {
	  $('.typeahead').typeahead({
	    name: 'name',
	    prefetch: './ajax_files/get_stops.php',
	    limit: 5
	  		});
	});

	</script>
	
	<script type="text/javascript">

	function findBusRoute(from, to, search_results) {
		
		if (from == "" || to == "") {
			search_results.innerHTML = "";
			return;
			}
			
		if (window.XMLHttpRequest) {
			// code for IE7+, Firefox, Chrome, Opera, Safari
			request = new XMLHttpRequest();
			
			} else {
				// code for IE6, IE5
				request = new ActiveXObject("Microsoft.XMLHTTP");
				
				}
				
		request.onreadystatechange = function() {
			
			if (request.readyState == 4 && request.status == 200) {
				related_object_id.innerHTML = request.responseText;
				}
			
			}

		request.open("GET","ajax_files/search_for_stops.php?f=" + from + "&t=" + to, true);
		
		request.send();

				
		}	

	</script>
    
  </head>

  <body>
  
    <!-- Part 1: Wrap all page content here -->
    <div id="wrap">

      <!-- Fixed navbar -->
      <?php $page = 'index';?>
      <?php require_once('../includes/layouts/navbar.php');?>

      	<div class="jumbotron masthead">
		  <div class="container">
		    <h1><?php echo WEB_APP_NAME; ?></h1>
		    <h3><?php echo WEB_APP_CATCH_PHRASE; ?></h3>
		    <br />
		    
		    <div>
			    <input type="text" class="typeahead" placeholder="From" id="from" />
			    <input type="text" class="typeahead" placeholder="To" id="to" />
	        	<br />
	        	<button class="btn btn-primary" onClick="findBusRoute(document.getElementById('from'), document.getElementById('to'), document.getElementById('bus_route_search_results'))">Find Bus Route</button>
        	</div>
        	
        	<div class="" id="bus_route_search_results">
        	</div>
        	
		  </div>
		</div>
      
      <!-- Begin page content -->      
      <div class="container">

        <!-- Start Content -->
        
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
        
        <div class="marketing">
        
        <div class="row-fluid">
        
        <div class="" id="bus_route_search_results">
        </div>
        
        </div>
        
        </div>
        <!-- End Content -->
        
      </div>

      <div id="push"></div>
    </div>

    <?php require_once('../includes/layouts/footer.php');?>
    
    <?php require_once('../includes/layouts/scripts.php');?>

  </body>
</html>
