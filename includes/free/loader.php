<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
/**
 * The Free Loader Class
 *
 * @package instagram-free
 *
 * @since 1.0
 */
if ( ! class_exists( 'KP_IFREE_Loader' ) ) {
	class KP_IFREE_Loader {

		function __construct() {
			require_once KP_IFREE_PATH . 'admin/views/scripts.php';

			// public folder
			require_once KP_IFREE_PATH . 'public/views/shortcodes.php';
			require_once KP_IFREE_PATH . 'public/views/scripts.php';
		}

	}
}

new KP_IFREE_Loader();