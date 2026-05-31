<?php
global $servizio;
if($servizio->post_status == "publish") {
    ?>
    <div class="card card-bg card-noicon rounded">
        <?php echo marconi_servizio_icon_svg(dsi_get_meta("icona", '_dsi_servizio_', $servizio->ID)); ?>
        <a href="<?php echo get_permalink($servizio); ?>">
            <div class="card-body">
                <div class="card-icon-content" id="card-desc-<?php echo $servizio->ID; ?>">
                    <p><strong><?php echo $servizio->post_title; ?></strong></p>
                </div><!-- /card-icon-content -->
            </div><!-- /card-body -->
            <div class="svc-foot">
                <?php $sottotitolo = dsi_get_meta("sottotitolo", '_dsi_servizio_', $servizio->ID);
                if (trim($sottotitolo) !== "") { ?>
                    <small><?php echo $sottotitolo; ?></small>
                <?php } ?>
                <span class="svc-arrow" aria-hidden="true">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" focusable="false"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
                </span>
            </div><!-- /svc-foot -->
        </a>
    </div><!-- /card card-bg rounded -->
    <?php
}