jQuery(document).ready(function () {
	// JSON settings array
	var json_str, opt, window_width, tab_width, border_size, fullscreen, tab_position, complete_url, open_v, close_v, args;
	json_str = j_options.j_options.replace(/&quot;/g, '"');
	opt = jQuery.parseJSON(json_str);
	border_size = isNaN(opt.border_size) ? parseInt(0) : opt.border_size;
	tab_width = parseInt(opt.tab_width);
	// Fullscreen check
	fullscreen = opt.open_width === "100" && opt.window_unit === '%' ? true : false;
	// slick Width parameter treatment
	window_width = jQuery(window).width();
	// Position the toggle tab opposite of the alignment of the slick content
	tab_position = opt.slick_tab_position === 'right' ? 'left': 'right';
	if (opt.tab_type != 1) {
		args={}
		args['border-top-' + tab_position + '-radius'] = '10px';
		args['border-bottom-' + tab_position + '-radius'] = '10px';
		jQuery('#tab_toggle').css(args)
	}
	// Fullscreen all round corners
	if (fullscreen) {
		jQuery('#tab_toggle').css({
			'border-radius': '4px'
		});
	}
	// Set the position of the toggle tab and it's border
	jQuery('#tab_toggle').css(tab_position, function () {
		if (!fullscreen) {
			if (opt.tab_type ==  1) { // Tab is custom image
				return  '8px';
			} else {
				return  -1*(border_size*2 + tab_width)+1 + 'px';	
			}
		} else {
			return '0px';
		}
	});
	if (opt.tab_type ==  0) { // Tab is a title - use borders?
		jQuery('#tab_toggle').css('border', 'outset ' + border_size + 'px ' + opt.tab_color);
	} else {
		jQuery('#tab_toggle').css('z-index', '1001'); // Close image z-index brings it on top of the slick
	}
	jQuery('.slick_tab_wrapper').css(opt.slick_tab_position, function () {
		if (opt.show_on_load) {
			return 0;
		}
	});
	jQuery('#slick_tab').css({
		'height': opt.open_height + opt.window_unit,
		'top': opt.open_top + '%',
		'width': opt.open_width + opt.window_unit
	});
	// Generate the content div
	jQuery('#slick_tab').append("<div id='slick_tab_content' style='position:relative; float:" + tab_position + "; z-index:1000; overflow:show; height:" + opt.open_height + opt.window_unit + "; width:" + opt.open_width + opt.window_unit + ";'></div>");
	if (opt.template_pick === 'Custom') {
		complete_url = opt.window_url;
	} else {
		complete_url = opt.site_url + '/' + opt.window_url;
	}
	// Get the content
	if (opt.include_method === 'js') {
		jQuery('#slick_tab_content').load(opt.window_url);
	} else {
		jQuery('#slick_tab_include').css('display', 'block');
		jQuery('#slick_tab_include').appendTo('#slick_tab_content');
	}
	// Generate the background div
	jQuery('#slick_tab').append("<div id='slick_tab_background' style='position:absolute; width:100%; height:100%; z-index:100;'></div>");
	// Set the opacity
	jQuery('#slick_tab_background').css("opacity", opt.opacity / 100);
	if (opt.background.substring(0, 7) === "http://") { // background is an url image
		// Set the background url
		jQuery('#slick_tab_background').css("background", "url(" + opt.background + ")");
		jQuery('#slick_tab_background').css("background-size", "100%");
		jQuery('#slick_tab_background').css("background-repeat", "no-repeat");
	} else { // background is a colour
		// Set the background colour
		jQuery('#slick_tab_background').css("background",  opt.background);
	}
	jQuery('#slick_tab_background').css('border', 'outset ' + border_size + 'px ' + opt.tab_color);
	/*
	 * Tab image settings
	 */
	 // Tab is a custom image
	if (opt.tab_type == 1) {
		jQuery('#tab_toggle').css({
			tab_position: '0px',
			'top': '0px'
		});
	// Tab is Text based
	} else {
		jQuery('#tab_toggle').css({
			'top': opt.tab_top + '%',
			'width': opt.tab_width + 'px',
			'height': opt.tab_height + 'px'
		});
		jQuery('#tab_toggle').css({
			'background-color': opt.tab_color
		});
		// Generate the tab slick title
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
			
			// Center the title vertically and horizontally
			jQuery('#tab_title_wrap').css("margin-top", (jQuery('#tab_toggle').outerHeight(true) - jQuery('.tab_title').outerHeight(true)) / 2 + 'px');
			jQuery('#tab_title_wrap').css("margin-left", (jQuery('#tab_toggle').outerWidth(true) - jQuery('.tab_title').outerWidth(true)) / 2 + 'px');
		} else {
			// Generate the tab slick title in other browsers
			jQuery('#tab_toggle').append(function () {
				if (opt.show_on_load) {
					return "<div id='tab_title_wrap'><span class='tab_title'>" + opt.tab_title_close + "</span></div>";
				}
				if (!opt.show_on_load) {
					return "<div id='tab_title_wrap'><span class='tab_title'>" + opt.tab_title_open + "</span></div>";
				}
			});
			// Center the title after rotation
			jQuery('#tab_title_wrap').css("margin-top", (jQuery('#tab_toggle').outerHeight(true) - jQuery('.tab_title').outerWidth(true)) / 2 + 'px');
			jQuery('#tab_title_wrap').css("margin-left", (jQuery('#tab_toggle').outerWidth(true) - jQuery('.tab_title').outerHeight(true)) / 2 + 'px');
		}
		jQuery("#tab_title_wrap").css('background-color', opt.tab_color);
	}
});