<?php
global $posts, $see_all_link, $card_type, $title;
?>
<section class="mb-4 px-2 w-full">
  <header>
    <h2 class="text-2xl font-bold"><?php echo $title ?></h2>
  </header>
  <div class="flex flex-nowrap items-start gap-5 relative z-0 w-full overflow-x-auto overflow-y-hidden 
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
        <?php get_template_part('template-parts/single/card', $card_type); ?>
      </div>
    <?php } ?>
  </div>

</section><!-- /section -->
<?php
