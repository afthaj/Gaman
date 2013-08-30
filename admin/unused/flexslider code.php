<div class="span11">
<div class="flexslider">
  <ul class="slides">
    <?php foreach($photos_of_stop as $photo_of_stop) { ?>
    <li>
      <img src="<?php echo '../'.$photo_of_stop->image_path(); ?>" />
    </li>
    <?php } ?>
  </ul>
</div>
</div>

<script type="text/javascript">
	$(window).load(function(){
      $('.flexslider').flexslider({
        animation: "slide",
        start: function(slider){
          $('body').removeClass('loading');
        }
      });
    });
</script>

<script defer src="../js/jquery.flexslider.js"></script>