	<form action="<?php echo home_url( '/' ); ?>" method="get">
		<fieldset>
			<input type="text" class="notv" id="search" name="s" value="<?php the_search_query(); ?>" />
			<label for="search" id="search-label"></label>
		</fieldset>
	</form>