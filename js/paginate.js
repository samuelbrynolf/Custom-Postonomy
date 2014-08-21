(function(b,d,e){var c=function(f){return f.each(function(){var o=d(this),n,k,m,g=15,h;function j(p){p.preventDefault();d(p.target).trigger("tap",[p])}function i(){m=b.document.body.scrollTop;if(o.is("a")){h=o[0].href;o[0].href="#"}}function l(p){p.preventDefault();if(n&&n!==p.type){return false}n=p.type;clearTimeout(k);k=setTimeout(function(){n=null},1000);if(p.type==="touchend"&&Math.abs(b.document.body.scrollTop-m)>g){return false}if(h){o[0].href=h}h=null;j(p)}o.bind("touchstart",i).bind("touchend",l).bind("click",l)})};var a=d.fn.bind;d.fn.bind=function(f,g){if(/(^| )tap( |$)/.test(f)){c(this)}return a.apply(this,[f,g])}}(this,jQuery));

var $fCPT = jQuery.noConflict();

$fCPT(function() {

	var loadTarget = $fCPT('#js-cptItems');
	var links = $fCPT('#js-filters .filter');
	var currentPageLink = $fCPT('a.s-is-appHome');
	var currentPageUrl = currentPageLink.attr('href') + ' ' + currentPageLink.attr('data-role') + ' > * ';

	function loadContent(state) {
		var url = state.url;
		var caller = $fCPT('[data-id=' + state.caller + ']');
		if ($fCPT('#loadMessage').length === 0) {
			$fCPT('<p id="loadMessage">Loading...</p>').insertBefore(loadTarget);
		}
		
		var loadmsg = $fCPT('#loadMessage');
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
		var $this = $fCPT(this);
		$this.attr('data-id', 'link' + index);
	}).bind('tap', function(e) {
		e.preventDefault();
		var $this = $fCPT(this);
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