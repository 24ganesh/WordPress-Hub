var json_str, opt, show_on_load, slide_params, toggleParams, tab_position, width, border_size, enable_timer, animation_speed, fullscreen;
// JSON Settings
json_str = j_options.j_options.replace(/&quot;/g, '"');
opt = jQuery.parseJSON(json_str);
// BOOLEANIZE
show_on_load = opt.show_on_load === "1" ? true : false;
enable_timer = opt.enable_timer === "1" ? true : false;
animation_speed = opt.animation_speed * 1000;
fullscreen = opt.open_width === "100" && opt.window_unit === '%' ? true : false;
border_size = isNaN(opt.border_size) ? parseInt(0) : opt.border_size;
width = opt.window_unit === '%' ? opt.open_width/100 * jQuery(window).width() : opt.open_width;
tab_position = opt.slick_tab_position == 'right' ? 'left' : 'right'; // Tab_position is the opening direction

var slickTab= {
	settings : {
		shelfId : 'slick_tab',
		shelfClass : 'slick_tab slick_tab_wrapper',
		showing : show_on_load,
		toggleEl : '#tab_toggle',
		animationSpeed : animation_speed,
		animationEase : 'swing'
	},
	init : function () {
		this.drawShelf();
		this.initResize();
		this.makeItSlide();
		var settings, slickTab, shelfEl, $tS, calc_width;
		slickTab= this;
		settings = this.settings;
		shelfEl = '#' + settings.shelfId;
		$tS = jQuery(shelfEl);
		slide_params = {};
		toggleParams = {};
		toggleParams['margin-' + tab_position] = '0px';
		if (show_on_load === true && settings.showing === true) {
			//toggleParams['opacity'] = opt.opacity / 100;
			jQuery(settings.toggleEl).css(toggleParams);
			if (enable_timer === true) {
				setTimeout(function () { // Autoclose
					if (fullscreen) {
						jQuery(settings.toggleEl).css(tab_position, -( tab_width + border_size * 2) + 'px');
					}
					calc_width = (parseInt(width) + 2 * border_size) * -1;
					slide_params[opt.slick_tab_position] = calc_width;
					$tS.animate( slide_params, settings.animationSpeed, settings.animationEase, slickTab.regenerateTab("autohide"));
					settings.showing = false;
				}, opt.timer * 1000);
			}
		}
	},
	initResize : function () {
		// Resize now and bind for future
		slickTab.resize();
		jQuery(window).resize(function () {
			slickTab.resize();
		});
	},
	drawShelf : function () {
		var slickTab, settings, shelf;
		slickTab= this;
		settings = this.settings;
		// tab_toggle div appended with title or custom image div
		shelf = opt.tab_type ==  1 ? jQuery('<div id="' + settings.shelfId + '" class="' + settings.shelfClass + '"></div>')
			.append("<div id='tab_toggle'><div id='tab_toggle_bg'></div></div>") : jQuery('<div id="' + settings.shelfId + '" class="' + settings.shelfClass + '"></div>')
			.append("<div id='tab_toggle'></div>");
		jQuery('body').prepend(shelf);
	},
	makeItSlide : function () {
		var settings, shelfEl, $tS, calc_width, customEl;
		settings = this.settings;
		slickTab = this;
		shelfEl = '#' + this.settings.shelfId;
		customEl = '.make_it_slide';
		$tS = jQuery(shelfEl);
		if (jQuery(customEl).length != 0) { jQuery(customEl).click(toggleState); }
		jQuery(settings.toggleEl).click(toggleState);
		function toggleState () {
			if (settings.showing === true) {
				if (fullscreen) {
						jQuery(settings.toggleEl).css(tab_position, -( tab_width + border_size * 2) + 'px');
					}
					calc_width = (parseInt(width) + 2 * border_size) * -1;
					slide_params[opt.slick_tab_position] = calc_width;
					$tS.animate(slide_params, settings.animationSpeed, settings.animationEase, slickTab.regenerateTab("opened"));
					settings.showing = false;
			} else if (settings.showing === false) {
				if (fullscreen) {
					jQuery(settings.toggleEl).css(tab_position, 0);
				}
				jQuery('#tab_toggle_bg').fadeOut(100, function() {
					slide_params[opt.slick_tab_position] = 0;
					$tS.animate( slide_params, settings.animationSpeed, settings.animationEase);
					//toggleParams['opacity'] = opt.opacity / 100;
					jQuery(settings.toggleEl).css(toggleParams);
					slickTab.regenerateTab("closed");
				});
				
				if(jQuery('#tab_title_wrap').length) {
					slide_params[opt.slick_tab_position] = 0;
					$tS.animate( slide_params, settings.animationSpeed, settings.animationEase);
					slickTab.regenerateTab("closed");
				}
				settings.showing = true;
			}
		}
	}, // END: makeItSlide
	resize : function () {
		var settings, shelfEl, $tS;
		settings = this.settings;
		shelfEl = '#' + this.settings.shelfId;
		// Runs at start and each time the window is rezied
		$tS = jQuery(shelfEl);
		if (!settings.showing) {
			$tS.css(opt.slick_tab_position, ((width + 2 * border_size) * -1));
		}
	},
	/* regenerateTab(currentState)
	 * Reloads the tab.
	 *
	 * Note: currentState is the initial state
	 */
	regenerateTab: function (currentState) {
		var classToggle, tab_title, tab_title_ie, select;
		switch(currentState){
			case "opened": // Tab is opened, Closing Parameters
				classToggle = "<div id='tab_toggle_bg' class='open_action'>";
				tab_title = opt.tab_title_open;
				tab_title_ie = spanify(opt.tab_title_open);  // Spans make letters vertical for the almighty IE - older versions
				break;
			case "autohide": // Tab is opened, Closing Parameters; initial DOM structure reset
				classToggle = "<div id='tab_toggle_bg' class='open_action'></div>";
				tab_title = opt.tab_title_open;
				tab_title_ie = spanify(opt.tab_title_open);
				break;
			case "closed": // Tab is closed; Opening Parameters
				classToggle = "<div id='tab_toggle_bg' class='closed_action' ></div>";
				tab_title = opt.tab_title_close;
				tab_title_ie = spanify(opt.tab_title_close);
				break;
		}
		// Toggle state via class replacement
		if (opt.tab_type ==  1) { // Tab is custom image
			jQuery('.open_action').css(tab_position, 0);
			jQuery('#tab_toggle_bg').replaceWith(classToggle);
			jQuery('#tab_toggle_bg').css(opt.slick_tab_position, 0).hide().fadeIn();
			if (tab_position == 'right'){jQuery('.closed_action').css('float', tab_position)}
		} else if (jQuery.browser.msie) { // IE Tab title with spans
			jQuery('#tab_title_wrap').replaceWith("<div id='tab_title_wrap'><span class='tab_title'></span></div>");
			jQuery('#tab_title_wrap span').replaceWith("<span class='tab_title'>" + tab_title_ie + '</span>');
			jQuery('#tab_title_wrap').css("margin-top", (jQuery('#tab_toggle').outerHeight(true) - jQuery('#tab_title_wrap').outerHeight(true)) / 2 + 'px');
		} else {// CSS rotated letters
			jQuery('#tab_title_wrap span').replaceWith("<span class='tab_title'>" + tab_title + '</span>');
			jQuery('#tab_title_wrap').css("margin-top", (jQuery('#tab_toggle').outerHeight(true) - jQuery('.tab_title').outerWidth(true)) / 2 + 'px');
			if(currentState != "closed"){jQuery('#tab_title_wrap').css("'margin-" + tab_position + "'", (jQuery('#tab_toggle').outerWidth(true) - jQuery('.tab_title').outerHeight(true)) / 2 + 'px')}
		}
		if(currentState != "closed"){
			//toggleParams['opacity'] = 1;
			jQuery(this.settings.toggleEl).css(toggleParams);
		}
		// Damn that text cursor
		select = window.getSelection();
		select.removeAllRanges();
		
		function spanify(title) { // Generate spans around each letter
			var tab_title_ie = '';
			for( $j=0;$j<title.length;$j++ ) {
					if((title[$j])) {
						tab_title_ie += "<span class='newline'>" + title[$j] + "</span>";
					}
			};
			return tab_title_ie
		}
	} // END: regenerateTab
};
jQuery(document).ready(function () {
    slickTab.init();
});