<?php
global $post, $messages;

$img_identita     = dsi_get_option("immagine", "la_scuola");
$img_altezza      = dsi_get_option("altezza_immagine", "la_scuola");
$hero_video             = dsi_get_option("video_hero", "la_scuola");
$hero_video_speed       = dsi_get_option("video_hero_speed", "la_scuola", 1);
$hero_video_loop_delay  = dsi_get_option("video_hero_loop_delay", "la_scuola", 0);
$testo_hero             = dsi_get_option("testo_hero", "la_scuola");

$landing_url = dsi_get_template_page_url("page-templates/la-scuola.php");

if ( is_numeric( $hero_video ) ) {
    $hero_video = wp_get_attachment_url( absint( $hero_video ) );
}
$hero_video_url       = is_string( $hero_video ) ? trim( $hero_video ) : '';
$hero_video_speed      = is_numeric( $hero_video_speed ) ? (float) $hero_video_speed : 1;
$hero_video_speed      = max( 0.25, min( 2, $hero_video_speed ) );
$hero_video_loop_delay = is_numeric( $hero_video_loop_delay ) ? (float) $hero_video_loop_delay : 0;
$hero_video_loop_delay = max( 0, min( 60, $hero_video_loop_delay ) );
$hero_video_type_data  = wp_check_filetype( (string) wp_parse_url( $hero_video_url, PHP_URL_PATH ) );
$hero_video_type      = ! empty( $hero_video_type_data['type'] ) ? $hero_video_type_data['type'] : 'video/mp4';
$hero_video_available = '' !== $hero_video_url;
?>
<section class="section bg-redbrown section-hero-marconi section-hero-left justify-content-center align-items-center"
         style="min-height: <?php echo intval($img_altezza); ?>px;">

    <?php if ($img_identita) { ?>
    <img src="<?php echo esc_url($img_identita); ?>"
         alt=""
         fetchpriority="high"
         loading="eager"
         class="section-hero-marconi__bg">
    <?php } ?>

    <?php if ( $hero_video_available ) { ?>
    <video class="section-hero-marconi__bg"
           autoplay
           muted<?php if ( $hero_video_loop_delay <= 0 ) { ?>
           loop<?php } ?>
           playsinline
           preload="metadata"
           aria-hidden="true"
           tabindex="-1"
           data-playback-rate="<?php echo esc_attr( $hero_video_speed ); ?>"
           data-loop-delay="<?php echo esc_attr( $hero_video_loop_delay ); ?>"<?php if ( $img_identita ) { ?>
           poster="<?php echo esc_url( $img_identita ); ?>"<?php } ?>>
        <source src="<?php echo esc_url( $hero_video_url ); ?>" type="<?php echo esc_attr( $hero_video_type ); ?>">
    </video>
    <?php } ?>

    <?php if ($messages && !empty($messages)) {
        get_template_part("template-parts/home/messages");
    } ?>

    <?php if ($testo_hero) { ?>
    <h2 class="hero-text">
        <?php
        if (!is_string($testo_hero)) {
            $testo_hero = '';
        }
        $parts = array_filter(array_map('trim', explode('-', $testo_hero)));
        if (!empty($parts)) {
            foreach ($parts as $part) {
                echo '<span>' . esc_html($part) . '</span>';
            }
        } else {
            echo '<span></span>';
        }
        ?>
    </h2>
    <?php } ?>

    <div class="hero-title sr-only sr-only-focusable">
        <div class="text-white font-weight-normal h4"><?php echo dsi_get_option("tipologia_scuola"); ?></div>
        <h1><span class="text-white d-line d-xl-block"><?php echo dsi_get_option("nome_scuola"); ?></span></h1>
        <h2 class="text-white font-weight-normal h3"><?php echo dsi_get_option("luogo_scuola"); ?></h2>
        <?php if ($landing_url) { ?>
            <a class="btn btn-sm btn-outline-white mt-4" href="<?php echo $landing_url; ?>" aria-label="Vai alla scuola"><?php _e("Vai alla scuola", "design_scuole_italia"); ?></a>
        <?php } ?>
    </div><!-- /hero-title -->

</section><!-- /section -->
