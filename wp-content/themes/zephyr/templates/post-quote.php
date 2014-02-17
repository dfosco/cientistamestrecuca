<?php global $zephyr_post_layout; ?>
<?php if ( is_sticky() ) { $sticky = 'sticky'; } else { $sticky = ''; } ?>
<article <?php post_class('row ' . $sticky .' '. $zephyr_post_layout); ?>>
	<?php 
	if ( $zephyr_post_layout !== 'post-info-right' ) {
		get_template_part( 'templates/sidepost' );
	} ?>
	<div class="post-content col-md-10 col-sm-10 col-xs-12">
	<?php 
	preg_match('@<blockquote>(.*?)</blockquote>@si', apply_filters('the_content', get_the_content()), $out );
	$quote_text = $out[1];
	?>
		<div class="post-quote">
			<div class="quote">
				<?php echo $quote_text; ?>
			</div>
			<div class="quote-author">
				<span class="quote-icon"></span> <?php _e('quote by','zephyr'); ?> <?php the_title(); ?>
			</div>
		</div>
		<span class="featured accentbg"><?php _e('featured', 'zephyr'); ?></span>
		<div class="post-author">
			<a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>" class="author-img"><?php echo zephyr_get_avatar( get_the_author_meta( 'ID' ), 32 ); ?></a>
			<em><span><?php _e('by','zephyr'); ?> </span> <a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>" class="author"><?php the_author_meta( 'display_name' ); ?></a> <span><?php _e('on','zephyr'); ?> </span> <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php echo get_the_time('d.m.o - h:i A'); ?></a></em>
		</div>
		<div class="title-sep"></div>
		<?php get_template_part( 'templates/about', 'category'); ?>
		<div class="post-text">
		<?php if ( !is_single() ) { 
			$gog = str_replace($out[0], '', apply_filters('the_content', get_the_content()));
			echo apply_filters('the_excerpt', wp_trim_words(strip_tags($gog), '55', ' <a class="read-more" href="'. get_permalink() .'">Read More</a>') );
			echo '</div>';
		} else {
			echo str_replace($out[0], '', apply_filters('the_content', get_the_content()));
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