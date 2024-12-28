<?php
global $posts, $see_all_link, $card_type, $title;
?>
<section class="group/stripe mb-4 px-2 w-full">
  <header class="px-4 text-xl/5 flex items-end justify-start">
    <a class="group/link relative inline-flex items-baseline
      no-underline
      hover:no-underline
      cursor-pointer" href="<?php echo $see_all_link; ?>">
      <div class="text-2xl/6 font-semibold"><?php echo $title; ?></div>
      <div class="text-base/6 text-[#4b21f2] font-semibold cursor-pointer inline-block opacity-0 pl-2
        group-hover/link:opacity-100
        group-hover/link:motion-preset-slide-right"
        aria-label="Vedi tutti:"><?php _e('Vedi tutti','design_scuole_italia'); ?></div>
      <div class="absolute text-[#4b21f2] right-28 inline-flex items-center justify-center opacity-0
        transition duration-1000 ease-out

        group-hover/link:translate-x-[4.6rem]
        group-hover/stripe:motion-opacity-out-100
        group-hover/stripe:motion-duration-[2.00s]/opacity
        group-hover/stripe:motion-translate-x-out-[4.3rem]
        group-hover/stripe:motion-duration-[1.00s]/translate
        group-hover/stripe:motion-ease-out-cubic
        ">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
          fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="square" stroke-linejoin="miter"
          class="h-[1.7rem] group-hover/link:h-[1.2rem] group-hover/link:mt-[0.4rem] icon icon-tabler icons-tabler-outline icon-tabler-chevron-right">
          <path stroke="none" d="M0 0h24v24H0z" fill="none" />
          <path d="M9 6l6 6l-6 6" />
        </svg>
      </div>
    </a>
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
    <?php } ?>
  </div>

</section><!-- /section -->
<?php
