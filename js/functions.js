var $spj = jQuery.noConflict();

$spj(function() {

	var loadTarget = $spj('#js-sample');
	var links = $spj('.m-filters__a');
	var currentPageLink = $spj('a.s-is-appHome');
	var currentPageUrl = currentPageLink.attr('href') + ' ' + currentPageLink.attr('data-role') + ' > * ';

	function loadContent(state) {
		var url = state.url;
		var caller = $spj('[data-id=' + state.caller + ']');
		if ($spj('#loadMessage').length === 0) {
			$spj('<p id="loadMessage">Laddar...</p>').insertBefore(loadTarget);
			//$spj('<p id="loadMessage">Laddar...</p>').insertBefore(loadTarget);
			//loadTarget.append('<p id="loadMessage">Laddar...</p>');
		}
		
		var loadmsg = $spj('#loadMessage');
		loadmsg.fadeIn('fast');
		links.removeClass('s-is-current');
		caller.addClass('s-is-current');

		function hideLoadmsg() {
			loadmsg.fadeOut('fast');
		}

		function contentSwitcher() {
			loadTarget.load(url, function() {
				loadTarget.fadeIn('medium', hideLoadmsg);
			});
		}
		loadTarget.hide(0, contentSwitcher);
	}
	
	links.each(function(index) {
		var $this = $spj(this);
		$this.attr('data-id', 'link' + index);
	}).bind('tap', function(e) {
		e.preventDefault();
		var $this = $spj(this);
		var loadUrl = $this.attr('href') + ' ' + $this.attr('data-role') + ' > *';
		var state = {
			url: loadUrl,
			caller: $this.attr('data-id')
		}
		History.pushState(state, $this.text(), $this.attr('href'));
	});
	
	History.Adapter.bind(window, 'statechange', function() {
		var state = History.getState().data;
		if (typeof state.url === 'undefined') {
			state.url = currentPageUrl;
			state.caller = currentPageLink.attr('data-id');
		}
		loadContent(state);
	});
});