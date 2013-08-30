<div class="flexslider">
  <ul class="slides">
    <?php foreach($photos_of_stop as $photo_of_stop) { ?>
    <li>
      <img src="<?php echo '../'.$photo_of_stop->image_path(); ?>" />
    </li>
    <?php } ?>
  </ul>
</div>