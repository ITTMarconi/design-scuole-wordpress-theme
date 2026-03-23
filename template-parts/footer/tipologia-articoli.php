<?php
/**
 * Template part for displaying Tipologia Articoli taxonomy in footer
 * Replaces the standard Categories widget
 */

// Get terms from tipologia-articolo taxonomy
$terms = get_terms(array(
    'taxonomy' => 'tipologia-articolo',
    'hide_empty' => true,
));

if (!empty($terms) && !is_wp_error($terms)) : ?>
    <div class="wp-block-group marconi-taxonomy-widget">
        <div class="wp-block-group__inner-container">
            <h2 class="wp-block-heading">Categorie</h2>
            <ul class="wp-block-archives-list wp-block-taxonomy-list tipologia-articolo-list">
                <?php foreach ($terms as $term) : 
                    $term_link = get_term_link($term);
                ?>
                    <li>
                        <a href="<?php echo esc_url($term_link); ?>">
                            <?php echo esc_html($term->name); ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
<?php endif; ?>
