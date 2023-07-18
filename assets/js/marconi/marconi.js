console.log("Enter Marconi Script");

jQuery('.section-hero-left .container').addClass('absolute-orizontal-position');

jQuery('.section-hero-left .container .hero-title .btn').on('mouseenter touchstart', function(e) {
	e.stopPropagation();
});
jQuery('.section-hero-left .container .hero-title .btn').on('mouseenter touchend', function(e) {
	e.stopPropagation();
});
jQuery('.section-hero-left .container .hero-title .btn').on('click', function(e) {
	e.stopPropagation();
});

jQuery('.section-hero-left').on('click', function() {
	console.log("Click on Hero");
	jQuery('.section-hero-left .container').toggleClass('sr-only sr-only-focusable');
});
jQuery('.section-hero-left').on('mouseenter touchstart', function() {
	jQuery('.section-hero-left .container').removeClass('sr-only sr-only-focusable');
	jQuery('.section-hero-left::before').css('opacity','0 !important');
});
jQuery('.section-hero-left').on('mouseleave touchend', function() {
	jQuery('.section-hero-left .container').addClass('sr-only sr-only-focusable');
	jQuery('.section-hero-left::before').css('opacity','0.5 !important');
});

