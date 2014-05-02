<?php get_header(); ?>

	<div class="grid_8 push_2 omega clearfix">

		<?php if ( have_posts() ) : while ( have_posts() ) : the_post();  ?>

			<?php get_template_part( 'content', 'post' ); ?>
		
		<?php endwhile; else: ?>

		<p>There are no posts or pages here.</p>

		<?php endif; ?>

	</div>

	<?php get_template_part( 'content', 'testimonials' ); ?>

<?php get_footer(); ?>