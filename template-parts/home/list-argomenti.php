<?php
/**
 * Home "Argomenti" section — tag cloud.
 *
 * Section visibility is gated in home.php by the `home_argomenti` option
 * (it acts as the on/off switch for the whole section). The tags shown here
 * are ALL content tags, sized into three tiers by post count (popularity),
 * not the curated list. The chips sit on the petrol band created by the
 * argomenti hero, so they use a white pill on dark.
 */

$argo_tags = get_terms(array(
    'taxonomy'   => 'post_tag',
    'hide_empty' => true,
    'orderby'    => 'count',
    'order'      => 'DESC',
    'number'     => 40,
));

if (!is_wp_error($argo_tags) && !empty($argo_tags)) :

    $counts = wp_list_pluck($argo_tags, 'count');
    $min = min($counts);
    $max = max($counts);

    // Display alphabetically for scannability; the size still encodes popularity.
    usort($argo_tags, function ($a, $b) {
        return strcoll($a->name, $b->name);
    });

    // Tailwind utility set per tier (literal strings so the scanner picks them up).
    $tier_classes = array(
        1 => 'text-sm px-3 py-1 font-semibold',
        2 => 'text-base px-4 py-2 font-semibold',
        3 => 'text-xl px-5 py-2 font-bold',
    );
?>
<div class="wrapper position-relative slided-top">
    <div class="flex flex-wrap justify-center items-center gap-3 mb-4 px-2">
        <?php foreach ($argo_tags as $tag) :
            if ($max === $min) {
                $tier = 2;
            } else {
                $ratio = ($tag->count - $min) / ($max - $min);
                $tier  = $ratio > 0.66 ? 3 : ($ratio > 0.33 ? 2 : 1);
            }
            $count_label = sprintf(_n('%s contenuto', '%s contenuti', $tag->count, 'design_scuole_italia'), number_format_i18n($tag->count));
        ?>
            <a class="inline-flex items-center rounded-full bg-white text-[#17324d] no-underline shadow leading-none transition hover:shadow-lg <?php echo $tier_classes[$tier]; ?>"
               href="<?php echo esc_url(get_term_link($tag)); ?>"
               title="<?php echo esc_attr($count_label); ?>">
                <?php echo esc_html($tag->name); ?>
            </a>
        <?php endforeach; ?>
    </div>
    <?php
    $landing_url = dsi_get_template_page_url("page-templates/argomenti.php");
    if ($landing_url) :
    ?>
        <div class="pb-5 text-center">
            <a class="btn btn-outline-petrol" href="<?php echo $landing_url; ?>"><strong><?php _e("Scopri di più", "design_scuole_italia"); ?></strong></a>
        </div>
    <?php endif; ?>
</div><!-- /wrapper -->
<?php endif; ?>
