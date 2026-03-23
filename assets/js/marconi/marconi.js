console.log("Enter Marconi Script");

function showHero(evt) {
  //evt.preventDefault();
  evt.stopPropagation();
  // Comment the following line to not show school red card	
  // jQuery('.section-hero-marconi .hero-title').removeClass('sr-only sr-only-focusable');
	//console.log("SHOW Hero");
}

function hideHero(evt) {
  jQuery('.section-hero-marconi .hero-title').addClass('sr-only sr-only-focusable');
	console.log("HIDE Hero");
}

// Rendi il bottone all'interno di #hero-container cliccabile
jQuery('.section-hero-marconi .hero-title .btn').on('touchstart', function(e) {
	//e.stopPropagation();
});
jQuery('.section-hero-marconi .hero-title .btn').on('click', function(e) {
	//e.stopPropagation();
});

// Visualizza il testo Hero se clicchi sull'immagine Hero
jQuery('.section-hero-marconi').on('touchstart', showHero);
jQuery('.section-hero-marconi').on('mouseenter', showHero);
jQuery('.section-hero-marconi').on('mouseleave', hideHero);
jQuery('.section-hero-marconi').on('click', showHero);

// Nascondi il testo Hero se clicchi su la zona sotto (#main-container)
jQuery('#main-container').on('click', hideHero);
jQuery('#main-container').on('touchstart', hideHero);

/*
 * 
 * $(":not(selector)")
jQuery('.section-hero-left').on('mouseleave touchend', function() {
	jQuery('.section-hero-left .container').addClass('sr-only sr-only-focusable');
});
*/

/**
 * Footer Archives & Categories Accordion
 */
jQuery(document).ready(function($) {
	// Handle traditional widget_archive widgets
	$('#footer-wrapper .widget_archive').each(function() {
		var $widget = $(this);
		var $heading = $widget.find('.widget-title, h2, h3').first();
		var $list = $widget.find('ul').first();
		
		if ($heading.length && $list.length) {
			setupAccordion($heading, $list);
		}
	});
	
	// Handle Gutenberg block archives (heading and list are siblings)
	$('#footer-wrapper .wp-block-archives-list').each(function() {
		var $list = $(this);
		var $heading = $list.siblings('.wp-block-heading, h2, h3').first();
		
		if ($heading.length) {
			setupAccordion($heading, $list);
		}
	});
	
	// Handle traditional widget_categories widgets
	$('#footer-wrapper .widget_categories').each(function() {
		var $widget = $(this);
		var $heading = $widget.find('.widget-title, h2, h3').first();
		var $list = $widget.find('ul').first();
		
		if ($heading.length && $list.length) {
			setupAccordion($heading, $list);
		}
	});
	
	// Handle Gutenberg block categories (heading and list are siblings)
	$('#footer-wrapper .wp-block-categories-list').each(function() {
		var $list = $(this);
		var $heading = $list.siblings('.wp-block-heading, h2, h3').first();
		
		if ($heading.length) {
			setupAccordion($heading, $list);
		}
	});
	
	// Handle custom taxonomy widgets (tipologia-articolo)
	$('#footer-wrapper .marconi-taxonomy-widget').each(function() {
		var $widget = $(this);
		var $heading = $widget.find('.wp-block-heading, h2, h3').first();
		var $list = $widget.find('.wp-block-taxonomy-list, ul').first();
		
		if ($heading.length && $list.length) {
			setupAccordion($heading, $list);
		}
	});
	
	// Handle Gutenberg block taxonomy lists (heading and list are siblings)
	$('#footer-wrapper .wp-block-taxonomy-list').each(function() {
		var $list = $(this);
		var $heading = $list.siblings('.wp-block-heading, h2, h3').first();
		
		if ($heading.length) {
			setupAccordion($heading, $list);
		}
	});
	
	function setupAccordion($heading, $list) {
		// Make heading clickable
		$heading.on('click', function() {
			$(this).toggleClass('active');
			$list.toggleClass('open');
		});
		
		// Add keyboard accessibility
		$heading.attr('tabindex', '0').attr('role', 'button').attr('aria-expanded', 'false');
		$list.attr('aria-hidden', 'true');
		
		$heading.on('keydown', function(e) {
			if (e.key === 'Enter' || e.key === ' ') {
				e.preventDefault();
				$(this).trigger('click');
			}
		});
		
		// Update aria attributes on toggle
		$heading.on('click', function() {
			var isOpen = $list.hasClass('open');
			$(this).attr('aria-expanded', isOpen);
			$list.attr('aria-hidden', !isOpen);
		});
	}
});

