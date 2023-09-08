<?php

// global $calendar_card;

$tipologie_notizie  = dsi_get_option( 'tipologie_notizie', 'notizie' );
$home_show_events   = dsi_get_option( 'home_show_events', 'homepage' );
$giorni_per_filtro  = dsi_get_option( 'giorni_per_filtro', 'homepage' );
$data_limite_filtro = strtotime( '-' . $giorni_per_filtro . ' day' );

// @customization Custom extra Home fields - #Marconi-theme
// This are the parameters for the carousel of notizie(max 2 types only selected in another section) and cirolari
// Notizie carousel settings
$home_notizie_carousel_speed = dsi_get_option( 'home_notizie_carousel_speed', 'homepage' );
$home_notizie_carousel_speed = intval( $home_notizie_carousel_speed );
if ( ! $home_notizie_carousel_speed ) {
	$home_notizie_carousel_speed = 5000;
}

$home_numero_notizie = dsi_get_option( 'home_numero_rassegne_stampa', 'homepage' );
$home_numero_notizie = intval( $home_numero_notizie );
if ( ! $home_numero_notizie ) {
	$home_numero_notizie = 5;
}

// Rassegna stampa carousel settings
$home_rassegna_stampa_carousel_speed = dsi_get_option( 'home_rassegna_stampa_carousel_speed', 'homepage' );
$home_rassegna_stampa_carousel_speed = intval( $home_rassegna_stampa_carousel_speed );
if ( ! $home_rassegna_stampa_carousel_speed ) {
	$home_rassegna_stampa_carousel_speed = 5000;
}

$home_numero_rassegne_stampa = dsi_get_option( 'home_numero_circolari', 'homepage' );
$home_numero_rassegne_stampa = intval( $home_numero_rassegne_stampa );
if ( ! $home_numero_rassegne_stampa ) {
	$home_numero_rassegne_stampa = 5;
}

// Circolari carousel settings
$home_circolari_carousel_speed = dsi_get_option( 'home_circolari_carousel_speed', 'homepage' );
$home_circolari_carousel_speed = intval( $home_circolari_carousel_speed );
if ( ! $home_circolari_carousel_speed ) {
	$home_circolari_carousel_speed = 5000;
}

$home_numero_circolari = dsi_get_option( 'home_numero_circolari', 'homepage' );
$home_numero_circolari = intval( $home_numero_circolari );
if ( ! $home_numero_circolari ) {
	$home_numero_circolari = 5;
}

// @fix It's a terrible hack, but it works
function get_option_value( $column, $type_name ) {
  global $home_notizie_carousel_speed, $home_numero_notizie, $home_rassegna_stampa_carousel_speed, $home_numero_rassegne_stampa;
  switch ($column) { 
    case 0:
		if ( $type_name == 'speed' ) {
			return $home_notizie_carousel_speed;
		} else {
			return $home_numero_notizie;
		}
	  break;
  case 1:
		if ( $type_name == 'speed' ) {
			return $home_rassegna_stampa_carousel_speed;
		} else {
			return $home_numero_rassegne_stampa;
		}
    break;
  } 
	return '';
}

