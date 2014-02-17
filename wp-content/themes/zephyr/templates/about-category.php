<div class="post-category">
	<?php
	$cats = get_the_category();
	$zephyr_x = 0;
	 _e('Posted in', 'zephyr'); foreach ( $cats as $cat ) {
		$zephyr_x++;
		if ( $zephyr_x > 1 ) {
			$com = ', ';
		} else {
			$com = ' ';
		}
		echo $com.'<a href="'.get_category_link( $cat->term_id ).'" title="'.$cat->name.'">'.$cat->name.'</a>';
	 }
	 ?>
</div>