<?php
global $zephyr_page_layout;
global $zephyr_default_title;
?>
<div id="content" class="left col-md-9 col-sm-9 col-xs-12">
	<div class="post-content col-md-12 col-xs-12">
		<?php if ( $zephyr_default_title !== 'on' ) { ?>
		<h1><?php the_title(); ?></h1>
		<?php } ?>
		<div class="post-text">
		<?php the_content(); ?>
		</div>
	</div>
</div>