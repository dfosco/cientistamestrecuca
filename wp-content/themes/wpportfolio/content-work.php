<div class="spotlight project" style="background-color: <?php the_field( 'background_color' ) ?>">
		
		<a href="<?php the_permalink();?>">
			<img src="<?php the_field( 'homepage_slider_image' )?>" alt="">
		</a>
		
		<h4>
			<a href="<?php the_permalink();?>"><?php the_title(); ?></a>
		</h4>

		<?php the_field( 'description' ) ?>

		<p>
			<a class="btn blue" style="background-color: <?php the_field( 'button_color' ) ?>" href="<?php the_permalink();?>">
				View Project &rarr;
			</a>
		</p>
</div>