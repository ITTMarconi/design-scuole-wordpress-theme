<div id="pre-header">
    <div class="container">
        <div class="row variable-gutters">
            <div class="col-8">
                <a href="https://www.miur.gov.it/" target="_blank" aria-label="MIUR - Collegamento esterno - Apre su nuova scheda">
                    <strong>Ministero dell'Istruzione e del Merito</strong>
                </a>
            </div><!-- /col-6 -->
            <div class="col-2 d-flex align-items-center justify-content-end">

                <?php
                /*
                    if(!is_user_logged_in()) {
                        get_template_part("template-parts/header/header-anon");
                    }else{
                        get_template_part("template-parts/header/header-logged");
                    }
                    */
                ?>
                <?php
                $show_socials = dsi_get_option("show_socials", "socials");
                if ($show_socials == "true") : ?>
                    <div class="header-social">
                        <!-- <span>Seguici su:</span> -->
                        <div class="header-social-wrapper">
                            <?php if ($facebook = dsi_get_option("facebook", "socials")) : ?><a href="<?php echo $facebook; ?>" aria-label="facebook" title="vai alla pagina facebook"><svg class="icon it-social-facebook">
                                        <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#it-social-facebook"></use>
                                    </svg></a><?php
                                            endif; ?>
                            <?php if ($youtube = dsi_get_option("youtube", "socials")) : ?><a href="<?php echo $youtube; ?>" aria-label="youtube" title="vai alla pagina youtube"><svg class="icon it-social-youtube">
                                        <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#it-social-youtube"></use>
                                    </svg></a><?php
                                            endif; ?>
                            <?php if ($instagram = dsi_get_option("instagram", "socials")) : ?><a href="<?php echo $instagram; ?>" aria-label="instagram" title="vai alla pagina instagram"><svg class="icon it-social-instagram">
                                        <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#it-social-instagram"></use>
                                    </svg></a><?php
                                            endif; ?>
                            <?php if ($twitter = dsi_get_option("twitter", "socials")) : ?><a href="<?php echo $twitter; ?>" aria-label="twitter" title="vai alla pagina twitter"><svg class="icon it-social-twitter">
                                        <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#it-social-twitter"></use>
                                    </svg></a><?php
                                            endif; ?>
                            <?php if ($linkedin = dsi_get_option("linkedin", "socials")) : ?><a href="<?php echo $linkedin; ?>" aria-label="linkedin" title="vai alla pagina linkedin"><svg class="icon it-social-linkedin">
                                        <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#it-social-linkedin"></use>
                                    </svg></a><?php
                                            endif; ?>
                            <?php if ($telegram = dsi_get_option("telegram", "socials")) : ?><a href="<?php echo $telegram; ?>" aria-label="telegram" title="vai su Telegram"><svg class="icon it-social-telegram">
                                        <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#it-social-telegram"></use>
                                    </svg></a><?php
                                            endif; ?>
                        </div><!-- /header-social-wrapper -->
                    </div><!-- /header-social -->
                <?php endif ?>
                <div class="header-utils-sticky">

                </div>
                <div class="header-search d-flex flex-grow-1 align-items-center justify-content-end">
                    <button type="button" class="d-flex align-items-center search-btn" data-toggle="modal" data-target="#search-modal" aria-label="Cerca nel sito" data-element="search-modal-button">
                        <span class="d-none d-lg-block mr-2"><strong>Cerca</strong></span>
                        <svg class="svg-search">
                            <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-search"></use>
                        </svg>
                    </button>
                </div><!-- /header-search -->
            </div><!-- /col -->
            <div class="col-2 header-utils-wrapper">
                <div class="header-utils">
                    <?php
                    if (!is_user_logged_in()) {
                        get_template_part("template-parts/header/header-anon");
                    } else {
                        get_template_part("template-parts/header/header-logged");
                    }
                    ?>
                </div><!-- /header-utils -->
            </div><!-- /col-6 -->
        </div><!-- /row -->
    </div><!-- /container -->
</div>
<?php
