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

// Get sticky post IDs
$sticky_ids = get_option('sticky_posts');

// Query 1: Get sticky posts of these taxonomies
$sticky_posts = array();
if (!empty($sticky_ids)) {
    $sticky_args = array(
        'post_type'           => 'post',
        'posts_per_page'      => -1,
        'post__in'            => $sticky_ids,
        'tax_query'           => array(
            array(
                'taxonomy' => 'tipologia-articolo',
                'field'    => 'term_id',
                'terms'    => $term_ids,
            ),
        ),
    );
    
    // Apply date filter if set
    if ($giorni_per_filtro != '' || $giorni_per_filtro > 0) {
        $sticky_args['date_query'] = array(
            array(
                'after'     => '-' . $giorni_per_filtro . ' day',
                'inclusive' => true,
            ),
        );
    }
    
    $sticky_posts = get_posts($sticky_args);
}

// Calculate how many regular posts to fetch
$num_sticky = count($sticky_posts);
$remaining_slots = max(0, $home_numero_notizie - $num_sticky);

// Query 2: Get regular posts (excluding sticky ones)
$regular_posts = array();
if ($remaining_slots > 0) {
    $regular_args = array(
        'post_type'           => 'post',
        'posts_per_page'      => $remaining_slots,
        'post__not_in'        => $sticky_ids,
        'orderby'             => 'date',
        'order'               => 'DESC',
        'tax_query'           => array(
            array(
                'taxonomy' => 'tipologia-articolo',
                'field'    => 'term_id',
                'terms'    => $term_ids,
            ),
        ),
    );
    
    // Apply date filter if set
    if ($giorni_per_filtro != '' || $giorni_per_filtro > 0) {
        $regular_args['date_query'] = array(
            array(
                'after'     => '-' . $giorni_per_filtro . ' day',
                'inclusive' => true,
            ),
        );
    }
    
    $regular_posts = get_posts($regular_args);
}

// Merge: sticky posts first, then regular posts
$posts = array_merge($sticky_posts, $regular_posts);
$see_all_link = "/tipologia-articolo/notizie/";
$card_type = "horizontal-thumb";
$title = "Notizie";
get_template_part("template-parts/home/articoli", "striscia");
