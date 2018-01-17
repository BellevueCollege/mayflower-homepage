//Add list-item-active to active slides on the list group
jQuery( document ).ready(function( $ ) {
    $('#carousel-featured-full').on('slide.bs.carousel', function ( e ) {
        var currentActiveSlide = $(e.relatedTarget).index();
        var totalSlides = $('.item').length;
        for ( var slide = 0; slide < totalSlides ; slide++ ) {
            $("[data-slide-to='" + slide + "']").removeClass('list-item-active');
        }
        $("[data-slide-to='" + currentActiveSlide + "']").addClass('list-item-active');
    });
});
