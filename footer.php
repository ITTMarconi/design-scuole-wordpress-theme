<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Design_Scuole_Italia
 */
?>
<footer id="footer-wrapper" class="footer-wrapper">
    <div class="container">
        <div class="row variable-gutters mb-5">
            <div class="col logos-wrapper">
                <img class="ue-logo"
                    src="<?php echo esc_url( get_template_directory_uri() . '/assets/img/logo-eu-inverted.svg' ); ?>"
                    alt="Finanziato dall' Unione Europea - Next generation EU"
                >
                <div class="logo-footer">
                    <a href="<?php echo home_url(); ?>" class="logo-header" <?php echo is_front_page() ? 'aria-current="page"' : ''; ?>>
                    <?php get_template_part("template-parts/common/logo", null, array( 'ignora_stemma_scuola' => true )); ?>
                    <span class="h1">     
                        <span><?php echo dsi_get_option("tipologia_scuola"); ?></span>
                        <span><strong><?php echo dsi_get_option("nome_scuola"); ?></strong></span>
                        <span><?php echo dsi_get_option("luogo_scuola"); ?></span>
                        <?php if (!is_front_page()): ?>
                        <span class="sr-only">— Visita la pagina iniziale della scuola</span>
                        <?php endif; ?>
                    </span>
                    </a>
                </div><!-- /logo-footer -->
            </div><!-- /col -->
        </div><!-- /row -->
        <div class="row variable-gutters mb-3">
            <div class="col-lg-3">
                <?php dynamic_sidebar( 'footer-1' ); ?>
            </div><!-- /col-lg-3 -->
            <div class="col-lg-3">
                <?php dynamic_sidebar( 'footer-2' ); ?>
            </div><!-- /col-lg-3 -->

            <div class="col-lg-3">
                <?php dynamic_sidebar( 'footer-3' ); ?>
            </div><!-- /col-lg-3 -->

            <div class="col-lg-3">
                <?php dynamic_sidebar( 'footer-4' ); ?>
            </div><!-- /col-lg-3 -->
        </div><!-- /row -->

        <div class="row variable-gutters">
            <div class="col-lg-12 sub-footer">
                <?php
                $location = "menu-footer";
                if ( has_nav_menu( $location ) ) {
                    wp_nav_menu(array(
                        "theme_location" => $location,
                        "depth" => 1,
                        "menu_class" => "footer-inline-menu",
                        "container" => "",
                        'walker' => new Footer_Menu_Walker()
                    ));
                }
                ?>
                <?php
                $show_socials = dsi_get_option( "show_socials", "socials" );
                if($show_socials == "true") : ?>
                    <div class="footer-social">
                        <span>Seguici su:</span>
                        <div class="footer-social-wrapper">
                            <?php if($facebook = dsi_get_option( "facebook", "socials" )) :?><a href="<?php echo $facebook; ?>" aria-label="facebook" title="vai alla pagina facebook"><svg class="icon it-social-facebook"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#it-social-facebook"></use></svg></a><?php endif; ?>
                            <?php if($youtube = dsi_get_option( "youtube", "socials" )) :?><a href="<?php echo $youtube; ?>" aria-label="youtube" title="vai alla pagina youtube"><svg class="icon it-social-youtube"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#it-social-youtube"></use></svg></a><?php endif; ?>
                            <?php if($instagram = dsi_get_option( "instagram", "socials" )) :?><a href="<?php echo $instagram; ?>" aria-label="instagram" title="vai alla pagina instagram"><svg class="icon it-social-instagram"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#it-social-instagram"></use></svg></a><?php endif; ?>
                            <?php if($twitter = dsi_get_option( "twitter", "socials" )) :?><a href="<?php echo $twitter; ?>" aria-label="twitter" title="vai alla pagina twitter"><svg class="icon it-social-twitter"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#it-social-twitter"></use></svg></a><?php endif; ?>
                            <?php if($linkedin = dsi_get_option( "linkedin", "socials" )) :?><a href="<?php echo $linkedin; ?>" aria-label="linkedin" title="vai alla pagina linkedin"><svg class="icon it-social-linkedin"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#it-social-linkedin"></use></svg></a><?php endif; ?>
                            <?php if($telegram = dsi_get_option( "telegram", "socials" )) :?><a href="<?php echo $telegram; ?>" aria-label="telegram" title="vai su Telegram"><svg class="icon it-social-telegram"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#it-social-telegram"></use></svg></a><?php endif; ?>
                        </div><!-- /footer-social-wrapper -->
                    </div><!-- /footer-social -->
                <?php endif ?>
            </div>
        </div><!-- /row -->
        <!--@customization add banners for badges and sponsors -->
        <?php get_template_part("template-parts/home/banners-grid"); ?>
        <!--@end customization -->
        <?php
        $contatti_indirizzo = dsi_get_option("contatti_indirizzo", "contacts");
        $icon_indirizzo = '<svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 384 512"><path d="M215.7 499.2C267 435 384 279.4 384 192C384 86 298 0 192 0S0 86 0 192c0 87.4 117 243 168.3 307.2c12.3 15.3 35.1 15.3 47.4 0zM192 128a64 64 0 1 1 0 128 64 64 0 1 1 0-128z"/></svg>';

        $contatti_centralino = dsi_get_option("contatti_centralino", "contacts");
        $icon_centralino = '<svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512"><path d="M164.9 24.6c-7.7-18.6-28-28.5-47.4-23.2l-88 24C12.1 30.2 0 46 0 64C0 311.4 200.6 512 448 512c18 0 33.8-12.1 38.6-29.5l24-88c5.3-19.4-4.6-39.7-23.2-47.4l-96-40c-16.3-6.8-35.2-2.1-46.3 11.6L304.7 368C234.3 334.7 177.3 277.7 144 207.3L193.3 167c13.7-11.2 18.4-30 11.6-46.3l-40-96z"/></svg>';
        $contatti_fax = dsi_get_option("contatti_fax", "contacts");
        $icon_fax = '<svg aria-label="il numero che segue è il fax" xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512"><path d="M128 64v96h64V64H386.7L416 93.3V160h64V93.3c0-17-6.7-33.3-18.7-45.3L432 18.7C420 6.7 403.7 0 386.7 0H192c-35.3 0-64 28.7-64 64zM0 160V480c0 17.7 14.3 32 32 32H64c17.7 0 32-14.3 32-32V160c0-17.7-14.3-32-32-32H32c-17.7 0-32 14.3-32 32zm480 32H128V480c0 17.7 14.3 32 32 32H480c17.7 0 32-14.3 32-32V224c0-17.7-14.3-32-32-32zM256 256a32 32 0 1 1 0 64 32 32 0 1 1 0-64zm96 32a32 32 0 1 1 64 0 32 32 0 1 1 -64 0zm32 96a32 32 0 1 1 0 64 32 32 0 1 1 0-64zM224 416a32 32 0 1 1 64 0 32 32 0 1 1 -64 0z"/></svg>';
        $contatti_PEO = dsi_get_option("contatti_PEO", "contacts");
        $icon_PEO = '<svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512"><path d="M48 64C21.5 64 0 85.5 0 112c0 15.1 7.1 29.3 19.2 38.4L236.8 313.6c11.4 8.5 27 8.5 38.4 0L492.8 150.4c12.1-9.1 19.2-23.3 19.2-38.4c0-26.5-21.5-48-48-48H48zM0 176V384c0 35.3 28.7 64 64 64H448c35.3 0 64-28.7 64-64V176L294.4 339.2c-22.8 17.1-54 17.1-76.8 0L0 176z"/></svg>';
        $contatti_PEC = dsi_get_option("contatti_PEC", "contacts");
        $icon_PEC = '<svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 640 512"><path d="M48 64C21.5 64 0 85.5 0 112c0 15.1 7.1 29.3 19.2 38.4L236.8 313.6c11.4 8.5 27 8.5 38.4 0l57.4-43c23.9-59.8 79.7-103.3 146.3-109.8l13.9-10.4c12.1-9.1 19.2-23.3 19.2-38.4c0-26.5-21.5-48-48-48H48zM294.4 339.2c-22.8 17.1-54 17.1-76.8 0L0 176V384c0 35.3 28.7 64 64 64H360.2C335.1 417.6 320 378.5 320 336c0-5.6 .3-11.1 .8-16.6l-26.4 19.8zM640 336a144 144 0 1 0 -288 0 144 144 0 1 0 288 0zm-76.7-43.3c6.2 6.2 6.2 16.4 0 22.6l-72 72c-6.2 6.2-16.4 6.2-22.6 0l-40-40c-6.2-6.2-6.2-16.4 0-22.6s16.4-6.2 22.6 0L480 353.4l60.7-60.7c6.2-6.2 16.4-6.2 22.6 0z"/></svg>';

        $contatti_CF = dsi_get_option("contatti_CF", "contacts");
        $contatti_meccanografico = dsi_get_option("contatti_meccanografico", "contacts");
        $contatti_IPA = dsi_get_option("contatti_IPA", "contacts");
        $contatti_CUF = dsi_get_option("contatti_CUF", "contacts");
        $contatti_AOO = dsi_get_option("contatti_AOO", "contacts");

        $footer_text = dsi_get_option("footer_text", "setup");

        if($contatti_indirizzo || $contatti_centralino || $contatti_PEO || $contatti_PEC || $contatti_CF || $contatti_meccanografico || $contatti_IPA || $contatti_CUF || (isset($footer_text) && trim($footer_text) != "")) {
        ?>
        <div class="row variable-gutters mb-3">
            <div class="col-lg-12 text-left text-md-center footer-text">

                <?php if($contatti_indirizzo) { 
                  $address = urlencode($contatti_indirizzo); 
                  echo $icon_indirizzo; ?>
                <a class="text-underline-hover" href="<?php echo 'https://www.google.com/maps/search/?api=1&query=' . $address . ';' ?>" aria-label="Ricerca l\'indirizzo dell\'Istituto su Google Maps" target="_blank"  title="Visualizza su Google Maps">
                    <?php echo $contatti_indirizzo; ?>
                </a>
                <?php } ?>

                <?php if($contatti_centralino || $contatti_PEO || $contatti_PEC) { ?>
                    <ul class="list-inline">
                        <?php if($contatti_centralino) { ?>
                            <li class="list-inline-item">
                                <?php echo $icon_centralino; ?>
                                <a class="text-underline-hover" href="tel:<?php echo str_replace(' ', '', $contatti_centralino); ?>" aria-label="numero del centralino">
                                    <?php echo $contatti_centralino; ?>
                                </a>
                            </li>
                        <?php } ?>
                        <?php if($contatti_fax) { ?>
                            <li class="list-inline-item">
                                <?php echo $icon_fax; ?>
                                <?php echo $contatti_fax; ?>
                            </li>
                        <?php } ?>

                        <?php if($contatti_PEO) { ?>
                            <li class="list-inline-item">
                                <?php echo $icon_PEO; ?>
                                <a class="text-underline-hover" href="mailto:<?php echo str_replace(' ', '', $contatti_PEO); ?>" aria-label="indirizzo email istituzionale dell\'Istituto">
                                    <?php echo $contatti_PEO; ?>
                                </a>
                            </li>
                        <?php } ?>
                        <?php if($contatti_PEC) { ?>
                            <li class="list-inline-item">
                                <?php echo $icon_PEC; ?>
                                <a class="text-underline-hover" href="mailto:<?php echo str_replace(' ', '', $contatti_PEC); ?>" aria-label="indirizzo email PEC">
                                    <?php echo $contatti_PEC; ?>
                                </a>
                            </li>
                        <?php } ?>
                    </ul>
                <?php } ?>

                <?php if($contatti_CF || $contatti_meccanografico || $contatti_IPA || $contatti_CUF) { ?>
                    <ul class="list-unstyled">
                        <?php if($contatti_CF) { ?>
                            <li><abbr title="Codice Fiscale">CF</abbr>: <?php echo $contatti_CF; ?></li>
                        <?php } ?>
                        <?php if($contatti_meccanografico) { ?>
                            <li><abbr title="Codice meccanografico di istituto">CM</abbr>: <a class="text-underline-hover" href="https://cercalatuascuola.istruzione.it/cercalatuascuola/ricerca/risultati?tipoRicerca=RAPIDA&rapida=<?php echo str_replace(' ', '', $contatti_meccanografico); ?>"><?php echo $contatti_meccanografico; ?></a></li>
                        <?php } ?>
                        <?php if($contatti_IPA) { ?>
                            <li><abbr title="Codice Indice delle Pubbliche Amministrazioni">IPA</abbr>: <?php echo $contatti_IPA; ?></li>
                        <?php } ?>
                        <?php if($contatti_CUF) { ?>
                            <li><abbr title="Codice Unico di Fatturazione">CUF</abbr>: <?php echo $contatti_CUF; ?></li>
                        <?php } ?>
                        <?php if($contatti_AOO) { ?>
                            <li><abbr title="Area Organizzativa Omogenea">AOO</abbr>: <?php echo $contatti_AOO; ?></li>
                        <?php } ?>
                    </ul>
                <?php } ?>
                <?php echo wpautop($footer_text); ?>
            </div>
        </div>
        <?php
        }
        get_template_part("template-parts/common/copy");
        ?>
    </div><!-- /container -->
</footer>

<?php wp_footer(); ?>

</body>
</html>
