<?php

// global $calendar_card;
global $posts, $see_all_link, $card_type, $title;

error_log("articoli-rassegna.php");

$giorni_per_filtro  = dsi_get_option('giorni_per_filtro', 'homepage');
$data_limite_filtro = strtotime('-' . $giorni_per_filtro . ' day');

// @customization Custom extra Home fields - #Marconi-theme
// This are the parameters for the carousel of notizie(max 2 types only selected in another section) and cirolari

$tipologie = dsi_get_option('tipologie_rassegna', 'notizie');
error_log("tipologie_rassegna: " . print_r($tipologie_rassegna, true));

// Rassegna carousel settings
$home_numero = dsi_get_option('home_numero_rassegna', 'homepage');
$home_numero = intval($home_numero_rassegna);
if (!$home_numero) {
    $home_numero = 5;
}

?>
<!-- RASSEGNA STAMPA -->
<?php
// Get an array of term IDs from $tipologie
$term_ids = array_map(
    function ($id) {
        $term = get_term_by('id', $id, 'tipologia-articolo');
        return ($term) ? $term->term_id : null;
    },
    $tipologie
);

// Set the arguments for the query
$args = array(
  'post_type'           => 'post',
  'posts_per_page'      => $home_numero,
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
$posts = get_posts($args);
// Set the column width for the news type section
$see_all_link = "/tipologia-articolo/rassegna-stampa/";
$card_type = "horizontal-thumb";
$title = "Rassegna Stampa";
get_template_part("template-parts/home/articoli", "striscia");
