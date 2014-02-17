<?php global $zephyr_post_layout; ?>
<?php if ( is_sticky() ) { $sticky = 'sticky'; } else { $sticky = ''; } ?>
<article <?php post_class('row ' . $sticky .' '. $zephyr_post_layout); ?>>
	<?php 
	if ( $zephyr_post_layout !== 'post-info-right' ) {
		get_template_part( 'templates/sidepost' );
	} ?>
	<div class="post-content col-md-10 col-sm-10 col-xs-12">
		<?php if ( has_post_thumbnail() ) {
			$zephyr_thumb_id = get_post_thumbnail_id();
			$zephyr_thumb_url = wp_get_attachment_image_src( $zephyr_thumb_id , 'zephyr-postlist');
			echo '<div class="zephyr-bigimg">';
			echo '<a href="'.get_permalink().'"><img class="bigimg" src="'.$zephyr_thumb_url[0].'" alt="'.get_the_title().'" /></a>';
			echo '</div>';
		}
		?>
		<h1 class="zephyr-post-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?><span class="featured accentbg"><?php _e('featured', 'zephyr'); ?></span></a></h1>
		<div class="post-author">
			<a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>" class="author-img"><?php echo zephyr_get_avatar( get_the_author_meta( 'ID' ), 32 ); ?></a>
			<em><span><?php _e('by','zephyr'); ?> </span> <a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>" class="author"><?php the_author_meta( 'display_name' ); ?></a> <span><?php _e('on','zephyr'); ?> </span> <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php echo get_the_time('d.m.o - h:i A'); ?></a></em>
		</div>
		<div class="title-sep"></div>
		<?php get_template_part( 'templates/about', 'category'); ?>
		<div class="post-text">
		<?php if ( !is_single() ) {
			zephyr_excerpt();
			echo '</div>';
		} else {
			the_content();
			echo '</div>';
			$link_pages_args = array(
				'before'           => '<div class="zephyr-pagination post-pagination">',
				'after'            => '</div>',
				'separator'        => '<span class="space"></span>',
				'nextpagelink'     => __( 'Next page', 'zephyr' ),
				'previouspagelink' => __( 'Previous page', 'zephyr' ),
				'pagelink'         => __('Page', 'zehpyr').' %'
			);
			wp_link_pages($link_pages_args);
			get_template_part( 'templates/about', 'tags');
			get_template_part( 'templates/about', 'nextprev');
			get_template_part( 'templates/about', 'author');
			get_template_part( 'templates/about', 'related');
			comments_template();
		} ?>
	</div>
	<?php 
	if ( $zephyr_post_layout == 'post-info-right' ) {
		get_template_part( 'templates/sidepost' );
	} ?>
	<div class="clearfix"></div>
</article>