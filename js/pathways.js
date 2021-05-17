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

	$('#pathways-tab-scroll-zone').find('a[data-toggle="tab"]').on('show.bs.tab', function (e) {
		if ( ! $('#pathways-tab-scroll-zone').hasClass('active')) {
			$('#pathways-tab-scroll-zone').addClass('active');
			// Thanks to https://stackoverflow.com/a/33296765
			var outer = $(this).parent();
			var target = $(this);
			var outerWidth = outer.width();
			var targetWidth = target.outerWidth( true );
			var scrollWidth = 0;
			var allElements = outer.find('a[data-toggle="tab"]');
			for ( var i = 0; i < target.index(); i++ ) {
				scrollWidth += $( allElements[i] ).outerWidth( true );
			}

			outer.parent().scrollLeft(Math.max(0, scrollWidth - (outerWidth - targetWidth)/2));
		}
	});
});