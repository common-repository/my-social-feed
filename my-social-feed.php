<?php
/**
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              #
 * @since             1.0
 * @package           Instagram
 *
 * Plugin Name:     My Social Feed
 * Plugin URI:      http://bplugins.com
 * Description:     You can easily display Instagram Feed in wordress post, page, widget area and theme template file. 
 * Version:         1.0.1
 * Author:          bPlugins LLC
 * Author URI:      https://bplugins.com
 * Text Domain:     instagram-free
 * Domain Path:     /languages
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! function_exists( 'activate_instagram' ) ) {
	/**
	 * The code that runs during plugin activation.
	 * This action is documented in includes/class-instagram-activator.php
	 */
	function activate_instagram() {
		require_once plugin_dir_path( __FILE__ ) . 'includes/class-instagram-activator.php';
		Instagram_Activator::activate();
	}
}

if ( ! function_exists( 'deactivate_instagram' ) ) {
	/**
	 * The code that runs during plugin deactivation.
	 * This action is documented in includes/class-instagram-deactivator.php
	 */
	function deactivate_instagram() {
		require_once plugin_dir_path( __FILE__ ) . 'includes/class-instagram-deactivator.php';
		Instagram_Deactivator::deactivate();
	}
}

register_activation_hook( __FILE__, 'activate_instagram' );
register_deactivation_hook( __FILE__, 'deactivate_instagram' );

require_once plugin_dir_path( __FILE__ ) . 'admin/views/framework/classes/setup.class.php';
require_once plugin_dir_path( __FILE__ ) . 'admin/views/instagram-settings.php';
require_once plugin_dir_path( __FILE__ ) . 'admin/views/instagram-metaboxs.php';

