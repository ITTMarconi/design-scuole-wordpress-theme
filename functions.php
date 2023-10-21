<?php
/**
 * Design Scuole Italia functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Design_Scuole_Italia
 */

/**
 * Define
 */
require get_template_directory() . '/inc/define.php';

/**
 * Vocabolario
 */
require get_template_directory() . '/inc/vocabolario.php';

/**
 * Extend User Taxonomy
 */
require get_template_directory() . '/inc/extend-tax-to-user.php';

/**
 * Implement Plugin Activations Rules
 */
require get_template_directory() . '/inc/theme-dependencies.php';


/**
 * header menu walker
 */
require get_template_directory() . '/walkers/header-walker.php';

/**
 * footer menu walker
 */
require get_template_directory() . '/walkers/footer-walker.php';

/**
 * Implement CMB2 Custom Field Manager
 */
if ( ! function_exists ( 'dsi_get_tipologia_articoli_options' ) ) {
	require get_template_directory() . '/inc/cmb2.php';
	require get_template_directory() . '/inc/backend-template.php';
}

/**
 * Utils functions
 */
require get_template_directory() . '/inc/utils.php';

/**
 * Notifications functions
 */
require get_template_directory() . '/inc/notification.php';

/**
 * Breadcrumb class
 */
require get_template_directory() . '/inc/breadcrumb.php';


/**
 * Activation Hooks
 */
require get_template_directory() . '/inc/activation.php';

/**
 * Actions & Hooks
 */
require get_template_directory() . '/inc/actions.php';

/**
 * Gutenberg editor rules
 */
require get_template_directory() . '/inc/gutenberg.php';

/**
 * Welcome page
 */
require get_template_directory() . '/inc/welcome.php';

/**
 * Admin menu
 */
require get_template_directory() . '/inc/menu-order.php';


/**
 * Import
 */
require get_template_directory() . '/inc/import.php';

/**
 * TCPDF
 */
require get_template_directory() . '/inc/dompdf.php';




if ( ! function_exists( 'dsi_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function dsi_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on Design Scuole Italia, use a find and replace
		 * to change 'design_scuole_italia' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'design_scuole_italia', get_template_directory() . '/languages' );


        load_theme_textdomain( 'easy-appointments', get_template_directory() . '/languages' );

        // Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

        // image size
        if ( function_exists( 'add_image_size' ) ) {
            add_image_size( 'article-simple-thumb', 500, 384 , true);
            add_image_size( 'item-thumb', 280, 280 , true);
            add_image_size( 'item-gallery', 730, 485 , true);
            add_image_size( 'vertical-card', 190, 290 , true);

            add_image_size( 'banner', 600, 250 , false);
        }

        // This theme uses wp_nav_menu()
		register_nav_menus( array(
			'menu-scuola' => esc_html__( 'Sottovoci del menu principale, voce "Scuola"', 'design_scuole_italia' ),
			'menu-servizi' => esc_html__( 'Sottovoci del menu principale, voce "Servizi"', 'design_scuole_italia' ),
			'menu-notizie' => esc_html__( 'Sottovoci del menu principale, voce "Novità"', 'design_scuole_italia' ),
			'menu-didattica' => esc_html__( 'Sottovoci del menu principale, voce "Didattica"', 'design_scuole_italia' ),
			/*'menu-classe' => esc_html__( 'Sottovoci del menu principale, voce "La mia classe"', 'design_scuole_italia' ),*/
			'menu-topright' => esc_html__( 'Menu secondario (in alto a destra)', 'design_scuole_italia' ),
			'menu-footer' => esc_html__( 'Menu a piè di pagina', 'design_scuole_italia' ),
		) );

	}
