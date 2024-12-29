<?php
$Parsedown = new Parsedown();
$Parsedown->setSafeMode(true);

global $post;
$numerazione_circolare = dsi_get_meta("numerazione_circolare", "", $post->ID);
//@customization Show "Circolare" only if numerazione_circolare is not empty
//@customization Add te ability to parse markdown in the description
$accesso_circolare = circolare_access($post->ID);
?>

<div class="card card-bg bg-white card-thumb-rounded">
  <div class="card-body">
    <div class="card-content">
      <?php if ($accesso_circolare != "false") { ?>
        <h3 class="h5"><a href="<?php echo get_permalink($post); ?>"><?php echo get_the_title($post); ?></a></h3>
        <small class="h6 text-greendark"><?= ($numerazione_circolare) ? _e("Circolare ", "design_scuole_italia") . $numerazione_circolare : "" ?></small>
        <?= $Parsedown->text($post->_dsi_circolare_descrizione); ?>
      <?php } else { ?>
        <div class="card-article-content">
          <p class="font-weight-bold pl-2">Il contenuto della circolare numero <?php echo $numerazione_circolare ?> (<?php echo date_i18n("j F Y", strtotime($post->post_date)); ?>) è riservato.</p>
        </div>
      <?php } ?>
    </div>
  </div><!-- /card-body -->
</div><!-- /card -->
<?php
