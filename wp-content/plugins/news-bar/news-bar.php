<?php

	/*
	  Plugin Name: News Bar
	  Plugin URI: http://gndev.info/
	  Version: 2.0.0
	  Author: Vladimir Anokhin
	  Author URI: http://gndev.info/
	  Description: News bar with latest tweets or posts from specified blog category. Extended version.
	  Text Domain: news-bar
	  Domain Path: /languages
	  License: GPL2
	 */

	// Check that class doesn't exists
	if ( !class_exists( 'GN_Plugin_Framework' ) )
		require_once 'classes/gn-plugin-framework.class.php';

	// Create plugin instanse
	$nbplus = new GN_Plugin_Framework( plugin_basename( dirname( __FILE__ ) ), 'includes', true );

	// Translate plugin meta
	__( 'News Bar', $nbplus->textdomain );
	__( 'Vladimir Anokhin', $nbplus->textdomain );
	__( 'News bar with latest tweets or posts from specified blog category. Extended version.', $nbplus->textdomain );

	// Frontend functions
	require_once 'includes/frontend.php';

	// News grabber
	require_once 'includes/get-news.php';

	// Admin bar controller
	require_once 'includes/admin-bar.php';

	// News Bar Plus taxonomy
	require_once 'includes/post-type.php';
?>