<?php
/*
Plugin Name: Smarty Slick Tab
Plugin URI: http://ataulswebdesigns.com/
Description: Smartly Slick Out your target page into and out of the visible page with this very useful simple side tab.
Version: 1.0
Author: AWD Team
Author URI: http://ataulswebdesigns.com/
License: GPL2
*/

// Define contants
define( 'SLICK_TAB_VERSION' , '1.50' );
define( 'SLICK_TAB_ROOT' , dirname(__FILE__) );
define( 'SLICK_TAB_FILE_PATH' , SLICK_TAB_ROOT . '/' . basename(__FILE__) );
define( 'SLICK_TAB_URL' , plugins_url(plugin_basename(dirname(__FILE__)).'/') );
define( 'SLICK_TAB_SETTINGS_PAGE' , 'admin.php?page=slick-tab/slick-tab' );

// Core class
class slick_tab {

	// Unique identifier added as a prefix to all options
	var $options_group = 'slick_tab_';
	// Initially stores default option values, but when load_options is run, it is populated with the options stored in the WP db
	var $options = array(
					"version" => 0,
					"show_on_load" => TRUE,
					"tab_top" => 50,
					"background" => "#f3f3f3",
					"window_unit" => 'px',
					"open_width" => 250,
					"open_height" => 250,
					"open_top" => 30,
					"opacity" => 80,
					"timer" => 2,
					"include_list" => "",
					"list_pick" => "all",
					"window_url" => "wp-content/plugins/slick-tab/templates/Subscribe.php",
					"picture_url" => "http://s.wp.com/wp-content/themes/h4/i/logo-v-rgb.png",
					"video_url" => "http://www.youtube.com/",
					"post_id" => 2,
					"animation_speed" => 1,
					"enable_timer" => TRUE,
					"exclude_list" => "",
					"template_pick" => "Subscribe",
					"disabled_pages" => "wp-login.php, wp-register.php",
					"slick_tab_position" => "left",
					"tab_image" => "",
					"tab_color" => "#f3f3f3",
					"tab_title_open" => "Open",
					"tab_title_close" => "Hide",
					"tab_height" => 50,
					"include_method" => 'js',
					"credentials" => 'all',
					"borders" => 1,
					"border_size" => 4,
					"cssonly" => 0,
					"tab_type" => 0,
					"tab_width" => 40
				);		
	
	/**
	 * Constructor
	 */
	function __construct() {
		global $wpdb;
		
		load_plugin_textdomain( 'slick-tab', null, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );

		// Load plugin options
		$this->load_options();
		
		// If in admin area load the settings page
		if(is_admin()) {
			include_once( SLICK_TAB_ROOT . '/php/settings.php' );
			// Create all of our objects
			$this->settings = new Slick_Tab_Settings();
		}
		
		// Core hooks to initialize the plugin
		add_action( 'init', array( &$this,'init' ) );
		add_action( 'admin_init', array( &$this, 'admin_init' ) );  
		
		if ( $this->get_plugin_option('list_pick') == 'shortcode'){
			// Add the [slicktab] shortcode
			add_shortcode( 'slicktab', array( &$this, 'do_sc' ) );
			add_action('template_redirect',array( &$this, 'sc_head' ));
		} else {
			// This is run after all the init calls have been run.
			add_action( 'init', array( &$this, 'do_init_prehook' ), 10 );
		}
		// Add admin scripts and stylesheets
		add_action('admin_enqueue_scripts', array(&$this, 'add_admin_scripts'));
	} // END __construct()
	
	/**
	 * Initialize the admin settings page
	 */
	function init() {
		if(is_admin()) {

			//Add the necessary pages for the plugin 
			add_action('admin_menu', array(&$this, 'add_menu_items'));
		}
	} // END: init()
	
