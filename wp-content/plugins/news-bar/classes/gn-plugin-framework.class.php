<?php

	/**
	 * Plugin framework class
	 */
	class GN_Plugin_Framework {

		/** @var string Plugin URL - plugin page */
		var $plugin_url;

		/** @var string Plugin version */
		var $version;

		/** @var string Plugin textdomain */
		var $textdomain;

		/** @var string Short plugin slug */
		var $slug;

		/** @var string Full plugin name */
		var $name;

		/** @var string Plugin URL - http://example.com/wp-content/plugins/plugin-slug */
		var $url;

		/** @var string Plugin control panel URL */
		var $admin_url;

		/** @var string Plugin option name. This option contains all plugin settings */
		var $option;

		/** @var string Plugin menu location. Default is submenu of 'options-general.php' */
		var $settings_menu;

		/** @var string Plugin menu label */
		var $settings_title;

		/** @var string Required lugin page capability */
		var $settings_capability;

		/** @var string Relative path to includes directory */
		var $includes;

		/**
		 * Constructor
		 *
		 * @param string $slug Short plugin slug
		 * @param string $includes Relative path to includes directory. Default: 'includes'
		 * @param mixed $settings Plugin control panel settings. Set it to TRUE and you'll have next defaults: array( 'menu' => 'options-general.php', 'title' => plugin name, 'capability' => 'manage_options' )
		 */
		function GN_Plugin_Framework( $slug, $includes = 'includes', $settings = false ) {

			// Check that function get_plugins exists
			if ( !function_exists( 'get_plugins' ) )
				require_once( ABSPATH . 'wp-admin/includes/plugin.php' );

			// Get plugin meta
			$meta = get_plugins( '/' . $slug );

			// Initialize plugin data
			$this->plugin_url = $meta[$slug . '.php']['PluginURI'];
			$this->version = $meta[$slug . '.php']['Version'];
			$this->textdomain = $slug;
			$this->slug = $slug;
			$this->name = $meta[$slug . '.php']['Name'];
			$this->url = path_join( plugins_url(), $slug );
			$this->admin_url = admin_url( $this->settings_menu . '?page=' . $slug );
			$this->option = str_replace( '-', '_', $slug ) . '_options';
			$this->includes = WP_PLUGIN_DIR . '/' . $this->slug . '/' . trim( $includes, '/' );

			// If settings page requested
			if ( $settings ) {

				// Settings page menu name. Default: options-general.php
				$this->settings_menu = ( isset( $settings['menu'] ) ) ? $settings['menu'] : 'options-general.php';

				// Settings page menu title. Default: plugin name
				$this->settings_title = ( isset( $settings['title'] ) ) ? $settings['title'] : $this->name;

				// Settings page user capability
				$this->settings_capability = ( isset( $settings['capability'] ) ) ? $settings['capability'] : 'manage_options';

				// Redefine admin url
				$this->admin_url = admin_url( $this->settings_menu . '?page=' . $slug );

				// Add settings page
				add_action( 'admin_menu', array( &$this, 'add_settings_page' ) );

				// Manage options
				add_action( 'admin_init', array( &$this, 'manage_options' ) );

				// Add settings link to plugins dashboard
				add_filter( 'plugin_action_links_' . $this->slug . '/' . $this->slug . '.php', array( &$this, 'add_settings_link' ) );
			}

			// Add plugin initialization hook
			add_action( 'init', array( &$this, 'plugin_init' ) );

			// Enqueue assets
			add_action( 'init', array( &$this, 'enqueue_assets' ) );

			// Insert default settings if it's doesn't exists
			add_action( 'admin_init', array( &$this, 'default_settings' ) );
		}

		/**
		 * Plugin initialization hook
		 */
		public function plugin_init() {

			// Make plugin available for translation
			load_plugin_textdomain( $this->textdomain, false, $this->slug . '/languages/' );
		}

		/**
		 * Enqueue assets
		 */
		public function enqueue_assets() {

			// Assets file path
			$assets_file = $this->includes . '/assets.php';

			// Check that file exists and include it
			if ( file_exists( $assets_file ) )
				require_once $assets_file;
		}

		/**
		 * Insert default plugin settings on activation
		 */
		public function default_settings( $manual = false ) {

			if ( $manual || !get_option( $this->option ) ) {

				// Create array with default options
				$defaults = array( );

				// Loop through available options
				foreach ( $this->get_options() as $value ) {
					$defaults[$value['id']] = $value['std'];
				}

				// Insert default options
				update_option( $this->option, $defaults );
			}
		}

		/**
		 * Get plugin options
		 */
		public function get_options() {

			// Check file parameter and correct it
			$options_file = $this->includes . '/options.php';

			// Check that file exists and include it
			if ( file_exists( $options_file ) )
				require_once $options_file;

			// Return options if it's set
			return ( isset( $options ) ) ? $options : false;
		}

		/**
		 * Get single plugin option value
		 */
		public function get_option( $option = false ) {

			// Get options from database
			$options = get_option( $this->option );

			// Check option is specified
			$value = ( $option ) ? $options[$option] : $options;

			// Return result
			return ( is_array( $value ) ) ? $value : stripslashes( $value );
		}

		/**
		 * Save/reset options
		 */
		public function manage_options() {

			global $pagenow;

			// Save options
			if ( $_POST['action'] == 'save' && $_GET['page'] == $this->slug && $pagenow == $this->settings_menu ) {

				// Prepare variables
				$options = $this->get_options();
				$new_options = array( );

				// Prepare data
				foreach ( $options as $value ) {
					$new_options[$value['id']] = ( is_array( $_POST[$value['id']] ) ) ? $_POST[$value['id']] : htmlspecialchars( $_POST[$value['id']] );
				}

				// Save new options
				if ( update_option( $this->option, $new_options ) ) {

					// Redirect
					header( 'Location: ' . $this->admin_url . '&saved=true' );
				}

				// Options not saved
				else {

					// Redirect
					header( 'Location: ' . $this->admin_url . '&saved=false' );
				}
			}

			// Reset options
			elseif ( $_GET['action'] == 'reset' && $_GET['page'] == $this->slug && $pagenow == $this->settings_menu ) {

				// Prepare variables
				$options = $this->get_options();
				$new_options = array( );

				// Prepare data
				foreach ( $options as $value ) {
					$new_options[$value['id']] = $value['std'];
				}

				// Save new options
				if ( update_option( $this->option, $new_options ) ) {

					// Redirect
					header( 'Location: ' . $this->admin_url . '&reseted=true' );
				} else {

					// Redirect
					header( 'Location: ' . $this->admin_url . '&reseted=false' );
				}
			}
		}

		/**
		 * Register settings page
		 */
		public function add_settings_page() {
			add_submenu_page( $this->settings_menu, __( $this->settings_title, $this->textdomain ), __( $this->settings_title, $this->textdomain ), $this->settings_capability, $this->slug, array( &$this, 'render_settings_page' ) );
		}

		/**
		 * Display settings page
		 */
		public function render_settings_page() {

			$backend_file = $this->includes . '/backend.php';

			if ( file_exists( $backend_file ) )
				require_once $backend_file;
		}

		/**
		 * Add settings link to plugins dashboard
		 */
		public function add_settings_link( $links ) {
			$links[] = '<a href="' . $this->admin_url . '">' . __( 'Settings', $this->textdomain ) . '</a>';
			return $links;
		}

		/**
		 * Show plugin options
		 */
		public function render_options() {

			// Get plugin options
			$options = $this->get_options();

			// Get current settings
			$settings = get_option( $this->option );

			// Open form
			echo '<form action="' . $this->admin_url . '" method="post" id="gndev-plugin-options-form">';

			// Options loop
			foreach ( $options as $option ) {

				// Get option file path
				$option_file = $this->includes . '/fields/' . $option['type'] . '.php';

				// Check that file exists and include it
				if ( file_exists( $option_file ) )
					include( $option_file );
				else
					echo '<h1>Error: <i>' . $option_file . '</i> broken</h1>';
			}

			// Close form
			echo '<input type="hidden" name="action" value="save" /></form>';
		}

		/**
		 * Show notifications
		 */
		public function notifications( $notifications ) {

			// No-js message
			?>
			<div class="error gndev-plugin-notification hide-if-js">
				<p><?php echo $notifications['js']; ?> <a href="http://enable-javascript.com/" target="_blank"><?php _e( 'Instructions', $this->textdomain ); ?></a>.</p>
			</div>
			<?php
			// Options reseted
			if ( $_GET['reseted'] == 'true' ) {
				?>
				<div class="updated gndev-plugin-notification">
					<p><?php echo $notifications['reseted']; ?><small class="hide-if-no-js"><?php _e( 'Click to close', $this->textdomain ); ?></small></p>
				</div>
				<?php
			}

			// Options not reseted
			if ( $_GET['reseted'] == 'false' ) {
				?>
				<div class="error gndev-plugin-notification">
					<p><?php echo $notifications['not-reseted']; ?><small class="hide-if-no-js"><?php _e( 'Click to close', $this->textdomain ); ?></small></p>
				</div>
				<?php
			}

			// Saved
			if ( $_GET['saved'] == 'true' ) {
				?>
				<div class="updated gndev-plugin-notification">
					<p><?php echo $notifications['saved']; ?><small class="hide-if-no-js"><?php _e( 'Click to close', $this->textdomain ); ?></small></p>
				</div>
				<?php
			}

			// No changes
			if ( $_GET['saved'] == 'false' ) {
				?>
				<div class="error gndev-plugin-notification">
					<p><?php echo $notifications['not-saved']; ?><small class="hide-if-no-js"><?php _e( 'Click to close', $this->textdomain ); ?></small></p>
				</div>
				<?php
			}
		}

	}
?>