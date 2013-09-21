<div class="navbar navbar-fixed-top navbar-invers">
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
          <li<?php if (!empty($page) && $page == 'index'){echo ' class="active"';}?>><a href="index.php"><i class="icon-home icon-white"></i></a></li>
          
          <li class="dropdown">
          	<a href="#" class="dropdown-toggle" data-toggle="dropdown">Bus Routes &amp; Stops <b class="caret"></b></a>
          	<ul class="dropdown-menu">
          		<li><a href="admin_list_stops.php"><i class="icon-info-sign icon-white"></i> View All Stops</a></li>
          		<?php if ($session->is_logged_in() && $session->object_type == 5) { ?>
          		<li><a href="admin_create_stop.php"><i class="icon-plus icon-white"></i> Add Bus Stop</a></li>
          		<?php } ?>
          		<li><a href="#"><i class="icon-search icon-white"></i> Search for Bus Stop</a></li>
          		<li class="divider"></li>
          		<li><a href="admin_list_routes.php"><i class="icon-info-sign icon-white"></i> View All Bus Routes</a></li>
          		<?php if ($session->is_logged_in() && $session->object_type == 5) { ?>
          		<li><a href="admin_create_route.php"><i class="icon-plus icon-white"></i> Add Bus Route</a></li>
          		<?php } ?>
          		<li><a href="#"><i class="icon-search icon-white"></i> Search for Bus Route</a></li>
          	</ul>
          </li>
          
          <li class="dropdown">
          	<a href="#" class="dropdown-toggle" data-toggle="dropdown">Buses &amp; Personnel<b class="caret"></b></a>
          	<ul class="dropdown-menu">
          		<li><a href="admin_list_bus_personnel.php"><i class="icon-info-sign icon-white"></i> View All Personnel</a></li>
          		<?php if ($session->is_logged_in() && $session->object_type == 5) { ?>
          		<li><a href="admin_create_bus_personnel.php"><i class="icon-plus icon-white"></i> Add Personnel</a></li>
          		<?php } ?>
          		<li><a href="#"><i class="icon-search icon-white"></i> Search for Personnel</a></li>
          		<li class="divider"></li>
          		<li><a href="admin_list_buses.php"><i class="icon-info-sign icon-white"></i> View All Buses</a></li>
          		<?php if ($session->is_logged_in() && $session->object_type == 5) { ?>
          		<li><a href="admin_create_bus.php"><i class="icon-plus icon-white"></i> Add Bus</a></li>
          		<?php } ?>
          		<li><a href="#"><i class="icon-search icon-white"></i> Search for Bus</a></li>
          	</ul>
          </li>
          
          <li class="dropdown">
          	<a href="#" class="dropdown-toggle" data-toggle="dropdown">Complaints <b class="caret"></b></a>
          	<ul class="dropdown-menu">
          		<li><a href="admin_list_complaints.php"><i class="icon-info-sign icon-white"></i> View All Complaints</a></li>
          		<li><a href="admin_create_complaint.php"><i class="icon-plus icon-white"></i> Add Complaint</a></li>
          		<li><a href="#"><i class="icon-search icon-white"></i> Search for Complaint</a></li>
          	</ul>
          </li>
          
          <li<?php if (!empty($page) && $page == 'test'){echo ' class="active"';}?>><a href="test.php">Test Page</a></li>

        </ul>
        <ul class="nav navbar-nav pull-right">
          
          <li><a href="<?php echo '..'.DS; ?>">Public Area</a></li>
          
          <?php if (!empty($session->id) && ($session->object_type == 5 || $session->object_type == 4) ) { // object_type 5 is admin and 4 is bus_personnel ?>
          	<li class="dropdown">
          	<a href="#" class="dropdown-toggle" data-toggle="dropdown">
          	<i class="icon-user icon-white"></i> <?php if (!empty($user->id)) { echo $user->full_name(); } ?> <b class="caret"></b>
          	</a>
          	<ul class="dropdown-menu">
          		<li><a href="admin_view_profile.php"><i class="icon-wrench icon-white"></i> View Profile</a></li>
          		<li><a href="logout.php"><i class="icon-off icon-white"></i> Logout</a></li>
          		<?php if ($session->is_logged_in() && $session->object_type == 5) { ?>
          		<li class="divider"></li>
          		<li><a href="admin_list_admin_users.php"><i class="icon-info-sign icon-white"></i> View All Admin Users</a></li>
          		<li><a href="admin_create_admin_user.php"><i class="icon-plus icon-white"></i> Add Admin User</a></li>
          		<li><a href="#"><i class="icon-search icon-white"></i> Search for Admin User</a></li>
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