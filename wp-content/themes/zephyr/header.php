<!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) | !(IE 8)  ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?php bloginfo('name'); ?> | <?php is_home() ? bloginfo('description') : wp_title(''); ?></title>
	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
	<?php wp_head(); ?>
</head>
<body <?php body_class( get_theme_mod('zephyr_color_scheme') ); ?>>
<div id="bgoverlay"></div>
<?php
global $zephyr_options;
global $zephyr_page_layout;
global $zephyr_cont;
global $zephyr_main_layout;
$zephyr_options = get_option('theme_zephyr_options');
$centered = '';
$sidebar_position = get_theme_mod('zephyr_sidebar_position');
$zephyr_main_layout = get_theme_mod('zephyr_layout');
if ( is_page() ) {
	$pid = get_the_ID();
	global $zephyr_post_layout;
	global $zephyr_posts_centered;
	global $zephyr_default_title;
	global $zephyr_page_slider;
	$zephyr_page_layout = get_post_meta($pid, 'zephyr_meta_box_layout', true);
	if ( $zephyr_page_layout == '0' || $zephyr_page_layout == '' ) { $zephyr_page_layout = $sidebar_position; }
	$zephyr_default_title = get_post_meta($pid, 'zephyr_meta_box_default_title', true);
	$zephyr_post_layout = get_post_meta($pid, 'zephyr_meta_box_post_info', true);
	$zephyr_posts_centered = get_post_meta($pid, 'zephyr_meta_box_centered', true);
	$zephyr_page_slider = get_post_meta( $pid, 'zephyr_page_slider', true );
	if ( $zephyr_posts_centered == 'on' ) { $centered = 'centered'; }
} else {
	// if all else fails, get global option
	$zephyr_page_layout = $sidebar_position;
}
if ( $zephyr_main_layout == 'boxed' ) {
	echo '<div class="container boxed">';
}
	if ( $zephyr_page_layout == 'sidebar-right' ) {  $zephyr_cont = 'contl'; } else { $zephyr_cont = 'contw'; }
	if ( $zephyr_page_layout == 'no-sidebar' ) { 
		get_template_part('templates/top', 'boxed');
	} else {
		get_template_part('templates/top');
	}
if ( is_page() ) {
	if ( $zephyr_page_slider ) {
		get_template_part('templates/page', 'slider');
	}
}
?>
<section id="main" class="row <?php echo $centered; ?>">