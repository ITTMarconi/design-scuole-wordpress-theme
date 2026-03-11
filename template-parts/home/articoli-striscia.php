<?php
global $posts, $see_all_link, $card_type, $title;
?>
<section class="group/stripe mb-4 px-2 w-full">
  <header class="px-4 flex items-center justify-start">
    <a class="group/link flex items-center no-underline hover:no-underline cursor-pointer w-full" href="<?php echo $see_all_link; ?>">
      <div class="text-2xl/6 font-semibold"><?php echo $title; ?></div>

      <!-- Chevron: sits right after title (before "Vedi tutti" in DOM) -->
      <!-- Opacity: appears on stripe hover -->
      <!-- Size: shrinks fast on link hover -->
      <!-- Slide: translates right past "Vedi tutti" after it has appeared -->
      <div class="opacity-0 transition-opacity duration-500 ease-in-out inline-flex
        group-hover/stripe:opacity-100">
        <div class="transition-transform duration-500 ease-in-out
          text-[#4b21f2] inline-flex items-center pl-0
          group-hover/link:translate-x-[5.75rem] group-hover/link:delay-[450ms]">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
            fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="square" stroke-linejoin="miter"
            class="transition-all duration-200 ease-in-out h-7 w-7
              group-hover/link:h-5 group-hover/link:w-5
              icon icon-tabler icons-tabler-outline icon-tabler-chevron-right">
            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
            <path d="M9 6l6 6l-6 6" />
          </svg>
        </div>
      </div>

      <!-- "Vedi tutti": typewriter effect — steps(10) reveals one character at a time -->
      <div class="text-base/6 text-[#4b21f2] font-semibold whitespace-nowrap overflow-hidden
        ![max-width:0px] transition-[max-width] duration-500 [transition-timing-function:steps(10,jump-both)]
        group-hover/link:![max-width:5.5rem] group-hover/link:pl-1"
        aria-label="Vedi tutti:"><?php _e('Vedi tutti','design_scuole_italia'); ?></div>
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
