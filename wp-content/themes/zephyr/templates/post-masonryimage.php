<?php global $zephyr_i;
global $zephyr_post_columns;
if ( $zephyr_i%2 == 0 ) {
	$class = 'masonry-post '.$zephyr_post_columns.' col-xs-12 second';
} else {
	$class = 'masonry-post '.$zephyr_post_columns.' col-xs-12';
}
?>
<article <?php post_class($class); ?> data-order="<?php echo $zephyr_i; ?>">
	<div class="masonry-post-img accentbg">
		<div class="overflow">
			<div class="masonry-slide">
				<?php if ( has_post_thumbnail() ) {
				$zephyr_thumb_id = get_post_thumbnail_id();
				$zephyr_thumb_url = wp_get_attachment_image_src( $zephyr_thumb_id , 'zephyr-galllery-3col');
					echo '<img src="'.$zephyr_thumb_url[0].'" alt="'.get_the_title().'" />';
				} ?>
			</div>
		</div>
		<?php get_template_part( 'templates/sidepost', 'masonry' ); ?>
	</div>
	<div class="post-content col-md-12">
		<h1><a href="<?php the_permalink(); ?>"><?php the_title(); ?><span class="featured accentbg"><?php _e('featured', 'zephyr'); ?></span></a></h1>
		<div class="post-author">
			<a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>" class="author-img"><?php echo zephyr_get_avatar( get_the_author_meta( 'ID' ), 32 ); ?></a>
			<em><span><?php _e('by','zephyr'); ?> </span> <a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>" class="author"><?php the_author_meta( 'display_name' ); ?></a> <span><?php _e('on','zephyr'); ?> </span> <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php echo get_the_time('d.m.o - h:i A'); ?></a></em>
		</div>
		<div class="title-sep"></div>
		<?php get_template_part( 'templates/about', 'category'); ?>
		<div class="post-text">
			<?php zephyr_excerpt(); ?>
		</div>
	</div>
</article>