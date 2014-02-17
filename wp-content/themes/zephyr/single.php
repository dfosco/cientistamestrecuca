<?php get_header(); 
	global $zephyr_page_layout;
	if ( $zephyr_page_layout == 'no-sidebar' ) {
		get_template_part('templates/single', 'nosidebar');
	} else {
		get_template_part('templates/single', 'sidebar');
	}
	if ( $zephyr_page_layout !== 'no-sidebar' ) {
		get_template_part('templates/sidelist', '');
	}
get_footer(); ?>