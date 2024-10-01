<!-- Access Modal -->
<div class="modal fade" id="access-modal" tabindex="-1" role="dialog" aria-labelledby="accessModal" aria-hidden="false">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content perfect-scrollbar">
      <div class="modal-body">
        <form id="access-form" class="access-main-wrapper" name="loginform" id="loginform" action="<?php echo esc_url(site_url('wp-login.php', 'login_post')); ?>" method="post">
          <div class="container">
            <div class="row variable-gutters mb-0 mb-lg-4 mb-xl-5">
              <div class="col">
                <h2 class="d-inline" id="accessModal">
                  <button type="button" class="close dismiss" data-dismiss="modal" aria-label="Chiudi">
                    <svg class="svg-cancel-large">
                      <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-cancel-large"></use>
                    </svg>
                  </button>
                </h2>
              </div>
            </div>
            <div class="row variable-gutters justify-content-center pt-4 pt-xl-5">
              <div class="col-lg-4 offset-lg-2 px-4 access-mobile-bg">
                <div class="access-login">
                  <h3><?php _e("Accesso Riservato Amministratori", "design_scuole_italia"); ?></h3>
                  <p class="text-large"><?php _e("Accesso riservato agli autori e amministratori", "design_scuole_italia"); ?></p>
                  <?php if (in_array('wp-spid-italia/wp-spid-italia.php', apply_filters('active_plugins', get_option('active_plugins')))) { ?>
                    <div class="col text-center pt-4">
                      <?php echo do_shortcode("[spid_login_button]"); ?>
                    </div>
                  <?php } ?>
                  <div class="access-login-form">
                    <div class="form-group">
                      <label for="login-email-field">Email address</label>
                      <input type="text" name="log" id="login-email-field" class="input form-control" value="" size="20" autocapitalize="off" aria-describedby="access-form" placeholder="La tua email">
                    </div>
                    <div class="form-group mb-3">
                      <label for="login-password-field">Password</label>
                      <input type="password" name="pwd" id="login-password-field" class="form-control" value="" size="20" aria-describedby="access-form" placeholder="Password">
                    </div>

                    <div class="row variable-gutters mb-4">
                      <div class="col text-right text-underline">
                        <p><a href="<?php echo esc_url(wp_lostpassword_url()); ?>" arial-label="<?php _e('Lost your password?'); ?>"><?php _e('Lost your password?'); ?></a></p>
                      </div>
                    </div>

                    <div class="row variable-gutters">
                      <div class="col-lg-6 mb-4">
                        <div class="form-check form-check-inline">
                          <input name="rememberme" type="checkbox" id="rememberme" value="forever" />
                          <label for="rememberme"><?php esc_html_e('Remember Me'); ?></label>
                        </div>
                      </div>
                      <div class="col-lg-6 mb-4">
                        <button type="submit" class="btn btn-white btn-block rounded" name="login" value="Accedi"><?php _e("Accedi", "design_scuole_italia"); ?></button>
                      </div>
                    </div>
                    <div class="nsl-container nsl-container-block nsl-container-login-layout-below" data-align="left" style="display: block;">
                      <div class="nsl-container-buttons"><a href="/wp-login.php?loginSocial=google&amp;redirect=https%3A%2F%2Fnew.marconirovereto.it%2Fwp-admin%2F" rel="nofollow" aria-label="Continue with <b>Google</b>" data-plugin="nsl" data-action="connect" data-provider="google" data-popupwidth="600" data-popupheight="600">
                          <div class="nsl-button nsl-button-default nsl-button-google" data-skin="light" style="background-color:#fff;">
                            <div class="nsl-button-svg-container"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                <path fill="#4285F4" d="M20.64 12.2045c0-.6381-.0573-1.2518-.1636-1.8409H12v3.4814h4.8436c-.2086 1.125-.8427 2.0782-1.7959 2.7164v2.2581h2.9087c1.7018-1.5668 2.6836-3.874 2.6836-6.615z"></path>
                                <path fill="#34A853" d="M12 21c2.43 0 4.4673-.806 5.9564-2.1805l-2.9087-2.2581c-.8059.54-1.8368.859-3.0477.859-2.344 0-4.3282-1.5831-5.036-3.7104H3.9574v2.3318C5.4382 18.9832 8.4818 21 12 21z"></path>
                                <path fill="#FBBC05" d="M6.964 13.71c-.18-.54-.2822-1.1168-.2822-1.71s.1023-1.17.2823-1.71V7.9582H3.9573A8.9965 8.9965 0 0 0 3 12c0 1.4523.3477 2.8268.9573 4.0418L6.964 13.71z"></path>
                                <path fill="#EA4335" d="M12 6.5795c1.3214 0 2.5077.4541 3.4405 1.346l2.5813-2.5814C16.4632 3.8918 14.426 3 12 3 8.4818 3 5.4382 5.0168 3.9573 7.9582L6.964 10.29C7.6718 8.1627 9.6559 6.5795 12 6.5795z"></path>
                              </svg></div>
                            <div class="nsl-button-label-container">Continua con <b>Google</b></div>
                          </div>
                        </a></div>
                    </div>
                    <!-- <div class="row variable-gutters">
                                            <div class="col text-center">
                                                <p>Non hai un account? <a href="#">Iscriviti</a></p>
                                            </div>
                                        </div> -->
                  </div>
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
