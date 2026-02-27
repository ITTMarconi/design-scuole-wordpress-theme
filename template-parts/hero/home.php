<?php
global $post, $messages;

$img_identita = dsi_get_option("immagine", "la_scuola");
$img_altezza = dsi_get_option("altezza_immagine", "la_scuola");
$testo_hero = dsi_get_option("testo_hero", "la_scuola");


//$id_scuola_principale = dsi_get_option("scuola_principale", "homepage");
$landing_url = dsi_get_template_page_url("page-templates/la-scuola.php");
?>
<section class="section bg-redbrown section-hero-marconi section-hero-left justify-content-center align-items-center" 
         style="background-image: url('<?php echo $img_identita; ?>'); min-height: <?php echo $img_altezza ?>px;">
    <?php
    if ($messages && !empty($messages)) {
        get_template_part("template-parts/home/messages");
    }
?>
  <?php if ($testo_hero) { ?>
    <h2 class="hero-text">
        <?php
        // Ensure it's a string; fallback to empty if not
        if (!is_string($testo_hero)) {
            $testo_hero = '';
        }

        // Split by '-', trim spaces, and filter out empty parts
        $parts = explode('-', $testo_hero);
        $parts = array_filter(array_map('trim', $parts));

        // Output each part in a <span>, or a single empty one if no parts
        if (!empty($parts)) {
            foreach ($parts as $part) {
                echo '<span>' . esc_html($part) . '</span>';
            }
        } else {
            echo '<span></span>'; // Or remove this if you prefer no output for empty cases
        }
        ?>
    </h2>
<?php } ?>

    <div class="hero-title sr-only sr-only-focusable">
        <div class="text-white font-weight-normal h4"><?php echo dsi_get_option("tipologia_scuola"); ?> </div>
        <h1><span class="text-white d-line d-xl-block"><?php echo dsi_get_option("nome_scuola"); ?></span> </h1>
        <h2 class="text-white font-weight-normal h3"><?php echo dsi_get_option("luogo_scuola"); ?></h2>
        <?php if ($landing_url) { ?>
            <a class="btn btn-sm btn-outline-white mt-4" href="<?php echo $landing_url; ?>" aria-label="Vai alla scuola"><?php _e("Vai alla scuola", "design_scuole_italia"); ?></a>
        <?php } ?>
    </div><!-- /hero-title -->
</section><!-- /section -->
