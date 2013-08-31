<?php
require_once("../../includes/initialize.php");

if (!$session->is_logged_in()){
	redirect_to("login.php");
} else {
	$user = User::find_by_id($_SESSION['user_id']);
}

if (isset($_POST['submit'])){
	$photo = new Photograph();
	
	$photo->caption = $_POST['caption'];
	$photo->attach_file($_FILES['file_upload']);
	
	if ($photo->save()){
		$session->message("Success! The photo was uploaded successfully. ");
		redirect_to('list_photos.php');
	} else {
		$message = join("<br />", $photo->errors);
	}
	
}

?>

<!DOCTYPE html>
<html lang="en">
  <head>
  	<title>Photo Upload &middot; Photo Gallery</title>
    <?php require_once('../../includes/header.php');?>
  </head>

  <body>


    <!-- Part 1: Wrap all page content here -->
    <div id="wrap">

      <!-- Fixed navbar -->
      <?php $page = photo_upload;?>
      <?php require_once('../../includes/navbar.php');?>

      <!-- Begin page content -->
      
      <div class="container">
        <div class="page-header">
          <h1>Photo Upload</h1>
        </div>
        
        <!-- Start Content -->
        
        <?php echo $session->message; ?>
        
        <div class="col-lg-4">
        
        <form action="photo_upload.php" method="POST" enctype="multipart/form-data">
        	<input type="hidden" name="MAX_FILE_SIZE" value="1000000"/>
        	<div class="form-group">
        		<input type="file" name="file_upload" />
        	</div>
        	<div class="form-group">
	        	<input type="text" class="form-control" name="caption" placeholder="Caption"/>
        	</div>
        	<button type="submit" class="btn btn-primary" name="submit">Upload</button>
        </form>
        </div>
        <!-- End Content -->
        
      </div>

      <div id="push"></div>
    </div>

    <?php require_once('../../includes/footer.php');?>

    <?php require_once('../../includes/bootstrap_scripts.php');?>

  </body>
</html>