endif;
add_action( 'after_setup_theme', 'dsi_setup' );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function dsi_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Footer - colonna 1', 'design_scuole_italia' ),
		'id'            => 'footer-1',
		'description'   => esc_html__( 'Prima colonna a più di pagina.', 'design_scuole_italia' ),
		'before_widget' => '<div class="footer-list">',
		'after_widget'  => '</div>',
		'before_title'  => '<h2 class="h3">',
		'after_title'   => '</h2>',
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'Footer - colonna 2', 'design_scuole_italia' ),
		'id'            => 'footer-2',
		'description'   => esc_html__( 'Seconda colonna a più di pagina.', 'design_scuole_italia' ),
		'before_widget' => '<div class="footer-list">',
		'after_widget'  => '</div>',
		'before_title'  => '<h2 class="h3">',
		'after_title'   => '</h2>',
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'Footer - colonna 3', 'design_scuole_italia' ),
		'id'            => 'footer-3',
		'description'   => esc_html__( 'Terza colonna a più di pagina.', 'design_scuole_italia' ),
		'before_widget' => '<div class="footer-list">',
		'after_widget'  => '</div>',
		'before_title'  => '<h2 class="h3">',
		'after_title'   => '</h2>',
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'Footer - colonna 4', 'design_scuole_italia' ),
		'id'            => 'footer-4',
		'description'   => esc_html__( 'Quarta colonna a più di pagina.', 'design_scuole_italia' ),
		'before_widget' => '<div class="footer-list">',
		'after_widget'  => '</div>',
		'before_title'  => '<h2 class="h3">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'dsi_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function dsi_scripts() {

    //wp_deregister_script('jquery');

	wp_enqueue_style( 'dsi-wp-style', get_stylesheet_uri() );
	wp_enqueue_style( 'dsi-font', get_template_directory_uri() . '/assets/css/fonts.css');
	wp_enqueue_style( 'dsi-boostrap-italia', get_template_directory_uri() . '/assets/css/bootstrap-italia.css');
//	wp_enqueue_style( 'dsi-scuole', get_template_directory_uri() . '/assets/css/scuole.css');
  wp_enqueue_style( 'itt-scuole-marconi', get_template_directory_uri() . '/assets/css/scuole-marconi.css');
	wp_enqueue_style( 'dsi-overrides', get_template_directory_uri() . '/assets/css/overrides.css');
	wp_enqueue_style( 'dsi-carousel-style', get_template_directory_uri() . '/assets/css/carousel-style-double.css');
	wp_enqueue_style( 'dsi-splide-min', get_template_directory_uri() . '/assets/css/splide.min.css');

	wp_enqueue_script( 'dsi-modernizr', get_template_directory_uri() . '/assets/js/modernizr.custom.js');

	// print css
    	wp_enqueue_style('dsi-print-style', get_template_directory_uri() . '/print.css', array(),'20190912','print' );

	// footer
	wp_enqueue_script( 'dsi-boostrap-italia-js', get_template_directory_uri() . '/assets/js/bootstrap-italia.js', array(), false, true);
	wp_enqueue_script( 'dsi-splide-min', get_template_directory_uri() . '/assets/js/splide.min.js', array(), null, true);


    /*TODO: da definire se minifizzare*/
	wp_enqueue_script( 'dsi-jquery-easing', get_template_directory_uri() . '/assets/js/components/jquery-easing/jquery.easing.js', array('jquery'), false, true);	wp_enqueue_script( 'dsi-jquery-scrollto', get_template_directory_uri() . '/assets/js/components/jquery.scrollto/jquery.scrollTo.js', array(), false, true);
	wp_enqueue_script( 'dsi-jquery-responsive-dom', get_template_directory_uri() . '/assets/js/components/ResponsiveDom/js/jquery.responsive-dom.js', array(), false, true);
	wp_enqueue_script( 'dsi-jpushmenu', get_template_directory_uri() . '/assets/js/components/jPushMenu/jpushmenu.js', array(), false, true);
	wp_enqueue_script( 'dsi-perfect-scrollbar', get_template_directory_uri() . '/assets/js/components/perfect-scrollbar-master/perfect-scrollbar/js/perfect-scrollbar.jquery.js', array(), false, true);
	wp_enqueue_script( 'dsi-vallento', get_template_directory_uri() . '/assets/js/components/vallenato.js-master/vallenato.js', array(), false, true);
	wp_enqueue_script( 'dsi-jquery-responsive-tabs', get_template_directory_uri() . '/assets/js/components/responsive-tabs/js/jquery.responsiveTabs.js', array(), false, true);
	wp_enqueue_script( 'dsi-fitvids', get_template_directory_uri() . '/assets/js/components/fitvids/jquery.fitvids.js', array(), false, true);
	wp_enqueue_script( 'dsi-sticky-kit', get_template_directory_uri() . '/assets/js/components/sticky-kit-master/dist/sticky-kit.js', array(), false, true);
	wp_enqueue_script( 'dsi-jquery-match-height', get_template_directory_uri() . '/assets/js/components/jquery-match-height/dist/jquery.matchHeight.js', array(), false, true);

	if(is_singular(array("servizio", "struttura", "luogo", "evento", "scheda_progetto", "post", "circolare", "indirizzo")) || is_archive() || is_search() || is_post_type_archive("luogo")) {
		wp_enqueue_script( 'dsi-leaflet-js', get_template_directory_uri() . '/assets/js/components/leaflet/leaflet.js', array(), false, true);
    }

	wp_enqueue_script( 'dsi-scuole-js', get_template_directory_uri() . '/assets/js/scuole.js', array(), false, true);

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'dsi_scripts' );

