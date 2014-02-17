<?php
function zephyr_scripts() {
// register bootstrap css files
	wp_register_style( 'zephyr_bootstrap', get_template_directory_uri() . '/css/bootstrap.min.css', array(), '3.02' );
// register google fonts
	// check if user changed default fonts
	$fontone = get_theme_mod('zephyr_fontone');
	$fonttwo = get_theme_mod('zephyr_fonttwo');
	$fonttitles = get_theme_mod('zephyr_font_titles');
	$fonttitle_weight = get_theme_mod('zephyr_font_titles_weight');
	$fonttitle_size = get_theme_mod('zephyr_font_titles_size');
	$fonttwo_size = get_theme_mod('zephyr_fonttwo_size');
	$fonttwo_weight = get_theme_mod('zephyr_fonttwo_weight');
	$zephyr_text_logo_font = get_theme_mod('zephyr_textlogo_font');
	$gfont_link = 'http://fonts.googleapis.com/css?family='.$fonttwo.':400,700|'.$fontone.':400,400italic,700,700italic';
	if ( !empty($zephyr_text_logo_font) ) {
		$gfont_link = $gfont_link.'|'.$zephyr_text_logo_font.':400';
	}
	if ( !empty($fonttitles) ) {
		$gfont_link = $gfont_link.'|'.$fonttitles.':400,700';
	}
	wp_register_style( 'zephyr_gfonts', $gfont_link, array(), '1' );
	wp_register_style( 'zephyr_fancybox', get_template_directory_uri() . '/css/fancybox.css', array(), '2.6' );
	wp_register_style( 'zephyr_sidr', get_template_directory_uri() . '/css/jquery.sidr.dark.css', array(), '1.4.7' );
// register the main css file for the theme
	wp_register_style( 'zephyr_css', get_stylesheet_directory_uri() . '/style.css', array('zephyr_gfonts', 'zephyr_bootstrap', 'zephyr_fancybox'), '1.0' );

// add the css files to the theme
	wp_enqueue_style( 'zephyr_css' );
	if ( !empty($fontone) && $fontone !== 'Gentium+Book+Basic' ) {
		$fontone_family = str_replace('+', ' ', $fontone);
		$fontone_style = "
		body, .fontone, .details, .post-text h1, .post-text h2, .post-text h3, .post-text h4, .post-text h5, .post-text h6, .counter-in h2, .author-info h2, .author-box-large-info h2 {
		font-family: '{$fontone_family}', serif;
		}";
		wp_add_inline_style( 'zephyr_css', $fontone_style ); 		
	}
	if ( !empty($fonttwo) && $fonttwo !== 'Titillium+Web' ) {
		$fonttwo_family = str_replace('+', ' ', $fonttwo);
		$fonttwo_style = "
		.fonttwo, h4, nav#main-top ul li, .zephyr-pagination, .comments-list h5, .form-row label, .form-row input[type=\"text\"],.form-row input[type=\"email\"], .form-row textarea, .form-row button.submit, .form-submit input, .zephir_acc_heading h4, .image-text-text p, .zephyr-button, .about-box h4, .about-box-img-large .details h4, .about-box-img-small .contwlogo h4, .header-block h2, .counter-in h3, .author-info h3, .author-box-large-info h3, .update-box-title h2, .zephyr-tags .zephyr-tag, #author-top h1, .lb-number, .post-category, .post-text h1.small, .post-text h2.small, .post-text h3.small, .post-text h4.small, .post-text h5.small, .post-text h6.small, .tagcloud a, .featured, .sidr, .comment-reply-link, .postpropinfo, .zilla-likes-count, .read-more {
		font-family: '{$fonttwo_family}', sans-serif;
		}";
		wp_add_inline_style( 'zephyr_css', $fonttwo_style ); 		
	}
	if ( !empty($fonttwo_weight) && $fonttwo_weight !== '600' ) {
		$fonttwo_weight_style = "
		.fonttwo, h4, nav#main-top ul li, .zephyr-pagination, .comments-list h5, .form-row label, .form-row input[type=\"text\"],.form-row input[type=\"email\"], .form-row textarea, .form-row button.submit, .form-submit input, .zephir_acc_heading h4, .image-text-text p, .zephyr-button, .about-box h4, .about-box-img-large .details h4, .about-box-img-small .contwlogo h4, .header-block h2, .counter-in h3, .author-info h3, .author-box-large-info h3, .update-box-title h2, .zephyr-tags .zephyr-tag, #author-top h1, .lb-number, .post-category, .post-text h1.small, .post-text h2.small, .post-text h3.small, .post-text h4.small, .post-text h5.small, .post-text h6.small, .tagcloud a, .featured, .sidr, .comment-reply-link, .postpropinfo, .zilla-likes-count, .read-more, nav#main-top ul li a {
		font-weight: {$fonttwo_weight} !important;
		}";
		wp_add_inline_style( 'zephyr_css', $fonttwo_weight_style ); 		
	}
	if ( !empty($fonttitles) && $fonttitles !== 'Gentium+Book+Basic' ) {
		$fonttitles_family = str_replace('+', ' ', $fonttitles);
		$fonttitles_style = "
		h1, h2, h3, h3 a, h1 a, h1, h2, h3, h4, h5, h6, .related-title, #author-top h1, #author-top h2, .post-text address, .widget_recent_entries ul > li > a {
		font-family: '{$fonttitles_family}', serif;
		}";
		wp_add_inline_style( 'zephyr_css', $fonttitles_style );
	}
	if ( !empty( $fonttitle_weight ) && $fonttitle_weight !== '400' ) {
		$fonttitle_weight_style = "
		h1, h2, h3, h3 a, h1 a, h1, h2, h3, h4, h5, h6, .related-title, #author-top h1, #author-top h2, .post-text address, .widget_recent_entries ul > li > a {
		font-weight: {$fonttitle_weight};
		}";
		wp_add_inline_style( 'zephyr_css', $fonttitle_weight_style );
	}
	if ( !empty($fonttwo_size) && $fonttwo_size !== '11' ) {
		$fonttwo_size_style = '.fonttwo, h4, nav#main-top ul li, .zephyr-pagination, .comments-list h5, .form-row label, .form-row input[type=\"text\"],.form-row input[type=\"email\"], .form-row textarea, .form-row button.submit, .form-submit input, .zephir_acc_heading h4, .image-text-text p, .zephyr-button, .about-box h4, .about-box-img-large .details h4, .about-box-img-small .contwlogo h4, .header-block h2, .counter-in h3, .author-info h3, .author-box-large-info h3, .update-box-title h2, .zephyr-tags .zephyr-tag, #author-top h1, .lb-number, .post-category, .post-text h1.small, .post-text h2.small, .post-text h3.small, .post-text h4.small, .post-text h5.small, .post-text h6.small, .tagcloud a, .featured, .sidr, .comment-reply-link, .postpropinfo, .zilla-likes-count, .read-more, nav#main-top ul li a { font-size: '.$fonttwo_size.'px; }';
		wp_add_inline_style( 'zephyr_css', $fonttwo_size_style );
	}
	if ( !empty( $fonttitle_size ) && $fonttitle_size !== '32' ) {
		$fonttitle_size_style = 'h1 { font-size: '.$fonttitle_size.'px; }';
		wp_add_inline_style( 'zephyr_css', $fonttitle_size_style );
	}
	$zephyr_link_color = get_option('zephyr_link_color');
	if ( !empty($zephyr_link_color) && $zephyr_link_color !== '#212121' ) {
		$zephyr_link_color_style = 'a { color:	'.$zephyr_link_color.'; } ';
		wp_add_inline_style( 'zephyr_css', $zephyr_link_color_style ); 
	}
	$zephyr_link_hover_color = get_option('zephyr_link_hover_color');
	if ( !empty($zephyr_link_hover_color) && $zephyr_link_hover_color !== '#020202' ) {
		$zephyr_link_hover_color_style = 'a:hover { color: '.$zephyr_link_hover_color.'; } ';
		wp_add_inline_style( 'zephyr_css', $zephyr_link_hover_color_style ); 
	}
	$zephyr_accent_color = get_option('zephyr_accent_color');
	if ( !empty($zephyr_accent_color) && $zephyr_accent_color !== '#FFD773' ) {
		$zephyr_accent_color_style = '.accentbg, .zephyr-tags a.zephyr-tag:hover, .widget_calendar #wp-calendar td a:hover, .form-submit input#submit, .tagcloud a:hover, #zephyr-widget-sidebar .carousel-indicators li.active, .form-submit input { background-color: '.$zephyr_accent_color.'; } .accentborder { border-color: '.$zephyr_accent_color.'; } .accentcolor, .comments-list .bypostauthor h5, .comments-list .bypostauthor h5 a { color: '.$zephyr_accent_color.'; } ';
		wp_add_inline_style( 'zephyr_css', $zephyr_accent_color_style ); 
	}
	$zephyr_text_color = get_option('zephyr_text_color');
	if ( !empty($zephyr_text_color) && $zephyr_text_color !== '#878787' ) {
		$zephyr_text_color_style = '.post-text p, .about-author p, .zephyr-chapter-top h3, #author-top .author-bio, .post-category, .read-more, .read-more a, .details, .post-author, .post-author span, .post-text h1, .post-text h2, .post-text h3, .post-text h4, .post-text h5, .post-text h6, .credits, .post-text ul li, .post-text ol li, .post-content .post-text h4, .post-text table, .post-text dl, #zephyr-widget-sidebar p, .post-text ul, .post-text ol  .post-text table, .post-text address, .cat-item, .recentcomments, .zephyr-desc { color: '.$zephyr_text_color.'; } ';
		wp_add_inline_style( 'zephyr_css', $zephyr_text_color_style ); 
	}
	$zephyr_titles_color = get_option('zephyr_titles_color');
	if ( !empty($zephyr_titles_color) && $zephyr_titles_color !== '#050505' ) {
		$zephyr_titles_color_style = 'h3 a, h1 a, h1, h2, h3, h4, h5, h6, .related-entries .col-md-4 a.related-title, #author-top h1, #author-top h2, .post-text address, .cat-name { color: '.$zephyr_titles_color.'; } ';
		wp_add_inline_style( 'zephyr_css', $zephyr_titles_color_style ); 
	}
	$zephyr_titles_hover_color = get_option('zephyr_titles_hover_color');
	if ( !empty($zephyr_titles_hover_color) && $zephyr_titles_hover_color !== '#ababab' ) {
		$zephyr_titles_hover_color_style = 'h3 a:hover, h1 a:hover, .related-entries .col-md-4 a.related-title:hover  { color: '.$zephyr_titles_hover_color.'; } ';
		wp_add_inline_style( 'zephyr_css', $zephyr_titles_hover_color_style ); 
	}	
	$zephyr_menu_color = get_option('zephyr_menu_color');
	if ( !empty($zephyr_menu_color) && $zephyr_menu_color !== '#B0B0B0' ) {
		$zephyr_menu_color_style = 'nav#main-top ul li a { color: '.$zephyr_menu_color.'; } ';
		wp_add_inline_style( 'zephyr_css', $zephyr_menu_color_style ); 
	}	
	$zephyr_dropdown_text_color = get_option('zephyr_dropdown_text_color');
	if ( !empty($zephyr_dropdown_text_color) && $zephyr_dropdown_text_color !== '#B0B0B0' ) {
		$zephyr_dropdown_text_color_style = 'nav#main-top ul li ul li a, nav#main-top ul li.active ul li a { color: '.$zephyr_dropdown_text_color.'; } ';
		wp_add_inline_style( 'zephyr_css', $zephyr_dropdown_text_color_style ); 
	}
	$zephyr_menu_hover_color = get_option('zephyr_menu_hover_color');
	if ( !empty($zephyr_menu_hover_color) && $zephyr_menu_hover_color !== '#B0B0B0' ) {
		$zephyr_menu_hover_color_style = 'nav#main-top ul li > a:hover { color: '.$zephyr_menu_hover_color.'; } ';
		wp_add_inline_style( 'zephyr_css', $zephyr_menu_hover_color_style ); 
	}
	$zephyr_menu_selected_color = get_option('zephyr_menu_selected_color');
	if ( !empty($zephyr_menu_selected_color) && $zephyr_menu_selected_color !== '#B0B0B0' ) {
		$zephyr_menu_selected_color_style = 'nav#main-top ul li.active a { color: '.$zephyr_menu_selected_color.'; } ';
		wp_add_inline_style( 'zephyr_css', $zephyr_menu_selected_color_style ); 
	}
	$zephyr_menu_border_color = get_option('zephyr_menu_border_color');
	if ( !empty($zephyr_menu_border_color) && $zephyr_menu_border_color !== '#B0B0B0' ) {
		$zephyr_menu_border_color_style = 'nav#main-top ul li ul:before { border-color: transparent transparent '.$zephyr_menu_border_color.'; } 
		nav#main-top ul li ul, nav#main-top ul li ul li { border-color: '.$zephyr_menu_border_color.'; }
		nav#main-top ul li ul li a:hover, nav#main-top ul li.active ul li a:hover { background-color: '.$zephyr_menu_border_color.'; }
		';
		wp_add_inline_style( 'zephyr_css', $zephyr_menu_border_color_style ); 
	}

	$zephyr_line_color = get_option('zephyr_line_color');
	if ( !empty($zephyr_line_color) && $zephyr_line_color !== '#efefef' ) {
		$zephyr_line_color_style = 'header, footer, .sidew, .sidew-r, .contw, .sidebar-list li, #category-top, #content.contw, #content.contl, .search-results #content > .col-md-12 > h1:after, .page #content > .col-md-12 > h1:after, .navbar-default .navbar-collapse, .container.boxed, #logo.col-md-12 { border-color: '.$zephyr_line_color.'; } .title-sep, #author-top .separator, .zephyr-chapter-top .separator { background-color: '.$zephyr_line_color.'; }';
		wp_add_inline_style( 'zephyr_css', $zephyr_line_color_style );
	}
	$zephyr_top_header_color = get_option('zephyr_top_header_color');
	if ( !empty($zephyr_top_header_color) && $zephyr_top_header_color !== '#ffffff' ) {
		$zephyr_top_header_color_style = '#logo.col-md-12 { background-color: '.$zephyr_top_header_color.' } ';
		wp_add_inline_style( 'zephyr_css', $zephyr_top_header_color_style );
	}
	$zephyr_search_line_color = get_option('zephyr_search_line_color');
	if ( !empty($zephyr_search_line_color) && $zephyr_search_line_color !== '#9a9a9a' ) {
		$zephyr_search_line_color_style = 'input.notv:focus { border-color: '.$zephyr_search_line_color.' } ';
		wp_add_inline_style( 'zephyr_css', $zephyr_search_line_color_style );
	}
	$zephyr_header_bg = get_theme_mod('zephyr_header_bg');
	if ( !empty($zephyr_header_bg) && $zephyr_header_bg !== '' ) {
		$zephyr_header_bg_style = '#logo.col-md-12 { background-image: url('.$zephyr_header_bg.'); border-bottom: none;} ';
		wp_add_inline_style( 'zephyr_css', $zephyr_header_bg_style );
	}
	$zephyr_bottom_header_color = get_option('zephyr_bottom_header_color');
	if ( !empty($zephyr_top_header_color) && $zephyr_bottom_header_color !== '#ffffff' ) {
		$zephyr_bottom_header_color_style = '#nav-search.col-md-12 { background-color: '.$zephyr_bottom_header_color.' } 
		@media all and (max-width: 767px) {
			#nav-search.col-md-12 { background-color: '.$zephyr_top_header_color.'; background-image: url('.$zephyr_header_bg.'); border-bottom: none; background-position: center center; }
		}
		@media all and (max-width: 991px) {
			.boxed #nav-search.col-md-12 { background-color: '.$zephyr_top_header_color.'; background-image: url('.$zephyr_header_bg.'); border-bottom: none; background-position: center center; }
		}
		';
		wp_add_inline_style( 'zephyr_css', $zephyr_bottom_header_color_style );
	}
	if ( !empty($zephyr_text_logo_font) ) {
		$zephyr_text_logo_font_family = str_replace('+', ' ', $zephyr_text_logo_font);
		$zephyr_textlogo_fontsize = get_theme_mod('zephyr_textlogo_fontsize');
		$zephyr_text_logo_font_style = '#zephyr-text-logo { font-family: '.$zephyr_text_logo_font_family.'; font-size: '.$zephyr_textlogo_fontsize.'px; }';
		wp_add_inline_style( 'zephyr_css', $zephyr_text_logo_font_style );
	}
	if ( is_singular() ) {
		global $post;
		$post_bg = get_post_meta( $post->ID, 'zephyr_post_bg', true );
		if ( $post_bg ) {
			$post_bg_img = wp_get_attachment_image_src($post_bg, 'original');
			$post_bg_style = ' body, body.custom-background{ background: url('.$post_bg_img[0].') fixed center center !important; }';
			wp_add_inline_style( 'zephyr_css', $post_bg_style );
		}
	}
	$bgvideo = get_theme_mod('zephyr_background_video');
	if ( $bgvideo == '' ) { $bgvideo = get_theme_mod('zephyr_background_youtube'); }
	if ( get_theme_mod('zephyr_back_over') && get_theme_mod('background_image') !== '' || $bgvideo !== '' ) {
		$back_over = get_theme_mod('zephyr_back_over');
		$back_over_op = $back_over / 100;
		$back_over_style = '#bgoverlay { -ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity='.$back_over.')"; filter: alpha(opacity='.$back_over.'); -moz-opacity: '.$back_over_op.'; -khtml-opacity: '.$back_over_op.';	opacity: '.$back_over_op.';}';
		wp_add_inline_style( 'zephyr_css', $back_over_style );
	}
