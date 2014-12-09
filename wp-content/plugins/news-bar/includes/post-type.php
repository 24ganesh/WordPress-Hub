<?php

	/**
	 * Register post type for News Bar
	 */
	function nbplus_post_type() {

		// Get plugin object
		global $nbplus;

		// Post type labels
		$labels = array(
			'name' => _x( 'News Bar', 'post type general name', $nbplus->textdomain ),
			'singular_name' => _x( 'News Bar item', 'post type singular name', $nbplus->textdomain ),
			'add_new' => _x( 'Add item', 'portfolio item', $nbplus->textdomain ),
			'add_new_item' => __( 'Add new item', $nbplus->textdomain ),
			'edit_item' => __( 'Edit item', $nbplus->textdomain ),
			'new_item' => __( 'New News Bar item', $nbplus->textdomain ),
			'view_item' => __( 'View item', $nbplus->textdomain ),
			'search_items' => __( 'Search items', $nbplus->textdomain ),
			'not_found' => __( 'Nothing found', $nbplus->textdomain ),
			'not_found_in_trash' => __( 'Nothing found in Trash', $nbplus->textdomain ),
			'parent_item_colon' => ''
		);

		$args = array(
			'labels' => $labels,
			'public' => false,
			'publicly_queryable' => true,
			'show_ui' => true,
			'query_var' => true,
			'menu_icon' => $nbplus->url . '/assets/images/post-type.png',
			'capability_type' => 'post',
			'hierarchical' => false,
			'supports' => array( 'title', 'editor' )
		);

		register_post_type( 'news-bar-plus', $args );
	}

	if ( $nbplus->get_option( 'disable_post_type' ) != 'on' )
		add_action( 'init', 'nbplus_post_type' );
?>