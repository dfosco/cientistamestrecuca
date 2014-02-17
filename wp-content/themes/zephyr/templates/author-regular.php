<?php 
$author = get_query_var('author');
$bgimg = get_the_author_meta( 'zephyr-author-bg', $author );
$authorname = get_the_author_meta('display_name', $author);
if ( !empty($bgimg) ) { $class = 'nospace'; } else { $class = ''; }
 ?>
	<div id="author-top" class="col-md-12 <?php echo $class; ?>">
		<?php 
		if ( !empty($bgimg) ) {
			echo '<img class="author-bg" src="'.$bgimg.'" alt="'.$authorname.'">';
		}
		echo '<div class="avatar-holder">'.zephyr_get_avatar($author, 126).'</div>';
		?>
		<h1><?php echo $authorname; ?></h1>
		<?php $nickname = get_the_author_meta('nickname', $author);
		if ( $nickname !== '' ) {
			echo '<h2>'.$nickname.'</h2>';
		} ?>
		<span class="separator"></span>
		<p class="author-bio"><?php the_author_meta('description', $author); ?></p>
	</div>