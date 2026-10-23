<?php
/**
 * Homepage hero, Marconi "Option B": "In evidenza" panel beside the hero video.
 *
 * Loaded by template-parts/hero/home.php when at least one "Avvisi in Home"
 * entry has Posizione = "Pannello In evidenza". Rows come already resolved
 * from marconi_get_avvisi() (inc/marconi-avvisi.php).
 *
 * @var array $args {
 *     @type array  $avvisi                Resolved avvisi (max 3).
 *     @type string $img_identita          Poster / fallback image URL.
 *     @type string $hero_video_url
 *     @type string $hero_video_type
 *     @type float  $hero_video_speed
 *     @type float  $hero_video_loop_delay
 * }
 */
global $messages;

$avvisi       = $args['avvisi'];
$img_identita = $args['img_identita'];
$video_url    = $args['hero_video_url'];

$occhiello  = trim( (string) dsi_get_option( 'evidenza_occhiello', 'home_messages', __( 'In evidenza', 'design_scuole_italia' ) ) );
$titolo     = trim( (string) dsi_get_option( 'evidenza_titolo', 'home_messages' ) );
$link_testo = trim( (string) dsi_get_option( 'evidenza_link_testo', 'home_messages' ) );
$link_url   = trim( (string) dsi_get_option( 'evidenza_link_url', 'home_messages' ) );

if ( '' === $titolo ) {
	$titolo    = '' !== $occhiello ? $occhiello : __( 'In evidenza', 'design_scuole_italia' );
	$occhiello = '';
}

$icon_paths = marconi_servizio_icon_paths();
?>
<section class="marconi-hero" aria-labelledby="marconi-evidenza-titolo">

    <div class="sr-only">
        <div><?php echo esc_html( dsi_get_option( 'tipologia_scuola' ) ); ?></div>
        <h1><?php echo esc_html( dsi_get_option( 'nome_scuola' ) ); ?></h1>
        <div><?php echo esc_html( dsi_get_option( 'luogo_scuola' ) ); ?></div>
    </div>

    <div class="marconi-hero__panel">
        <div class="marconi-hero__heading">
            <?php if ( '' !== $occhiello ) { ?>
            <p class="marconi-hero__eyebrow"><?php echo esc_html( $occhiello ); ?></p>
            <?php } ?>
            <h2 id="marconi-evidenza-titolo" class="marconi-hero__title"><?php echo esc_html( $titolo ); ?></h2>
        </div>

        <ul class="marconi-hero__list">
            <?php foreach ( $avvisi as $avviso ) {
                // Date badge only for eventi with a start date, unless "Visualizza icona" is checked.
                $is_evento = 'evento' === $avviso['tipo'] && $avviso['data_inizio'] && ! $avviso['mostra_icona'];
                $colori    = array( 'red', 'yellow', 'green', 'blue', 'purple', 'transparent' );
                $badge_mod = ' marconi-hero__badge--' . ( in_array( $avviso['colore'], $colori, true ) ? $avviso['colore'] : 'red' );
                $external  = ! str_starts_with( $avviso['url'], home_url() ) && ! str_starts_with( $avviso['url'], '/' );
                ?>
            <li>
                <a class="marconi-hero__item" href="<?php echo esc_url( $avviso['url'] ); ?>"<?php if ( $external ) { ?> target="_blank" rel="noopener"<?php } ?>>
                    <?php if ( $is_evento ) { ?>
                    <span class="marconi-hero__badge<?php echo esc_attr( $badge_mod ); ?>">
                        <time datetime="<?php echo esc_attr( gmdate( 'Y-m-d', $avviso['data_inizio'] ) ); ?>">
                            <span class="marconi-hero__badge-day"><?php echo esc_html( date_i18n( 'j', $avviso['data_inizio'] ) ); ?></span>
                            <span class="marconi-hero__badge-month"><?php echo esc_html( date_i18n( 'M', $avviso['data_inizio'] ) ); ?></span>
                        </time>
                    </span>
                    <?php } else { ?>
                    <span class="marconi-hero__badge marconi-hero__badge--icon<?php echo esc_attr( $badge_mod ); ?>" aria-hidden="true">
                        <svg viewBox="0 0 24 24" fill="currentColor" focusable="false"><?php echo $icon_paths[ $avviso['icona'] ]; // phpcs:ignore WordPress.Security.EscapeOutput -- static SVG paths ?></svg>
                    </span>
                    <?php } ?>
                    <span class="marconi-hero__text">
                        <span class="marconi-hero__item-title"><?php echo esc_html( $avviso['titolo'] ); ?></span>
                        <?php if ( '' !== $avviso['sottotitolo'] ) { ?>
                        <span class="marconi-hero__item-sub"><?php echo esc_html( $avviso['sottotitolo'] ); ?></span>
                        <?php } ?>
                        <?php if ( 'articolo' === $avviso['tipo'] && $avviso['data_pubblicazione'] ) { ?>
                        <span class="marconi-hero__item-meta"><?php
                            /* translators: %s: publication date */
                            printf( esc_html__( 'Pubblicato il %s', 'design_scuole_italia' ), '<time datetime="' . esc_attr( wp_date( 'Y-m-d', $avviso['data_pubblicazione'] ) ) . '">' . esc_html( mb_strtolower( wp_date( 'j F', $avviso['data_pubblicazione'] ) ) ) . '</time>' );
                        ?></span>
                        <?php } ?>
                    </span>
                    <svg class="marconi-hero__arrow" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
                </a>
            </li>
            <?php } ?>
        </ul>

        <?php if ( '' !== $link_testo && '' !== $link_url ) { ?>
        <a class="marconi-hero__more" href="<?php echo esc_url( $link_url ); ?>"><?php echo esc_html( $link_testo ); ?></a>
        <?php } ?>
    </div>

    <div class="marconi-hero__media">
        <?php if ( $img_identita ) { ?>
        <img src="<?php echo esc_url( $img_identita ); ?>"
             alt=""
             fetchpriority="high"
             loading="eager"
             class="section-hero-marconi__bg">
        <?php } ?>

        <?php if ( '' !== $video_url ) { ?>
        <video class="section-hero-marconi__bg"
               autoplay
               muted<?php if ( $args['hero_video_loop_delay'] <= 0 ) { ?>
               loop<?php } ?>
               playsinline
               preload="metadata"
               aria-hidden="true"
               tabindex="-1"
               data-playback-rate="<?php echo esc_attr( $args['hero_video_speed'] ); ?>"
               data-loop-delay="<?php echo esc_attr( $args['hero_video_loop_delay'] ); ?>"<?php if ( $img_identita ) { ?>
               poster="<?php echo esc_url( $img_identita ); ?>"<?php } ?>>
            <source src="<?php echo esc_url( $video_url ); ?>" type="<?php echo esc_attr( $args['hero_video_type'] ); ?>">
        </video>

        <?php } ?>

        <?php if ( $messages && ! empty( $messages ) ) { ?>
        <div class="marconi-hero__messages">
            <?php get_template_part( 'template-parts/home/messages' ); ?>
        </div>
        <?php } ?>
    </div>

</section>