function console_log ($output, $msg = "log") {
    echo '<script> console.log("'. $msg .'",'. json_encode($output) .')</script>';
};

/*
 * Set post views count using post meta
 */
function set_views($post_ID) {
	$key = 'views';
	$count = get_post_meta($post_ID, $key, true); //retrieves the count

	if($count == ''){ //check if the post has ever been seen

		//set count to 0
		$count = 0;

		//just in case
		delete_post_meta($post_ID, $key);

		//set number of views to zero
		add_post_meta($post_ID, $key, '0');

	} else{ //increment number of views
		$count++;
		update_post_meta($post_ID, $key, $count);
	}
}

//keeps the count accurate by removing prefetching
remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);

function add_menu_link_class( $atts, $item, $args ) {
	if (property_exists($args, 'link_class')) {
	  $atts['class'] = $args->link_class;
	}
	return $atts;
  }
  add_filter( 'nav_menu_link_attributes', 'add_menu_link_class', 1, 3 );

function add_file_types_to_uploads($file_types){
	$new_filetypes = array();
	$new_filetypes['svg'] = 'image/svg+xml';
	$new_filetypes['svgz'] = 'image/svg+xml';
	$file_types = array_merge($file_types, $new_filetypes );
	return $file_types;
}

add_action('upload_mimes', 'add_file_types_to_uploads');

/**
 * Consenti ricerca per argomenti/tags con tutti i content types
 */
function add_tags_to_all_content_types( $query ) {
  if ( is_admin() || ! $query->is_main_query() ) {
    return;
  }

  if($query->is_tag && $query->is_main_query()){
    $query->set('post_type', array('documento','luogo','struttura','page','servizio','indirizzo','evento','post','circolare','scheda_didattica','scheda_progetto','materia'));
  }
}

add_action( 'pre_get_posts', 'add_tags_to_all_content_types' );

/**
 * Marconi custom enqueue scripts and styles.
 */

//@customization Enqueue scripts from custom javascript file
function marconi_scripts() {
	wp_enqueue_script('jquery');
	wp_enqueue_script( 'marconi-js', get_template_directory_uri() . '/assets/js/marconi/marconi.js', array(), '0.4', true);
}
add_action( 'wp_enqueue_scripts', 'marconi_scripts' );

function lines_to_list($text) {
    // Normalize line breaks and split the text into lines
    $text = str_replace("\r\n", "\n", $text);
    $text = str_replace("\r", "\n", $text);
    $lines = explode("\n", $text);

    // Start the <ul> element
    $output = '<ul>';

    // Loop through each line and add it as a list item
    foreach ($lines as $line) {
        // Remove leading/trailing whitespace
        $line = trim($line);

        // Skip empty lines
        if (empty($line)) {
            continue;
        }

        $output .= '<li>' . esc_html($line) . '</li>';
    }

    // Close the </ul> element
    $output .= '</ul>';

    return $output;
}

