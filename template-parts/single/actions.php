<?php
global $post;
$parts = parse_url( home_url() );
$current_uri = "{$parts['scheme']}://{$parts['host']}" . add_query_arg( NULL, NULL );
if(is_singular()){
    $current_title = get_the_title();
}else if ( is_tag() ) {
    $current_title = __("Argomento", "design_scuole_italia").": ".single_cat_title( '', false );
} elseif ( is_category() ) {
    $current_title = single_tag_title( '', false );
} elseif ( is_tax("tipologia-articolo") ) {
    $current_title = single_term_title('', false);
} elseif ( is_tax("tipologia-servizio") ) {
    $current_title = __("Servizi per ", "design_scuole_italia").": ".single_term_title('', false);
} elseif ( is_post_type_archive() ) {
    $current_title = post_type_archive_title('', false);
}else{
    $current_title = dsi_get_option("nome_scuola");
}

$actions_suffix = is_singular() && isset( $post->ID ) ? $post->ID : md5( $current_uri );
$modal_id = 'modal-more-items-' . $actions_suffix;
$share_id = 'social-share-' . $actions_suffix;
$share_control_id = 'share-control-' . $actions_suffix;

?><div class="actions-wrapper actions-main">
    <a class="toggle-actions" href="#" title="Vedi azioni" data-target="#<?php echo esc_attr( $modal_id ); ?>" data-toggle="modal">
        <svg class="it-more-items"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#it-more-items"></use></svg>
        <span><?php _e("Stampa / Condividi", "design_scuole_italia"); ?></span>
    </a>
    <div class="modal fade modal-actions" id="<?php echo esc_attr( $modal_id ); ?>" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="link-list-wrapper">
                        <ul class="link-list">
                            <!--
							<li>
								<a href="#" class="list-item left-icon" title="Scarica il contenuto">
									<svg class="icon it-download"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#it-download"></use></svg>
									<span>Scarica</span>
								</a>
							</li>
							//-->
                            <?php if(is_singular("circolare")){ ?>
                            <li>
                                <a href="<?php echo add_query_arg( array( 'pdf' => 'true' ), get_permalink($post) ); ?>" class="list-item left-icon" title="<?php _e("Genera PDF", "design_scuole_italia"); ?>">
                                    <svg class="icon it-pdf"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#it-pdf-document"></use></svg>
                                    <span><?php _e("Genera PDF", "design_scuole_italia"); ?></span>
                                </a>
                            </li>
                            <?php } ?>
                            <li>
                                <a href="javascript:window.print();" class="list-item left-icon" title="<?php _e("Stampa il contenuto", "design_scuole_italia"); ?>">
                                    <svg class="icon it-print"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#it-print"></use></svg>
                                    <span><?php _e("Stampa", "design_scuole_italia"); ?></span>
                                </a>
                            </li>
                            <!--
							<li>
								<a href="#" class="list-item left-icon" title="Ascolta il contenuto">
									<svg class="icon it-hearing"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#it-hearing"></use></svg>
									<span>Ascolta</span>
								</a>
							</li>
							//-->
                            <li>
                                <a href="mailto:?subject=<?php echo urlencode($current_title); ?>&body=<?php echo urlencode($current_uri); ?>" class="list-item left-icon" title="<?php _e("Invia il contenuto", "design_scuole_italia"); ?>">
                                    <svg class="icon it-email"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#it-email"></use></svg>
                                    <span><?php _e("Invia", "design_scuole_italia"); ?></span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="list-item left-icon marconi-copy-link" data-copy-url="<?php echo esc_attr( $current_uri ); ?>" title="<?php _e("Copia il link", "design_scuole_italia"); ?>">
                                    <svg class="icon it-share"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#it-share"></use></svg>
                                    <span><?php _e("Copia link", "design_scuole_italia"); ?></span>
                                </a>
                            </li>
                            <li>
                                <a class="list-item collapsed link-toggle marconi-share-toggle" title="<?php _e("Condividi", "design_scuole_italia"); ?>" href="#<?php echo esc_attr( $share_id ); ?>" aria-expanded="false" aria-controls="<?php echo esc_attr( $share_id ); ?>" role="button" id="<?php echo esc_attr( $share_control_id ); ?>"> 
                                    <svg class="icon it-share"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#it-share"></use></svg>
                                    <span><?php _e("Condividi", "design_scuole_italia"); ?></span>
                                    <svg class="icon icon-toggle svg-arrow-down-small"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#svg-arrow-down-small"></use></svg>
                                </a>
                                <ul class="link-sublist" id="<?php echo esc_attr( $share_id ); ?>" role="region" aria-labelledby="<?php echo esc_attr( $share_control_id ); ?>" hidden>
                                    <li>
                                        <a class="list-item" href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode($current_uri); ?>" title="<?php _e("Condividi su", "design_scuole_italia"); ?>: Facebook" target="_blank" rel="noopener noreferrer">
                                            <svg class="icon it-social-facebook"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#it-social-facebook"></use></svg>
                                            <span>Facebook</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="list-item" href="https://twitter.com/share?text=<?php echo urlencode($current_title); ?>&url=<?php echo urlencode($current_uri); ?>" title="<?php _e("Condividi su", "design_scuole_italia"); ?>: Twitter"  target="_blank" rel="noopener noreferrer">
                                            <svg class="icon it-social-twitter"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#it-social-twitter"></use></svg>
                                            <span>Twitter</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="list-item" href="https://www.linkedin.com/shareArticle?mini=true&url=<?php echo urlencode($current_uri); ?>&title=<?php echo urlencode($current_title); ?>&source=<?php echo dsi_get_option("nome_scuola"); ?>" title="<?php _e("Condividi su", "design_scuole_italia"); ?>: Linkedin"  target="_blank" rel="noopener noreferrer">
                                            <svg class="icon it-social-linkedin"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#it-social-linkedin"></use></svg>
                                            <span>Linkedin</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div><!-- /modal-body -->
            </div><!-- /modal-content -->
        </div><!-- /modal-dialog -->
    </div><!-- /modal -->
    <script>
        jQuery(function($) {
            function marconiCopyText(text) {
                if (navigator.clipboard && window.isSecureContext) {
                    return navigator.clipboard.writeText(text);
                }

                var textarea = document.createElement('textarea');
                textarea.value = text;
                textarea.setAttribute('readonly', '');
                textarea.style.position = 'fixed';
                textarea.style.left = '-9999px';
                document.body.appendChild(textarea);
                textarea.select();

                return new Promise(function(resolve, reject) {
                    try {
                        document.execCommand('copy') ? resolve() : reject();
                    } catch (error) {
                        reject(error);
                    } finally {
                        document.body.removeChild(textarea);
                    }
                });
            }

            $('.marconi-copy-link').off('click.marconiCopyLink').on('click.marconiCopyLink', function(event) {
                event.preventDefault();
                var $link = $(this);
                var $label = $link.find('span').first();
                var defaultLabel = $label.text();

                marconiCopyText($link.data('copy-url')).then(function() {
                    $label.text('<?php echo esc_js( __( "Link copiato", "design_scuole_italia" ) ); ?>');
                    setTimeout(function() {
                        $label.text(defaultLabel);
                    }, 2000);
                }).catch(function() {
                    window.prompt('<?php echo esc_js( __( "Copia il link", "design_scuole_italia" ) ); ?>', $link.data('copy-url'));
                });
            });

            $('.marconi-share-toggle').off('click.marconiShare').on('click.marconiShare', function(event) {
                event.preventDefault();
                var $toggle = $(this);
                var $target = $($toggle.attr('href'));
                if (!$target.length) {
                    return;
                }
                var isOpening = $target.prop('hidden');
                $target.prop('hidden', !isOpening);
                $toggle.attr('aria-expanded', isOpening ? 'true' : 'false').toggleClass('active', isOpening);
            });
        });
    </script>
    </div><!-- /actions-wrapper --><?php
