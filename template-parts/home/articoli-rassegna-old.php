<?php

// global $calendar_card;

error_log("articoli-rassegna.php");


$tipologie_notizie  = dsi_get_option('tipologie_notizie', 'notizie');
error_log("tipologie_notizie: " . print_r($tipologie_notizie, true));

$tipologie_rassegna  = dsi_get_option('tipologie_rassegna', 'notizie');
error_log("tipologie_rassegna: " . print_r($tipologie_rassegna, true));

$id_tipologia_comunicazioni = dsi_get_option('tipologia_comunicazioni', 'notizie');
$giorni_per_filtro  = dsi_get_option('giorni_per_filtro', 'homepage');
$data_limite_filtro = strtotime('-' . $giorni_per_filtro . ' day');

// @customization Custom extra Home fields - #Marconi-theme
// This are the parameters for the carousel of notizie(max 2 types only selected in another section) and cirolari

// Comunicazioni carousel settings
$home_numero_comunicazioni = dsi_get_option('home_numero_comunicazioni', 'homepage');
$home_numero_comunicazioni = intval($home_numero_comunicazioni);
if (!$home_numero_comunicazioni) {
    $home_numero_comunicazioni = 5;
}

$home_comunicazioni_carousel_speed = dsi_get_option('home_comunicazioni_carousel_speed', 'homepage');
$home_comunicazioni_carousel_speed = intval($home_comunicazioni_carousel_speed);
if (!$home_comunicazioni_carousel_speed) {
    $home_comunicazioni_carousel_speed = 5000;
}

// Notizie carousel settings
$home_numero_notizie = dsi_get_option('home_numero_notizie', 'homepage');
$home_numero_notizie = intval($home_numero_notizie);
if (!$home_numero_notizie) {
    $home_numero_notizie = 5;
}

$home_notizie_carousel_speed = dsi_get_option('home_notizie_carousel_speed', 'homepage');
$home_notizie_carousel_speed = intval($home_notizie_carousel_speed);
if (!$home_notizie_carousel_speed) {
    $home_notizie_carousel_speed = 5000;
}

// Eventi carousel settings
$home_numero_rassegna = dsi_get_option('home_numero_rassegna', 'homepage');
$home_numero_rassegna = intval($home_numero_rassegna);
if (!$home_numero_rassegna) {
    $home_numero_rassegna = 5;
}

$home_rassegna_carousel_speed = dsi_get_option('home_rassegna_carousel_speed', 'homepage');
$home_rassegna_carousel_speed = intval($home_rassegna_carousel_speed);
if (!$home_rassegna_carousel_speed) {
    $home_rassegna_carousel_speed = 5000;
}