// load all javascript plugins in one file
	wp_register_script( 'zephyr_js_plugins', get_template_directory_uri() . '/js/zephyr.plugins.js', array('jquery'), '1.0', true );
	wp_register_script( 'zephyr_fancybox', get_template_directory_uri() . '/js/fancybox.min.js', array(), '2.1.5', true );
	wp_register_script( 'zephyr_isotope', get_template_directory_uri() . '/js/isotope.min.js', array(), '1.5.25', true );
	wp_register_script( 'zephyr_sidr', get_template_directory_uri() . '/js/jquery.sidr.min.js', array('jquery'), '1.2.1', true );
	wp_register_script( 'zephyr_js', get_template_directory_uri() . '/js/zephyr.js', array('zephyr_js_plugins',  'zephyr_fancybox'), '1.0', true );
// 	add scripts only to ie8
	function zephyr_ie8() {
	   echo '<!--[if lt IE 9]><script type="text/javascript" src="'.get_template_directory_uri() . '/js/html5.shiv.js"></script><script type="text/javascript" src="' . get_template_directory_uri() . '/js/respond.js"></script><![endif]-->';
	}
	add_action( 'wp_head', 'zephyr_ie8' );
	$sidemenu = get_theme_mod('zephyr_sidemenu');
	$infinite = get_theme_mod('zephyr_infinite');
	$optin = get_option( 'zephyr_optin_options' );
	$sticky_sidebar = get_theme_mod('zephyr_sidebar_sticky');
	$sticky_sidepost = get_theme_mod('zephyr_sticky_postside');
	$showlines_top = get_theme_mod('zephyr_lines_top');
	$showlines_bottom = get_theme_mod('zephyr_lines_bottom');
	$vars = Array();
	if ( $infinite ) {
		if ( is_category() ) {
			$vars['cat'] = get_query_var('cat');
		}
		if ( is_tag() ) {
			$vars['tag'] = get_query_var('tag');
		}
		if ( is_author() ) {
			$vars['author'] = get_query_var('author');
		}
	}
	if ( is_search() || is_single() || is_archive() ) {
		$infinite = 0;
	}
	if ( is_singular() ) { 
		wp_enqueue_script( "comment-reply" );
	}
	if ( is_page() ) {
		$pid = get_the_ID();
		$zephyr_post_layout = get_post_meta($pid, 'zephyr_meta_box_post_info', true);
		$vars['columns'] = get_post_meta($pid,'zephyr_meta_box_columns', true);
		if ( $zephyr_post_layout == 'post-masonry' ) {
			wp_enqueue_script( 'zephyr_isotope' );
		}
		if ( get_post_meta($pid,'zephyr_display_posts', true) !== 'on' ) {
			$infinite = 0;
		} else {
			$vars['cat'] = get_post_meta($pid, 'zephyr_category', true);
		}
	}
	if ( $sidemenu == 'sidemenu' ) {
		wp_enqueue_style( 'zephyr_sidr' );
		wp_enqueue_script( 'zephyr_sidr' );
	}
	if ( $bgvideo ) {
		wp_enqueue_script( 'wp-mediaelement' );
	}
	wp_enqueue_script( 'zephyr_js' );
	wp_localize_script( 'zephyr_js', 'Zephyr', array( 'sidemenu' => $sidemenu, 'bgvideo' => $bgvideo, 'infinite' => $infinite, 'queryvars' => json_encode($vars) , 'ajaxurl' => admin_url( 'admin-ajax.php' ), 'optin' => $optin['optin_enable'], 'optinhide' => $optin['optinhide'], 'optindelay' => $optin['optindelay'], 'stickysidebar' => $sticky_sidebar, 'stickysidepost' => $sticky_sidepost, 'showlinestop' => $showlines_top , 'showlinesbottom' => $showlines_bottom ) );
}

