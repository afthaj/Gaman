<?php
require_once("../../includes/initialize.php");

if (!$session->is_logged_in()){
	redirect_to("login.php");
} else {
	$user = User::find_by_id($_SESSION['user_id']);
	
	
	$current_page = !empty($_GET['page']) ? (int)$_GET['page'] : 1;
	
	$per_page = 10;
	
	$total_count = Photograph::count_all();
	
	$pagination = new Pagination($current_page, $per_page, $total_count);
	
	$sql  = "SELECT * FROM photographs ";
	$sql .= "LIMIT {$per_page} ";
	$sql .= "OFFSET {$pagination->offset()}";
	
	$photos = Photograph::find_by_sql($sql);
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Photo List &middot; Photo Gallery</title>
    <?php require_once('../../includes/header.php');?>
  </head>

  <body>


    <!-- Part 1: Wrap all page content here -->
    <div id="wrap">

      <!-- Fixed navbar -->
      <?php $page = list_photos;?>
      <?php require_once('../../includes/navbar.php');?>

      <!-- Begin page content -->
      
      <div class="container">
        <div class="page-header">
          <h1>Photo List</h1>
        </div>
        
        <!-- Start Content -->
        
        <?php echo $session->message; ?>
        
        <table class="table table-bordered table-hover">
	        <tr align="center">
	        <td>Image</td>
	        <td>File Name</td>
	        <td>File Size</td>
	        <td>Caption</td>
	        <td>No. of Comments</td>
	        <td>Delete Link</td>
	        </tr>
        	
        	<?php foreach($photos as $photo){ ?>
        		<tr align="center">
        		<td><a href="photo_admin.php?id=<?php echo $photo->id; ?>"><img src="../<?php echo $photo->image_path();?>" width="200"></a></td>
        		<td><?php echo $photo->filename; ?></td>
        		<td><?php echo $photo->size_as_text(); ?></td>
        		<td><?php echo $photo->caption; ?></td>
        		<?php if ($photo->comment_count() != 0){ ?>
        		<td><a href="photo_admin.php?id=<?php echo $photo->id; ?>" class="btn btn-info"><?php echo $photo->comment_count(); ?></a></td>
        		<?php } else { ?>
        		<td><a href="#" class="btn btn-info"><?php echo $photo->comment_count(); ?></a></td>
        		<?php } ?>
        		
        		<td><a href="delete_photo.php?id=<?php echo $photo->id; ?>" class="btn btn-danger">Delete</a></td>
        		</tr>
        	<?php }?>
        	
        </table>
        
        <!-- Start Pagination -->
		
		<div class="clearfix">&nbsp;</div>
		
		<div class="col-lg-12 text-center">
		<?php 
		if ($pagination->total_pages() > 1){
			
			/*
			echo '<ul class="pager">';
			if ($pagination->has_previous_page()){
				
				echo '<li class="previous">';
				echo '<a href="list_photos.php?page=';
				echo $pagination->previous_page();
				echo '">&larr; Previous</a>';
				echo '</li>';
			}
			
			if ($pagination->has_next_page()){
				
				echo '<li class="next">';
				echo '<a href="list_photos.php?page=';
				echo $pagination->next_page();
				echo '">Next &rarr;</a>';
				echo '</li>';
			}
			echo '</ul>';
			*/

			echo '<ul class="pagination pagination">';
			
			echo $pagination->has_previous_page() ? '<li><a href="list_photos.php?page='.$pagination->previous_page().'">&laquo;</a></li>' : '<li class="disabled"><a href="">&laquo;</a></li>';
			
			for ($i=1; $i <= $pagination->total_pages(); $i++) {
				
				echo '<li';
				echo $i == $pagination->current_page ? ' class="active"' : '';
				echo '>';
				echo '<a href="list_photos.php?page=';
				echo $i;
				echo '">'.$i.'</a>';
				echo '</li>';
				
			}
			
			echo $pagination->has_next_page() ? '<li><a href="list_photos.php?page='.$pagination->next_page().'">&raquo;</a></li>' : '<li class="disabled"><a href="">&raquo;</a></li>';
			
			echo '</ul>';
		}
		?>
		</div>
		
		<!-- End Pagination -->
        
        <!-- End Content -->
        
      </div>

      <div id="push"></div>
    </div>

    <?php require_once('../../includes/footer.php');?>

    <?php require_once('../../includes/bootstrap_scripts.php');?>

  </body>
</html>
