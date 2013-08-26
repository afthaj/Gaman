<div class="navbar navbar-fixed-top">
  <div class="navbar-inner">
    <div class="container-fluid">
      
      <a class="btn btn-navbar" data-toggle="collapse" data-target=".navbar-responsive-collapse">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </a>

      <a class="brand" href="index.php"> Gaman</a>
      
      <div class="nav-collapse collapse navbar-responsive-collapse">
        <ul class="nav navbar-nav">
          <li<?php if (isset($page) && $page == index){echo ' class="active"';}?>><a href="index.php">Home</a></li>
          <li class="dropdown">
          	<a href="#" class="dropdown-toggle" data-toggle="dropdown">Admin <b class="caret"></b></a>
          	<ul class="dropdown-menu">
          		<li><a href="admin_admin_users_list.php">View All Admin Users</a></li>
          		<li><a href="admin_create_admin_user.php">Add Admin User</a></li>
          		<li><a href="#">Search for Admin User</a></li>
          	</ul>
          </li>
          <li class="dropdown">
          	<a href="#" class="dropdown-toggle" data-toggle="dropdown">Bus Routes <b class="caret"></b></a>
          	<ul class="dropdown-menu">
          		<li><a href="admin_routes_list.php">View All Bus Routes</a></li>
          		<li><a href="admin_create_route.php">Add Bus Route</a></li>
          		<li><a href="#">Search for Bus Route</a></li>
          	</ul>
          </li>
          <li class="dropdown">
          	<a href="#" class="dropdown-toggle" data-toggle="dropdown">Bus Stops <b class="caret"></b></a>
          	<ul class="dropdown-menu">
          		<li><a href="admin_stops_list.php">View All Stops</a></li>
          		<li><a href="admin_create_stop.php">Add Bus Stop</a></li>
          		<li><a href="">Search for Bus Stop</a></li>
          	</ul>
          </li>
          <li class="dropdown">
          	<a href="#" class="dropdown-toggle" data-toggle="dropdown">Buses <b class="caret"></b></a>
          	<ul class="dropdown-menu">
          		<li><a href="admin_buses_list.php">View All Buses</a></li>
          		<li><a href="admin_create_bus.php">Add Bus</a></li>
          		<li><a href="">Search for Bus</a></li>
          	</ul>
          </li>
          <li class="dropdown">
          	<a href="#" class="dropdown-toggle" data-toggle="dropdown">Personnel <b class="caret"></b></a>
          	<ul class="dropdown-menu">
          		<li><a href="">View All Personnel</a></li>
          		<li><a href="">Add Personnel</a></li>
          		<li><a href="">Search for Personnel</a></li>
          	</ul>
          </li>
          
          <li<?php if (isset($page) && $page == complaints){echo ' class="active"';}?>><a href="complaints.php">Complaints</a></li>
        </ul>
        <ul class="nav navbar-nav pull-right">
          
          <?php if (isset($admin_user->id)){ ?>
          	<li class="dropdown">
          	<a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo $admin_user->full_name(); ?> <b class="caret"></b></a>
          	<ul class="dropdown-menu">
          		<li><a href="admin_view_profile.php">View Profile</a></li>
          		<li><a href="logout.php">Logout</a></li>
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