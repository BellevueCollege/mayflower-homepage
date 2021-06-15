jQuery(document).ready(function ($) {
	$('.pathways-card').each(function() {
		/**
		 * Swap expand and collapse icons based on BS4 triggers
		 */
		$(this).find('.collapse').on('show.bs.collapse', function () {
			$(this).parent().find('.card-header').find('button').find('i.fas').removeClass('fa-chevron-down').addClass('fa-chevron-up');
		});
		$(this).find('.collapse').on('hide.bs.collapse', function () {
			$(this).parent().find('.card-header').find('button').find('i.fas').addClass('fa-chevron-down').removeClass('fa-chevron-up');
		});
	});

	$('#pathways-tab-scroll-zone').find('a[data-toggle="tab"]').on('show.bs.tab', function() { activatePathwaysModule( $(this) ) } );
	if ( $('#pathways-tab-scroll-zone').find('a[data-toggle="tab"].active').length ) {
		activatePathwaysModule( $('#pathways-tab-scroll-zone').find('a[data-toggle="tab"].active').first() );
	}

	$('#pathways-scroll-back').click( function() {
		$('#pathways-tab-scroll-zone').find('a[data-toggle="tab"].active').prev().click();
	});
	$('#pathways-scroll-forward').click( function() {
		$('#pathways-tab-scroll-zone').find('a[data-toggle="tab"].active').next().click();
	});
});

function activatePathwaysModule( target ) {
	//if ( ! jQuery('#pathways-module').hasClass('active')) {
		jQuery('#pathways-module').addClass('active');
		// Thanks to https://stackoverflow.com/a/33296765
		var outer = target.parent();
		var target = target;
		var outerWidth = outer.width();
		var targetWidth = target.outerWidth( true );
		var scrollWidth = 0;
		var allElements = outer.find('a[data-toggle="tab"]');
		for ( var i = 0; i < target.index(); i++ ) {
			scrollWidth += jQuery( allElements[i] ).outerWidth( true );
		}

		outer.parent().scrollLeft(Math.max(0, scrollWidth - (outerWidth - targetWidth)/2));
	//}
}