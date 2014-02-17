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
			<?php 
			$gallery_slider = get_post_meta($post->ID, 'zephyr_meta_box_post_slider', true);
			if ( get_post_gallery() ) {
				if ( $gallery_slider == 'post-slider' ) {
					$slider_images = get_post_gallery($post->ID, false); 
					$slider_images = explode(',', $slider_images['ids']);
				?>
					<div id="carousel-<?php echo $post->ID; ?>" class="carousel slide" data-ride="carousel">
							<ol class="carousel-indicators">
								<?php
								$i = 0;
								foreach ( $slider_images as $slider_img ) { ?> 
								<li data-target="#carousel-<?php echo $post->ID; ?>" data-slide-to="<?php echo $i; ?>" class="<?php if ($i == 0 ) { echo 'active'; } ?>"></li>
								<?php 
								$i++; } ?>
							</ol>
							<div class="carousel-inner">
							<?php 
							$i = 0;
							foreach ( $slider_images as $slider_img ) { 
							$image = wp_get_attachment_image_src($slider_img, 'zephyr-galllery-3col');
							$alt = get_post_meta( $slider_img, '_wp_attachment_image_alt', true );
							if ( $alt == '' ) { $alt = get_the_title(); }
							?>
							<div class="item <?php if ( $i == 0 ) { echo 'active'; } ?>">
								<img src="<?php echo $image[0]; ?>" alt="<?php echo $alt; ?>">
							</div>
							<?php $i++; } ?>
						</div>
					</div>
				<?php
				} else {
					$gallery = get_post_gallery($post->ID, false);
					$gallery_ids = explode(',', $gallery['ids']);
					if ( isset($gallery['columns']) ) { 
						$columns = $gallery['columns'];
					} else {
						$columns = 3;
					}
					if ( $columns == 1 ) {
						$isize = 'zephyr-postlist';
						$class = 'col-md-12';
					}
					if ( $columns == 2 ) {
						$isize = 'zephyr-galllery-2col';
						$class = 'col-md-6';
					}
					if ( $columns == 3 ) {
						$isize = 'zephyr-galllery-3col';
						$class = 'col-md-4';
					}
					if ( $columns == 4 ) {
						$isize = 'zephyr-galllery-4col';
						$class = 'col-md-3';
					}
					echo '<div class="zephyr-gallery">';
						foreach ( $gallery_ids as $id ) {
							$image = wp_get_attachment_image_src($id, $isize);
							$large = wp_get_attachment_image_src($id, 'large');
							$alt = get_post_meta( $id, '_wp_attachment_image_alt', true );
							if ( $alt == '' ) { $alt = get_the_title(); }
							?>
							<div class="centered <?php echo $class; ?>">
								<a class="fancybox" rel="gallery-<?php echo $post->ID; ?>" href="<?php echo $large[0]; ?>"><img src="<?php echo $image[0]; ?>" alt="<?php echo $alt; ?>"></a>
							</div>
							<?php
						}
					echo '</div>';
				}
			}
			?>
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
			<?php zephyr_excerpt();  ?>
		</div>
	</div>
</article>