add_action( 'wp_enqueue_scripts', 'zephyr_scripts' );

// Admin scripts
function zephyr_meta_box_scripts($hook) {
	wp_register_script( 'zephyr_page_slider', get_template_directory_uri() . '/js/zephyr-page-slider.js', array(), '1.0', true );
	wp_register_script( 'zephyr_post_bg', get_template_directory_uri() . '/js/zephyr-post-bg.js', array(), '1.0', true );
	wp_register_style( 'zephyr_meta_box', get_template_directory_uri() . '/css/meta-box.css', array(), '1.0' );
	wp_register_script( 'zephyr-ddslick', get_template_directory_uri() .'/js/jquery.ddslick.min.js', array('jquery') );  
	wp_register_script( 'zephyr-socials', get_template_directory_uri() .'/js/zephyr-socials.js', array('jquery', 'zephyr-ddslick') );
	wp_enqueue_style('zephyr_meta_box');
	if( $hook == 'post.php' || $hook == 'post-new.php' ) {
		global $post;
		if ( 'page' === $post->post_type ) {
			wp_enqueue_script('zephyr_page_slider');
		}
		if ( 'post' === $post->post_type ) {
			wp_enqueue_script('zephyr_post_bg');
		}
	} 
	if ( 'appearance_page_zephyr-social' == get_current_screen() -> id ) {  
		wp_enqueue_script('zephyr-socials');  
	}  
	if( $hook == 'profile.php' || 'advertising_page_zephyr-optin' == get_current_screen() -> id ) {
		wp_enqueue_media();
		wp_enqueue_script( 'zephyr-author-js', get_template_directory_uri() . '/js/zephyr-admin-author.js', array('jquery'), '1.0' );
 	}
}

