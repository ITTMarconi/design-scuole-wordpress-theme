<!-- Access Modal -->
<div class="modal fade" id="services-modal" tabindex="-1" role="dialog" aria-labelledby="accessModal" aria-hidden="false">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content perfect-scrollbar">
            <div class="modal-body">
                <form id="access-form" class="access-main-wrapper" name="loginform" id="loginform" action="<?php echo esc_url( site_url( 'wp-login.php', 'login_post' ) ); ?>" method="post">
                    <div class="container">
                        <div class="row variable-gutters mb-0 mb-lg-4 mb-xl-5">
                            <div class="col">
                                <h2 class="d-inline" id="accessModal"><?php _e("Accedi ai servizi", "design_scuole_italia"); ?>
                                    <button type="button" class="close dismiss" data-dismiss="modal" aria-label="Chiudi">
                                        <svg class="svg-cancel-large"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-cancel-large"></use></svg>
                                    </button>
                                </h2>
                            </div>
                        </div>
                        <div class="row variable-gutters justify-content-center pt-4 pt-xl-5">
                            <div class="col-lg-4">
                                <p class="text-intro"><?php echo dsi_get_option("login_messaggio", "login"); ?></p>
                                <div class="access-buttons">
                                    <?php
                                    $link_esterni = dsi_get_option("link_esterni", "login");
                                    if(isset($link_esterni) && is_array($link_esterni) && count($link_esterni)>0) {
                                        foreach ($link_esterni as $item) {
                                            ?>
                                            <a class="btn btn-petrol btn-block btn-lg rounded mb-3"
                                               href="<?php echo $item["url_link"]; ?>"><?php echo $item["nome_link"]; ?></a>
                                            <?php
                                        }
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- End Access Modal -->
