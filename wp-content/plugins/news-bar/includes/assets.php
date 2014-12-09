<?php

	global $pagenow;

	// Register styles
	wp_register_style( $this->slug . '-frontend', $this->url . '/assets/css/frontend.css', false, $this->version, 'all' );
	wp_register_style( $this->slug . '-frontend-skin', $this->url . '/assets/skins/' . $this->get_option( 'skin' ) . '.css', false, $this->version, 'all' );
	wp_register_style( $this->slug . '-backend', $this->url . '/assets/css/backend.css', false, $this->version, 'all' );

	// Register scripts
	wp_register_script( $this->slug . '-frontend', $this->url . '/assets/js/frontend.js', array( 'jquery' ), $this->version, false );
	wp_register_script( $this->slug . '-form', $this->url . '/assets/js/form.js', array( 'jquery' ), $this->version, false );
	wp_register_script( $this->slug . '-backend', $this->url . '/assets/js/backend.js', array( 'jquery' ), $this->version, false );

	// Enqueue admin assets
	if ( is_admin() && $pagenow == $this->settings_menu ) {
		wp_enqueue_style( 'thickbox' );
		wp_enqueue_style( 'farbtastic' );
		wp_enqueue_style( $this->slug . '-backend' );
		wp_enqueue_script( 'jquery' );
		wp_enqueue_script( 'media-upload' );
		wp_enqueue_script( 'thickbox' );
		wp_enqueue_script( 'farbtastic' );
		wp_enqueue_script( $this->slug . '-form' );
		wp_enqueue_script( $this->slug . '-backend' );
	}

	// Enqueue front-end assets
	elseif ( !is_admin() ) {
		wp_enqueue_style( $this->slug . '-frontend' );
		wp_enqueue_style( $this->slug . '-frontend-skin' );
		wp_enqueue_script( 'jquery' );
		wp_enqueue_script( $this->slug . '-frontend' );
	}
?>