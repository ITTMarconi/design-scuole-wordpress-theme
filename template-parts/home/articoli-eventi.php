<?php

// global $calendar_card;

$tipologie_notizie = dsi_get_option("tipologie_notizie", "notizie");
$home_show_events = dsi_get_option("home_show_events", "homepage");
$giorni_per_filtro = dsi_get_option("giorni_per_filtro", "homepage");
$data_limite_filtro = strtotime("-". $giorni_per_filtro . " day");

$home_circolari_carousel_speed = dsi_get_option("home_circolari_carousel_speed", "homepage");
$home_circolari_carousel_speed = intval($home_circolari_carousel_speed);
if (!$home_circolari_carousel_speed)
    $home_circolari_carousel_speed = 5000;

$home_notizie_carousel_speed = dsi_get_option("home_notizie_carousel_speed", "homepage");
$home_notizie_carousel_speed = intval($home_notizie_carousel_speed);
if (!$home_notizie_carousel_speed)
    $home_notizie_carousel_speed = 5000;

$home_numero_notizie = dsi_get_option("home_numero_notizie", "homepage");
$home_numero_notizie = intval($home_numero_notizie);
if (!$home_numero_notizie)
    $home_numero_notizie = 5;

$home_numero_circolari = dsi_get_option("home_numero_circolari", "homepage");
$home_numero_circolari = intval($home_numero_circolari);
if (!$home_numero_circolari)
    $home_numero_circolari = 5;

$ct = 0;
$column = 1;
if ($home_show_events == "false")
    $column = 2;
