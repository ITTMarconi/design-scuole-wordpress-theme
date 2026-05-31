<?php
global $servizio;
if($servizio->post_status == "publish") {
    ?>
    <div class="card card-bg card-noicon rounded">
        <a href="<?php echo get_permalink($servizio); ?>">
            <div class="card-body">
                <div class="card-icon-content" id="card-desc-<?php echo $servizio->ID; ?>">
                    <p><strong><?php echo $servizio->post_title; ?></strong></p>
                    <?php $sottotitolo = dsi_get_meta("sottotitolo", '_dsi_servizio_', $servizio->ID);
                    if (trim($sottotitolo) !== "") { ?>
                        <small><?php echo $sottotitolo; ?></small>
                    <?php } ?>
                </div><!-- /card-icon-content -->
            </div><!-- /card-body -->
        </a>
    </div><!-- /card card-bg rounded -->
    <?php
}