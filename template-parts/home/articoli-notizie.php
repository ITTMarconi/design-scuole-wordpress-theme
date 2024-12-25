<?php

// global $calendar_card;
global $posts, $see_all_link, $card_type, $title;

error_log("articoli-notizie.php");


$tipologie_notizie  = dsi_get_option('tipologie_notizie', 'notizie');
error_log("tipologie_notizie: " . print_r($tipologie_notizie, true));

$giorni_per_filtro  = dsi_get_option('giorni_per_filtro', 'homepage');
$data_limite_filtro = strtotime('-' . $giorni_per_filtro . ' day');

// @customization Custom extra Home fields - #Marconi-theme
// This are the parameters for the carousel of notizie(max 2 types only selected in another section) and cirolari

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


?>
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
$posts = get_posts($args);
$see_all_link = "/tipologia-articolo/notizie/";
$card_type = "horizontal-thumb";
$title = "Notizie";
get_template_part("template-parts/home/articoli", "striscia");
