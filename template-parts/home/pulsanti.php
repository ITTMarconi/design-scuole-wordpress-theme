<?php
$visualizza_banner = dsi_get_option("visualizza_pulsanti", "homepage");
if($visualizza_banner == "si") {
    $pulsanti_group = dsi_get_option("pulsanti_group", "homepage");

    // @customization Marconi: "Accesso rapido" bar overlapping the Option B hero.
    if ( get_query_var( 'marconi_hero_evidenza' ) && ! empty( $pulsanti_group ) ) {
        ?>
    <nav class="marconi-accesso wrapper" aria-label="<?php esc_attr_e( 'Accesso rapido', 'design_scuole_italia' ); ?>">
        <ul class="marconi-accesso__list">
            <?php foreach ( $pulsanti_group as $pulsanti ) {
                if ( empty( $pulsanti['url'] ) || empty( $pulsanti['label'] ) ) continue;
                ?>
            <li>
                <a class="marconi-accesso__item" href="<?php echo esc_url( $pulsanti['url'] ); ?>">
                    <?php if ( ! empty( $pulsanti['icon'] ) ) { ?>
                    <i class="fa <?php echo esc_attr( $pulsanti['icon'] ); ?>" aria-hidden="true"></i>
                    <?php } ?>
                    <span><?php echo esc_html( $pulsanti['label'] ); ?></span>
                </a>
            </li>
            <?php } ?>
        </ul>
    </nav>
        <?php
        return;
    }
    ?>
    <div class="pulsanti-group wrapper position-relative">
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
