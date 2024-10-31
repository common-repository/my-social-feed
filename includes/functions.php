<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}  // if direct access

/**
 * Functions
 */
if ( !class_exists( 'KP_Instagram_Free_Functions' ) ) {
	class KP_Instagram_Free_Functions {

		/**
		 * Initialize the class
		 */
		public function __construct() {
			add_filter( 'post_updated_messages', array( $this, 'kp_ifree_change_default_post_update_message' ) );
			add_filter( 'admin_footer_text', array( $this, 'admin_footer' ), 1, 2 );
			add_action( 'admin_menu', array( $this, 'admin_menu' ), 100 );

			// hide button
			add_action('admin_head-post.php', array( $this, 'kp_instagram_hide_publishing_actions'));
			add_action('admin_head-post-new.php', array( $this, 'kp_instagram_hide_publishing_actions'));	

			// change publish text
			add_filter( 'gettext', array( $this, 'kp_instagram_change_publish_button'), 10, 2 );

			if ( is_admin() ) {
				add_filter( 'post_row_actions', array( $this, 'kp_instagram_disable_quick_edit'), 10, 2 );
			}
		}

		/**
		 * Post update messages
		 */
		function kp_ifree_change_default_post_update_message( $message ) {
			$screen = get_current_screen();
			if ( 'kpi_instagram' == $screen->post_type ) {
				$message['post'][1]  = $title = esc_html__( 'Instagram Feed updated.', 'instagram-free' );
				$message['post'][4]  = $title = esc_html__( 'Instagram Feed updated.', 'instagram-free' );
				$message['post'][6]  = $title = esc_html__( 'Instagram Feed published.', 'instagram-free' );
				$message['post'][8]  = $title = esc_html__( 'Instagram Feed submitted.', 'instagram-free' );
				$message['post'][10] = $title = esc_html__( 'Instagram Feed draft updated.', 'instagram-free' );
			}

			return $message;
		}

		/**
		 * Review Text
		 *
		 * @param $text
		 *
		 * @return string
		 */
		public function admin_footer( $text ) {
			$screen = get_current_screen();
			if ( 'kpi_instagram' == get_post_type() || $screen->id == 'kpi_instagram_page_ifree_help' ) {
				
				$url  = 'https://wordpress.org/support/plugin/my-social-feed/reviews/?filter=5#new-post';
				$text = sprintf(
					__( 'If you like <strong>My Social Feed</strong> Plugin please leave us a <a href="%s" target="_blank">&#9733;&#9733;&#9733;&#9733;&#9733;</a> rating. Your Review is very important to us as it helps us to grow more. ', 'instagram-free' ),
					$url
				);
			}

			return $text;
		}

		/**
		 * Hide Actions
		*/
		function kp_instagram_hide_publishing_actions(){
		        $post_type = 'kpi_instagram';
		        global $post;
		        if($post->post_type == $post_type){
		            echo '
		                <style type="text/css">
		                    #misc-publishing-actions,
		                    #minor-publishing-actions{
		                        display:none;
		                    }
		                </style>
		            ';
		       }
		}
		/**
		 * Change Publish Text
		*/
		function kp_instagram_change_publish_button( $translation, $text ) {
			if ( 'kpi_instagram' == get_post_type()){
				if ( $text == 'Publish' ){
				    return 'Save';
				}
			}	
			
			return $translation;			
		}
		/**
		 * Hide & Disabled View, Quick Edit and Preview Button
		 */
		function kp_instagram_disable_quick_edit( $actions = array(), $post = null ) {
			global $post;
		    if( $post->post_type == 'kpi_instagram' ) {
				if ( isset( $actions['view'] ) ) {
					unset( $actions['view'] );
				}
				if ( isset( $actions['inline hide-if-no-js'] ) ) {
					unset( $actions['inline hide-if-no-js'] );
				}
			}
		    return $actions;
		}

		/**
		 * Admin Menu
		 */
		public function admin_menu() {
			add_submenu_page(
				'edit.php?post_type=kpi_instagram', __( 'Instagram Feed Pro', 'instagram-free' ), __( 'Premium', 'instagram-free' ), 'manage_options', 'instagram_premium', array(
					$this,
					'premium_page_callback',
				)
			);
			add_submenu_page(
				'edit.php?post_type=kpi_instagram', __( 'Instagram Help', 'instagram-free' ), __( 'Help', 'instagram-free' ), 'manage_options', 'ifree_help', array(
					$this,
					'help_page_callback',
				)
			);
		}

		/**
		 * Premium Page Callback
		 */
		public function premium_page_callback() {
			?>
			<div class="wrap about-wrap kp-ifree-help kp-ifree-upgrade">
				<h1><?php _e( 'Upgrade to <span>My Social Feed Pro</span>', 'instagram-free' ); ?></h1>
				<p class="about-text">
					<?php
					echo esc_html__(
						'Get more Advanced Functionality & Flexibility with the Premium version.', 'instagram-free'
					);
					?>
				</p>
				<div class="wp-badge"></div>
				<ul>
					<li class="pfree-upgrade-btn"><a href="#" target="_blank"><?php echo esc_html__( 'Buy My Social Feed Pro', 'instagram-free' ); ?></a></li>
					<li class="pfree-upgrade-btn"><a href="#" target="_blank"><?php echo esc_html__( 'Live Demo & All Features', 'instagram-free' ); ?></a></li>
				</ul>

				<hr>

				<div class="kp-ifree-pro-features">
					<h2 class="text-center"><?php echo esc_html__( 'Premium Features You\'ll Love', 'instagram-free' ); ?></h2>
					<p class="text-center kp-ifree-pro-subtitle"><?php echo esc_html__( 'We\'ve added 150+ extra features in our Premium Version of this plugin. Let’s see some amazing features.', 'instagram-free' ); ?></p>

					<div class="feature-section three-col">
						<div class="col">
							<div class="kp-ifree-feature">
								<h3><span class="dashicons dashicons-yes"></span><?php echo esc_html__( 'Advanced Shortcode Generator', 'instagram-free' ); ?></h3>
								<p><?php echo esc_html__( 'Understanding long-shortcodes attributes are very painful. Instagram Feed Pro comes with built-in Shortcode Generator to control easily the look and function of the Instagram feed showcase.', 'instagram-free' ); ?></p>
							</div>
						</div>
						<div class="col">
							<div class="kp-ifree-feature">
								<h3><span class="dashicons dashicons-yes"></span><?php echo esc_html__( 'Easy To Use–No Coding Required', 'instagram-free' ); ?></h3>
								<p><?php echo esc_html__( 'Instagram Feed Pro is very easy to use for anyone who is familiar with WordPress. After installing Instagram Feed Pro, it will add a powerful, easy to use Instagram Feed menu on your WordPress dashboard. You’ll be able to manage it and showcase your instagram feed easily!', 'instagram-free' ); ?></p>
							</div>
						</div>
						<div class="col">
							<div class="kp-ifree-feature">
								<h3><span class="dashicons dashicons-yes"></span><?php echo esc_html__( 'Slider, Grid, Masonry, List, & Filter Layouts', 'instagram-free' ); ?></h3>
								<p><?php echo esc_html__( 'You can select from 5 beautiful instagram feed layouts: Slider, Grid, Masonry, List, & Filter. Creating a customized layout is super easy. You can change the number of layout columns, reviewer info to show, font, & color etc.', 'instagram-free' ); ?></p>
							</div>
						</div>
						<div class="col">
							<div class="kp-ifree-feature">
								<h3><span class="dashicons dashicons-yes"></span><?php echo esc_html__( '10+ Professional Themes', 'instagram-free' ); ?></h3>
								<p><?php echo esc_html__( 'Get designer quality results without writing a single line of code through 10+ professionally pre-designed themes for front-end display. Each theme has a different structure and huge customization options to cover all the demands.', 'instagram-free' ); ?></p>
							</div>
						</div>
						<div class="col">
							<div class="kp-ifree-feature">
								<h3><span class="dashicons dashicons-yes"></span><?php echo esc_html__( '840+ Google Fonts', 'instagram-free' ); ?></h3>
								<p><?php echo esc_html__( 'Instagram Feed Pro includes over 840+ Google fonts. You can add your desired font from 840+ Google Fonts. Customize the font family, size, transform, letter spacing, color, and line-height for every element.', 'instagram-free' ); ?></p>
							</div>
						</div>
						<div class="col">
							<div class="kp-ifree-feature">
								<h3><span class="dashicons dashicons-yes"></span><?php echo esc_html__( '100+ Visual Customisation Options', 'instagram-free' ); ?></h3>
								<p><?php echo esc_html__( 'It could be easier to generate the shortcode to display the instagram feed. Just go to the Shortcode Generator, choose the settings you want and generated shortcode is ready to use where you want like posts, pages, and widgets.', 'instagram-free' ); ?></p>
							</div>
						</div>
						<div class="col">
							<div class="kp-ifree-feature">
								<h3><span class="dashicons dashicons-yes"></span><?php echo esc_html__( '14 Display Options', 'instagram-free' ); ?></h3>
								<p><?php echo esc_html__( 'Pick individual fields for each Instagram\'s Feed information. You can toggle between Instagram Feed Image, Video, title, Content, Name, Rating star, identity, Company, Location, Mobile, E-mail, Date, Website, And Social profile links.', 'instagram-free' ); ?></p>
							</div>
						</div>
						<div class="col">
							<div class="kp-ifree-feature">
								<h3><span class="dashicons dashicons-yes"></span><?php echo esc_html__( 'Highly Customizable', 'instagram-free' ); ?></h3>
								<p><?php echo esc_html__( 'Instagram Feed Pro is extremely customizable with plenty of amazing options. From layouts to fonts to unlimited color options,  themes are carefully made with easy customization in mind, effortlessly!', 'instagram-free' ); ?></p>
							</div>
						</div>
						<div class="col">
							<div class="kp-ifree-feature">
								<h3><span class="dashicons dashicons-yes"></span><?php echo esc_html__( 'Drag & Drop Re-Ordering!', 'instagram-free' ); ?></h3>
								<p><?php echo esc_html__( 'One of the most amazing features of Instagram Feed Pro is the ability to drag & drop re-order instagram feed. You can re-order your instagram feed simply by drag & drop, or choose to display the instagram feed randomly.', 'instagram-free' ); ?></p>
							</div>
						</div>
						<div class="col">
							<div class="kp-ifree-feature">
								<h3><span class="dashicons dashicons-yes"></span><?php echo esc_html__( 'Showcase by Specific Category', 'instagram-free' ); ?></h3>
								<p><?php echo esc_html__( 'Do you want to show a specific instagram feed category to your potential customers? You can show instagram feed from categories. Save your time by allowing automatical showcasing of available instagram feed from the category.', 'instagram-free' ); ?></p>
							</div>
						</div>
						<div class="col">
							<div class="kp-ifree-feature">
								<h3><span class="dashicons dashicons-yes"></span><?php echo esc_html__( 'Display Specific Instagram feed', 'instagram-free' ); ?></h3>
								<p><?php echo esc_html__( 'You can display the specific instagram feed from available instagrams in the list. Highlight your specific instagram feed in strategic positions, it will allow you to convert visitors into your valuable customers.', 'instagram-free' ); ?></p>
							</div>
						</div>
						<div class="col">
							<div class="kp-ifree-feature">
								<h3><span class="dashicons dashicons-yes"></span><?php echo esc_html__( 'Front-end Submission Form', 'instagram-free' ); ?></h3>
								<p><?php echo esc_html__( 'You can create Front-end Submission Form for customers to collect new instagram feed for your business. When you receive a new instagram feed, simply review and approve it to automatically add it to your customer instagram feed page!', 'instagram-free' ); ?></p>
							</div>
						</div>
					</div>

				</div>
				<hr>					
				<h2 class="text-center kp-ifree-promo-video-title"><?php _e( 'Watch How <b>My Social Feed Pro</b> Works', 'instagram-free' ); ?></h2>
					<div class="headline-feature feature-video">

						<iframe width="1050" height="590" src="https://www.youtube.com/embed/QaiWWJTKrjA" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
					</div>
					<hr>
					<div class="kp-ifree-join-community text-center">
						<h2><?php _e( 'Join the <b>20000+</b> Happy Users Worldwide!', 'instagram-free' ); ?></h2>
						<a class="tfree-upgrade-btn" target="_blank" href="E"><?php echo esc_html__( 'Get a license instantly', 'instagram-free' ); ?></a>
						<p><?php _e( 'Every purchase comes with <b>7-day</b> money back guarantee and access to our incredibly Top-notch Support with lightening-fast response time and 100% satisfaction rate. One-Time payment, lifetime automatic update.', 'instagram-free' ); ?></p>
					</div>
					<br>
					<br>

					<hr>
					<div class="kp-ifree-upgrade-sticky-footer text-center">
						<p>
							<a href="#" target="_blank" class="button button-primary"><?php echo esc_html__( 'Live Demo', 'instagram-free' ); ?></a> 
							<a href="#" target="_blank" class="button button-primary"><?php echo esc_html__( 'Upgrade Now', 'instagram-free' ); ?></a>
						</p>
					</div>
				</div>
			<?php
		}

		/**
		 * Help Page Callback
		 */
		public function help_page_callback() {
			?>
			<div class="wrap about-wrap kp-ifree-help">
				<h1><?php echo esc_html__( 'Welcome to My Social Feed!', 'instagram-free' ); ?></h1>
				<p class="about-text">
					<?php
						echo esc_html__(
							'Thank you for installing My Social Feed! You\'re now running the most popular My Social Feed plugin. This video playlist will help you get started with the plugin.', 'instagram-free'
						);
					?>
				</p>
				<div class="wp-badge"></div>

				<hr>

				<div class="headline-feature feature-video">
					<iframe width="560" height="315" src="https://www.youtube.com/embed/QaiWWJTKrjA" frameborder="0" allowfullscreen></iframe>
				</div>

				<hr>

				<div class="feature-section help-section three-col">
					<div class="col">
						<div class="kp-ifree-feature text-center">
							<i class="kp-ifree-font-icon fa fa-life-ring"></i>
							<h3><?php echo esc_html__( 'Need any Assistance?', 'instagram-free' ); ?></h3>
							<p><?php echo esc_html__( 'Our Expert Support Team is always ready to help you out promptly.', 'instagram-free' ); ?></p>
							<a href="http://bplugins.com" target="_blank" class="button
							button-primary"><?php echo esc_html__( 'Contact Support', 'instagram-free' ); ?></a>
						</div>
					</div>
					<div class="col">
						<div class="kp-ifree-feature text-center">
							<i class="kp-ifree-font-icon fa fa-file-text"></i>
							<h3><?php echo esc_html__( 'Looking for Documentation?', 'instagram-free' ); ?></h3>
							<p><?php echo esc_html__( 'We have detailed documentation on every aspects of Instagram.', 'instagram-free' ); ?></p>
							<a href="https://docs.google.com/document/d/1icV3XdgSUvblrseBWtoDRvvOqpsKvoV69C5awBuTFYc/edit?ts=5ee1284d" target="_blank" class="button button-primary"><?php echo esc_html__( 'Documentation', 'instagram-free' ); ?></a>
						</div>
					</div>
					<div class="col">
						<div class="kp-ifree-feature text-center">
							<i class="kp-ifree-font-icon fa fa-thumbs-up"></i>
							<h3><?php echo esc_html__( 'Like This Plugin?', 'instagram-free' ); ?></h3>
							<p><?php echo esc_html__( 'If you like This Plugin, please leave us a 5 star rating.', 'instagram-free' ); ?></p>
							<a href="https://wordpress.org/support/plugin/my-social-feed/reviews/?filter=5#new-post" target="_blank" class="button button-primary">
								<?php echo esc_html__( 'Rate the Plugin', 'instagram-free' ); ?>
							</a>
						</div>
					</div>
				</div>

			</div>
			<?php
		}


	}
}

new KP_Instagram_Free_Functions();

/**
 *
 * Multi Language Support
 *
 * @since 1.0
 */

// Polylang plugin support for multi language support.
if ( class_exists( 'Polylang' ) ) {

	add_filter( 'pll_get_post_types', 'kp_ifree_instagram_polylang', 10, 2 );

	function kp_ifree_instagram_polylang( $post_types, $is_settings ) {
		if ( $is_settings ) {			
			unset( $post_types['kpi_instagram'] );
		} else {
			$post_types['kpi_instagram']     = 'kpi_instagram';
		}
		return $post_types;
	}
}