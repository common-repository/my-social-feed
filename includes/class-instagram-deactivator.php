<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Instagram
 * @subpackage Instagram/includes
 */
if ( ! class_exists( 'Instagram_Deactivator' ) ) {
	class Instagram_Deactivator {

		/**
		 * Deactivation hook function.
		 */
		public static function deactivate() {

		}

	}
}