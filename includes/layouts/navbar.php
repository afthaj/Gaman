<div class="navbar navbar-fixed-top navbar-invers">
        
    <div class="container">
      
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-responsive-collapse">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      
      <a class="navbar-brand" href="index.php">Gaman</a>
      
      <div class="nav-collapse collapse navbar-responsive-collapse">
        <ul class="nav navbar-nav">
          <li<?php if (isset($page) && $page == index){echo ' class="active"';}?>><a href="index.php">Home</a></li>
          
          
          <li<?php if (isset($page) && $page == test){echo ' class="active"';}?>><a href="test.php">Test</a></li>
        </ul>
        <ul class="nav navbar-nav pull-right">
          
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