?>
<section class="section bg-white py-2 py-lg-3 py-xl-5">
    <div class="container">
        <div class="row variable-gutters">
        <!-- CIRCOLARI -->
        <div class="col-lg-4">
            <div class="title-section pb-4">
            <h2><?php _e('Comunicazioni', 'design_scuole_italia'); ?></h2>
            </div><!-- /title-section -->
            <?php
            $args = array(
              'post_type'           => 'circolare',
              'posts_per_page'      => $home_numero_comunicazioni,
            );
            $posts = get_posts($args);
            ?>
            <div id="carouselIndicators-comunicazioni" class="carousel slide" data-ride="carousel">
              <ol class="carousel-indicators">
                
                <?php foreach ($posts as $key => $post) { ?>
                  <li data-target="#carouselIndicators-comunicazioni" data-slide-to="<?php echo $key; ?>" <?php echo $key === 0 ? 'class="active"' : ''; ?>></li>
                <?php } ?>
              </ol>

              <div class="carousel-inner">
                <?php foreach ($posts as $key => $post) { ?>
                  <div class="carousel-item <?php echo $key === 0 ? 'active' : ''; ?>" data-interval="<?php echo $home_comunicazioni_carousel_speed; ?>">
                    <?php get_template_part('template-parts/single/card', 'circolare-thumb'); ?>
                  </div>
                <?php } ?>
              </div>
              <!-- Uncomment per aggiungere le frecce laterali -->
              <!--
                <a class="carousel-control-prev" href="#carouselIndicators" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Precedente</span>
                </a>
                <a class="carousel-control-next" href="#carouselIndicators" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Prossima</span>
                </a>
             -->

            </div><!-- /carousel -->
            <div class="py-4">
              <a class="text-underline" href="<?php echo get_post_type_archive_link('circolare'); ?>"><strong><?php _e('Vedi tutti', 'design_scuole_italia'); ?></strong></a>
            </div>
        </div><!-- /col-lg-4 --> <!-- <?php echo "a"; ?> -->
        <!-- NOTIZIE -->
        <?php
        // Get an array of term IDs from $tipologie_notizie
        $term_ids = array_map(
            function ($id) {
                $term = get_term_by('id', $id, 'tipologia-articolo');
                return ($term) ? $term->term_id : null;
            },
            $tipologie_notizie
        );

        // Set the arguments for the query
        $args = array(
          'post_type'           => 'post',
          'posts_per_page'      => $home_numero_rassegna,
          'tax_query'           => array(
            array(
              'taxonomy' => 'tipologia-articolo',
              'field'    => 'term_id',
              'terms'    => $term_ids,
            ),
          ),
        );
        // Filter the query by the number of days specified in the option
        if ($giorni_per_filtro != '' || $giorni_per_filtro > 0) {
            $filter = array(
            'date_query' => array(
              array(
                'after'     => '-' . $giorni_per_filtro . ' day',
                'inclusive' => true,
              ),
            ),
            );
            // Merge the filter arguments with the query arguments
            $args   = array_merge($args, $filter);
        }
        // Retrieve the posts for all news types
        $all_posts = get_posts($args);
        // Set the column width for the news type section
        $lg = 4;
            // @customization view the two types of news as a carousel of cards - #Marconi-theme
        ?>
        <div class="col-lg-<?php echo $lg; ?>">
            <div class="title-section pb-4">
              <h2>Notizie</h2>
            </div><!-- /title-section -->
            <div id="carouselIndicators" class="carousel slide" data-ride="carousel">
              <ol class="carousel-indicators">
                <?php foreach ($all_posts as $key => $post) { ?>
                  <li data-target="#carouselIndicators" data-slide-to="<?php echo $key; ?>" <?php echo $key === 0 ? 'class="active"' : ''; ?>></li>
                <?php } ?>
              </ol>

              <div class="carousel-inner">
                <?php foreach ($all_posts as $key => $post) { ?>
                  <div class="carousel-item <?php echo $key === 0 ? 'active' : ''; ?>" data-interval="<?php echo $home_notizie_carousel_speed; ?>">
                    <?php get_template_part('template-parts/single/card', 'horizontal-thumb'); ?>
                  </div>
                <?php } ?>
              </div>
            </div><!-- /carousel -->
            <div class="py-4">
              <a class="text-underline" href="/tipologia-articolo/notizie/"><strong><?php _e('Vedi tutti', 'design_scuole_italia'); ?></strong></a>
            </div>
        </div><!-- /col-lg-4 -->
        <!-- RASSEGNA STAMPA -->
        <?php
        // Get an array of term IDs from $tipologie_rassegna
        $term_ids = array_map(
            function ($id) {
                $term = get_term_by('id', $id, 'tipologia-articolo');
                return ($term) ? $term->term_id : null;
            },
            $tipologie_rassegna
        );

        // Set the arguments for the query
        $args = array(
          'post_type'           => 'post',
          'posts_per_page'      => $home_numero_notizie,
          'tax_query'           => array(
            array(
              'taxonomy' => 'tipologia-articolo',
              'field'    => 'term_id',
              'terms'    => $term_ids,
            ),
          ),
        );
        // Filter the query by the number of days specified in the option
        if ($giorni_per_filtro != '' || $giorni_per_filtro > 0) {
            $filter = array(
            'date_query' => array(
              array(
                'after'     => '-' . $giorni_per_filtro . ' day',
                'inclusive' => true,
              ),
            ),
            );
            // Merge the filter arguments with the query arguments
            $args   = array_merge($args, $filter);
        }
        // Retrieve the posts for all news types
        $all_posts = get_posts($args);
        // Set the column width for the news type section
        $lg = 4;
            // @customization view the two types of news as a carousel of cards - #Marconi-theme
        ?>
        <div class="col-lg-<?php echo $lg; ?>">
            <div class="title-section pb-4">
              <h2>Rassegna Stampa</h2>
            </div><!-- /title-section -->
            <div id="carouselIndicatorsRassegna" class="carousel slide" data-ride="carousel">
              <ol class="carousel-indicators">
                <?php foreach ($all_posts as $key => $post) { ?>
                  <li data-target="#carouselIndicatorsRassegna" data-slide-to="<?php echo $key; ?>" <?php echo $key === 0 ? 'class="active"' : ''; ?>></li>
                <?php } ?>
              </ol>

              <div class="carousel-inner">
                <?php foreach ($all_posts as $key => $post) { ?>
                  <div class="carousel-item <?php echo $key === 0 ? 'active' : ''; ?>" data-interval="<?php echo $home_notizie_carousel_speed; ?>">
                    <?php get_template_part('template-parts/single/card', 'horizontal-thumb'); ?>
                  </div>
                <?php } ?>
              </div>
            </div><!-- /carousel -->
            <div class="py-4">
              <a class="text-underline" href="/tipologia-articolo/rassegna-stampa/"><strong><?php _e('Vedi tutti', 'design_scuole_italia'); ?></strong></a>
            </div>
        </div><!-- /col-lg-4 -->
      </div><!-- /row -->
    </div><!-- /container -->
</section><!-- /section -->
<?php
