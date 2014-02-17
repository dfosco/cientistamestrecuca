	<form action="<?php echo home_url( '/' ); ?>" method="get">
		<fieldset>
			<input type="text" class="notv" id="searchmobile" name="s" value="<?php the_search_query(); ?>" placeholder="<?php _e('Search...', 'zephyr'); ?>" />
		</fieldset>
	</form>