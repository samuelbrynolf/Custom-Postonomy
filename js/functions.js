(function() {
	var loadTarget = jQuery('#js-sample');
	var links = jQuery('.m-filters__a');
	var currentPageLink = jQuery('a.s-is-appHome');
	var currentPageUrl = currentPageLink.attr('href') + ' ' + currentPageLink.attr('data-role') + ' > * ';

	function loadContent(state) {
		var url = state.url;
		var caller = jQuery('[data-id=' + state.caller + ']');
		if (jQuery('#loadMessage').length === 0) {
			jQuery('<p id="loadMessage">Laddar...</p>').insertBefore(loadTarget);
		}
		var loadmsg = jQuery('#loadMessage');
		loadmsg.fadeIn('fast');
		links.removeClass('s-is-current');
		caller.addClass('s-is-current');

		function hideLoadmsg() {
			loadmsg.fadeOut('fast');
		}

		function contentSwitcher() {
			loadTarget.load(url, function() {
				jQuery(this).fadeIn('medium', hideLoadmsg);
			});
		}
		loadTarget.hide(0, contentSwitcher);
	}
	links.each(function(index) {
		var jQuerythis = jQuery(this);
		jQuerythis.attr('data-id', 'link' + index);
	}).on('click', function(e) {
		e.preventDefault();
		var jQuerythis = jQuery(this);
		var loadUrl = jQuerythis.attr('href') + ' ' + jQuerythis.attr('data-role') + ' > *';
		var state = {
			url: loadUrl,
			caller: jQuerythis.attr('data-id')
		}
		History.pushState(state, jQuerythis.text(), jQuerythis.attr('href'));
	});
	History.Adapter.bind(window, 'statechange', function() {
		var state = History.getState().data;
		if (typeof state.url === 'undefined') {
			state.url = currentPageUrl;
			state.caller = currentPageLink.attr('data-id');
		}
		loadContent(state);
	});
})();