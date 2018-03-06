//Toggle list group for carousel list
jQuery(document).ready(function ($) {
    $('.list-group-col').hide();
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
});