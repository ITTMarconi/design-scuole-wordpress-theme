<?php
$visualizza_banner_in_fondo = dsi_get_option('visualizza_banner_in_fondo', 'homepage');
echo "<!-- visualizza_banner: $visualizza_banner_in_fondo -->";
if ($visualizza_banner_in_fondo == 'si') {
  $banner_group = dsi_get_option('banner_group', 'homepage');
  $class        = 'single-banner';
?>
  <section class="section section-footer">
    <div class="container grid-container">
      <?php
      foreach ($banner_group as $banner) {
        $image_url = wp_get_attachment_image_url($banner['banner_id'], 'medium');
        $image_alt = get_post_meta($banner['banner_id'], '_wp_attachment_image_alt', true);
      ?>
        <div class="grid-item">
          <div class="banner">
            <?php
            if ($banner['url'] != '') {
              echo '<a href="' . $banner['url'] . '" target="_blank">';
            }
            ?>
            <figure class="text-center">
              <img src="<?php echo $image_url; ?>" alt="<?php echo $image_alt; ?>" />
            </figure>
            <?php
            if ($banner['url'] != '') {
              echo '</a>';
            }
            ?>
          </div><!-- /item -->
        </div>
      <?php
      }
      ?>
    </div><!-- /grid-container -->
</section><!-- /section -->
<?php
}
