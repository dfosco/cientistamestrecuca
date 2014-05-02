<?php get_header(); ?>

<!-- ---**---**---**---**---**---**---**---**---**---** -->
<!-- Code for Featured Project -->
<!-- ---**---**---**---**---**---**---**---**---**---** -->


			<div id="featured" class="clearfix flexslider">
				
				<ul class="slides">

					<?php 

					$args = array(
						'post_type' => 'work',
						
					);

					$the_query = new WP_Query( $args ); 

					?>

					<?php if ( have_posts() ) : while ( $the_query->have_posts() ) : $the_query->the_post();  ?>

					<li style="background-color: <?php the_field( 'background_color' ) ?>">
						
					<div class="container">
					<div class="grid_8"><img src="<?php the_field( 'homepage_slider_image' )?>" alt="<?php the_title(); ?> Project Screenshot"></div>
						<div id="featured-info" class="grid_4 omega">
							<h5>Featured Project</h5>
							<h3 style="color: <?php the_field( 'button_color' ) ?>"><?php the_title(); ?></h3>
							<p><?php the_field('description') ?></p>
							<a class="btn" style="background-color: <?php the_field( 'button_color' ) ?>" href="<?php the_permalink(); ?>">View Project &rarr;</a>
						</div>
					</div>

					</li>

					<?php endwhile; endif; ?>

					 
					
				</ul>
			</div>




<div class="container clearfix">

<!-- ---**---**---**---**---**---**---**---**---**---** -->
<!-- Code for Featured Posts -->
<!-- ---**---**---**---**---**---**---**---**---**---** -->
	<div class="grid_12 omega">
		<h5>Featured Post</h5>
	</div>
	<?php 

	$args = array(
	
		'post_type' => 'post',
		'category_name' => 'featured',
		'posts_per_page' => 1,	
	);

	$the_query = new WP_Query ( $args );
 	?>

	<?php if ( have_posts() ) : while ( $the_query->have_posts() ) : $the_query->the_post();  ?>

		<div class="grid_12 omega clearfix">
			<article>
				<?php get_template_part( 'content', 'post' ); ?>
			</article>
		</div>

	<?php endwhile; endif; ?>

	<!-- ---**---**---**---**---**---**---**---**---**---** -->
	<!-- Code for Recent Posts -->
	<!-- ---**---**---**---**---**---**---**---**---**---** -->
	
	<div class="grid_12 omega clearfix">
		<div class="grid_6 recent-post">
			<article>
				<h5>Recent Post</h5>

				<?php 

				$args = array(
				
					'post_type' => 'post',
					'cat' => -5,
					'posts_per_page' => 1,	
				);

				$the_query = new WP_Query ( $args );
			 	?>

				<?php if ( have_posts() ) : while ( $the_query->have_posts() ) : $the_query->the_post();  ?>

					<?php get_template_part( 'content', 'post' ); ?>
				
				<?php endwhile; endif; ?>

			</article>
		</div>	
		
		<!-- ---**---**---**---**---**---**---**---**---**---** -->
		<!-- Code for Recent Work -->
		<!-- ---**---**---**---**---**---**---**---**---**---** -->
		
		<div class="grid_6 omega">
			<article>
			

			<?php 

			$args = array(
				'post_type' => 'work',
				'posts_per_page' => 1
			);

			$the_query = new WP_Query( $args );

			 ?>

			<?php if ( have_posts() ) : while ( $the_query->have_posts() ) : $the_query->the_post();  ?>

				
					<?php get_template_part( 'content', 'work' ); ?>
				

			<?php endwhile; endif; ?>
			</article>
		</div>
	</div>

		
	<!-- ---**---**---**---**---**---**---**---**---**---** -->
	<!-- Code for Random Testimonial -->
	<!-- ---**---**---**---**---**---**---**---**---**---** -->

<div class="testimonial grid_12 clearfix">

	<?php get_template_part( 'content', 'testimonials' ); ?>

</div>

<?php get_footer(); ?>