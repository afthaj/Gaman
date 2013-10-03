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

$commuters = $commuter_object->find_all();

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
		
		//if (from == "" || to == "") {
			//search_results.innerHTML = "";
			//return;
			//}
			
		
		var from_encoded = encodeURI(from.value);
		var to_encoded = encodeURI(to.value);

		var search_url = "ajax_files/search_for_stops.php?f=";
			search_url += from_encoded;
			search_url += "&t=";
			search_url += to_encoded;

		//document.write(search_url);
			
		if (window.XMLHttpRequest) {
			// code for IE7+, Firefox, Chrome, Opera, Safari
			request = new XMLHttpRequest();
			
			} else {
				// code for IE6, IE5
				request = new ActiveXObject("Microsoft.XMLHTTP");
				
				}
				
		request.onreadystatechange = function() {
			
			if (request.readyState == 4 && request.status == 200) {
				search_results.innerHTML = request.responseText;
				}
			
			}

		request.open("GET",search_url, true);
		
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
        
        <div class="row">
        
        <div id="bus_route_search_results" class="search-results">
        </div>
        
        <hr />
        
        <div class="marketing">
        
        <div class="row">
        
        <h2>Hello!</h2>

		<p>My name is <a href="https://twitter.com/afthaj" class="" target="_blank">Aftha Jaldin</a> and I'm a Final Year Research Student at the University of Colombo School of Computing following a degree in Information and Communication Technology (wow, that's a mouthful!). My chosen area of research for the final year project is the Bus Passenger Transportation System in the Western Province of Sri Lanka.</p> 
		
		<p>As regular commuters, you use the bus transportation system in Colombo daily and know the ins-and-outs, the shortfalls and the shortcuts of the system. Therefore, I need your help in doing my research project.</p>
		
		<p>I have created this prototype system (tentatively named "Gaman") to test the usability and the various functionality needed in system such as this. It aims to be an information portal and a means of providing feedback to the people who manage and regulate the bus service. It also has a Bus Route Finder which is still in its prototype stage. (shout-out to <a href="https://twitter.com/chav_" class="" target="_blank">@chav_</a> for the help given). After using the system, I would like you to complete a simple survey about your experience in using the system. The Survey can be accessed via the "Survey Info" link in the main navigation bar at the top of every page.</p>
		
		<p>Please feel free to give as much input to the survey as you can, it will only help my research efforts.</p>
		
		<p>I thank you in advance and hope you succeed in whatever you do in life!</p> 
		
		<p>P.S.: did I tell you? you are awesome!</p>
        
        </div>
        
        <div class="">
        
	        <table class="span6 table table-bordered table-hover h-center">
	        	
	        	<thead>
		        <tr>
		        <td colspan="4" align="center"><h4>Login Credentials</h4></td>
		        </tr>
		        
		        <tr align="center">
		        <td>Username</td>
		        <td>Password</td>
		        <td>First Name</td>
		        <td>Last Name</td>
		        </tr>
		        </thead>
		        
		        <tbody>
		        <?php foreach ($commuters as $commuter) { ?>
		        <tr align="center">
		        <td><?php echo $commuter->username; ?></td>
		        <td><?php echo $commuter->password; ?></td>
		        <td><?php echo $commuter->first_name; ?></td>
		        <td><?php echo $commuter->last_name; ?></td>
		        </tr>
		        <?php } ?>
		        </tbody>
	        
	        </table>
	        
	        <div class="alert alert-info span6 h-center">In order to use the Feedback and Complaints Functionalities, you will need to login</div>
        
        </div>
        
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
