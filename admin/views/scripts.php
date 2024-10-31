<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}  // if direct access

/**
 * Admin Scripts and styles
 */
if ( ! class_exists( 'KP_IFREE_Admin_Scripts' ) ) {
	class KP_IFREE_Admin_Scripts {

		/**
		 * @var null
		 * @since 1.0
		 */
		protected static $_instance = null;

		/**
		 * @return KP_IFREE_Admin_Scripts
		 * @since 1.0
		 */
		public static function instance() {
			if ( is_null( self::$_instance ) ) {
				self::$_instance = new self();
			}

			return self::$_instance;
		}

		/**
		 * Initialize the class
		 */
		public function __construct() {

			add_action( 'admin_enqueue_scripts', array( $this, 'admin_scripts' ) );
		}

		/**
		 * Enqueue admin scripts
		 */
		public function admin_scripts() {
			wp_enqueue_style( 'instagram-free-admin', KP_IFREE_URL . 'admin/assets/css/admin.css', array(), KP_IFREE_VERSION );
		}

	}
}

new KP_IFREE_Admin_Scripts();