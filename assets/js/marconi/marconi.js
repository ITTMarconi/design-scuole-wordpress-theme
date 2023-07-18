console.log("Enter Marconi Script");

jQuery('#hero-container').addClass('absolute-orizontal-position');

jQuery('#hero-container .container .hero-title .btn').on('mouseenter touchstart', function(e) {
	e.stopPropagation();
});
jQuery('#hero-container .hero-title .btn').on('mouseenter touchend', function(e) {
	e.stopPropagation();
});
jQuery('#hero-container .hero-title .btn').on('click', function(e) {
	e.stopPropagation();
});


jQuery('.section-hero-left').on('click', function(e) {
	e.stopPropagation();
	jQuery('#hero-container').removeClass('sr-only sr-only-focusable');
});

jQuery('.section-hero-left').on('mouseenter touchstart', function(e) {
	e.stopPropagation();
	jQuery('#hero-container').removeClass('sr-only sr-only-focusable');
});
jQuery('.section-hero-left').on('mouseleave touchend', function(e) {
	e.stopPropagation();
	jQuery('#hero-container').addClass('sr-only sr-only-focusable');
});

jQuery('#main-container').on('click', function(e) {
	jQuery('#hero-container').addClass('sr-only sr-only-focusable');
});
jQuery('#main-container').on('mouseenter touchstart', function(e) {
	jQuery('#hero-container').addClass('sr-only sr-only-focusable');
});



/*
 * 
 * $(":not(selector)")
jQuery('.section-hero-left').on('mouseleave touchend', function() {
	jQuery('.section-hero-left .container').addClass('sr-only sr-only-focusable');
});
*/

