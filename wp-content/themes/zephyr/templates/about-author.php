<div class="about-author">
<?php if ( get_the_author_meta( 'description' ) !== '' ) { ?>
	<h4 class="border"><?php _e('About the author', 'zephyr'); ?></h4>
	<div class="row">
		<div class="col-md-3">
			<a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>" class="author-img">
			<img src="<?php echo get_avatar_url(get_avatar( get_the_author_meta( 'ID' ), 102 )); ?>" alt="<?php echo the_author_meta( 'display_name' ); ?>" class="author-big" />
			</a>
		</div>
		<div class="col-md-9">
			<h4><a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>"><?php echo the_author_meta( 'display_name' ); ?></a></h4>
			<p><?php echo the_author_meta( 'description' ); ?></p>
		</div>
	</div>
<?php } ?>
</div>