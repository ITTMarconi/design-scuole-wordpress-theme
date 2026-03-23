<?php

// global $calendar_card;
global $posts, $see_all_link, $card_type, $title;

error_log("articoli-il-guglielmo.php");

$giorni_per_filtro  = dsi_get_option('giorni_per_filtro', 'homepage');
$data_limite_filtro = strtotime('-' . $giorni_per_filtro . ' day');

// @customization Custom extra Home fields - #Marconi-theme
// This are the parameters for the carousel of notizie(max 2 types only selected in another section) and cirolari

// Il Guglielmo carousel settings
$home_numero = dsi_get_option('home_numero_guglielmo', 'homepage');
$home_numero = intval($home_numero);
if (!$home_numero) {
    $home_numero = 5;
}

?>
<!-- IL GUGLIELMO -->
<?php

// Get sticky post IDs
$sticky_ids = get_option('sticky_posts');

// Query 1: Get sticky posts of this taxonomy
$sticky_posts = array();
if (!empty($sticky_ids)) {
    $sticky_args = array(
        'post_type'           => 'post',
        'posts_per_page'      => -1,
        'post__in'            => $sticky_ids,
        'tax_query'           => array(
            array(
                'taxonomy' => 'tipologia-articolo',
                'field'    => 'slug',
                'terms'    => 'il-guglielmo',
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
$remaining_slots = max(0, $home_numero - $num_sticky);

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
                'field'    => 'slug',
                'terms'    => 'il-guglielmo',
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
// Set the column width for the news type section
$see_all_link = "/tipologia-articolo/il-guglielmo/";
$card_type = "horizontal-thumb";
$title = "Il Guglielmo";
get_template_part("template-parts/home/articoli", "striscia");