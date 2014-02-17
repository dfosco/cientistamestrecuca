<div id="content" class="container">
	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
		<?php get_template_part( 'templates/post', get_post_format() ); ?>
	<?php endwhile; else : ?>
		<div class="col-md-offset-2 col-xs-offset-2 col-sm-offset-2 col-md-10 col-xs-10 col-sm-10">
		<h1><?php _e('No matching posts were found', 'zephyr'); ?></h1>
		</div>
	<?php endif; ?>
</div>