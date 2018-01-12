//If there's only one slide, hide carousel interface 
jQuery( document ).ready(function( $ ) {
	if ( carousel_slide_count == 1) {
		$('.carousel-controls').hide();
	}
});