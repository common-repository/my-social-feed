<?php 
  if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
  }

/**
 * Sanitize function for text field.
 */
if ( ! function_exists( 'kpfinstagram_sanitize_text' ) ):
  function kpfinstagram_sanitize_text( $value ) {

    $text = filter_var( $value, FILTER_SANITIZE_STRING );
    return $text;

  }
endif;

//
// Metabox of the instagram post type.
// Set a unique slug-like ID.
//
$prefix_shortcode_opts = 'kp_instagram_options';

//
// Instagram metabox.
//
CSF::createMetabox(
  $prefix_shortcode_opts, array(
    'title'     => esc_html__( 'Instagram Feed Settings', 'instagram-free' ),
    'class'     => 'kpi-main-class',
    'post_type' => 'kpi_instagram',
    'context'   => 'normal',
  )
);

//get default options
$get_feed_options    = get_option( '_kp_instagram_options' );
$profile                  = $get_feed_options['kpd-profile'];
$biography                = $get_feed_options['kpd-biography'];
$gallery                  = $get_feed_options['kpd-gallery'];
$styling                  = $get_feed_options['kpd-styling'];
$items                    = $get_feed_options['kpd-items'];
$per_row                  = $get_feed_options['kpd-per-row'];
$margin                   = $get_feed_options['kpd-margin'];

// General Settings section.
//
// Create a section
  CSF::createSection( $prefix_shortcode_opts, array(
    'fields' => array(
      
      array(
        'id'          => '',
        'type'        => 'radio',
        'title'       => esc_html__( 'Choose Username / Tag', 'instagram-free' ),
        'desc'        => esc_html__( 'Choose Instagram username/tag.', 'instagram-free' ),
        'options'     => array(
          'username'  => 'Username',
          'tag'       => 'Tag'
        ),
        'default'     => 'username',
        'class'       => 'feed-disabled',
        
      ),

      array(
        'id'       => 'kp-username',
        'type'     => 'text',
        'title'    => esc_html__( 'Username', 'instagram-free' ),
        'subtitle' => esc_html__( 'This text field is required, Instagram username from where to retrieve the feed.', 'instagram-free' ),
        'validate' => 'csf_validate_required',
        'after'    => ' <small class="csf-text-error">( * required )</small>',
      ),

      array(
        'id'       => '',
        'type'     => 'switcher',
        'title'    => esc_html__( 'Allow Popup', 'instagram-free' ),
        'desc'     => esc_html__( 'Show feed images in popup', 'instagram-free' ),
        'default'  => false,
        'class'    => 'feed-disabled',
      ),

      array(
        'id'       => '',
        'type'     => 'switcher',
        'title'    => esc_html__( 'Allow Slider', 'instagram-free' ),
        'desc'     => esc_html__( 'Show feed images in slider', 'instagram-free' ),
        'default'  => false,
        'class'    => 'feed-disabled',
        
      ),

      array(
        'id'       => 'kp-profile',
        'type'     => 'switcher',
        'title'    => esc_html__( 'Display Profile', 'instagram-free' ),
        'desc'     => esc_html__( 'Enable displaying the profile data', 'instagram-free' ),
        'default'  => $profile,
      ),

      array(
        'id'       => 'kp-biography',
        'type'     => 'switcher',
        'title'    => esc_html__( 'Display Biography', 'instagram-free' ),
        'desc'     => esc_html__( 'Enable displaying the biography.', 'instagram-free' ),
        'default'  => $biography,
      ),

      array(
        'id'        => '',
        'type'      => 'select',
        'title'     => esc_html__( 'Display Biography Position', 'instagram-free' ),
        'desc'      => esc_html__( 'Set biography position', 'instagram-free' ),
        'class'     => 'feed-disabled',
        'default'   => false,
        'options'   => array(
          'text-center'  => 'Align Center',
          'text-left'    => 'Align Left',
          'text-right'   => 'Align Right'
        ),
        'dependency' => array( 'kp-biography', '==', 'true' ),
      ),

      array(
        'id'        => '',
        'type'      => 'select',
        'title'     => esc_html__( 'Images Styles', 'instagram-free' ),
        'desc'      => esc_html__( 'Set feed Images style square or round', 'instagram-free' ),
        'default'   => false,
        'options'   => array(
          'default' => 'Square Images',
          'radius'  => 'Round Images'
        ),
        'class'     => 'feed-disabled',
      ),

      array(
        'id'         => '',
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
        'id'       => 'kp-gallery',
        'type'     => 'switcher',
        'title'    => esc_html__( 'Display Gallery', 'instagram-free' ),
        'desc'     => esc_html__( 'Enables displaying the gallery', 'instagram-free' ),
        'default'  => $gallery,
      ),

      array(
        'id'       => 'kp-styling',
        'type'     => 'switcher',
        'title'    => esc_html__( 'Display Styling', 'instagram-free' ),
        'desc'     => esc_html__( 'Enable default inline css styles.', 'instagram-free' ),
        'default'  => $styling,
      ),

      array(
        'id'         => '',
        'type'       => 'switcher',
        'title'      => esc_html__( 'Display IGTV', 'instagram-free' ),
        'desc'       => esc_html__( 'Enable displaying the IGTV feed if available.', 'instagram-free' ),
        'default'    => false,
        'class'      => 'feed-disabled',
      ),

      array(
        'id'       => 'kp-items',
        'type'     => 'spinner',
        'title'    => esc_html__( 'Items', 'instagram-free' ),
        'desc'     => esc_html__( 'Show number of images - Max. 12 for user', 'instagram-free' ),
        'default'  => $items,
        'min'      => '1', 
      ),

      array(
        'id'       => 'kp-per-row',
        'type'     => 'spinner',
        'title'    => esc_html__( 'Items Per Row', 'instagram-free' ),
        'desc'     => esc_html__( 'Number of images that will be displayed in each row.', 'instagram-free' ),
        'default'  => $per_row,
        'min'      => '1', 
      ),

      array(
        'id'       => 'kp-margin',
        'type'     => 'spinner',
        'title'    => esc_html__( 'Margin', 'instagram-free' ),
        'desc'     => esc_html__( 'Margin (percentage) between images in gallery.', 'instagram-free' ),
        'default'  => $margin,
      )

    )
  ) );


// metabox for wordpress

if ( ! function_exists( 'kp_insta_meta_init' ) ) :
    function kp_insta_meta_init(){
        add_meta_box('kp_insta_shortcode', 'Instagram Feed Shortcode', 'kp_insta_shortcode_setup', 'kpi_instagram', 'normal', 'high');
    }
endif;

add_action('admin_init','kp_insta_meta_init');

if ( ! function_exists( 'kp_insta_shortcode_setup' ) ) :
    function kp_insta_shortcode_setup(){
        global $post;
        ?>
        <div class="kpi-main-class">
          <div class="csf-field csf-field-text">
            <div class="csf-title"><h4><?php echo esc_html__( 'Shortcode', 'instagram-free' ) ?></h4></div>
            <div class="csf-fieldset">
              <input type='text' id='kp_insta_shortcode' onfocus='this.select();' readonly value='[instagram id="<?php echo $post->ID; ?>"]' /> 
              <p><?php echo esc_html__( 'Copy this shortcode and paste it into your post, page, or text widget content', 'instagram-free' ) ?></p>
            </div>
          </div>
        </div>
        <?php
    }
endif;