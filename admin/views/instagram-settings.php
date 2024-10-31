<?php 

if ( ! defined( 'ABSPATH' ) ) {
  exit;
}  // if direct access

//
// Set a unique slug-like ID.
//
$prefix = '_kp_instagram_options';

//
// Review text.
//
$url  = 'https://wordpress.org/support/plugin/my-social-feed/reviews/?filter=5#new-post';
$text = sprintf(
  __( 'If you like <strong>My Social Feed</strong> please leave us a <a href="%s" target="_blank">&#9733;&#9733;&#9733;&#9733;&#9733;</a> rating. Your Review is very important to us as it helps us to grow more. ', 'instagram-free' ),
  $url
);

//
// Create a settings page.
//
CSF::createOptions(
  $prefix, array(
    'menu_title'       => esc_html__( 'Instagram Feed Settings', 'instagram-free' ),
    'menu_parent'      => 'edit.php?post_type=kpi_instagram',
    'menu_type'        => 'submenu', // menu, submenu, options, theme, etc.
    'menu_slug'        => 'kpi_settings',
    'theme'            => 'light',
    'class'            => 'kpi-main-class',
    'show_all_options' => false,
    'show_search'      => false,
    'show_footer'      => false,
    'footer_credit'    => $text,
    'framework_title'  => esc_html__( 'Instagram Feed Settings', 'instagram-free' ),
  )
);

//
// Custom CSS section.
//
// Create a section
  CSF::createSection( $prefix, array(
    'fields' => array(
      array(
        'id'       => ' ',
        'type'     => 'switcher',
        'title'    => esc_html__( 'Allow Popup', 'instagram-free' ),
        'desc'     => esc_html__( 'Show feed images in popup', 'instagram-free' ),
        'class'      => 'feed-disabled',
        'default'   => false,
      ),

      array(
        'id'       => ' ',
        'type'     => 'switcher',
        'title'    => esc_html__( 'Allow Slider', 'instagram-free' ),
        'desc'     => esc_html__( 'Show feed images in slider', 'instagram-free' ),
        'class'      => 'feed-disabled',
        'default'   => false,
      ),
      
      array(
        'id'       => 'kpd-profile',
        'type'     => 'switcher',
        'title'    => esc_html__( 'Display Profile', 'instagram-free' ),
        'desc'     => esc_html__( 'Enable displaying the profile data', 'instagram-free' ),
        'default'  => true,
      ),

      array(
        'id'       => 'kpd-biography',
        'type'     => 'switcher',
        'title'    => esc_html__( 'Display Biography', 'instagram-free' ),
        'desc'     => esc_html__( 'Enable displaying the biography.', 'instagram-free' ),
        'default'  => true,
      ),
      
      array(
        'id'        => ' ',
        'type'      => 'select',
        'title'     => esc_html__( 'Display Biography Position', 'instagram-free' ),
        'desc'      => esc_html__( 'Set biography position', 'instagram-free' ),
        'class'      => 'feed-disabled',
        'default'   => false,
        'options'   => array(
          'text-center'  => 'Align Center',
          'text-left'    => 'Align Left',
          'text-right'   => 'Align Right'
        )
      ),

      array(
        'id'        => ' ',
        'type'      => 'select',
        'title'     => esc_html__( 'Images Styles', 'instagram-free' ),
        'desc'      => esc_html__( 'Set feed Images style square or round', 'instagram-free' ),
        'class'      => 'feed-disabled',
        'default'   => false,
        'options'   => array(
          'default' => 'Square Images',
          'radius'  => 'Round Images'
        )
      ),

      array(
        'id'         => ' ',
        'type'       => 'select',
        'title'      => esc_html__( 'Images Size', 'instagram-free' ),
        'desc'       => esc_html__( 'Scale of items to build gallery. Does not apply to video previews.', 'instagram-free' ),
        'class'      => 'feed-disabled',
        'default'    => false,
        'options'    => array(
                      640  => 640,
                      480  => 480,
                      320  => 320,
                      240  => 240,
                      150  => 150
                    )
      ),

      array(
        'id'       => 'kpd-gallery',
        'type'     => 'switcher',
        'title'    => esc_html__( 'Display Gallery', 'instagram-free' ),
        'desc'     => esc_html__( 'Enables displaying the gallery', 'instagram-free' ),
        'default'  => true,
      ),

      array(
        'id'       => 'kpd-styling',
        'type'     => 'switcher',
        'title'    => esc_html__( 'Display Styling', 'instagram-free' ),
        'desc'     => esc_html__( 'Enable default inline css styles.', 'instagram-free' ),
        'default'  => true,
      ),      

      array(
        'id'         => ' ',
        'type'       => 'switcher',
        'title'      => esc_html__( 'Display IGTV', 'instagram-free' ),
        'desc'       => esc_html__( 'Enable displaying the IGTV feed if available.', 'instagram-free' ),
        'default'    => false,
        'class'      => 'feed-disabled',
      ), 

      array(
        'id'       => 'kpd-items',
        'type'     => 'spinner',
        'title'    => esc_html__( 'Items', 'instagram-free' ),
        'desc'     => esc_html__( 'Show number of images - Max. 12 for user', 'instagram-free' ),
        'default'  => '8',
        'min'      => '1', 
      ),

      array(
        'id'       => 'kpd-per-row',
        'type'     => 'spinner',
        'title'    => esc_html__( 'Items Per Row', 'instagram-free' ),
        'desc'     => esc_html__( 'Number of images that will be displayed in each row.', 'instagram-free' ),
        'default'  => '4',
        'min'      => '1', 
      ),

      array(
        'id'       => 'kpd-margin',
        'type'     => 'spinner',
        'title'    => esc_html__( 'Margin', 'instagram-free' ),
        'desc'     => esc_html__( 'Margin (percentage) between images in gallery.', 'instagram-free' ),
        'default'  => '1',
      )

    )
  ) );