<?php global $zephyr_page_layout;
	if ( $zephyr_page_layout == 'sidebar-left' || $zephyr_page_layout == '' ) {
		$class = 'sidew';
	} elseif($zephyr_page_layout == 'sidebar-right') {
		$class = 'sidew-r';
	}

?>
<aside id="sidebar" class="<?php echo $class; ?> col-md-3 col-sm-3 col-xs-12">
	<?php if ( get_theme_mod('zephyr_sidebar_content') == 'sidebar-widgets' ) {
		get_sidebar();
	} else { ?>
		<ul class="sidebar-list">
		<?php
		$zephyr_side_a = Array(
			'posts_per_page' => 30,
			'ignore_sticky_posts' => 1
		);
		$zephyr_side_q = new WP_Query($zephyr_side_a);
		if ( $zephyr_side_q->have_posts() ) : while ( $zephyr_side_q->have_posts() ) : $zephyr_side_q->the_post();
		?>
			<li>
				<?php if ( get_post_format() == 'quote' ) {
					$title = substr(strip_tags(get_the_content()), 0, 50) . '...';
				} else {
					$title = get_the_title();
				} ?>
				<h3><a href="<?php the_permalink(); ?>"><?php echo $title; ?></a></h3>
				<div class="details">
					<em><?php _e('by', 'zephyr'); ?> <a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>" class="author"><?php the_author_meta( 'display_name' ); ?></a>  -  <?php echo get_the_time('h:i A - d.m.o'); ?></em>
				</div>
			</li>
			<?php zephyr_get_ads_sidebar($zephyr_side_q); ?>
		<?php endwhile; else: ?>
			<?php _e('No posts were found', 'zephyr'); ?>
		<?php endif; ?>
		<?php wp_reset_query(); ?>
		</ul>
	<?php } ?>
</aside>