<?php global $zephyr_cont; ?>
<div id="content" class="<?php echo $zephyr_cont; ?> col-md-9 col-sm-9 col-xs-12">
<?php 
	global $zephyr_post_layout;
	?>

	<?php // building query
	$zephyr_cat = get_post_meta($post->ID, 'zephyr_category', true);
	if ( $zephyr_cat == 0 ) { 
		$zephyr_q = new WP_query('posts_per_page='.get_option('posts_per_page'));
	} else {
		$zephyr_q = new WP_query('cat='.$zephyr_cat);
	}
	global $zephyr_i;
	$pages = $zephyr_q->max_num_pages;
	$zephyr_i = 0;
	if ( $zephyr_q->have_posts() ) : while ( $zephyr_q->have_posts() ) : $zephyr_q->the_post(); ?>
		<?php 
		if ( $zephyr_post_layout == 'post-masonry' ) {
			$zephyr_i++;
			get_template_part( 'templates/post', 'masonry'.get_post_format() );
		} else {
			get_template_part( 'templates/post', get_post_format() );
		}
		zephyr_get_ads_post($zephyr_q);
	endwhile; else : ?>
		<h2><?php _e('No posts found, go ', 'zephyr'); ?> <a href="<?php echo home_url(); ?>" title="<?php bloginfo('name'); ?>"><?php _e('home', 'zephyr'); ?></a>?</h2>
	<?php endif; ?>
	<div class="clearfix"></div>
</div>
<?php zephyr_pagination($pages) ?>