<?php get_header(); ?>
	<?php if ( have_posts() ) : while ( have_posts() ) : the_post();
	// get the layout variables
	global $zephyr_page_layout;
	global $zephyr_full_content;
	global $zephyr_post_columns;
	$display_posts = get_post_meta($post->ID,'zephyr_display_posts', true);
	$zephyr_full_content = get_post_meta($post->ID,'zephyr_full_content', true);
	$zephyr_post_columns = get_post_meta($post->ID,'zephyr_meta_box_columns', true);
	if ( $zephyr_post_columns == '' ) { $zephyr_post_columns = 'col-md-6'; }
	if ( $display_posts == 'on' ) {
		if ( $zephyr_page_layout == 'no-sidebar' ) {
			get_template_part('templates/content', 'nosidebar');
		} else {
			get_template_part('templates/content', '');
		}
	} else {
		if ( $zephyr_page_layout == 'no-sidebar' ) {
			get_template_part('templates/content', 'page-nosidebar');
		} else {
			get_template_part('templates/content', 'page');
		}
	} ?>
	<?php endwhile; else : ?>
		<div class="col-md-offset-2 col-xs-offset-2 col-sm-offset-2 col-md-10 col-xs-10 col-sm-10">
		<h1><?php _e('No matching posts were found', 'zephyr'); ?></h1>
		</div>
	<?php endif; ?>
	<?php if ( $zephyr_page_layout !== 'no-sidebar' ) { get_template_part('templates/sidelist', ''); } ?>
		
<?php get_footer(); ?>