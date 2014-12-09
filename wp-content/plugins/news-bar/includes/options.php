<?php

	/**
	 * Get blog categories
	 *
	 * @param string $mode Return all categories or only first one
	 * @return mixed According to mode returns array with all cats or first one
	 */
	function nbp_get_categories( $mode = 'all' ) {

		// Get blog categories
		$categories_obj = get_categories( array(
			'hide_empty' => 0,
			'hierarchical' => 1
			) );

		// Create an array with categories
		foreach ( $categories_obj as $category )
			$categories[$category->cat_ID] = $category->cat_name;

		// Get first categry ID
		$categories_ids = array_keys( $categories );
		$first_category = $categories_ids[0];

		if ( $mode == 'all' )
			return $categories;
		elseif ( $mode == 'first' )
			return $first_category;
	}

	/**
	 * Get available post types
	 */
	function nbp_get_post_types() {

		// Get plugin object
		global $nbplus;

		$post_types = get_post_types( array( '_builtin' => false ), 'objects' );
		$types['news-bar-plus'] = __( 'News Bar', $nbplus->textdomain );

		foreach ( $post_types as $slug => $post_type ) {
			if ( $slug != 'news-bar-plus' )
				$types[$slug] = $post_type->label;
		}

		return $types;
	}

	/**
	 * Get available icons
	 *
	 * @return array $icons Associative array with available icons
	 */
	function nbp_get_icons() {

		// Get plugin object
		global $nbplus;

		// create an array to hold directory list
		$icons = array( );

		// create a handler for the directory
		$handler = opendir( path_join( WP_PLUGIN_DIR, $nbplus->slug . '/assets/images/icons/' ) );

		// open directory and walk through the filenames
		while ( $file = readdir( $handler ) ) {

			// if file isn't this directory or its parent, add it to the results
			if ( $file != "." && $file != ".." ) {
				$name = str_replace( '.png', '', $file );
				$icons[$name] = $nbplus->url . '/assets/images/icons/' . $file;
			}
		}

		// tidy up: close the handler
		closedir( $handler );

		// done!
		return $icons;
	}

	/** Available options */
	$options = array(
		array(
			'name' => __( 'About plugin', $this->textdomain ),
			'type' => 'about'
		),
		array(
			'name' => __( 'Settings', $this->textdomain ),
			'type' => 'opentab'
		),
		array(
			'name' => __( 'News settings', $this->textdomain ),
			'type' => 'title',
		),
		array(
			'name' => __( 'Receive news from', $this->textdomain ),
			'desc' => __( 'Choose news source', $this->textdomain ),
			'options' => array(
				'twitter' => __( 'Twitter', $this->textdomain ),
				'category' => __( 'Blog category', $this->textdomain ),
				'rss' => __( 'RSS feed', $this->textdomain ),
				'post_type' => __( 'Custom post type', $this->textdomain ),
			),
			'std' => 'twitter',
			'id' => 'source',
			'type' => 'select',
			'trigger' => true
		),
		array(
			'name' => __( 'Twitter username', $this->textdomain ),
			'desc' => __( 'Enter your twitter username', $this->textdomain ),
			'std' => 'gn_themes',
			'id' => 'twitter',
			'type' => 'text',
			'triggable' => 'source=0'
		),
		array(
			'name' => __( 'Blog category', $this->textdomain ),
			'desc' => __( 'Choose blog category', $this->textdomain ),
			'options' => nbp_get_categories( 'all' ),
			'std' => nbp_get_categories( 'first' ),
			'id' => 'category',
			'type' => 'select',
			'triggable' => 'source=1'
		),
		array(
			'name' => __( 'RSS feed url', $this->textdomain ),
			'desc' => __( 'Enter the url of RSS feed', $this->textdomain ),
			'std' => path_join( home_url(), '?feed=rss2' ),
			'id' => 'rss',
			'type' => 'text',
			'triggable' => 'source=2'
		),
		array(
			'name' => __( 'Custom post type', $this->textdomain ),
			'desc' => __( 'You can select any custom post type registered on your site.<br/>Recommended: News Bar', $this->textdomain ),
			'options' => nbp_get_post_types(),
			'std' => 'news-bar-plus',
			'id' => 'custom_post_type',
			'type' => 'select',
			'triggable' => 'source=3'
		),
		array(
			'name' => __( 'Disable plugin post type', $this->textdomain ),
			'desc' => __( 'Disable custom post type registered by this plugin.<br/>If you enable this option custom post type News Bar will be deregistered.<br/>Do not enable this option if you using this custom post type as news source', $this->textdomain ),
			'std' => '',
			'id' => 'disable_post_type',
			'type' => 'checkbox',
			'label' => __( 'Disable', $this->textdomain )
		),
		array(
			'name' => __( 'Number of items to rotate', $this->textdomain ),
			'desc' => __( 'Select number of news to be showed.<br/>Reccomended value: from 1 to 20', $this->textdomain ),
			'std' => 3,
			'min' => 1,
			'max' => 20,
			'units' => __( 'pc.', $this->textdomain ),
			'id' => 'number',
			'type' => 'number'
		),
		array(
			'name' => __( 'Open links in new window', $this->textdomain ),
			'desc' => __( 'Open ticker links in new window/tab or in the same', $this->textdomain ),
			'std' => 'on',
			'id' => 'links-target',
			'type' => 'checkbox',
			'label' => __( 'Yes', $this->textdomain )
		),
		array(
			'name' => __( 'Caching', $this->textdomain ),
			'type' => 'title',
		),
		array(
			'name' => __( 'Enable caching <sup>BETA</sup>', $this->textdomain ),
			'desc' => __( 'This option enables caching for feeds.<br/>Be careful with this option.', $this->textdomain ),
			'std' => '',
			'id' => 'cache',
			'type' => 'checkbox',
			'label' => __( 'Enable', $this->textdomain ),
		),
		array(
			'name' => __( 'Animation', $this->textdomain ),
			'type' => 'title',
		),
		array(
			'name' => __( 'Animation type', $this->textdomain ),
			'desc' => __( 'Select animation type', $this->textdomain ),
			'options' => array(
				'fade' => __( 'Fade', $this->textdomain ),
				'slide' => __( 'Slide', $this->textdomain )
			),
			'std' => 'fade',
			'id' => 'animation',
			'type' => 'select',
		),
		array(
			'name' => __( 'News animation delay', $this->textdomain ),
			'desc' => __( 'Time between ticker animations in milliseconds ( 1000ms = 1sec )', $this->textdomain ),
			'std' => 5000,
			'min' => 50,
			'max' => 100000,
			'units' => __( 'ms', $this->textdomain ),
			'id' => 'delay',
			'type' => 'number',
		),
		array(
			'name' => __( 'News rotation speed', $this->textdomain ),
			'desc' => __( 'Ticker animation speed in milliseconds ( 1000ms = 1sec )', $this->textdomain ),
			'std' => 600,
			'min' => 50,
			'max' => 10000,
			'units' => __( 'ms', $this->textdomain ),
			'id' => 'speed',
			'type' => 'number',
		),
		array(
			'name' => __( 'Social icons', $this->textdomain ),
			'type' => 'title',
		),
		array(
			'name' => __( 'Show social icons', $this->textdomain ),
			'desc' => __( 'Show or hide social icons in News Bar', $this->textdomain ),
			'options' => array(
				'true' => __( 'Yes', $this->textdomain ),
				'false' => __( 'No', $this->textdomain )
			),
			'std' => 'true',
			'id' => 'show-social-icons',
			'type' => 'select',
			'trigger' => true
		),
		array(
			'name' => __( 'Open links in new window', $this->textdomain ),
			'desc' => __( 'Open icon links in new window/tab or in the same', $this->textdomain ),
			'std' => 'on',
			'id' => 'social-icons-target',
			'type' => 'checkbox',
			'label' => __( 'Yes', $this->textdomain ),
			'triggable' => 'show-social-icons=0'
		),
		array(
			'name' => __( 'Icon #1', $this->textdomain ),
			'desc' => __( 'Select social icon and enter the url<br/>Leave url blank to disable icon', $this->textdomain ),
			'std' => array( $this->url . '/assets/images/icons/facebook.png', 'http://facebook.com/' ),
			'id' => 'icon-1',
			'type' => 'social-icon',
			'icons' => nbp_get_icons(),
			'triggable' => 'show-social-icons=0'
		),
		array(
			'name' => __( 'Icon #2', $this->textdomain ),
			'desc' => __( 'Select social icon and enter the url<br/>Leave url blank to disable icon', $this->textdomain ),
			'std' => array( $this->url . '/assets/images/icons/twitter-1.png', 'http://twitter.com/' ),
			'id' => 'icon-2',
			'type' => 'social-icon',
			'icons' => nbp_get_icons(),
			'triggable' => 'show-social-icons=0'
		),
		array(
			'name' => __( 'Icon #3', $this->textdomain ),
			'desc' => __( 'Select social icon and enter the url<br/>Leave url blank to disable icon', $this->textdomain ),
			'std' => array( $this->url . '/assets/images/icons/youtube.png', 'http://youtube.com/' ),
			'id' => 'icon-3',
			'type' => 'social-icon',
			'icons' => nbp_get_icons(),
			'triggable' => 'show-social-icons=0'
		),
		array(
			'name' => __( 'Icon #4', $this->textdomain ),
			'desc' => __( 'Select social icon and enter the url<br/>Leave url blank to disable icon', $this->textdomain ),
			'std' => array( $this->url . '/assets/images/icons/vimeo.png', 'http://vimeo.com/' ),
			'id' => 'icon-4',
			'type' => 'social-icon',
			'icons' => nbp_get_icons(),
			'triggable' => 'show-social-icons=0'
		),
		array(
			'name' => __( 'Icon #5', $this->textdomain ),
			'desc' => __( 'Select social icon and enter the url<br/>Leave url blank to disable icon', $this->textdomain ),
			'std' => array( $this->url . '/assets/images/icons/feed-4.png', 'http://feedburner.com/' ),
			'id' => 'icon-5',
			'type' => 'social-icon',
			'icons' => nbp_get_icons(),
			'triggable' => 'show-social-icons=0'
		),
		array(
			'type' => 'closetab'
		),
		array(
			'name' => __( 'Appearance', $this->textdomain ),
			'type' => 'opentab'
		),
		array(
			'name' => __( 'General styling', $this->textdomain ),
			'type' => 'title'
		),
		array(
			'name' => __( 'Show News Bar at', $this->textdomain ),
			'desc' => __( 'Choose where News Bar will be displayed', $this->textdomain ),
			'options' => array(
				'top' => __( 'top of page', $this->textdomain ),
				'bottom' => __( 'bottom of page', $this->textdomain )
			),
			'std' => 'top',
			'id' => 'bar-position',
			'type' => 'select'
		),
		array(
			'name' => __( 'Remove admin bar', $this->textdomain ),
			'desc' => __( 'Default WordPress admin bar will be removed from frontend for all users<br/>It is recommended to enable this option', $this->textdomain ),
			'std' => 'on',
			'id' => 'admin-bar',
			'type' => 'checkbox',
			'label' => __( 'Yes', $this->textdomain )
		),
		array(
			'name' => __( 'News icon', $this->textdomain ),
			'desc' => __( 'Select icon for news (16x16 px)', $this->textdomain ),
			'std' => $this->url . '/assets/images/icons/arrow-6.png',
			'id' => 'icon',
			'icons' => nbp_get_icons(),
			'type' => 'icon'
		),
		array(
			'name' => __( 'Bar width', $this->textdomain ),
			'desc' => __( 'Specify bar width to fit it to the site', $this->textdomain ),
			'std' => array( 96, '%' ),
			'values' => array( 'px', '%' ), // 'em', 'pt', etc.
			'id' => 'width',
			'min' => 1,
			'max' => 3000,
			'type' => 'size'
		),
		array(
			'name' => __( 'Skin', $this->textdomain ),
			'desc' => __( 'Choose skin for News Bar', $this->textdomain ),
			'options' => array(
				'default' => __( 'Default', $this->textdomain ),
				'custom' => __( 'Custom skin', $this->textdomain ),
				'glass' => __( 'Glass', $this->textdomain ),
				'dark-glass' => __( 'Dark glass', $this->textdomain ),
				'wood' => __( 'Wood', $this->textdomain ),
				'dark-wood' => __( 'Dark wood', $this->textdomain ),
				'aluminum' => __( 'Aluminum', $this->textdomain ),
				'metal' => __( 'Metal', $this->textdomain ),
				'cherry' => __( 'Cherry', $this->textdomain ),
				'concrete' => __( 'Concrete', $this->textdomain ),
				'vista' => __( 'Vista', $this->textdomain ),
				'grass' => __( 'Grass', $this->textdomain ),
			),
			'std' => 'default',
			'id' => 'skin',
			'type' => 'select',
			'trigger' => true
		),
		array(
			'name' => __( 'Custom skin settings', $this->textdomain ),
			'type' => 'title',
			'triggable' => 'skin=1'
		),
		array(
			'name' => __( 'Custom skin image', $this->textdomain ),
			'desc' => __( 'Enter the url or upload custom skin image.<br/>Image must be tileable by X-axis', $this->textdomain ),
			'std' => '',
			'id' => 'custom-skin',
			'type' => 'image',
			'triggable' => 'skin=1'
		),
		array(
			'name' => __( 'Custom skin text color', $this->textdomain ),
			'desc' => __( 'Choose text color for your custom skin', $this->textdomain ),
			'std' => '#777777',
			'id' => 'custom-skin-text',
			'type' => 'color',
			'triggable' => 'skin=1'
		),
		array(
			'name' => __( 'Custom skin links color', $this->textdomain ),
			'desc' => __( 'Choose links color for your custom skin', $this->textdomain ),
			'std' => '#777777',
			'id' => 'custom-skin-links',
			'type' => 'color',
			'triggable' => 'skin=1'
		),
		array(
			'name' => __( 'Custom skin links hover color', $this->textdomain ),
			'desc' => __( 'Choose hovered links color for your custom skin', $this->textdomain ),
			'std' => '#777777',
			'id' => 'custom-skin-links-hover',
			'type' => 'color',
			'triggable' => 'skin=1'
		),
		array(
			'name' => __( 'Advanced settings', $this->textdomain ),
			'type' => 'title',
		),
		array(
			'name' => __( 'CSS position', $this->textdomain ),
			'desc' => __( 'Specify CSS-position property for News Bar', $this->textdomain ),
			'options' => array(
				'fixed' => __( 'Fixed', $this->textdomain ),
				'absolute' => __( 'Absolute', $this->textdomain ),
				'static' => __( 'Static', $this->textdomain )
			),
			'std' => 'fixed',
			'id' => 'position',
			'type' => 'select',
		),
		array(
			'name' => __( 'Font size', $this->textdomain ),
			'desc' => __( 'Font size for Bews Bar', $this->textdomain ),
			'std' => 13,
			'units' => 'px',
			'id' => 'font-size',
			'min' => 0,
			'max' => 3000,
			'type' => 'number',
		),
		array(
			'name' => __( 'HTML margin-top', $this->textdomain ),
			'desc' => __( 'Here you can specify margin-top value for HTML tag, if News Bar placed at the top of the page', $this->textdomain ),
			'std' => 32,
			'min' => 0,
			'max' => 1000,
			'units' => 'px',
			'id' => 'margin-top',
			'type' => 'number'
		),
		array(
			'name' => __( 'News Bar z-index', $this->textdomain ),
			'desc' => __( 'Specify z-index CSS-property for News Bar', $this->textdomain ),
			'std' => 200000,
			'min' => 1,
			'max' => 10000000,
			'units' => '',
			'id' => 'z-index',
			'type' => 'number'
		),
		array(
			'type' => 'closetab'
		)
	);
?>