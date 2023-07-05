<?php
$visualizza_banner = dsi_get_option("visualizza_pulsanti", "homepage");
if($visualizza_banner == "si") {
    $pulsanti_group = dsi_get_option("pulsanti_group", "homepage");
    ?>
    <div class="pulsanti-group container position-relative">
        <div class="d-flex justify-content-center row variable-gutters mb-3">
            <?php
            foreach ($pulsanti_group as $pulsanti){
                ?>
                  <a href='<?php echo $pulsanti["url"] ?>' class='beautiful-button <?php echo $pulsanti["class"] ?>'>
                    <i class='fa <?php echo $pulsanti["icon"] ?>' aria-hidden="true"></i>
                    <?php echo $pulsanti["label"] ?>
                  </a>
                <?php
            }
            ?>
        </div>
    </div><!-- /container -->

    <?php
}

