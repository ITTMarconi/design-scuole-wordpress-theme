console.log("Enter Marconi Script");

// Apply configurable hero video speed and loop delay.
jQuery(function($) {
	$('.section-hero-marconi video[data-playback-rate], .marconi-hero video[data-playback-rate]').each(function() {
		var video = this;
		var setPlaybackRate = function() {
			var speed = parseFloat(video.getAttribute('data-playback-rate'));
			if (isFinite(speed) && speed > 0) {
				video.defaultPlaybackRate = speed;
				video.playbackRate = speed;
			}
		};
		var loopDelay = parseFloat(video.getAttribute('data-loop-delay'));

		setPlaybackRate();
		video.addEventListener('loadedmetadata', setPlaybackRate);

		// prefers-reduced-motion: show the poster image instead of the video
		// (CSS hides the video; here we stop playback and the download).
		var reduceMotion = window.matchMedia ? window.matchMedia('(prefers-reduced-motion: reduce)') : null;
		var playVideo = function() {
			var playPromise = video.play();
			if (playPromise && 'function' === typeof playPromise.catch) {
				playPromise.catch(function() {});
			}
		};
		var applyMotionPreference = function() {
			var sources = video.querySelectorAll('source');
			if (reduceMotion && reduceMotion.matches) {
				video.pause();
				sources.forEach(function(source) {
					if (source.getAttribute('src')) {
						source.setAttribute('data-src', source.getAttribute('src'));
						source.removeAttribute('src');
					}
				});
				video.load();
			} else if (video.querySelector('source[data-src]')) {
				sources.forEach(function(source) {
					source.setAttribute('src', source.getAttribute('data-src'));
					source.removeAttribute('data-src');
				});
				video.load();
				playVideo();
			}
		};
		applyMotionPreference();
		if (reduceMotion) {
			if (reduceMotion.addEventListener) {
				reduceMotion.addEventListener('change', applyMotionPreference);
			} else if (reduceMotion.addListener) {
				reduceMotion.addListener(applyMotionPreference);
			}
		}

		if (isFinite(loopDelay) && loopDelay > 0) {
			video.addEventListener('ended', function() {
				window.setTimeout(function() {
					if (reduceMotion && reduceMotion.matches) {
						return;
					}
					video.currentTime = 0;
					var playPromise = video.play();
					if (playPromise && 'function' === typeof playPromise.catch) {
						playPromise.catch(function() {});
					}
				}, loopDelay * 1000);
			});
		}
	});
});

// iOS Safari applies :active only when a touchstart listener exists (press feedback
// on the "Accesso rapido" bar). Passive: does not delay scrolling.
document.addEventListener('touchstart', function() {}, { passive: true });

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

		// Add keyboard accessibility — start collapsed
		$heading.attr('tabindex', '0').attr('role', 'button').attr('aria-expanded', 'false');
		$list.attr('aria-hidden', 'true');
		// Links inside a collapsed aria-hidden container must not be reachable via Tab
		$list.find('a').attr('tabindex', '-1');

		$heading.on('keydown', function(e) {
			if (e.key === 'Enter' || e.key === ' ') {
				e.preventDefault();
				$(this).trigger('click');
			}
		});

		// Update aria attributes and focusability on toggle
		$heading.on('click', function() {
			var isOpen = $list.hasClass('open');
			$(this).attr('aria-expanded', isOpen);
			$list.attr('aria-hidden', !isOpen);
			// Restore or remove tab reachability to match visibility
			$list.find('a').attr('tabindex', isOpen ? '0' : '-1');
		});
	}
});

