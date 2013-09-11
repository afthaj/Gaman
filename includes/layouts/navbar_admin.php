<div class="navbar navbar-fixed-top">
  <div class="navbar-inner">
    <div class="container-fluid">
      
      <a class="btn btn-navbar" data-toggle="collapse" data-target=".navbar-responsive-collapse">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </a>

      <a class="brand" href="index.php"><?php echo WEB_APP_NAME;?></a>
      
      <div class="nav-collapse collapse navbar-responsive-collapse">
        <ul class="nav navbar-nav">
          <li<?php if (isset($page) && $page == 'index'){echo ' class="active"';}?>><a href="index.php">Home</a></li>
          
          <li class="dropdown">
          	<a href="#" class="dropdown-toggle" data-toggle="dropdown">Bus Routes &amp; Stops <b class="caret"></b></a>
          	<ul class="dropdown-menu">
          		<li><a href="admin_list_stops.php">View All Stops</a></li>
          		<?php if ($session->is_logged_in() && $session->object_type == 5) { ?>
          		<li><a href="admin_create_stop.php">Add Bus Stop</a></li>
          		<?php } ?>
          		<li><a href="#">Search for Bus Stop</a></li>
          		<li class="divider"></li>
          		<li><a href="admin_list_routes.php">View All Bus Routes</a></li>
          		<?php if ($session->is_logged_in() && $session->object_type == 5) { ?>
          		<li><a href="admin_create_route.php">Add Bus Route</a></li>
          		<?php } ?>
          		<li><a href="#">Search for Bus Route</a></li>
          	</ul>
          </li>
          
          <li class="dropdown">
          	<a href="#" class="dropdown-toggle" data-toggle="dropdown">Buses &amp; Personnel<b class="caret"></b></a>
          	<ul class="dropdown-menu">
          		<li><a href="admin_list_bus_personnel.php">View All Personnel</a></li>
          		<?php if ($session->is_logged_in() && $session->object_type == 5) { ?>
          		<li><a href="admin_create_bus_personnel.php">Add Personnel</a></li>
          		<?php } ?>
          		<li><a href="#">Search for Personnel</a></li>
          		<li class="divider"></li>
          		<li><a href="admin_list_buses.php">View All Buses</a></li>
          		<?php if ($session->is_logged_in() && $session->object_type == 5) { ?>
          		<li><a href="admin_create_bus.php">Add Bus</a></li>
          		<?php } ?>
          		<li><a href="#">Search for Bus</a></li>
          	</ul>
          </li>
          
          <li class="dropdown">
          	<a href="#" class="dropdown-toggle" data-toggle="dropdown">Complaints <b class="caret"></b></a>
          	<ul class="dropdown-menu">
          		<li><a href="admin_list_complaints.php">View All Complaints</a></li>
          		<li><a href="admin_create_complaint.php">Add Complaint</a></li>
          		<li><a href="#">Search for Complaint</a></li>
          	</ul>
          </li>
          
          <li<?php if (isset($page) && $page == 'test'){echo ' class="active"';}?>><a href="test.php">Test Page</a></li>

        </ul>
        <ul class="nav navbar-nav pull-right">
          
          <li><a href="<?php echo '..'.DS; ?>">Public Area</a></li>
          
          <?php if (isset($session->id) && ($session->object_type == 5 || $session->object_type == 4) ) { // object_type 5 is admin and 4 is bus_personnel ?>
          	<li class="dropdown">
          	<a href="#" class="dropdown-toggle" data-toggle="dropdown">
          	<?php
          	
          	echo $user->full_name(); ?> <b class="caret"></b>
          	</a>
          	<ul class="dropdown-menu">
          		<li><a href="admin_view_profile.php">View Profile</a></li>
          		<li><a href="logout.php">Logout</a></li>
          		<?php if ($session->is_logged_in() && $session->object_type == 5) { ?>
          		<li class="divider"></li>
          		<li><a href="admin_list_admin_users.php">View All Admin Users</a></li>
          		<li><a href="admin_create_admin_user.php">Add Admin User</a></li>
          		<li><a href="#">Search for Admin User</a></li>
          		<?php } ?>
          	</ul>
          	</li>
          <?php } else { ?>
          	<li><a href="login.php">Login</a></li>
          <?php } ?>
          
        </ul>
      </div><!--/.nav-collapse -->
      
    </div>
  </div>
</div>