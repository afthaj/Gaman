<?php
require_once("../../includes/initialize.php");
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
	
  $comments = $photo->comments();
	
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Photo &middot; Photo Gallery Admin</title>
    <?php require_once('../../includes/header.php');?>
  </head>

  <body>


    <!-- Part 1: Wrap all page content here -->
    <div id="wrap">

      <!-- Fixed navbar -->
      <?php require_once('../../includes/navbar.php');?>

      <!-- Begin page content -->
      
      <div class="container">
        <div class="page-header">
          <h1>Photo Page &middot; Admin</h1>
        </div>
        
        <!-- Start Content -->
        
        <?php echo $message; ?>
        <br />
        <br />
		<a href="list_photos.php" class="btn btn-warning">&larr; Back</a>
		<br />
		<br />
		
		<div class="col-lg-12">
		  <img src="../<?php echo $photo->image_path(); ?>" width="800" class="img-rounded"/>
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
			        	<p><a href="delete_comment.php?id=<?php echo $comment->id; ?>" class="btn btn-danger">Delete</a></p>
			        	<br />
			        </div>
		        <?php }?>
	        <?php } ?>

		</div>
        
        <!-- End Content -->
        
      </div>

      <div id="push"></div>
    </div>

    <?php require_once('../../includes/footer.php');?>

    <?php require_once('../../includes/bootstrap_scripts.php');?>

  </body>
</html>
