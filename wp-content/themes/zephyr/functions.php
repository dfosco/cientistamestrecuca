<?php
// add support for automatic-feed-links
add_theme_support( 'automatic-feed-links' );

// register the widgetized sidebar
register_sidebar(array(
  'name' => __( 'Widgets Sidebar', 'zephyr' ),
  'id' => 'zephyr-sidebar',
  'description' => __( 'Add widgets for the main sidebar, make sure you selected Widgets in Appearance > Customize > Layout > Sidebar content', 'zephyr' ),
  'before_title' => '<h2 class="fonttwo">',
  'after_title' => '</h2>'
));

add_action('after_setup_theme', 'zephyr_setup');
function zephyr_setup(){
	if ( get_theme_mod('zephyr_firstrun') == '' ) {
		if ( get_theme_mod('zephyr_logo') == '' ) { set_theme_mod('zephyr_logo', get_template_directory_uri().'/img/zephyr.png'); }
		if ( get_theme_mod('zephyr_fontone') == '' ) { set_theme_mod('zephyr_fontone', 'Gentium+Book+Basic'); }
		if ( get_theme_mod('zephyr_fonttwo') == '' ) { set_theme_mod('zephyr_fonttwo', 'Titillium+Web'); }
		if ( get_theme_mod('zephyr_sidebar_position') == '' ) { set_theme_mod('zephyr_sidebar_position', 'sidebar-left'); }
		if ( get_theme_mod('zephyr_sidemenu') == '' ) { set_theme_mod('zephyr_sidemenu', 'sidemenu'); }
		if ( get_theme_mod('zephyr_footertext') == '' ) { set_theme_mod('zephyr_footertext', 'Developed by <a href="http://themeflame.org" target="_blank">Themeflame</a>'); }
		if ( get_theme_mod('zephyr_infinite') == '' ) { set_theme_mod('zephyr_infinite', '0'); }
		if ( get_theme_mod('zephyr_sticky_sidebar') == '' ) { set_theme_mod('zephyr_sticky_sidebar', '0'); }
		if ( get_theme_mod('zephyr_scrolltop') == '' ) { set_theme_mod('zephyr_scrolltop', '1'); }
		if ( get_theme_mod('zephyr_header_align') == '' ) { set_theme_mod('zephyr_header_align', 'logocenter'); }
		
		update_option( 'zilla_likes_settings', array('disable_css' => 1) );
		set_theme_mod('zephyr_firstrun', '1');
	}
    load_theme_textdomain('zephyr', get_template_directory() . '/lang');
}

if ( ! isset( $content_width ) ) $content_width = 1147;

// loading scripts ( CSS & JS )
require_once( 'zephyr-includes/zephyr-scripts.php' );

// adding menu with custom walker
require_once( 'zephyr-includes/zephyr-menu.php' );

// adding custom comments walker
require_once( 'zephyr-includes/zephyr-comments.php' );

// adding thumbnails
require_once( 'zephyr-includes/zephyr-thumbnails.php' );

// adding support for post formats
add_theme_support( 'post-formats', array( 'aside', 'gallery', 'image', 'quote', 'video', 'audio' ) );

// functions used in the template
require_once( 'zephyr-includes/zephyr-functions.php' );

// adding shortcodes plugin using the TGM plugin Activation class
require_once( 'zephyr-includes/zephyr-plugins.php' );

// adding the page options
require_once( 'zephyr-admin/zephyr-page-options.php' );

// adding the post options
require_once( 'zephyr-admin/zephyr-post-options.php' );

// adding support for the customization api
require_once( 'zephyr-admin/zephyr-customization.php' );

// adding custom widgets
require_once( 'zephyr-admin/zephyr-widgets.php' );

// adding custom author options
require_once( 'zephyr-admin/zephyr-author-options.php' );

// adding support for oembed featured image
require_once( 'zephyr-includes/oembed_featured_image.php' );

// adding social menu
require_once( 'zephyr-admin/zephyr-options.php' );

?>