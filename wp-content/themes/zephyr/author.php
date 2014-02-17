<?php get_header(); 
	global $zephyr_cont;
	if ( $zephyr_page_layout == 'no-sidebar' ) { $class = "container"; } else { $class = "left ".$zephyr_cont." col-md-9 col-sm-9 col-xs-12"; }
 ?>
<div id="content" class="<?php echo $class; ?>">
	<?php 
		get_template_part('templates/author', 'regular');
	if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
		<?php get_template_part( 'templates/post', get_post_format() ); ?>
	<?php endwhile; else : ?>
	<h1><?php _e('No matching posts were found', 'zephyr'); ?></h1>
	<?php endif; ?>
</div>
<?php if ( $zephyr_page_layout !== 'no-sidebar' ) {
		get_template_part('templates/sidelist', '');
	}
get_footer(); ?>