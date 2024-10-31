<?php

if ( ! defined( 'ABSPATH' ) ) { exit; }  // if direct access

/**
 * Scripts and styles
 */
if ( ! class_exists( 'KP_IFREE_Front_Scripts' ) ) {
	class KP_IFREE_Front_Scripts {

		/**
		 * @var null
		 * @since 1.0
		 */
		protected static $_instance = null;

		/**
		 * @return KP_IFREE_Front_Scripts
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

			add_action( 'wp_enqueue_scripts', array( $this, 'front_scripts' ) );
		}

		/**
		 * Plugin Scripts and Styles
		 */
		function front_scripts() {
			// CSS Files.
			wp_enqueue_style( 'ifree-style', KP_IFREE_URL . 'public/assets/css/style.css', array(), KP_IFREE_VERSION );

			// JS Files.
			wp_enqueue_script( 'ifree-instagramFeed-min', KP_IFREE_URL . 'public/assets/js/jquery.instagramFeed.min.js', array( 'jquery' ), KP_IFREE_VERSION, true );

			wp_enqueue_script( 'ifree-instagramFeed-custom', KP_IFREE_URL . 'public/assets/js/instagramFeed.custom.js', array( 'jquery','ifree-instagramFeed-min' ), KP_IFREE_VERSION, true );

		}

	}
}
new KP_IFREE_Front_Scripts();