<?php get_header();
	global $zephyr_cont;
	global $zephyr_page_layout;
	if ( $zephyr_page_layout == 'no-sidebar' ) { $class = "container"; } else { $class = "left ".$zephyr_cont." col-md-9 col-sm-9 col-xs-12"; }
 ?>
<div id="content" class="<?php echo $class; ?>">
	<div id="category-top" class="col-md-12 col-sm-12 col-xs-12">
		<?php $cat = get_category(get_query_var('cat'),false); ?>
		<span class="circle accentbg"></span><span><?php _e('Categories', 'zephyr'); ?> - <span class="cat-name"><?php echo $cat->name; ?></span></span><br />
		<span class="postcount"><?php if ( $cat->count == 1 ) { echo $cat->count.' '.__('post', 'zephyr'); } elseif ( $cat->count == 0 ) { _e('No posts', 'zephyr'); } else { echo $cat->count.' '.__('posts', 'zephyr'); } ?></span>
		<div class="clearfix"></div>
	</div>
	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
		<?php get_template_part( 'templates/post', get_post_format() ); ?>
	<?php endwhile; else : ?>
	<h1><?php _e('No matching posts were found', 'zephyr'); ?></h1>
	<?php endif; ?>
</div>
<?php if ( $zephyr_page_layout !== 'no-sidebar' ) {
		get_template_part('templates/sidelist', '');
	}
get_footer(); ?>