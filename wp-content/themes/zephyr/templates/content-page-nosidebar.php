<?php global $zephyr_default_title; ?>
<div id="content" class="container">
	<div class="col-md-12 col-sm-12 col-xs-12">
		<?php if ( $zephyr_default_title !== 'on' ) { ?>
		<h1><?php the_title(); ?></h1>
		<?php } ?>
		<div class="post-text">
		<?php the_content(); ?>
		</div>
	</div>
</div>