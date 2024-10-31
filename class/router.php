<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Instagram - route class
 *
 * @since 1.0
 */
if ( ! class_exists( 'KP_IFREE_Router' ) ) {
	class KP_IFREE_Router {

		/**
		 * @var KP_IFREE_Router single instance of the class
		 *
		 * @since 1.0
		 */
		protected static $_instance = null;


		/**
		 * Main KP_IFREE_Router Instance
		 *
		 * @since 1.0
		 * @static
		 * @return self Main instance
		 */
		public static function instance() {
			if ( is_null( self::$_instance ) ) {
				self::$_instance = new self();
			}

			return self::$_instance;
		}

		/**
		 * Include the required files
		 *
		 * @since 1.0
		 * @return void
		 */
		function includes() {
			include_once KP_IFREE_PATH . 'includes/free/loader.php';
		}

		/**
		 * function
		 *
		 * @since 1.0
		 * @return void
		 */
		function kp_ifree_function() {
			include_once KP_IFREE_PATH . 'includes/functions.php';
		}

	}
}