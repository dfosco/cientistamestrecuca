<?php global $zephyr_cont; 
	global $zephyr_post_layout;
	global $zephyr_i;
	global $isms;
	global $zephyr_post_columns;
	$zephyr_i = 0;
	if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
		<?php 
		if ( $isms == 'true' ) {
			$zephyr_i++;
			get_template_part( 'templates/post', 'masonry'.get_post_format() );
		} else {
			get_template_part( 'templates/post', get_post_format() );
		}
	endwhile; else : ?>
		<h2><?php _e('No posts found, go ', 'zephyr'); ?> <a href="<?php echo home_url(); ?>" title="<?php bloginfo('name'); ?>"><?php _e('home', 'zephyr'); ?></a>?</h2>
	<?php endif; ?>
