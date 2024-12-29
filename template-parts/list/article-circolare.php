<?php
$Parsedown = new Parsedown();
$Parsedown->setSafeMode(true);

global $post;

$image_url = get_the_post_thumbnail_url($post, "article-simple-thumb");
$class = dsi_get_post_types_color_class($post->post_type);
$icon = dsi_get_post_types_icon_class($post->post_type);


//@customization Add te ability to parse markdown in the description
$excerpt =  $Parsedown->text(dsi_get_meta("descrizione", "", $post->ID));
if (!$excerpt)
  $excerpt = '<p>' . get_the_excerpt($post) . '</p>';

$argomenti = dsi_get_argomenti_of_post();
$numerazione_circolare =  dsi_get_meta("numerazione_circolare", "", $post->ID);

//@customization Show "Circolare" only if numerazione_circolare is not empty
$accesso_circolare = circolare_access($post->ID);
?>

<?php if ($accesso_circolare != "false") { ?>
  <a class="presentation-card-link" href="<?php the_permalink(); ?>">
    <article class="card card-bg card-article card-article-<?php echo $class; ?> cursorhand" role="region" aria-label="Card della circolare">
      <div class="card-body" aria-label="data pubblicazione <?php echo date_i18n("y", strtotime($post->post_date)); ?>">
        <div class="card-article-img" aria-hidden="true" <?php if ($image_url) echo 'style="background-image: url(\'' . $image_url . '\');"'; ?>>
          <div class="date">
            <span class="year" aria-hidden="true"><?php echo date_i18n("Y", strtotime($post->post_date)); ?></span>
            <span class="day" aria-hidden="true"><?php echo date_i18n("d", strtotime($post->post_date)); ?></span>
            <span class="month" aria-hidden="true"><?php echo date_i18n("M", strtotime($post->post_date)); ?></span>
          </div>
          <?php if (!$image_url) { ?>
            <svg aria-hidden="true" class="icon-<?php echo $class; ?> svg-<?php echo $icon; ?>">
              <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-<?php echo $icon; ?>"></use>
            </svg>
          <?php } ?>
        </div>
        <div class="card-article-content">
          <small class="h6 text-greendark"><?= ($numerazione_circolare) ? _e("Circolare ", "design_scuole_italia") . $numerazione_circolare : "" ?></small>
          <h2 class="h3"><?php the_title(); ?></h2>
          <?php echo $excerpt; ?>
          <?php /* if(is_array($argomenti) && count($argomenti)) { ?>
                        <div class="badges">
                            <?php foreach ( $argomenti as $item ) { ?>
                                <a href="<?php echo get_term_link($item); ?>" title="<?php _e("Vai all'argomento", "design_scuole_italia"); ?>: <?php echo $item->name; ?>"
                                   class="badge badge-sm badge-pill badge-outline-<?php echo $class; ?>"><?php echo $item->name; ?></a>
                            <?php } ?>
                        </div><!-- /badges -->
                    <?php } */ ?>
          <?php $post_tags = get_the_terms(get_the_ID(), 'tipologia-circolare');
          if ($post_tags) {
            foreach ($post_tags as $tag) {
              echo '<a href="' . get_tag_link($tag->term_id) . '" class="badge badge-sm badge-pill badge-outline-greendark" aria-label="Tipologia: ' . $tag->name . '">' . $tag->name . '</a> ';
            }
          }
          ?>
        </div><!-- /card-avatar-content -->
      </div><!-- /card-body -->
    </article><!-- /card card-bg card-article -->
  </a>
<?php } else { ?>
  <article class="card card-bg card-article" tabindex="0" role="region" aria-label="Card della circolare">
    <div class="card-body">
      <div class="card-content">
        <div class="card-article-content">
          <p class="font-weight-bold pl-2">Il contenuto della circolare n.<?php echo $numerazione_circolare ?> è riservato.</p>
        </div>
      </div>
    </div>
  </article>
<?php } ?>
