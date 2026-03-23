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

// Set the arguments for the query
$args = array(
  'post_type'           => 'post',
  'posts_per_page'      => $home_numero,
  'ignore_sticky_posts' => false,
  'tax_query'           => array(
    array(
      'taxonomy' => 'tipologia-articolo',
      'field'    => 'slug',
      'terms'    => 'il-guglielmo',
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

// Put sticky posts first (WordPress "in evidenza" / sticky flag)
$sticky_ids = get_option('sticky_posts');
if (!empty($sticky_ids) && !empty($posts)) {
    usort($posts, function($a, $b) use ($sticky_ids) {
        $a_sticky = in_array($a->ID, $sticky_ids) ? 0 : 1;
        $b_sticky = in_array($b->ID, $sticky_ids) ? 0 : 1;
        return $a_sticky - $b_sticky;
    });
}
// Set the column width for the news type section
$see_all_link = "/tipologia-articolo/il-guglielmo/";
$card_type = "horizontal-thumb";
$title = "Il Guglielmo";
get_template_part("template-parts/home/articoli", "striscia");