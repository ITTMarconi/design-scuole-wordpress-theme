<?php
global $posts, $see_all_link, $card_type, $title;
?>
<section class="mb-4 px-2 w-full">
  <header>
    <h2 class="px-4">
      <a class="no-underline inline-block hover:no-underline cursor-pointer" href="<?php echo $see_all_link ?>" class="rowTitle ltr-0">
        <div class="table-cell text-xl font-bold align-bottom"><?php echo $title ?></div>
        <div class="table-cell align-bottom aro-row-header">
          <div class="cursor-pointer inline-block opacity-0 max-w-0 transition-[max-width 1s, opacity 1s, transform .75s] see-all-link"><?php _e('Vedi tutti', 'design_scuole_italia'); ?></div>
          <div class="aro-row-chevron icon-akiraCaretRight"></div>
        </div>
      </a>
    </h2>
  </header>
  <div class="flex flex-nowrap items-start gap-5 relative w-full overflow-x-auto overflow-y-hidden 
        scrolling-auto snap-mandatory snap-x px-2 py-2 
        [&::-webkit-scrollbar]:hidden
        [&::-webkit-scrollbar]:w-2
        [&::-webkit-scrollbar-track]:rounded-full
        [&::-webkit-scrollbar-track]:bg-gray-100
        [&::-webkit-scrollbar-thumb]:rounded-full
        [&::-webkit-scrollbar-thumb]:bg-gray-300">
    <?php foreach ($posts as $post) { ?>
      <div class="snap-center flex-none basis-auto w-80 transition-transform hover:scale-x-105">
        <?php get_template_part('template-parts/single/card', $card_type); ?>
      </div>
    <?php } ?>
  </div>

</section><!-- /section -->
<?php