	/**
	 * do_init_prehook()
	 * Called if no shortcode was enabled to determine what pages slicktab appears on
	 */
	function do_init_prehook() {
		do_action( 'tab_init' );
		global $params, $disabled_pages_array, $current_page_id, $exclude_include, $list_pick, $exclude_array, $include_array;
		$current_page_id = url_to_postid( "http://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'] ); 
		//$disabled_pages = array('wp-login.php', 'wp-register.php');
		
		// Avoid returning null/false when dealing with empty arrays
		if (empty($exclude_array)) {
			$exclude_array[0] = -1;
		}
		if (empty($include_array)) {
			$include_array[0] = -1;
		}
		// Exclude/Include/All option setter
		if($list_pick == 'all') {
			$exclude_include = TRUE;
		} else if($list_pick == 'exclude') {
			$exclude_include = !in_array($current_page_id, $exclude_array);
		} else if($list_pick == 'include'){
			$exclude_include =  in_array($current_page_id, $include_array);
		} 
		
		// Disable/Enable the plugin on page ID's($include_array/$exclude_array) and $disabled
		if ( !in_array( $GLOBALS['pagenow'], $disabled_pages_array ) && $exclude_include ) {
			$this->do_init_hook();
		}
	} // END: do_init_prehook()
	
	/**
	 * sc_head()
	 * Searches the page for [slicktab] in order to execute the scripts on the pages that contain the shortcode
	 */
	function sc_head(){
		global $posts;
		// Allow other plugins to safely hook in
		do_action( 'tab_init' );
		
		$pattern = get_shortcode_regex(); 
		preg_match('/'.$pattern.'/s', $posts[0]->post_content, $matches); 
		if (is_array($matches) && $matches[2] == 'slicktab') { 
			$this->do_init_hook();
		}
	} // END: sc_head()
	/**
	 * do_sc()
	 * Shortcode hook
	 */
	function do_sc() {
		// Hide [slicktab] by registering it as a shortcode
	} // END: do_sc()
	
	/**
	 * do_init_hook()
	 * Register front end scripts and stylesheets
	 */
	function do_init_hook() {
		global $params, $current_user, $credentials;
		$current_user = wp_get_current_user();
		switch ( $this->get_plugin_option('credentials') ) {
			case "all":
				$credentials = true;
				break;
			case "auth":
				if ( 0 == $current_user->ID ) {
					$credentials = false;
				} else {
					$credentials = true;
				}
				break;
			case "unauth":
				if ( 0 == $current_user->ID ) {
					$credentials = true;
				} else {
					$credentials = false;
				}				
				break;	
		}
		
		if( $credentials && !is_admin() && $GLOBALS['pagenow'] != 'iframe.php') {
			wp_enqueue_script('jquery');
			
			//JS slick-tab frontend
			wp_register_script('slick_tab_script', ( SLICK_TAB_URL . 'js/slick_tab.js'), false); 
			wp_enqueue_script('slick_tab_script');
			wp_localize_script('slick_tab_script', 'j_options', $params);
			
			if( $this->get_plugin_option('cssonly') == 0){		
				// CSS
				$myStyleUrl = SLICK_TAB_URL . 'slick-tab.css';
				wp_register_style('slick_tab_StyleSheet', $myStyleUrl);
				wp_enqueue_style( 'slick_tab_StyleSheet');

				//JS slick-tab set options to slick-tab
				wp_register_script('slick_tab_settings', ( SLICK_TAB_URL . 'js/options_set.js'), false); 
				wp_enqueue_script('slick_tab_settings');
				wp_localize_script('slick_tab_settings', 'j_options', $params);					
			} else {
				// CSS
				$myStyleUrl = SLICK_TAB_URL . 'cssonly.css';
				wp_register_style('slick_tab_StyleSheet', $myStyleUrl);
				wp_enqueue_style( 'slick_tab_StyleSheet');

				//JS slick-tab set options to slick-tab
				wp_register_script('slick_tab_settings', ( SLICK_TAB_URL . 'js/cssonly.js'), false); 
				wp_enqueue_script('slick_tab_settings');
				wp_localize_script('slick_tab_settings', 'j_options', $params);	
			}			
		}		
	} // END: do_init_hook()	
	
	/**
	 * Initialize the plugin for the admin 
	 */
	function admin_init() {
		// Register all plugin settings so that we can change them and such
		foreach($this->options as $option => $value) {
	    	register_setting($this->options_group, $this->get_plugin_option_fullname($option));
	    }

	} // END: admin_init() 
	
	/**
	 * This function is called when plugin is activated.
	 */
	function activate_plugin ( ) {
		global $wpdb;
	} // END: activate_plugin
	
	/**
	 * This function is called when plugin is deactivated.
	 */
	function deactivate_plugin( ) {
		$this->delete_options($this->options);
	} // END: deactivate_plugin

	/*
	 * Loads options for the plugin.
	 * If option doesn't exist in database, it is added
	 *
	 * Note: default values are stored in the $this->options array
	 * Note: a prefix unique to the plugin is appended to all the options. Prefix is stored in $this->options_group 
	 */
	function load_options ( ) {
		global $params, $exclude_array, $include_array, $disabled_pages_array, $list_pick, $include_method, $window_url; 
		$new_options = array();
		
		foreach($this->options as $option => $value) {
			$name = $this->get_plugin_option_fullname($option);
			$return = get_option($name);
			if($return === false) {
				add_option($name, $value);
				$new_array[$option] = $value;
			} else {
				$new_array[$option] = $return;
			}
		}
		
		$this->options = $new_array;
		
		// Include Method
		$include_method = $new_array['include_method'];
		
		// Window URL to pass
		$window_url = $new_array['window_url'];
		
		// Disabled, exclude, include string to array
		$list_pick = $new_array['list_pick'];
		$exclude_string = $new_array['exclude_list'];
		$exclude_array = array_map('trim',explode(",",$exclude_string));
		$include_string = $new_array['include_list'];
		$include_array = array_map('trim',explode(",",$include_string));
		$disabled_pages_string = $new_array['disabled_pages'];
		$disabled_pages_array = array_map('trim',explode(",",$disabled_pages_string));
		
		// json
		$j_options = $this->options;
		$j_options['site_url'] = site_url();
		$json_str = json_encode($j_options);		
		$params = array(
	    	'j_options' => $json_str
		);
		
	} // END: load_options
	
	/*
	 * Delete all the options in the database
	 *
	 * TODO: Confirmation
	 */ 
	function delete_options($my_options) {
		if (!is_string($my_options)){
			foreach(array_keys($my_options) as $value) {
				
				$name = $this->get_plugin_option_fullname($value);
					delete_option($name);	
			}
		}
	} // end delete_options()

	/**
	 * Returns option for the plugin specified by $name, e.g. show_on_load
	 *
	 * Note: The plugin option prefix does not need to be included in $name 
	 * 
	 * @param string name of the option
	 * @return option|null if not found
	 *
	 */
	function get_plugin_option ( $name ) {
		if(is_array($this->options) && $option = $this->options[$name])
			return $option;
		else 
			return null;
	} // END: get_option
	
	/*
	 * Utility function: appends the option prefix and returns the full name of the option as it is stored in the wp_options db
	 */
	function get_plugin_option_fullname ( $name ) {
		return $this->options_group . $name;
	}
	
	/**
	 * Updates option for the plugin specified by $name, e.g. show_on_load
	 *
	 * Note: The plugin option prefix does not need to be included in $name 
	 * 
	 * @param string name of the option
	 * @param string value to be set
	 *
	 */
	function update_plugin_option( $name, $new_value ) {
		if( is_array($this->options) /* && !empty( $this->options[$name] ) */ ) {
			$this->options[$name] = $new_value;
			update_option( $this->get_plugin_option_fullname( $name ), $new_value );
		}
	}

	/**
	 * Adds menu page for the plugin
	 */
	function add_menu_items ( ) {
		
		/**
		 * Add Top-level Admin Menu
		 */
		//add_menu_page(__('Smarty Slick Tab', 'slick-tab'), __('Smarty Slick Tab', 'slick-tab'), 'manage_options', $this->get_page('slick-tab'), array(&$this->settings, 'settings_page'));
		add_options_page(__('Smarty Slick Tab', 'slick-tab'), __('Smarty Slick Tab', 'slick-tab'), 'manage_options', $this->get_page('slick-tab'), array(&$this->settings, 'settings_page'));		
	} // END: add_menu_items() 
	
	/**
	 * Gets the page string/path
	 * @param string $page
	 * @return string
	 */
	function get_page ( $page = '' ) {
		return 'slick-tab'. (($page) ? '/' . $page : '');
	}
	
	/**
	 * Adds necessary Javascript and CSS to admin
	 */
	function add_admin_scripts() {
		if(is_admin()) {
			wp_enqueue_style('jquery-ui', SLICK_TAB_URL . '/css/jquery-ui.css');
			wp_enqueue_script('jquery');
			wp_enqueue_script('jquery-form');
			wp_enqueue_script('jquery-ui-core');
			wp_enqueue_script('jquery-ui-widget');
			wp_enqueue_script('jquery-ui-tabs');
			wp_enqueue_style( 'farbtastic' );
			wp_enqueue_script( 'farbtastic' );
		}
	}

} // END: class slick_tab

// Create new instance of the slick_tab object
global $slick_tab;
$slick_tab = new slick_tab();

/**
 * tab_loaded()
 * Allow dependent plugins and core actions to attach themselves in a safe way
 */
function tab_loaded() {
	do_action( 'tab_loaded' );
}
add_action( 'plugins_loaded', 'tab_loaded', 20 );

/*
 * Attach action to load the contents via php
 * NOTE: Experimental, helps set the page containing a form properly
 */
global $include_method;
if ($include_method === 'php') {
	add_action('wp_head', 'get_contents');
}

// Hook to perform action when plugin activated
register_activation_hook( SLICK_TAB_FILE_PATH, array(&$slick_tab, 'activate_plugin'));
register_deactivation_hook( SLICK_TAB_FILE_PATH, array(&$slick_tab, 'deactivate_plugin'));

// Enable the Slick Tab Widget Area if template_pick set to Widget
if ($slick_tab->get_plugin_option('template_pick') == 'Widget'){
	register_sidebar( array(
			'name' => __( 'Slick Tab Widget Area', 'SLICKTAB' ),
			'id' => 'header-area',
			'description' => __( 'The slick tab widget area', 'SLICKTAB' ),
			'before_widget' => '<div id="%1$s" class="widget-container %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h3 class="widget-title">',
			'after_title' => '</h3>',
		) );
}
function get_contents() {
	global $window_url;
	$url = $window_url;
	?><div id="slick_tab_include" style="display: none"><?php
	if (substr($url, 0, 7) == 'http://') {
		$url = substr($window_url, strlen(get_site_url())); 
	}
	include_once(ltrim($url, "/"));
	?></div><?php
    //ob_get_clean();
}