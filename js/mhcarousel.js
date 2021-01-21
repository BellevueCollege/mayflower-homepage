//Toggle list group for carousel list
jQuery(document).ready(function ($) {
	$('#home-carousel-featured-full').carousel({
		interval: false
	});


	//Updates slide title for carousel next button
	$('#slide-title').html(carousel_posts[1]);
	$('#home-carousel-featured-full').on('slide.bs.carousel', function (e) {
		var next_slide_number = parseInt(e.relatedTarget.getAttribute('data-slide-number')) + 1;
		$('#slide-title').html(carousel_posts[next_slide_number]);
		
		// last slide shows first slide button title
		$('#slide-title').html(carousel_posts[next_slide_number - carousel_posts.length]);
	});

	//Add list-item-active to active slides on the list group
	$('#home-carousel-featured-full').on('slide.bs.carousel', function (e) {
		var currentActiveSlide = $(e.relatedTarget).index();
		var totalSlides = $('.dropdown-item').length;
		for (var slide = 0; slide < totalSlides; slide++) {
			$("[data-slide-to='" + slide + "']").removeClass('active');
		}
		$("[data-slide-to='" + currentActiveSlide + "']").addClass('active');
	});

	var elements = document.getElementsByClassName('responsive-bg-img');
	for (var i = 0; i < elements.length; i++) {
		if ( elements[i].getElementsByTagName('img').length > 0 ) {
			new ResponsiveBackgroundImage(elements[i]);
		}
	}

	
});

/*
Thanks to https://aclaes.com/responsive-background-images-with-srcset-and-sizes/
Transpiled using typescript from https://es6console.com/
*/
var ResponsiveBackgroundImage = (function () {
	function ResponsiveBackgroundImage(element) {
		var _this = this;
		this.element = element;
		this.img = element.querySelector('img');
		this.src = '';
		this.img.addEventListener('load', function () {
			_this.update();
		});
		if (this.img.complete) {
			this.update();
		}
	}
	ResponsiveBackgroundImage.prototype.update = function () {
		var src = typeof this.img.currentSrc !== 'undefined' ? this.img.currentSrc : this.img.src;
		if (this.src !== src) {
			this.src = src;
			this.element.style.backgroundImage = 'url("' + this.src + '")';
		}
	};
	return ResponsiveBackgroundImage;
})();