if ( ! class_exists( 'KP_Instagram_FREE' ) ) {
	/**
	 * Handles core plugin hooks and action setup.
	 *
	 * @package instagram-free
	 * @since 1.0
	 */
	class KP_Instagram_FREE {
		/**
		 * Plugin version
		 *
		 * @var string
		 */
		public $version = '1.0.1';

		/**
		 * @var KP_IFREE_Instagram $shortcode
		 */
		public $instagram;

		/**
		 * @var KP_IFREE_Router $router
		 */
		public $router;

		/**
		 * @var null
		 * @since 1.0
		 */
		protected static $_instance = null;

		/**
		 * @return KP_Instagram_FREE
		 * @since 1.0
		 */
		public static function instance() {
			if ( is_null( self::$_instance ) ) {
				self::$_instance = new self();
			}

			return self::$_instance;
		}

		/**
		 * KP_Instagram_FREE constructor.
		 */
		function __construct() {
			// Define constants.
			$this->define_constants();

			// Required class file include.
			spl_autoload_register( array( $this, 'autoload' ) );

			// Include required files.
			$this->includes();

			// instantiate classes.
			$this->instantiate();

			// Initialize the filter hooks.
			$this->init_filters();

			// Initialize the action hooks.
			$this->init_actions();
		}
		
		/**
		 * Initialize WordPress filter hooks
		 *
		 * @return void
		 */
		function init_filters() {
			add_filter( 'plugin_action_links', array( $this, 'add_instagram_plugin_action_links' ), 10, 2 );
			add_filter( 'manage_kpi_instagram_posts_columns', array( $this, 'add_shortcode_column' ),10 );
			add_filter( 'plugin_row_meta', array( $this, 'after_instagram_free_row_meta' ), 10, 4 );
		}

		/**
		 * Initialize WordPress action hooks
		 *
		 * @return void
		 */
		function init_actions() {
			add_action( 'plugins_loaded', array( $this, 'load_text_domain' ) );
			add_action( 'manage_kpi_instagram_posts_custom_column', array( $this, 'add_instagram_extra_column' ), 10, 2 );
			add_action( 'activated_plugin', array( $this, 'redirect_help_page' ) );
		}

		/**
		 * Define constants
		 *
		 * @since 1.0
		 */
		public function define_constants() {
			$this->define( 'KP_IFREE_VERSION', $this->version );
			$this->define( 'KP_IFREE_PATH', plugin_dir_path( __FILE__ ) );
			$this->define( 'KP_IFREE_URL', plugin_dir_url( __FILE__ ) );
			$this->define( 'KP_IFREE_BASENAME', plugin_basename( __FILE__ ) );
		}

		/**
		 * Define constant if not already set
		 *
		 * @since 1.0
		 *
		 * @param  string      $name
		 * @param  string|bool $value
		 */
		public function define( $name, $value ) {
			if ( ! defined( $name ) ) {
				define( $name, $value );
			}
		}


		/**
		 * Load TextDomain for plugin.
		 *
		 * @since 1.0
		 */
		public function load_text_domain() {
			load_plugin_textdomain( 'instagram-free', false, KP_IFREE_PATH . '/languages' );
		}

		/**
		 * Add plugin action menu
		 *
		 * @param array  $links
		 * @param string $file
		 *
		 * @return array
		 */
		public function add_instagram_plugin_action_links( $links, $file ) {
			if ( KP_IFREE_BASENAME === $file ) {
				$links['go_pro'] = sprintf( '<a href="%s" style="%s">%s</a>', '#', 'color:#1dab87;font-weight:bold', __( 'Go Premium!', 'instagram-free' ) );
			}

			return $links;
		}

		/**
		 * Add plugin row meta link
		 *
		 * @since 1.0
		 *
		 * @param $plugin_meta
		 * @param $file
		 *
		 * @return array
		 */
		function after_instagram_free_row_meta( $plugin_meta, $file ) {
			if ( KP_IFREE_BASENAME === $file ) {
				$plugin_meta[] = '<a href="#" target="_blank">' . __( 'Live Demo', 'instagram-free' ) . '</a>';
			}

			return $plugin_meta;
		}

		/**
		 * Autoload class files on demand
		 *
		 * @param string $class requested class name
		 */
		function autoload( $class ) {
			$name = explode( '_', $class );
			if ( isset( $name[2] ) ) {
				$class_name = strtolower( $name[2] );
				$filename   = KP_IFREE_PATH . '/class/' . $class_name . '.php';

				if ( file_exists( $filename ) ) {
					require_once $filename;
				}
			}
		}

		/**
		 * Instantiate all the required classes
		 *
		 * @since 1.0
		 */
		function instantiate() {
			$this->instagram = KP_IFREE_Instagram::getInstance();

			do_action( 'kp_ifree_instagram', $this );
		}

		/**
		 * page router instantiate.
		 *
		 * @since 1.0
		 */
		function page() {
			$this->router = KP_IFREE_Router::instance();
			return $this->router;
		}

		/**
		 * Include the required files
		 *
		 * @return void
		 */
		function includes() {
			$this->page()->kp_ifree_function();
			$this->router->includes();
		}

		/**
		 * ShortCode Column
		 *
		 * @param $columns
		 *
		 * @return array
		 */
		function add_shortcode_column($defaults) {
			$defaults['shortcode'] = __( 'Shortcode', 'instagram-free' );
			return $defaults;
		}

		/**
		 * @param $column
		 * @param $post_id
		 */
		function add_instagram_extra_column( $column, $post_id ) {

			switch ( $column ) {

				case 'shortcode':
					$column_field = '<input type="text" onClick="this.select();" readonly value="[instagram ' . 'id=&quot;' . $post_id . '&quot;' . ']"/>';
					echo $column_field;
					break;
				default:
					break;

			} // end switch

		}
		
		/**
		 * Redirect after active
		 *
		 * @param $plugin
		 */
		function redirect_help_page( $plugin ) {
			if ( KP_IFREE_BASENAME === $plugin ) {
				exit( wp_redirect( admin_url( 'edit.php?post_type=kpi_instagram&page=ifree_help' ) ) );
			}
		}

	}
}

/**
 * Returns the main instance.
 *
 * @since 1.0
 * @return KP_Instagram_FREE
 */
function kp_instagram_free() {
	return KP_Instagram_FREE::instance();
}

// kp_instagram_free instance.
kp_instagram_free();