if (is_array($tipologie_notizie) && count($tipologie_notizie)) {
    ?>
    <section class="section bg-white py-2 py-lg-3 py-xl-5">
        <div class="container">
            <div class="row variable-gutters">
                <!-- NOTIZIE -->
                <?php
                foreach ($tipologie_notizie as $id_tipologia_notizia) {
                    if ($ct >= $column)
                        break;

        $tipologia_notizia = get_term_by("id", $id_tipologia_notizia, "tipologia-articolo");

        if($tipologia_notizia) {
            // se è selezionata solo una tipologia, pesco 2 elementi
            $ppp = $home_numero_notizie;
            $args = array('post_type' => 'post',
                    'posts_per_page' => $ppp,
                    'tax_query' => array(
                        array(
                            'taxonomy' => 'tipologia-articolo',
                            'field' => 'term_id',
                            'terms' => $tipologia_notizia->term_id,
                        ),
                	),
            );

        	if($giorni_per_filtro != "" || $giorni_per_filtro > 0) {
            	$filter = array(
                		'date_query' => array(
            				array(
								'after' => '-'. $giorni_per_filtro . ' day',
                				'inclusive' => true,
            				),
            			),
        		);

				$args = array_merge($args,$filter);


            }


            $posts = get_posts($args);

            $lg = 4;
            if((count($tipologie_notizie) == 1) && ($home_show_events == "false"))
                $lg = 8;
            if (is_array($posts) && count($posts)) {
            ?>
            <div class="col-lg-<?php echo $lg; ?>">
                <div class="title-section pb-4">
                    <h2><?php echo $tipologia_notizia->name; ?></h2>
                </div><!-- /title-section -->
                        $lg = 4;
                        if (is_array($posts) && count($posts)) {
                            ?>
                            <div class="col-lg-<?php echo $lg; ?>">
                                <div class="title-section pb-4">
                                    <h2><?php echo $tipologia_notizia->name; ?></h2>
                                </div><!-- /title-section -->
                                <div id="carouselIndicators-<?php echo $ct; ?>" class="carousel slide" data-ride="carousel">
                                    <ol class="carousel-indicators">
                                        <?php foreach ($posts as $key => $post) { ?>
                                            <li data-target="#carouselIndicators-<?php echo $ct; ?>"
                                                data-slide-to="<?php echo $key; ?>" <?php echo $key === 0 ? 'class="active"' : ''; ?>></li>
                                        <?php } ?>
                                    </ol>

                                    <div class="carousel-inner">
                                        <?php foreach ($posts as $key => $post) { ?>
                                            <div class="carousel-item <?php echo $key === 0 ? 'active' : ''; ?>"
                                                 data-interval="<?php echo $home_notizie_carousel_speed ?>">
                                                <?php get_template_part("template-parts/single/card", "vertical-thumb"); ?>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div><!-- /carousel -->
                                <div class="py-4">
                                    <a class="text-underline"
                                       href="<?php echo get_term_link($tipologia_notizia); ?>"><strong><?php _e("Vedi tutti", "design_scuole_italia"); ?></strong></a>
                                </div>
                            </div><!-- /col-lg-4 PIPPO--> <!-- <?php echo $tipologia_notizia->name; ?> -->
                            <?php
                        }
                    }
                    $ct++;
                }
                <?php
                if((count($tipologie_notizie) == 1) && ($home_show_events == "false"))
                    echo '<div class="row variable-gutters">';
                foreach ($posts as $post) {
                    if((count($tipologie_notizie) == 1) && ($home_show_events == "false"))
                        echo '<div class="col-lg-6 mb-2">';
                    get_template_part("template-parts/single/card", "vertical-thumb");

                    $tipologia_notizia = get_term_by("id", $id_tipologia_notizia, "tipologia-articolo");
                    if ($tipologia_notizia) {
                        // se è selezionata solo una tipologia, pesco 2 elementi
                        $ppp = $home_numero_notizie;
                        $args = array('post_type' => 'post',
                            'posts_per_page' => $ppp,
                            'tax_query' => array(
                                array(
                                    'taxonomy' => 'tipologia-articolo',
                                    'field' => 'term_id',
                                    'terms' => $tipologia_notizia->term_id,
                                ),
                            ),
                        );
                        $posts = get_posts($args);

                        $lg = 4;
                        if (is_array($posts) && count($posts)) {
                            ?>
                            <div class="col-lg-<?php echo $lg; ?>">
                                <div class="title-section pb-4">
                                    <h2><?php echo $tipologia_notizia->name; ?></h2>
                                </div><!-- /title-section -->
                                <div id="carouselIndicators-<?php echo $ct; ?>" class="carousel slide" data-ride="carousel">
                                    <ol class="carousel-indicators">
                                        <?php foreach ($posts as $key => $post) { ?>
                                            <li data-target="#carouselIndicators-<?php echo $ct; ?>"
                                                data-slide-to="<?php echo $key; ?>" <?php echo $key === 0 ? 'class="active"' : ''; ?>></li>
                                        <?php } ?>
                                    </ol>

                                    <div class="carousel-inner">
                                        <?php foreach ($posts as $key => $post) { ?>
                                            <div class="carousel-item <?php echo $key === 0 ? 'active' : ''; ?>"
                                                 data-interval="<?php echo $home_notizie_carousel_speed ?>">
                                                <?php get_template_part("template-parts/single/card", "vertical-thumb"); ?>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div><!-- /carousel -->
                                <div class="py-4">
                                    <a class="text-underline"
                                       href="<?php echo get_term_link($tipologia_notizia); ?>"><strong><?php _e("Vedi tutti", "design_scuole_italia"); ?></strong></a>
                                </div>
                            </div><!-- /col-lg-4 PIPPO--> <!-- <?php echo $tipologia_notizia->name; ?> -->
                            <?php
                        }
                    }
                    $ct++;
                }

                // <!-- EVENTI -->
                if ($home_show_events != "false") { ?>

                    <div class="col-lg-4">

                        <!-- <div class="title-section <?php if ($home_show_events == "true_event") echo 'pb-4'; ?>"> -->
                        <div class="title-section pb-4">
                            <h2><?php _e("Eventi", "design_scuole_italia"); ?></h2>
                        </div><!-- /title-section -->

                        <?php
                        if ($home_show_events == "true_event") {
                            $args = array('post_type' => 'evento',
                                'posts_per_page' => 1,
                                'meta_key' => '_dsi_evento_timestamp_inizio',
                                'orderby' => array('meta_value' => 'ASC', 'date' => 'ASC'),
                                'meta_query' => array(
                                    array(
                                        'key' => '_dsi_evento_timestamp_inizio'
                                    ),
                                    array(
                                        'key' => '_dsi_evento_timestamp_inizio',
                                        'value' => time(),
                                        'compare' => '>=',
                                        'type' => 'numeric'
                                    )
                                )
                            );
                            $posts = get_posts($args);
                            foreach ($posts as $post) {
                                get_template_part("template-parts/evento/card");
                            }
                        } else {
                            // $calendar_card = true;
                            // get_template_part("template-parts/evento/full_calendar");
                        }

                        ?>
                        <div class="py-4">
                            <a class="text-underline"
                               href="<?php echo get_post_type_archive_link("evento"); ?>"><strong><?php _e("Vedi tutti", "design_scuole_italia"); ?></strong></a>
                        </div>
                    </div><!-- /col-lg-4 -->
                    <?php
                }
                ?>

                <!-- CIRCOLARI -->
                <div class="col-lg-4">

                    <div class="title-section pb-4">
                        <h2><?php _e("Comunicazioni", "design_scuole_italia"); ?></h2>
                    </div><!-- /title-section -->
                    <?php
                    $args = array('post_type' => 'circolare',
                        'posts_per_page' => $home_numero_circolari
                    );
                    $posts = get_posts($args);
                    ?>

                    <div id="carouselIndicators-circ" class="carousel slide" data-ride="carousel">
                        <ol class="carousel-indicators">
                            <?php foreach ($posts as $key => $post) { ?>
                                <li data-target="#carouselIndicators-circ"
                                    data-slide-to="<?php echo $key; ?>" <?php echo $key === 0 ? 'class="active"' : ''; ?>></li>
                            <?php } ?>
                        </ol>

                        <div class="carousel-inner">
                            <?php foreach ($posts as $key => $post) { ?>
                                <div class="carousel-item <?php echo $key === 0 ? 'active' : ''; ?>"
                                     data-interval="<?php echo $home_circolari_carousel_speed ?>">
                                    <?php get_template_part("template-parts/single/card", "circolare"); ?>
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
                    </div><!-- /carouselExampleIndicators -->
                    <div class="py-4">
                        <a class="text-underline"
                           href="<?php echo get_post_type_archive_link("circolare"); ?>"><strong><?php _e("Vedi tutte", "design_scuole_italia"); ?></strong></a>
                    </div>
                </div>

            </div><!-- /row -->
        </div><!-- /container -->
    </section><!-- /section --><?php

}