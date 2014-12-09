<?php
/*
Plugin Name: WEN's Responsive Column Layout Shortcodes
Plugin URI: http://wordpress.org/plugins/wens-responsive-column-shortcodes/
Description:  WEN's Responsive Column Layout Shortcodes easily add shortcodes to create 2, 3, 4, 5, 6, columns along with responsive layout in your posts/pages or widget section.
Version: 1.2.3
Author: Web Experts Nepal, Bhuwan Roka
Author URI: http://webexpertsnepal.com
License: GPL2
Copyright (C) 2013 Bhuwan Roka
*/
//Responsive columna layout created from shorcodes
//Coded by Web Experts Nepal Team //Bhuwan Roka


if ( !function_exists('wens_formatter') ) :
function wens_formatter($content) {
  $new_content = '';

  /* Matches the contents and the open and closing tags */
  $pattern_full = '{(\[raw\].*?\[/raw\])}is';

  /* Matches just the contents */
  $pattern_contents = '{\[raw\](.*?)\[/raw\]}is';

  /* Divide content into pieces */
  $pieces = preg_split($pattern_full, $content, -1, PREG_SPLIT_DELIM_CAPTURE);

  /* Loop over pieces */
  foreach ($pieces as $piece) {
    /* Look for presence of the shortcode */
    if (preg_match($pattern_contents, $piece, $matches)) {

      /* Append to content (no formatting) */
      $new_content .= $matches[1];
    } else {

      /* Format and append to content */
      $new_content .= wptexturize(wpautop($piece));
    }
  }

  return $new_content;
}

// Remove the 2 main auto-formatters
#remove_filter('the_content', 'wpautop');
#remove_filter('the_content', 'wptexturize');
add_filter('widget_text', 'do_shortcode');
// Before displaying for viewing, apply this function
#add_filter('the_content', 'wens_formatter', 99);
#add_filter('widget_text', 'wens_formatter', 99);
endif;

/**
 * Enqueue style-file, if it exists.
 * Register with hook 'wp_print_styles'
 *
 */
function wens_column_stylesheet() {
    $my_style_url = WP_PLUGIN_URL . '/wens-responsive-column-layout-shortcodes/wen-style.css';
    $my_style_file = WP_PLUGIN_DIR . '/wens-responsive-column-layout-shortcodes/wen-style.css';

    if ( file_exists($my_style_file) ) {
        wp_register_style('column-styles', $my_style_url);
        wp_enqueue_style('column-styles');
    }
}
add_action('wp_print_styles', 'wens_column_stylesheet');
/**
 *Responsive Fulid Columns Shortcodes
 *
 */
// add the main shortcode [bscolumns]
add_shortcode( 'bscolumns', 'wen_bs_columns' );
function wen_bs_columns( $atts, $content=null ){
  extract(shortcode_atts(array(
    'class' 	=> 'span1'
    ), $atts));
      $result ='';
  	  $result .= '<div class="'.$class.'">';
	  $result .= do_shortcode( $content );
	  $result .= '</div>';
  return force_balance_tags( $result );
}

// add buttons to tinyMCE editor
add_action( 'init', 'wen_bs_button' );
function wen_bs_button() {
  add_filter( 'mce_external_plugins', 'wen_bs_add_button' );
  add_filter( 'mce_buttons', 'wen_bs_register_button' );
}

// add button action script
function wen_bs_add_button( $plugin_array ) {
  $plugin_array['bscolumns'] = plugins_url( 'js/bscolumns.js', __FILE__ );
  return $plugin_array;
}

// register button in editor
function wen_bs_register_button( $buttons ) {
  array_push( $buttons, 'bscolumns-button', 'bscolumns-list' );
  return $buttons;
}
// remove uncessary <p> tag inside column layout
function wen_custom_script() {
wp_register_script('wen_custom_script', plugins_url('js/custom.js', __FILE__), array('jquery'),'1.1', true);
wp_enqueue_script('wen_custom_script');
}

add_action( 'wp_enqueue_scripts', 'wen_custom_script' );


?>
