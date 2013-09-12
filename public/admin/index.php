<?php
require_once("../../includes/initialize.php");

if (!$session->is_logged_in()){
	//redirect_to("login.php");
} else {
	// object_type = 5 is admin, 4 is bus_personnel, 6 is commuter 
	 if ($_SESSION['object_type'] == 5 ){
		$user = AdminUser::find_by_id($_SESSION['id']);
		
		$p = new Photograph();
		$profile_picture = $p->get_profile_picture($session->object_type, $user->id);
		
	} else if ($_SESSION['object_type'] == 4 ){
		$user = BusPersonnel::find_by_id($_SESSION['id']);
		
		$p = new Photograph();
		$profile_picture = $p->get_profile_picture($session->object_type, $user->id);
		
	} else if ($_SESSION['object_type'] == 6 ){
		$user = Commuter::find_by_id($_SESSION['id']);
		
		$p = new Photograph();
		$profile_picture = $p->get_profile_picture($session->object_type, $user->id);
	}
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Admin Home &middot; <?php echo WEB_APP_NAME; ?></title>
    <?php require_once('../../includes/layouts/header_admin.php');?>
    
  </head>

  <body>
  
    <!-- Part 1: Wrap all page content here -->
    <div id="wrap">

      <!-- Fixed navbar -->
      <?php $page = 'index';?>
      <?php require_once('../../includes/layouts/navbar_admin.php');?>

      	<div class="jumbotron masthead">
		  <div class="container">
		    <h1><?php echo WEB_APP_NAME; ?></h1>
		    <p><?php echo WEB_APP_CATCH_PHRASE; ?></p>
		  </div>
		</div>
      
      <!-- Begin page content -->      
      <div class="container">

        <!-- Start Content -->
        
        <?php echo $session->message; ?>
        
        <div class="marketing">
        
        <div class="row-fluid">
        
        <div class="span4">
        <h2>Subheading 1</h2>
        <p class="lead">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin rhoncus consectetur lectus, sit amet semper nisi lacinia varius. Etiam a tempus eros, ac dictum nisl. Quisque eu dignissim metus. Fusce id pretium risus. Phasellus adipiscing elit in mi semper tincidunt. Nullam lorem tortor, dapibus et nisl ac, fringilla scelerisque sem. Praesent commodo ipsum ut congue elementum.</p>
        </div>
        
        <div class="span4">
        <h2>Subheading 2</h2>
        <p class="lead">Aenean aliquam leo libero, ut tempor lorem cursus vitae. Donec porttitor diam orci, nec mollis diam pulvinar a. In tempus fermentum libero tempus mollis. Vestibulum volutpat nulla sed neque consequat, vel venenatis magna vestibulum. Duis placerat quam non pretium congue.</p>
        </div>
        
        <div class="span4">
        <h2>Subheading 3</h2>
        <p class="lead">Aenean pharetra nisi a lorem tincidunt mattis. Quisque arcu eros, varius eu sapien sit amet, luctus volutpat neque. Maecenas turpis massa, ornare at ipsum ut, elementum cursus sem. Nunc ac lacus faucibus, lacinia nisl vel, venenatis metus. Curabitur luctus enim sapien, et euismod nisl mollis eu.</p>
        </div>
        
        </div>
        
        </div>
        <!-- End Content -->
        
      </div>

      <div id="push"></div>
    </div>

    <?php require_once('../../includes/layouts/footer_admin.php');?>

    <?php require_once('../../includes/layouts/scripts_admin.php');?>

  </body>
</html>
