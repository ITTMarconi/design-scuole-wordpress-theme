console.log("Enter Marconi Script");

function showHero(evt) {
  //evt.preventDefault();
  evt.stopPropagation();
  jQuery('.section-hero-marconi .hero-title').removeClass('sr-only sr-only-focusable');
	console.log("SHOW Hero");
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

