<?php
/* Template Name: Notizie
 *
 * notizie template file
 *
 * @package Design_Scuole_Italia
 */
global $post, $tipologia_notizia, $ct;
get_header();

?>
	<main id="main-container" class="main-container greendark">
		<?php get_template_part("template-parts/common/breadcrumb"); ?>
		<?php
		while ( have_posts() ) :
			the_post();

			get_template_part("template-parts/hero/notizie");

			$ct=1;
      get_template_part("template-parts/home/notizie", "circolari");
      $ct++;

			$tipologie_notizie = dsi_get_option("tipologie_notizie", "notizie");
			if(is_array($tipologie_notizie) && count($tipologie_notizie)){
				foreach ( $tipologie_notizie as $id_tipologia_notizia ) {
					$tipologia_notizia = get_term_by("id", $id_tipologia_notizia, "tipologia-articolo");
					get_template_part("template-parts/home/notizie", "tipologie");
					$ct++;
				}

			}

    $tipologie_rassegna = dsi_get_option("tipologie_rassegna", "notizie");
    error_log("Tipologie in Rassegna: " . print_r($tipologie_rassegna, true));
      

			if(is_array($tipologie_rassegna) && count($tipologie_rassegna)){
				foreach ( $tipologie_rassegna as $id_tipologia_rassegna ) {
					$tipologia_notizia = get_term_by("id", $id_tipologia_rassegna, "tipologia-articolo");
          error_log(print_r($tipologia_notizia, true));
					get_template_part("template-parts/home/notizie", "tipologie");
					$ct++;
				}

			}

      get_template_part("template-parts/home/eventi");

		endwhile; // End of the loop.
		?>
	</main>

<?php
get_footer();



