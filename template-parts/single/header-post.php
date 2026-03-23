<?php
global $post, $autore, $luogo, $c, $badgeclass;
$link_schede_documenti = dsi_get_meta("link_schede_documenti");
$file_documenti = dsi_get_meta("file_documenti");
$luoghi = dsi_get_meta("luoghi");
$persone = dsi_get_meta("persone");
$numerazione_circolare = dsi_get_meta("numerazione_circolare");

$image_url = get_the_post_thumbnail_url($post, "full");
$autore = get_user_by("ID", $post->post_author);
$has_thumb = has_post_thumbnail($post);
$is_guglielmo = has_term('il-guglielmo', 'tipologia-articolo', $post);
?>
<section class="section bg-white article-title<?php echo $has_thumb ? ' article-title-author' : ' article-title-small flex items-center'; ?>">
    <div class="flex flex-col md:flex-row w-full">
        <div class="<?php echo $has_thumb ? 'md:w-1/2' : 'w-full'; ?> flex flex-col justify-between pb-12 pt-0 md:pt-12 px-4 md:px-10 article-title-author-container">
            <div class="title-content">
                <h1><?php the_title(); ?></h1>
                <p class="mb-0"><?php echo dsi_get_meta("descrizione"); ?></p>
            </div><!-- /title-content -->
            <?php if (!$is_guglielmo) { ?>
            <div class="card card-avatar card-comments">
                <div class="card-body p-0">
                    <?php get_template_part("template-parts/autore/card"); ?>
                    <?php /* Commentati i commenti
                    if(dsi_get_option("show_contatore_commenti", "setup") != "false") { ?>
                    <div class="comments ml-auto">
                        <p><?php echo $post->comment_count; ?></p>
                    </div><!-- /comments -->
                    <?php } */ ?>
                </div><!-- /card-body -->
            </div><!-- /card card-avatar -->
            <?php } ?>
        </div><!-- /col -->
        <?php if($has_thumb): ?>
        <div class="md:w-1/2 flex items-center justify-center py-8 px-4">
            <img class="title-img max-w-full max-h-[260px] md:max-h-[440px]" src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr(get_the_title()); ?>" loading="lazy">
        </div><!-- /col -->
        <?php endif; ?>
    </div>
</section>