add_action( 'admin_enqueue_scripts', 'zephyr_meta_box_scripts' );

function zephyr_post_clases($classes) {
	global $post;
	$zephyr_post_layout = '';
	if ( get_post_meta( $post->ID, 'zephyr_post_bg', true ) ) {
		$classes[] = 'post-bgimg';
	}
	$classes[] = $zephyr_post_layout;
	return $classes;
}
add_filter('post_class', 'zephyr_post_clases');

function zephyr_body_clases($classes) {
	global $post;
	$zephyr_page_layout = get_theme_mod('zephyr_sidebar_position');
	if ( is_page() ) {
		$pid = get_the_ID();
		if ( get_post_meta($pid, 'zephyr_meta_box_layout', true) ) {
			$zephyr_page_layout =  get_post_meta($pid, 'zephyr_meta_box_layout', true);
		}
		$zephyr_post_layout = get_post_meta($pid, 'zephyr_meta_box_post_info', true);
		$classes[] = $zephyr_post_layout;
	}
	$classes[] = $zephyr_page_layout;
	if ( get_theme_mod('zephyr_header_bg') !== '' || get_option('zephyr_top_header_color') !== '#ffffff' ) {
		$classes[] = 'bghead';
	}
	return $classes;
}
add_filter('body_class', 'zephyr_body_clases');
?>