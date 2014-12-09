<?php

	/**
	 * Disable default admin bar
	 */
	function nbp_disable_admin_bar() {
		show_admin_bar( false );
		remove_action( 'wp_head', '_admin_bar_bump_cb' );
		remove_action( 'wp_head', 'wp_admin_bar_header' );
		remove_action( 'wp_footer', 'wp_admin_bar_render', 1000 );
		if ( !is_admin() ) {
			wp_deregister_script( 'admin-bar' );
			wp_deregister_style( 'admin-bar' );
		}
	}

	if ( $nbplus->get_option( 'admin-bar' ) == 'on' )
		add_action( 'init', 'nbp_disable_admin_bar' );
?>