$ct     = 0;
$column = 1;
if ( $home_show_events == 'false' ) {
	$column = 2;
}
if ( is_array( $tipologie_notizie ) && count( $tipologie_notizie ) ) {
	?>
	<section class="section bg-white py-2 py-lg-3 py-xl-5">
		<div class="container">
			<div class="row variable-gutters">
				<!-- CIRCOLARI -->
				<div class="col-lg-4">

					<div class="title-section pb-4">
						<h2><?php _e( 'Comunicazioni', 'design_scuole_italia' ); ?></h2>
					</div><!-- /title-section -->
					<?php
					$args  = array(
						'post_type'      => 'circolare',
						'posts_per_page' => $home_numero_circolari,
					);
					$posts = get_posts( $args );
					// @customization view circolari as a carousel of cards - #Marconi-theme
					?>

					<div id="carouselIndicators-circ" class="carousel slide" data-ride="carousel">
						<ol class="carousel-indicators">
							<?php foreach ( $posts as $key => $post ) { ?>
								<li data-target="#carouselIndicators-circ"
									data-slide-to="<?php echo $key; ?>" <?php echo $key === 0 ? 'class="active"' : ''; ?>></li>
							<?php } ?>
						</ol>

						<div class="carousel-inner">
							<?php foreach ( $posts as $key => $post ) { ?>
								<div class="carousel-item <?php echo $key === 0 ? 'active' : ''; ?>"
									data-interval="<?php echo $home_circolari_carousel_speed; ?>">
									<?php get_template_part( 'template-parts/single/card', 'circolare' ); ?>
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
							href="<?php echo get_post_type_archive_link( 'circolare' ); ?>"><strong><?php _e( 'Vedi tutte', 'design_scuole_italia' ); ?></strong></a>
					</div>
				</div>
	  		<!-- NOTIZIE -->
				<?php
				// Loop through each selected news type
				foreach ( $tipologie_notizie as $id_tipologia_notizia ) {
					// Display no more than $column news types
					if ( $ct >= $column ) {
						break;
					}
					// Get the term for the current news type
					$tipologia_notizia = get_term_by( 'id', $id_tipologia_notizia, 'tipologia-articolo' );
					if ( $tipologia_notizia ) {
						// Set the number of posts to display
						$ppp = get_option_value( $ct, 'number' );
						// Set up the query to retrieve posts for the current news type
						$args = array(
							'post_type'           => 'post',
							'posts_per_page'      => $ppp,
							'tax_query'           => array(
								array(
									'taxonomy' => 'tipologia-articolo',
									'field'    => 'term_id',
									'terms'    => $tipologia_notizia->term_id,
								),
							),
						);
						if ( $giorni_per_filtro != '' || $giorni_per_filtro > 0 ) {
							$filter = array(
								'date_query' => array(
									array(
										'after'     => '-' . $giorni_per_filtro . ' day',
										'inclusive' => true,
									),
								),
							);
							$args   = array_merge( $args, $filter );
						}
						// Retrieve the posts for the current news type
						$posts = get_posts( $args );
						// Set the column width for the news type section
						$lg = 4;
						if ( is_array( $posts ) && count( $posts ) ) {
							// @customization view the two types of news as a carousel of cards - #Marconi-theme
							?>
							<div class="col-lg-<?php echo $lg; ?>">
								<div class="title-section pb-4">
									<h2><?php echo $tipologia_notizia->name; ?></h2>
								</div><!-- /title-section -->
								<div id="carouselIndicators-<?php echo $ct; ?>" class="carousel slide" data-ride="carousel">
									<ol class="carousel-indicators">
										<?php foreach ( $posts as $key => $post ) { ?>
											<li data-target="#carouselIndicators-<?php echo $ct; ?>"
												data-slide-to="<?php echo $key; ?>" <?php echo $key === 0 ? 'class="active"' : ''; ?>></li>
										<?php } ?>
									</ol>

									<div class="carousel-inner">
										<?php foreach ( $posts as $key => $post ) { ?>
											<div class="carousel-item <?php echo $key === 0 ? 'active' : ''; ?>"
												data-interval="<?php echo get_option_value( $ct, 'speed' ); ?>">
												<?php get_template_part( 'template-parts/single/card', 'horizontal-thumb' ); ?>
											</div>
										<?php } ?>
									</div>
								</div><!-- /carousel -->
								<div class="py-4">
									<a class="text-underline"
										href="<?php echo get_term_link( $tipologia_notizia ); ?>"><strong><?php _e( 'Vedi tutti', 'design_scuole_italia' ); ?></strong></a>
								</div>
							</div><!-- /col-lg-4 --> <!-- <?php echo $tipologia_notizia->name; ?> -->
							<?php
						}
					}
					$ct++;
				}

				// <!-- EVENTI -->
				if ( $home_show_events != 'false' ) {
					?>

					<div class="col-lg-4">

						<!-- <div class="title-section 
						<?php
						if ( $home_show_events == 'true_event' ) {
							echo 'pb-4';}
						?>
						"> -->
						<div class="title-section pb-4">
							<h2><?php _e( 'Eventi', 'design_scuole_italia' ); ?></h2>
						</div><!-- /title-section -->

						<?php
						if ( $home_show_events == 'true_event' ) {
							$args  = array(
								'post_type'           => 'evento',
								'posts_per_page'      => 1,
								'meta_key'            => '_dsi_evento_timestamp_inizio',
								'orderby'             => array(
									'meta_value' => 'ASC',
									'date'       => 'ASC',
								),
								'meta_query'          => array(
									array(
										'key' => '_dsi_evento_timestamp_inizio',
									),
									array(
										'key'     => '_dsi_evento_timestamp_inizio',
										'value'   => time(),
										'compare' => '>=',
										'type'    => 'numeric',
									),
								),
							);
							$posts = get_posts( $args );
							foreach ( $posts as $post ) {
								get_template_part( 'template-parts/evento/card' );
							}
						} else {
							// $calendar_card = true;
							// get_template_part("template-parts/evento/full_calendar");
						}

						?>
						<div class="py-4">
							<a class="text-underline"
								href="<?php echo get_post_type_archive_link( 'evento' ); ?>"><strong><?php _e( 'Vedi tutti', 'design_scuole_italia' ); ?></strong></a>
						</div>
					</div><!-- /col-lg-4 -->
					<?php
				}
				?>


			</div><!-- /row -->
		</div><!-- /container -->
	</section><!-- /section -->
	<?php

}
