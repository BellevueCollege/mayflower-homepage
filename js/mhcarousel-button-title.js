//Updates slide title for carousel next button
jQuery( document ).ready(function( $ ) {
    $( '#slide-title' ).html( carousel_posts[1] );
    $('#carousel-featured-full').on('slide.bs.carousel', function ( e ) {
        var next_slide_number = parseInt( e.relatedTarget.getAttribute( 'data-slide-number' ) ) + 1;
        $( '#slide-title' ).html( carousel_posts[next_slide_number] );

        // last slide shows first slide button title
        $( '#slide-title' ).html( carousel_posts[next_slide_number - carousel_posts.length] );
    });
});