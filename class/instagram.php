<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * The KP_IFREE_Instagram class.
 */
if ( ! class_exists( 'KP_IFREE_Instagram' ) ) {
	class KP_IFREE_Instagram {

		/**
		 * The class instance.
		 *
		 * @var $_instance
		 * @since 1.0
		 */
		private static $_instance;

		/**
		 * The method to get instance.
		 *
		 * @return $_instance
		 * @since 1.0
		 */
		public static function getInstance() {
			if ( ! self::$_instance ) {
				self::$_instance = new self();
			}

			return self::$_instance;
		}

		/**
		 * The class constructor.
		 *
		 * @since 1.0
		 */
		public function __construct() {
			add_filter( 'init', array( $this, 'register_post_type' ) );
		}

		/**
		 * Register post type
		 *
		 * @since 1.0
		 */
		public function register_post_type() {

			if ( post_type_exists( 'kpi_instagram' ) ) {
				return;
			}

			$labels = apply_filters(
				'kp_instagram_post_type_labels',
				array(
					'name'                  => esc_html__( 'Instagram Feed', 'instagram-free' ),
					'all_items'          	=> esc_html__( 'Instagram Feed', 'instagram-free' ),
					'singular_name'         => esc_html__( 'Instagram Feed', 'instagram-free' ),				
					'add_new'               => esc_html__( 'Add Instagram Feed', 'instagram-free' ),
					'add_new_item'          => esc_html__( 'Add Instagram Feed', 'instagram-free' ),
					'edit'                  => esc_html__( 'Edit', 'instagram-free' ),
					'edit_item'             => esc_html__( 'Edit Instagram Feed', 'instagram-free' ),
					'new_item'              => esc_html__( 'New Instagram Feed', 'instagram-free' ),
					'view_item' 			=> esc_html__( 'View Instagram Feed', 'instagram-free' ),
					'search_items'          => esc_html__( 'Search Instagram Feed', 'instagram-free' ),
					'not_found' 			=> esc_html__( 'Sorry, we couldn\'t find the Instagram Feed file you are looking for.', 'instagram-free' )
				)
			);

			$args = apply_filters(
				'kp_instagram_post_type_args',
				array(
					'label'              => esc_html__( 'Instagram Feed', 'instagram-free' ),
					'description'        => esc_html__( 'Instagram custom post type.', 'instagram-free' ),
					'taxonomies'         => array(),
					'public'             => false,
					'has_archive'        => false,
					'publicly_queryable' => true,
					'query_var'          => false,
					'show_ui'            => current_user_can( 'manage_options' ) ? true : false,
					'show_in_menu'       => true,
					'menu_icon'          => 'dashicons-instagram',
					'show_in_nav_menus'  => true,
					'show_in_admin_bar'  => true,
					'hierarchical'       => false,
					'menu_position'      => 20,
					'supports'           => array('title'),
					'capability_type'    => 'post',
					'labels'             => $labels,
					'rewrite' 			 => array( 'slug' => 'instagram-free' )
				)
			);

			register_post_type( 'kpi_instagram', $args );
		}

	}
}