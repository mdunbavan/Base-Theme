// Facebook Like ASYNC
(function(d, s, id) {
	var js, fjs = d.getElementsByTagName(s)[0];
	if (d.getElementById(id)) {return;}
	js = d.createElement(s); js.id = id;
	js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=149527638481052";
	fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));

// Google Analytics
var _gaq = _gaq || [];
_gaq.push(['_setAccount', base_settings.ga_ua ]);
_gaq.push(['_trackPageview']);
(function() {
	var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
	ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
	var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
})();

// jQuery Safe Zone
(function($){ 
	
	/**
	 * Dropdown Menu
	 */
	$('#navigation ul li:not(.current_page_item, .current_page_ancestor, .current_page_parent) ul').slideUp(0).addClass('jquery');
	$('#navigation ul > li:not(.current_page_item, .current_page_ancestor, .current_page_parent)').hover(function () {
		$("ul", this).stop(true, true).slideDown(200);
	},function () {
		$("ul", this).stop(true, true).delay(140).slideUp(100);
	});
	$('#navigation ul:first > li').addClass('first-children');
	
	// Cancel if there's only one subnav item
	$length = $('#navigation .current_page_parent ul li, #navigation .current_page_ancestor ul li, #navigation .current_page_item ul li').length;
	if( $length == 1 ) {
		$('#navigation .current_page_parent > ul, #navigation .current_page_ancestor > ul, #navigation .current_page_item > ul').remove();
		$('body').removeClass('page-parent, page-child');
		return false;
	}
	
	/**
	 * Comment form validation
	 */
	if ($("#commentform").length > 0) {
		head.js("http://ajax.microsoft.com/ajax/jquery.validate/1.7/jquery.validate.min.js", function() {
			$("#commentform").validate();
		});
	}
		
	/**
	 * AJAX Share Widgets
	 */
	var post_container = $('div[id^="post"]');
	if ( post_container.length > 0 ) {
		post_container.bind("mouseenter", function(){
			// Post details
			var id = $(this).attr("id").slice(5);
			var title = $('.ajax-sharing-link', this).text();
			var permalink = $('.ajax-sharing-link', this).attr('href');
			
			if ( window.console && window.console.log ) console.log('Post: ' + id + ' - ' + permalink + ' - ' + title);
			
			// Remove icon images
			$('#sharing-' + id).css('background', 'none');
			
			// Facebook
			var fb_str = '<fb:like href="' + permalink + '" layout="' + base_settings.facebook_layout + '" send="false" show_faces="false"></fb:like>';
			$('#fb-newshare-' + id).css('width', '100px').html(fb_str);
			FB.XFBML.parse(document.getElementById('fb-newshare-' + id));
			
			// Twitter
			var twitter_str = '<iframe allowtransparency="true" frameborder="0" scrolling="no" src="http://platform.twitter.com/widgets/tweet_button.html?url=' + permalink + '&amp;text=' + title + '&amp;count=' + base_settings.twitter_count + '&amp;via=' + base_settings.twitter_via + '&amp;related=' + base_settings.twitter_related + '" style="width:100px; height:50px;" allowTransparency="true" frameborder="0"></iframe>';
			$('#tweet-newshare-' + id).css('width', '100px').html(twitter_str);
			
			// Google Plus
			$('#gplus-newshare-' + id).parent().css('width', '85px');
			if (typeof(gapi) != 'object') jQuery.getScript('http://apis.google.com/js/plusone.js', function () {
				gapi.plusone.render('gplus-newshare-' + id, {
					"href": permalink,
					"size": base_settings.google_size
				});
			});
			else {
				gapi.plusone.render('gplus-newshare-' + id, {
					"href": permalink,
					"size": 'medium'
				});
			}
			
			// LinkedIn
			var linkedin_str = '<script id="inshare-' + id + '" type="in/share" data-url="' + permalink + '" data-counter="' + base_settings.linkedin_data_counter + '"></script>';
			$('#linkedin-newshare-' + id).css('width', '100px').html(linkedin_str);
			if (typeof(IN) != 'object') 
				jQuery.getScript('http://platform.linkedin.com/in.js');
			else 
				IN.parse(document.getElementById('linkedin-newshare-' + id));
				
			$(this).unbind('mouseenter mouseleave');
		});
	}
	
})(jQuery);
