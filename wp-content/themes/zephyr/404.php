<?php get_header();
	global $zephyr_cont;
	global $zephyr_page_layout;
	if ( $zephyr_page_layout == 'no-sidebar' ) { $class = "container"; } else { $class = "left ".$zephyr_cont." col-md-9 col-sm-9 col-xs-12"; }
 ?>
<div id="content" class="<?php echo $class; ?>">
	<div class="post-content col-md-10 col-sm-10 col-xs-12 col-md-offset-2">
		<h1><?php _e('404 Error', 'zephyr'); ?></h1>
		<div class="post-text">
			<p><?php _e( 'It looks like nothing was found at this location.', 'zephyr' ); ?>
		</div>
	</div>
</div>
<?php if ( $zephyr_page_layout !== 'no-sidebar' ) {
		get_template_part('templates/sidelist', '');
	}
get_footer(); ?>