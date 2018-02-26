//Toggle list group for carousel list
jQuery(document).ready(function ($) {
    $(".list-group-tree").on('click', "[data-toggle=collapse]", function () {
        $(this).toggleClass('in')
        $(this).next(".list-group.collapse").collapse('toggle');
        $("#list-group-glyph").toggleClass('glyphicon-list glyphicon-remove');
        return false;
    });
});