<?php get_header();
	global $zephyr_page_layout;
	if ( $zephyr_page_layout == 'no-sidebar' ) { $class = "container"; } else { $class = "left contw col-md-9 col-sm-9 col-xs-12"; }
 ?>
<div id="content" class="<?php echo $class; ?>">
	<?php
	if ( have_posts() ) : 
	echo '<h1>'.__('Search Results for ', 'zephyr').'<em>"'.get_search_query().'"</em></h1>';
	while ( have_posts() ) : the_post(); ?>
		<?php get_template_part( 'templates/post', get_post_format() ); ?>
	<?php endwhile; else : ?>
	<h1><?php _e('No matching posts were found', 'zephyr'); ?></h1>
	<?php endif; ?>
	<?php zephyr_pagination() ?>
</div>
<?php if ( $zephyr_page_layout !== 'no-sidebar' ) {
		get_template_part('templates/sidelist', '');
	}
get_footer(); ?>