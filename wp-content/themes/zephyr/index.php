<?php get_header();
	global $zephyr_cont;
	if ( $zephyr_page_layout == 'no-sidebar' ) { $class = "container"; } else { $class = $zephyr_cont." col-md-9 col-sm-9 col-xs-12"; }
 ?>
<div id="content" class="<?php echo $class; ?>">
	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
		<?php get_template_part( 'templates/post', get_post_format() ); ?>
		<?php zephyr_get_ads_post();  ?>
	<?php endwhile; else : ?>
	<div class="col-md-offset-2 col-xs-offset-2 col-sm-offset-2 col-md-10 col-xs-10 col-sm-10">
	<h1><?php _e('No matching posts were found', 'zephyr'); ?></h1>
	</div>
	<?php endif; ?>
	<?php zephyr_pagination() ?>
</div>
<?php if ( $zephyr_page_layout !== 'no-sidebar' ) {
		get_template_part('templates/sidelist', '');
	}
get_footer(); ?>