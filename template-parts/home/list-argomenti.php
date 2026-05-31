<?php
/**
 * Home "Argomenti" section — tag cloud.
 *
 * Section visibility is gated in home.php by the `home_argomenti` option
 * (it acts as the on/off switch for the whole section). The tags shown here
 * are ALL content tags, filtered for noise, then sized into three tiers by
 * popularity using QUANTILES (balanced thirds) rather than a raw ratio — with
 * skewed data a ratio collapses almost everything into the small tier. The
 * chips sit on the petrol band created by the argomenti hero (white pill on
 * dark), are left-aligned on mobile and centred on desktop.
 *
 * Two knobs, both filterable so they can be tuned without editing this file:
 *   marconi_home_argomenti_exclude   — array of tag slugs to hide
 *   marconi_home_argomenti_min_count — minimum number of contents to appear
 */

$argo_exclude   = apply_filters('marconi_home_argomenti_exclude', array(
    'fuori-di-testa', // tag di test
    // Esempi di duplicati/varianti da nascondere (decommenta quelli che vuoi):
    // 'scienzafuturo',            // duplicato di "Scienza & Futuro"
    // 'appetito-vien-viaggiando', // duplicato di "L'appetito vien viaggiando"
));
$argo_min_count = (int) apply_filters('marconi_home_argomenti_min_count', 1);
$argo_limit     = 40;

$argo_tags = get_terms(array(
    'taxonomy'   => 'post_tag',
    'hide_empty' => true,
    'orderby'    => 'count',
    'order'      => 'DESC',
    'number'     => 60, // fetch extra, then filter down to $argo_limit
));

if (!is_wp_error($argo_tags) && !empty($argo_tags)) :

    // Filter out noise (excluded slugs / below the minimum count), then cap.
    $argo_tags = array_values(array_filter($argo_tags, function ($t) use ($argo_exclude, $argo_min_count) {
        return !in_array($t->slug, $argo_exclude, true) && $t->count >= $argo_min_count;
    }));
    $argo_tags = array_slice($argo_tags, 0, $argo_limit);

endif;

if (!empty($argo_tags)) :

    // Quantile tiers: rank by count desc, split into balanced thirds.
    $ranked = $argo_tags; // already count-desc from the query
    $total  = count($ranked);
    $tier_of = array();
    foreach ($ranked as $i => $t) {
        $tier_of[$t->term_id] = ($i < $total / 3) ? 3 : (($i < 2 * $total / 3) ? 2 : 1);
    }

    // Display alphabetically for scannability; size encodes the tier.
    usort($argo_tags, function ($a, $b) {
        return strcoll($a->name, $b->name);
    });

    // Tailwind utility set per tier (literal strings so the scanner picks them up).
    $tier_classes = array(
        1 => 'text-sm px-3 py-1 font-semibold',
        2 => 'text-base px-4 py-2 font-semibold',
        3 => 'text-lg px-5 py-2 font-bold',
    );
?>
<div class="wrapper position-relative slided-top">
    <div class="flex flex-wrap justify-start md:justify-center items-center gap-3 mb-4 px-2">
        <?php foreach ($argo_tags as $tag) :
            $tier = $tier_of[$tag->term_id];
            $count_label = sprintf(_n('%s contenuto', '%s contenuti', $tag->count, 'design_scuole_italia'), number_format_i18n($tag->count));
        ?>
            <a class="inline-flex items-center rounded-full bg-white text-[#17324d] no-underline shadow leading-none transition-all duration-150 hover:bg-[#3f5b6e] hover:text-white hover:-translate-y-0.5 hover:shadow-lg focus-visible:bg-[#3f5b6e] focus-visible:text-white <?php echo $tier_classes[$tier]; ?>"
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
            <a class="btn btn-outline-petrol btn-scopri" href="<?php echo $landing_url; ?>"><strong><?php _e("Scopri di più", "design_scuole_italia"); ?></strong><span class="btn-arrow" aria-hidden="true"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" focusable="false"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg></span></a>
        </div>
    <?php endif; ?>
</div><!-- /wrapper -->
<?php endif; ?>
