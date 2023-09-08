<?php
$parsedown = new Parsedown();
$parsedown->setSafeMode( true );

global $post, $autore;
$autore = get_user_by("ID", $post->post_author);

$image_id = get_post_thumbnail_id($post);
$image_url = get_the_post_thumbnail_url($post, "vertical-card");
$post_link = get_permalink($post);

//@customization Add te ability to parse markdown in the description
?>
<div class="card card-bg bg-white card-thumb-rounded card-horizontal-thumb">
    <?php if($image_url) { ?>
      <div class="card-thumb">
        <a href="<?php echo $post_link; ?>"><?php dsi_get_img_from_id_url( $image_id, $image_url ); ?></a>
            	
			</div><!-- /card-thumb -->
		<?php  } ?>
  <div class="card-body">
    <div class="card-content">
      <h3 class="h5"><a href="<?php echo $post_link; ?>"><?php echo get_the_title($post); ?></a></h3>

    <?php
      if($post->post_type == "post") {
    ?>
        <p><?php echo $parsedown->text($post->_dsi_articolo_descrizione); ?></p>
      <?php
      } else if($post->post_type == "circolare") {
      ?>
        <p><?php echo $parsedown->text($post->_dsi_circolare_descrizione); ?></p>
      <?php
      } else {                        
      ?>
        <p><?php echo get_the_excerpt($post); ?></p>
      <?php
      }
      ?>
    </div><!-- /card-content -->
  </div><!-- /card-body -->
</div><!-- /card --><?php


