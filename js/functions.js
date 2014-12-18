(function($){
	'use strict';
	$(function(){
		var loadTarget = $('#js-cptItems');
		var nextPostsLink = $('#js-nextPostsLink');
		var linksParent = $('#js-filters'); 
		
		if(nextPostsLink.length){
			var urlSplit = nextPostsLink.attr('href').toString().split(/(\/page\/)(\d*\/?$)/);
			var totalPages = nextPostsLink.attr('data-stop');
			var currentPageLink = nextPostsLink;
			var currentPageUrl = urlSplit[0] + ' ' + nextPostsLink.attr('data-role') + ' > * ';
			
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
		} 
		
		if(linksParent.length){
			var links = linksParent.find('.filter'); 
			var currentPageLink = linksParent.find('a.s-is-appHome');
			var currentPageUrl = currentPageLink.attr('href') + ' ' + currentPageLink.attr('data-role') + ' > * ';
			
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
				if($this.is(currentPageLink) && nextPostsLink.length){
					nextPostsLink.attr('href', currentPageLink.attr('href')+'/page/2');
					console.log(currentPageLink.attr('href')+'/page/2');
					nextPostsLink.fadeIn();
				}
				
				// 1: Conditional på om det ska finnas någon pagin och om det finns någon nextposts link
				// 2. Fånga upp klickat-filters attr href
				// 3. Uppdatera nextPostsLink.attr('href', xxxxx); så pagin-base url stämmer med filtrens. ladda med +'/page/2'
				// 4. Ovan hinns nog inte med riktigt. SLäng in i contentswitcher istället.
				
				// 1. Uppdatera container height innerHeight(); till en min-height. släng in transitions på denna parentklass
								
				History.pushState(state, $this.text(), $this.attr('href'));
			});
		}
	
		function loadContent(state) {
			
			function pageAdder() {
				loadTarget.append($('<div/>', { id: pageID, class: 'js-addedPage' }));
				var pageIDObj = $('#'+pageID);
				pageIDObj.load(url, function(response, status, xhr){
					if ( status == 'error' ) {
						console.log('error');
					} else {
						console.log('success');
					}
				});
			}
			
			function hideLoadmsg() {
				loadmsg.fadeOut('fast');
			}
				
			function contentSwitcher() {
				loadTarget.load(url, function() {
					loadTarget.fadeIn('medium', hideLoadmsg);
				});
			}
			
			var url = state.url;
			if(state.caller === nextPostsLink.attr('data-id')){
				var pushedPageNum = state.pagesNum;
				var newPageNum = $('.js-addedPage').length+1;
				var pageID = 'page-'+pushedPageNum;
				console.log('pagenumber = '+pushedPageNum+' and has '+newPageNum+' added divs');
				console.log('last added div is # '+pageID);
				
				if(pushedPageNum == totalPages){
					nextPostsLink.fadeOut();
				} else if(pushedPageNum < totalPages && nextPostsLink.is(':hidden')){
					nextPostsLink.fadeIn();
				}

				pushedPageNum++;
				var newUrl = urlSplit[0] + urlSplit[1] + pushedPageNum;
				var previousPage = $('#page-'+pushedPageNum);
				
				if(newPageNum < pushedPageNum){
					pageAdder();
				} else if(newPageNum > pushedPageNum || newPageNum == pushedPageNum){
					previousPage.remove();
					console.log('Remove #page-'+pushedPageNum);
				}
				nextPostsLink.attr('href', newUrl);
			} else {
				var caller = $('[data-id=' + state.caller + ']');
				if ($('#loadMessage').length === 0) {
					$('<p id="loadMessage">Loading...</p>').insertBefore(loadTarget);
				}
				
				var loadmsg = $('#loadMessage');
				loadmsg.fadeIn('fast');
				links.removeClass('s-is-current');
				caller.addClass('s-is-current');	
				loadTarget.hide(0, contentSwitcher);
				
				if(caller.is(currentPageLink) && nextPostsLink.length){
					console.log('test');
					nextPostsLink.attr('href', urlSplit[0] + urlSplit[1] + '2');
				}
			}
		}

		History.Adapter.bind(window, 'statechange', function() {
			var state = History.getState().data;
			if (typeof state.url === 'undefined') {
				state.url = currentPageUrl;
				state.caller = currentPageLink.attr('data-id');
			}
			if (typeof state.pagesNum === 'undefined') {
				state.pagesNum = 1;
				nextPostsLink.fadeIn();
			}
			loadContent(state);
		});
	});
}(jQuery));