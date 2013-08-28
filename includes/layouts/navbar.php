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
          <li<?php if (isset($page) && $page == 'index'){echo ' class="active"';}?>><a href="index.php">Home</a></li>
          
          
          <li<?php if (isset($page) && $page == 'test'){echo ' class="active"';}?>><a href="test.php">Test</a></li>
        </ul>
        <ul class="nav navbar-nav pull-right">
          
          <li><a href="./admin">Admin Area</a></li>
          
          <?php if (isset($user->id)){ ?>
          	<li class="dropdown">
          	<a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo $user->full_name(); ?> <b class="caret"></b></a>
          	<ul class="dropdown-menu">
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