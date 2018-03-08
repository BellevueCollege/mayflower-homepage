//Toggle list group for carousel list
jQuery(document).ready(function ($) {
	$('#carousel-featured-full').carousel({
		interval: false
	});

	$('#mhcarousel-next').click( function( e ) {
		e.preventDefault();
		$('#carousel-featured-full').carousel('next');
	});
	
	$('.mhcarousel-direct').click(function (e) {
		e.preventDefault();
		var slide_number = $(this).attr('data-slide-to');
		$('#carousel-featured-full').carousel(parseInt(slide_number) );
	});


	$('.list-group-icon').click(function( e ){
		e.preventDefault();
		if ( $('.list-group-col').css('display') == 'none'){ //if list is closed, then open
			$('.list-group-col').slideToggle();
			$('#list-group-glyph').toggleClass('glyphicon-list glyphicon-remove');
			$('.list-group-icon').attr('aria-label', 'Close Slide List').attr('aria-expanded', 'true');
			$('#mhcarousel-slide-list').focus();
		} else { //if list is opened, then close
			$('.list-group-col').slideToggle();
			$('#list-group-glyph').toggleClass('glyphicon-remove glyphicon-list');
			$('.list-group-icon').attr('aria-label', 'Open Slide List').attr('aria-expanded', 'false');;
		}
	});

	//Updates slide title for carousel next button
	$('#slide-title').html(carousel_posts[1]);
	$('#carousel-featured-full').on('slide.bs.carousel', function (e) {
		var next_slide_number = parseInt(e.relatedTarget.getAttribute('data-slide-number')) + 1;
		$('#slide-title').html(carousel_posts[next_slide_number]);
		
		// last slide shows first slide button title
		$('#slide-title').html(carousel_posts[next_slide_number - carousel_posts.length]);
	});

	//Add list-item-active to active slides on the list group
	$('#carousel-featured-full').on('slide.bs.carousel', function (e) {
		var currentActiveSlide = $(e.relatedTarget).index();
		var totalSlides = $('.item').length;
		for (var slide = 0; slide < totalSlides; slide++) {
			$("[data-slide-to='" + slide + "']").removeClass('list-item-active');
		}
		$("[data-slide-to='" + currentActiveSlide + "']").addClass('list-item-active');
	});

	var elements = document.getElementsByClassName('responsive-bg-img');
	for (var i = 0; i < elements.length; i++) {
		new ResponsiveBackgroundImage(elements[i]);
	}

	
});

/* Thanks to https://aclaes.com/responsive-background-images-with-srcset-and-sizes/ */
class ResponsiveBackgroundImage {

	constructor(element) {
		this.element = element;
		this.img = element.querySelector('img');
		this.src = '';

		this.img.addEventListener('load', () => {
			this.update();
		});

		if (this.img.complete) {
			this.update();
		}
	}

	update() {
		
		var src = typeof this.img.currentSrc !== 'undefined' ? this.img.currentSrc : this.img.src;
		if (this.src !== src) {
			this.src = src;
			this.element.style.backgroundImage = 'url("' + this.src + '")';

		}
	}
}

