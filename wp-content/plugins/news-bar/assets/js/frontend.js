jQuery(document).ready(function($) {

	nbp_init_ticker();

});

/*
 * Init news ticker
 */
function nbp_init_ticker() {

	var // Define variables
	ticker = jQuery('#news-bar-plus-ticker'),
	items = ticker.find('.news-bar-plus-item'),
	delay = parseInt( ticker.attr('data-news-bar-plus-delay') ),
	speed = parseInt( ticker.attr('data-news-bar-plus-speed') ),
	animation = ticker.attr('data-news-bar-plus-animation');

	// Check number of items
	if ( items.length > 1 ) {

		// Hide all tweets except first
		items.css({
			position: 'absolute',
			left: '25px',
			top: '0px'
		}).not(':first').hide();

		// Run timer
		var timer = setInterval( function() {

			var // Get current and next item index
			current = parseInt( ticker.find('.news-bar-plus-item:visible').index() ),
			next = ( ( current + 1 ) >= items.length ) ? 0 : current + 1;

			// Fade animation
			if ( animation == 'fade' ) {

				// Hide current tweet
				items.eq(current).fadeOut(speed);

				// Show next tweet
				items.eq(next).delay( Math.round( speed / 2 ) ).fadeIn(speed);
			}

			// Fade animation
			else if ( animation == 'slide' ) {

				// Hide current tweet
				items.eq(current).slideUp(speed);

				// Show next tweet
				items.eq(next).slideDown(speed);
			}
		}, delay );
	}
}