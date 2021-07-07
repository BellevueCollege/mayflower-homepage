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
		$('#pathways-tab-scroll-zone').find('a[data-toggle="tab"].active').prev('a[data-toggle="tab"]').click();
	});
	$('#pathways-scroll-forward').click( function() {
		$('#pathways-tab-scroll-zone').find('a[data-toggle="tab"].active').next('a[data-toggle="tab"]').click();
	});
	$('#pathways-grid-view').click( function() {
		deactivatePathwaysModule();
	});
});

function activatePathwaysModule( target ) {
	//if ( ! jQuery('#pathways-module').hasClass('active')) {
		jQuery('#pathways-module').addClass('active');
		// Thanks to https://stackoverflow.com/a/33296765
		//console.log(target);
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

		if ( ! target.prev('a[data-toggle="tab"]').length ) {
			jQuery('#pathways-scroll-back').attr('disabled', true);
		} else if( ! target.next('a[data-toggle="tab"]').length ) {
			jQuery('#pathways-scroll-forward').attr('disabled', true);
		} else {
			jQuery('#pathways-scroll-back').attr('disabled', false);
			jQuery('#pathways-scroll-forward').attr('disabled', false);
		}

		console.log(target.next('a[data-toggle="tab"]').length);
	//}
}

function deactivatePathwaysModule() {
	jQuery('#pathways-module').removeClass('active').find('a[data-toggle="tab"]').removeClass('active').attr('aria-selected', false);
	jQuery('.pathways-card-tab').first().focus();
	window.location.href = window.location.href.replace(/#.*/,'#pathway-none');
	srSpeak('Note: Tab Content is now Hidden. Select a tab to display tab content.', 'polite');
}

/**
 * Add function to politely alert screen reader users of changes
 * 
 * Thanks to https://a11y-guidelines.orange.com/en/web/components-examples/make-a-screen-reader-talk/
 * 
 **/
function srSpeak(text, priority) {
	var el = document.createElement("div");
	var id = "speak-" + Date.now();
	el.setAttribute("id", id);
	el.setAttribute("aria-live", priority || "polite");
	el.classList.add("sr-only");
	document.body.appendChild(el);

	window.setTimeout(function () {
	  document.getElementById(id).innerHTML = text;
	}, 100);

	window.setTimeout(function () {
		document.body.removeChild(document.getElementById(id));
	}, 1000);
}