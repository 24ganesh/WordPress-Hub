jQuery(document).ready(function () {
	// JSON settings array
	var json_str, opt, tab_position, complete_url, open_v, close_v;
	json_str = j_options.j_options.replace(/&quot;/g, '"');
	opt = jQuery.parseJSON(json_str);
	tab_position = opt.slick_tab_position == 'right' ? 'left' : 'right';
	jQuery('#slick_tab').append("<div id='slick_tab_content'></div>");

	if (opt.template_pick === 'Custom') {
		complete_url = opt.window_url;
	} else {
		complete_url = opt.site_url + '/' + opt.window_url;
	}
	// Set the content URL
	if (opt.include_method === 'js') {
		jQuery('#slick_tab_content').load(opt.window_url);

	} else {
		jQuery('#slick_tab_include').css('display', 'block');
		jQuery('#slick_tab_include').appendTo('#slick_tab_content');
	}
	// Generate the background div
	jQuery('#slick_tab_content').append("<div id='slick_tab_background'></div>");
	
	// Tab is a custom image
	if (opt.tab_type == 1) {
		jQuery('#tab_toggle').css({
			tab_position: '0px',
			'top': '0px'
		});
	// Tab is Text based
	} else {
		jQuery('#tab_toggle').addClass('tab_text_bg ');
		
		// Generate the slick tab title
		if (jQuery.browser.msie) { //IE workaround - Generate spans around each letter
		open_v = '';
		for( $j=0;$j<opt.tab_title_open.length;$j++ ) {
		    if((opt.tab_title_open[$j])) {
		       open_v += "<span class='newline'>" + opt.tab_title_open[$j] + "</span>";
			}
		}
		close_v = '';
		for( $j=0;$j<opt.tab_title_close.length;$j++ ) {
		    if((opt.tab_title_close[$j])) {
		       close_v += "<span class='newline'>" + opt.tab_title_close[$j] + "</span>";
			}
		}
		jQuery('#tab_toggle').append(function () {
			
			if (opt.show_on_load) {
				return "<div id='tab_title_wrap' class='tab_title'>" + close_v + "</div>";
			}
			if (!opt.show_on_load) {
				return "<div id='tab_title_wrap' class='tab_title'>" + open_v + "</div>";
			}
		});
		} else {
			// Generate the slick tab title in other browsers
			jQuery('#tab_toggle').append(function () {
				if (opt.show_on_load) {
					return "<div id='tab_title_wrap'><span class='tab_title'>" + opt.tab_title_close + "</span></div>";
				}
				if (!opt.show_on_load) {
					return "<div id='tab_title_wrap'><span class='tab_title'>" + opt.tab_title_open + "</span></div>";
				}
			});
		}
	}
});