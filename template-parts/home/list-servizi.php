<?php
global $servizio;
$home_servizi_manuali = dsi_get_option("home_servizi_manuali", "homepage");

?>
<div class="wrapper position-relative slided-top">
    <div class="row variable-gutters mb-4 services-grid">
        <?php
        $home_is_selezione_automatica_servizi = dsi_get_option("home_is_selezione_automatica_servizi", "homepage");
        if($home_is_selezione_automatica_servizi != "false"){
            $args = array('post_type' => 'servizio',
                'posts_per_page' => 6,
            );
            $servizi = get_posts($args);
            foreach ($servizi as $servizio) {
                ?>
                <div class="col-lg-4 mb-4">
                    <?php get_template_part("template-parts/servizio/card", "noicon"); ?>
                </div><!-- /col-lg-4 -->
                <?php
            }
        }else {
            if (is_array($home_servizi_manuali) && count($home_servizi_manuali)) {
                foreach ($home_servizi_manuali as $idservizio){
                 $servizio = get_post($idservizio);
                    ?>
                    <div class="col-lg-4 mb-4">
                        <?php get_template_part("template-parts/servizio/card", "noicon"); ?>
                    </div><!-- /col-lg-4 -->
                    <?php

                }
            }
        }
        ?>
    </div><!-- /row -->
    <?php
    $landing_url = dsi_get_template_page_url("page-templates/servizi.php");
    if($landing_url) {
        ?>
        <div class="pb-5 text-center">
            <a class="btn btn-outline-purplelight btn-scopri" href="<?php echo $landing_url; ?>"><strong><?php _e("Scopri di più", "design_scuole_italia"); ?></strong><span class="btn-arrow" aria-hidden="true"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" focusable="false"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg></span></a>
        </div>
        <?php
    }
 ?>
</div><!-- /container --><?php
