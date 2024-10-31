<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly.

// Instagram Free shortcode.
if ( ! function_exists( 'kp_instagram_free_shortcode' ) ) :
	function kp_instagram_free_shortcode( $atts ) {
		extract(
			shortcode_atts(
				array(
					'id' => null
				), $atts, 'instagram-free'
			)
		);

		$post_id = $atts['id'];

		$html = '';

		$instagram_args = array(
			'post_type'      => 'kpi_instagram',
			'p'         	 => $post_id, // ID of a page, post, or custom type
			'post_status'    => 'publish'		
		);

		$instagram_query = new WP_Query( $instagram_args );

		if ( $instagram_query->have_posts() ) {

			while ( $instagram_query->have_posts() ) :
				$instagram_query->the_post();

				// get codestar options
				$data  = get_post_meta( get_the_ID(), 'kp_instagram_options', true );
				
				// instagram container
				$container 		= "instagram-feed".esc_attr(get_the_ID());

				// settings array
				$json_args = array(
					'username' 				=> $data['kp-username'],
			        'container'				=> '#'.$container,
			        'display_profile'		=> $data['kp-profile'] ? true : false,
			        'display_biography'		=> $data['kp-biography'] ? true : false,
			        'display_gallery'		=> $data['kp-gallery'] ? true : false,
			        'callback'				=> null,
			        'styling'				=> $data['kp-styling'] ? true : false,
			        'items'					=> $data['kp-items'],
			        'items_per_row'			=> $data['kp-per-row'],
			        'margin'				=> $data['kp-margin']
				);

				// json encode options
				$instagram_options = json_encode($json_args);	

				// html output
				$html .='<div id="'.esc_attr($container).'" class="kp_instagram_container" data-insta-options="'. esc_attr($instagram_options).'"></div>';
			endwhile;
		}	

		// reset postdata
		wp_reset_postdata();

		return $html;
	}
endif;

//call shortcode
add_shortcode( 'instagram', 'kp_instagram_free_shortcode' );