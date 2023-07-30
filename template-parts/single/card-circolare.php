<?php
$Parsedown = new Parsedown();
$Parsedown->setSafeMode(true);

global $post;
$numerazione_circolare = dsi_get_meta("numerazione_circolare", "", $post->ID);
//@customization Show "Circolare" only if numerazione_circolare is not empty
//@customization Add te ability to parse markdown in the description
?><div class="card card-bg bg-white card-thumb-rounded">
	<div class="card-body">
		<div class="card-content">
      <h3 class="h5"><a href="<?php echo get_permalink($post); ?>"><?php echo get_the_title($post); ?></a></h3>
      <small class="h6 text-greendark"><?= ($numerazione_circolare) ? _e("Circolare ", "design_scuole_italia").$numerazione_circolare : "" ?></small>
			<?= $Parsedown->text($post->_dsi_circolare_descrizione); ?>
      </div>
	</div><!-- /card-body -->
</div><!-- /card --><?php
