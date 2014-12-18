(function( $ ) {
    "use strict";
 
    $(function() {

	var loadTarget = $('#js-cptItems');
	var linksParent = $('#js-filters'); 
	var links = linksParent.find('.filter'); 
	var nextPostsLink = $('#js-nextPostsLink');
	var urlSplit = nextPostsLink.attr('href').toString().split(/(\/page\/)(\d*\/?$)/);
	
	if(linksParent.length){
		var currentPageLink = linksParent.find('a.s-is-appHome');
		var currentPageUrl = currentPageLink.attr('href') + ' ' + currentPageLink.attr('data-role') + ' > * ';
	} else {
		var currentPageLink = nextPostsLink;
		var currentPageUrl = urlSplit[0] + ' ' + nextPostsLink.attr('data-role') + ' > * ';
	}

	function loadContent(state) {
		var url = state.url;
		if(state.caller === nextPostsLink.attr('data-id')){
			var pushedPageNum = state.pagesNum;
			var contentID = 'page-'+pushedPageNum;
			var newContentNum = $('.js-addedPage').length+1;
			
			function contentAdder() {
				loadTarget.append($('<div/>', { id: contentID, class: 'js-addedPage' }));
				var contentIDObj = $('#'+contentID);
				contentIDObj.load(url, function(response, status, xhr){
					if ( status == 'error' ) {
						console.log('error');
					} else {
						console.log('success');
					}
				});
			}
			
			pushedPageNum++
			var newUrl = urlSplit[0] + urlSplit[1] + pushedPageNum;
			var unMatchedContent = $('#page-'+pushedPageNum);
			nextPostsLink.attr('href', newUrl);
			
			if(newContentNum < pushedPageNum){
				contentAdder();
			} else if(newContentNum > pushedPageNum || newContentNum == pushedPageNum){
				unMatchedContent.remove();
			}
		} else {
			var caller = $('[data-id=' + state.caller + ']');
			if ($('#loadMessage').length === 0) {
				$('<p id="loadMessage">Loading...</p>').insertBefore(loadTarget);
			}
			
			var loadmsg = $('#loadMessage');
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
	}
	
	links.each(function(index) {
		var $this = $(this);
		$this.attr('data-id', 'link' + index);
	}).bind('tap', function(e) {
		e.preventDefault();
		var $this = $(this);
		var loadUrl = $this.attr('href') + ' ' + $this.attr('data-role') + ' > *';
		var state = {
			url: loadUrl,
			caller: $this.attr('data-id')
		}
		History.pushState(state, $this.text(), $this.attr('href'));
	});
	
	// PAGIN
	nextPostsLink.bind('tap', function(d){
	  var $this = $(this);
		urlSplit = $this.attr('href').toString().split(/(\/page\/)(\d*\/?$)/);
	    
	  if(urlSplit.length > 3){
	    var paginCount = parseInt(urlSplit[2]);
	    var loadUrl = $this.attr('href') + ' ' + $this.attr('data-role') + ' > *';
			var state = {
				url: loadUrl,
				caller: $this.attr('data-id'),
				pagesNum: paginCount
			}
			History.pushState(state, $this.text(), $this.attr('href'));
	  }
	});
	
	History.Adapter.bind(window, 'statechange', function() {
		var state = History.getState().data;
		if (typeof state.url === 'undefined') {
			state.url = currentPageUrl;
			state.caller = currentPageLink.attr('data-id');
		}
		if (typeof state.pagesNum === 'undefined') {
			state.pagesNum = 1;
		}
		loadContent(state);
	});
    });
 
}(jQuery));