// @customization Define a custom wpautop function that substitutes prefixed lines with links and icons
// valid prefixes:
// mail: mailto: link with email icon
// pec:  mailto: link with email checked icon
// tel:  tel: link with phone icon
// fax:  tel: link with fax icon
// map:  link to google maps search of the line
function wpautop_icons($content) {
    // Apply the existing wpautop function
    $content = lines_to_list($content);

    // Replace lines starting with mail:
    $content = preg_replace_callback(
        '/mail:([a-zA-Z0-9._%-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4})/',
        function($matches) {
            $email = $matches[1];
            $icon = '<svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512"><path d="M48 64C21.5 64 0 85.5 0 112c0 15.1 7.1 29.3 19.2 38.4L236.8 313.6c11.4 8.5 27 8.5 38.4 0L492.8 150.4c12.1-9.1 19.2-23.3 19.2-38.4c0-26.5-21.5-48-48-48H48zM0 176V384c0 35.3 28.7 64 64 64H448c35.3 0 64-28.7 64-64V176L294.4 339.2c-22.8 17.1-54 17.1-76.8 0L0 176z"/></svg>';
            return $icon . ' <a href="mailto:' . $email . '" aria-label="indirizzo email istituzionale dell\'Istituto">' . $email . '</a>';
        },
        $content
    );

    //<svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 640 512"><path d="M48 64C21.5 64 0 85.5 0 112c0 15.1 7.1 29.3 19.2 38.4L236.8 313.6c11.4 8.5 27 8.5 38.4 0l57.4-43c23.9-59.8 79.7-103.3 146.3-109.8l13.9-10.4c12.1-9.1 19.2-23.3 19.2-38.4c0-26.5-21.5-48-48-48H48zM294.4 339.2c-22.8 17.1-54 17.1-76.8 0L0 176V384c0 35.3 28.7 64 64 64H360.2C335.1 417.6 320 378.5 320 336c0-5.6 .3-11.1 .8-16.6l-26.4 19.8zM640 336a144 144 0 1 0 -288 0 144 144 0 1 0 288 0zm-76.7-43.3c6.2 6.2 6.2 16.4 0 22.6l-72 72c-6.2 6.2-16.4 6.2-22.6 0l-40-40c-6.2-6.2-6.2-16.4 0-22.6s16.4-6.2 22.6 0L480 353.4l60.7-60.7c6.2-6.2 16.4-6.2 22.6 0z"/></svg>
    $content = preg_replace_callback(
        '/pec:([a-zA-Z0-9._%-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4})/',
        function($matches) {
            $email = $matches[1];
            $icon = '<svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 640 512"><path d="M48 64C21.5 64 0 85.5 0 112c0 15.1 7.1 29.3 19.2 38.4L236.8 313.6c11.4 8.5 27 8.5 38.4 0l57.4-43c23.9-59.8 79.7-103.3 146.3-109.8l13.9-10.4c12.1-9.1 19.2-23.3 19.2-38.4c0-26.5-21.5-48-48-48H48zM294.4 339.2c-22.8 17.1-54 17.1-76.8 0L0 176V384c0 35.3 28.7 64 64 64H360.2C335.1 417.6 320 378.5 320 336c0-5.6 .3-11.1 .8-16.6l-26.4 19.8zM640 336a144 144 0 1 0 -288 0 144 144 0 1 0 288 0zm-76.7-43.3c6.2 6.2 6.2 16.4 0 22.6l-72 72c-6.2 6.2-16.4 6.2-22.6 0l-40-40c-6.2-6.2-6.2-16.4 0-22.6s16.4-6.2 22.6 0L480 353.4l60.7-60.7c6.2-6.2 16.4-6.2 22.6 0z"/></svg>';
            return $icon . ' <a href="mailto:' . $email . '" aria-label="indirizzo email PEC">' . $email . '</a>';
        },
        $content
    );


    // Replace lines starting with tel:
    $content = preg_replace_callback(
        '/tel:([0-9\.]+)/',
        function($matches) {
          $number = $matches[1];
          $icon = '<svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512"><path d="M164.9 24.6c-7.7-18.6-28-28.5-47.4-23.2l-88 24C12.1 30.2 0 46 0 64C0 311.4 200.6 512 448 512c18 0 33.8-12.1 38.6-29.5l24-88c5.3-19.4-4.6-39.7-23.2-47.4l-96-40c-16.3-6.8-35.2-2.1-46.3 11.6L304.7 368C234.3 334.7 177.3 277.7 144 207.3L193.3 167c13.7-11.2 18.4-30 11.6-46.3l-40-96z"/></svg>';
            return $icon . ' <a href="tel:' . $number . '" aria-label="numero del centralino">' . $number . '</a>';
        },
        $content
    );
    // <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M128 64v96h64V64H386.7L416 93.3V160h64V93.3c0-17-6.7-33.3-18.7-45.3L432 18.7C420 6.7 403.7 0 386.7 0H192c-35.3 0-64 28.7-64 64zM0 160V480c0 17.7 14.3 32 32 32H64c17.7 0 32-14.3 32-32V160c0-17.7-14.3-32-32-32H32c-17.7 0-32 14.3-32 32zm480 32H128V480c0 17.7 14.3 32 32 32H480c17.7 0 32-14.3 32-32V224c0-17.7-14.3-32-32-32zM256 256a32 32 0 1 1 0 64 32 32 0 1 1 0-64zm96 32a32 32 0 1 1 64 0 32 32 0 1 1 -64 0zm32 96a32 32 0 1 1 0 64 32 32 0 1 1 0-64zM224 416a32 32 0 1 1 64 0 32 32 0 1 1 -64 0z"/></svg>

    $content = preg_replace_callback(
        '/fax:([0-9\.]+)/',
        function($matches) {
          $number = $matches[1];
          $icon = '<svg aria-label="il numero che segue è il fax" xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512"><path d="M128 64v96h64V64H386.7L416 93.3V160h64V93.3c0-17-6.7-33.3-18.7-45.3L432 18.7C420 6.7 403.7 0 386.7 0H192c-35.3 0-64 28.7-64 64zM0 160V480c0 17.7 14.3 32 32 32H64c17.7 0 32-14.3 32-32V160c0-17.7-14.3-32-32-32H32c-17.7 0-32 14.3-32 32zm480 32H128V480c0 17.7 14.3 32 32 32H480c17.7 0 32-14.3 32-32V224c0-17.7-14.3-32-32-32zM256 256a32 32 0 1 1 0 64 32 32 0 1 1 0-64zm96 32a32 32 0 1 1 64 0 32 32 0 1 1 -64 0zm32 96a32 32 0 1 1 0 64 32 32 0 1 1 0-64zM224 416a32 32 0 1 1 64 0 32 32 0 1 1 -64 0z"/></svg>';
            return $icon . ' ' . $number;
        },
        $content
    );

    // Replace lines starting with map:
    $content = preg_replace_callback(
        '/map:(.+)\<\/li\>/',
        function($matches) {
            $address = urlencode($matches[1]);
            $icon = '<svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 384 512"><path d="M215.7 499.2C267 435 384 279.4 384 192C384 86 298 0 192 0S0 86 0 192c0 87.4 117 243 168.3 307.2c12.3 15.3 35.1 15.3 47.4 0zM192 128a64 64 0 1 1 0 128 64 64 0 1 1 0-128z"/></svg>';
            return $icon . ' <a href="https://www.google.com/maps/search/?api=1&query=' . $address . '" aria-label="Ricerca l\'indirizzo dell\'Istituto su Google Maps" target="_blank">' . $matches[1] . '</a>';
        },
        $content
    );

    return $content;
}

// Sistema temporaneamente i breadcrumb per alcune pagine
function breadcrumb_fix( $string, $arg1 ) {

    $string = str_replace("La Scuola", "Scuola",$string);
		$string = str_replace("Documenti", "Le carte della scuola",$string);
		$string = str_replace("Strutture", "Organizzazione",$string);
		$string = str_replace("?post_type=indirizzo","",$string);
		$string = str_replace("Indirizzo di Studio", "Indirizzi di studio",$string);

    return $string;
}
add_filter( 'breadcrumb_trail', 'breadcrumb_fix', 10, 3);

// Aggiunge un css personalizzato per l'interfaccia di Admin
function admin_theme_style() {
    wp_enqueue_style('admin-style', get_template_directory_uri() . '/assets/css/admin-style.css');
}
add_action('admin_enqueue_scripts', 'admin_theme_style');

