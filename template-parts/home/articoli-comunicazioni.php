<?php

// global $calendar_card;

global $posts, $see_all_link, $card_type, $title;

error_log("articoli-rassegna.php");


$id_tipologia_comunicazioni = dsi_get_option('tipologia_comunicazioni', 'notizie');
$giorni_per_filtro  = dsi_get_option('giorni_per_filtro', 'homepage');
$data_limite_filtro = strtotime('-' . $giorni_per_filtro . ' day');

// @customization Custom extra Home fields - #Marconi-theme
// This are the parameters for the carousel of notizie(max 2 types only selected in another section) and cirolari

// Numero di Comunicazioni
$home_numero_comunicazioni = dsi_get_option('home_numero_comunicazioni', 'homepage');
$home_numero_comunicazioni = intval($home_numero_comunicazioni);
if (!$home_numero_comunicazioni) {
    $home_numero_comunicazioni = 5;
}

?>
<?php
$args = array(
    'post_type'      => 'circolare',
    'posts_per_page' => $home_numero_comunicazioni,
);
$posts = get_posts($args);

// Put circolari flagged "in evidenza" first
usort($posts, function($a, $b) {
    $a_ev = get_post_meta($a->ID, '_dsi_circolare_in_evidenza', true) ? 0 : 1;
    $b_ev = get_post_meta($b->ID, '_dsi_circolare_in_evidenza', true) ? 0 : 1;
    return $a_ev - $b_ev;
});
$see_all_link = get_post_type_archive_link('circolare');
$card_type = "circolare-thumb";
$title = "Comunicazioni";
get_template_part("template-parts/home/articoli", "striscia");
