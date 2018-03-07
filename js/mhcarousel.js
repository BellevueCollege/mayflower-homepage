//Toggle list group for carousel list
jQuery(document).ready(function ($) {
	$('.list-group-icon').click(function(){
		if ( $('.list-group-col').css('display') == 'none'){ //if list is closed, then open
			$('.list-group-col').slideToggle();
			$('#list-group-glyph').toggleClass('glyphicon-list glyphicon-remove');
			$('.list-group-icon').attr('aria-label', 'Close Slide List');
		} else { //if list is opened, then close
			$('.list-group-col').slideToggle();
			$('#list-group-glyph').toggleClass('glyphicon-remove glyphicon-list');
			$('.list-group-icon').attr('aria-label', 'Open Slide List');
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
});