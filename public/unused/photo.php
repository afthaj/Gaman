<?php
require_once("../includes/initialize.php");
?>

<?php

  if(empty($_GET['id'])) {
    $session->message("No photograph ID was provided.");
    redirect_to("index.php");
  }
  
  $photo = Photograph::find_by_id($_GET['id']);
  
  if(!$photo) {
    $session->message("The photo could not be located.");
    redirect_to("index.php");
  }

	if(isset($_POST['submit'])) {
		
		$author = $_POST['author'];
	  	$body = $_POST['body'];
	  	$new_comment = Comment::make_comment($photo->id, $author, $body);
	  
	  if ($new_comment){
	  	if ($new_comment->save()){
	  		$session->message("Success! The comment was made AND saved.");
	  		redirect_to("photo.php?id={$photo->id}");
	  	} else {
	  		$session->message("Error. The comment could not be saved.");
	  		redirect_to("photo.php?id={$photo->id}");
	  	}
	  } else {
	  	$session->message("Error. The comment could not be made.");
		redirect_to("photo.php?id={$photo->id}");
	  }
	  
// 	  if($new_comment && $new_comment->save()) {
// 	    redirect_to("photo.php?id={$photo->id}");
	
// 		} else {
// 		    $session->message("There was an error that prevented the comment from being saved.");
// 		    redirect_to("index.php");
// 		}

	} else {
		$author = "";
		$body = "";
	}
	
	$comments = $photo->comments();
	
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Photo &middot; Photo Gallery</title>
    <?php require_once('../includes/header.php');?>
  </head>

  <body>


    <!-- Part 1: Wrap all page content here -->
    <div id="wrap">

      <!-- Fixed navbar -->
      <div class="navbar navbar-fixed-top">
	        
	    <div class="container">
	      
	      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-responsive-collapse">
	        <span class="icon-bar"></span>
	        <span class="icon-bar"></span>
	        <span class="icon-bar"></span>
	      </button>
	      
	      <a class="navbar-brand" href="index.php">Photo Gallery</a>
	      
	      <div class="nav-collapse collapse navbar-responsive-collapse">
	        
	        <ul class="nav navbar-nav pull-right">
	          
	          <?php if (isset($user->id)){ ?>
	          	<li class="dropdown">
	          	<a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo $user->full_name(); ?> <b class="caret"></b></a>
	          	<ul class="dropdown-menu">
	          		<li><a href="admin/logout.php">Logout</a></li>
	          	</ul>
	          	</li>
	          <?php } else { ?>
	          	<li><a href="admin/login.php">Login</a></li>
	          <?php } ?>
	          
	        </ul>
	      </div><!--/.nav-collapse -->
	      
	    </div>
	  
	</div>

      <!-- Begin page content -->
      
      <div class="container">
        <div class="page-header">
          <h1>Photo Page</h1>
        </div>
        
        <!-- Start Content -->
        
        <?php echo $message; ?>
        <br />
        <br />
		<a href="index.php" class="btn btn-warning">&larr; Back</a>
		<br />
		<br />
		
		<div class="col-lg-12">
		  <img src="<?php echo $photo->image_path(); ?>" width="800" class="img-rounded"/>
		  <h3><?php echo $photo->caption; ?></h3>
		</div>
		
		<div class="clearfix">&nbsp;</div>
		
		<!-- List comments -->
		<div class="col-lg-4">
			<div class="form-group">
	        	<h3 class="form-signin-heading">Comments</h3>
	        </div>
	        
	        <?php if(empty($comments)){
	        	echo "<p>No comments have been submitted</p>";
	        } else { ?>
	        	<?php foreach($comments as $comment){ ?>
		        	<div class="form-group">
			        	<p><?php echo $comment->author; ?> wrote:</p>
			        	<p><?php echo $comment->body; ?></p>
			        	<p><?php echo datetime_to_text($comment->created); ?></p>
			        	<br />
			        </div>
		        <?php }?>
	        <?php } ?>

		</div>
		
		<div class="clearfix">&nbsp;</div>
		
		<div class="col-lg-4">
		<form class="form-signin" action="photo.php?id=<?php echo $photo->id; ?>" method="post">
			<div class="form-group">
	        	<h3 class="form-signin-heading">New Comment</h3>
	        </div>
			<div class="form-group">
				<input type="text" class="form-control" name="author" placeholder="Your Name" value="">
			</div>
			<div class="form-group">
				<textarea name="body" class="form-control" rows="3" placeholder="Your Comment"></textarea>
			</div>
			<button type="submit" name="submit" class="btn btn-primary">Submit</button>
		</form>
		</div>
        
        <!-- End Content -->
        
      </div>

      <div id="push"></div>
    </div>

    <?php require_once('../includes/footer.php');?>

    <?php require_once('../includes/bootstrap_scripts.php');?>

  </body>
</html>
