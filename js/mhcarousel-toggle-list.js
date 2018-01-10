//Toggle list group for carousel list
jQuery(function() {
    jQuery(".list-group-tree").on('click', "[data-toggle=collapse]", function(){
        jQuery(this).toggleClass('in')
        jQuery(this).next(".list-group.collapse").collapse('toggle');
        jQuery("#list-group-glyph").toggleClass('glyphicon-th-list glyphicon-remove');
        return false;
    })
});