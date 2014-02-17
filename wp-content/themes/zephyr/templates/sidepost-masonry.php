<div class="masonry-sidebar">
	<?php if( function_exists('zilla_likes') ) : ?> 
	<div class="like postprop black">
		<?php zilla_likes(); ?>
	</div>
	<?php endif; ?> 
	<div class="comments postprop black">
		<?php 
		if ( is_single() ) {
			$comments_link = '#comments';
		} else {
			$comments_link = get_permalink().'/#comments';
		}
		?>
		<a href="<?php echo $comments_link; ?>" class="posticon"></a>
		<a href="<?php echo $comments_link; ?>" class="postpropinfo"><?php comments_number( '0', '1', '%' ); ?></a>
	</div>
	<div class="share postprop black">
		<div class="drop-sharebox">
			<a href="#" class="posticon" id="shareMenu<?php echo $post->ID; ?>" data-toggle="dropdown"></a>
			<div class="sharebox" aria-labelledby="shareMenu<?php echo $post->ID; ?>">
				<div class="shareboxin">
					<a target="_blank" href="http://twitter.com/home?status=<?php echo urlencode(get_permalink()); ?>" class="zephyr-sharer twitter left"></a>
					<a target="_blank" href="<?php echo 'http://www.facebook.com/sharer/sharer.php?s=100&amp;'.rawurlencode('p[url]').'='.get_permalink().'&amp;'.rawurlencode('p[title]').'='.rawurlencode(get_the_title()); ?>" class="zephyr-sharer facebook left"></a>
					<a target="_blank" href="https://plus.google.com/share?url=<?php echo urlencode(get_permalink()); ?>" class="zephyr-sharer gplus left"></a>
					<a target="_blank" href="http://www.linkedin.com/shareArticle?mini=true&amp;url=<?php echo urlencode(get_permalink()); ?>&amp;title=<?php echo urlencode(get_the_title()); ?>&amp;summary=<?php echo urlencode(strip_tags(get_the_excerpt())); ?>&amp;source=" class="zephyr-sharer linkedin left"></a>
					<div class="socline"></div>
					<a href="javascript:void((function()%7Bvar%20e=document.createElement('script');e.setAttribute('type','text/javascript');e.setAttribute('charset','UTF-8');e.setAttribute('src','http://assets.pinterest.com/js/pinmarklet.js?r='+Math.random()*99999999);document.body.appendChild(e)%7D)());" class="zephyr-sharer pinterest left"></a>
					<a target="_blank" href="http://digg.com/submit?url=<?php echo urlencode(get_permalink()); ?>" class="zephyr-sharer digg left"></a>
					<a target="_blank" href="http://reddit.com/submit?url=<?php echo urlencode(get_permalink()); ?>&amp;title=<?php echo urlencode(get_the_title()); ?>" class="zephyr-sharer reddit left"></a>
					<a target="_blank" href="http://www.stumbleupon.com/submit?url=<?php echo urlencode(get_permalink()); ?>&amp;title=<?php echo urlencode(get_the_title()); ?>" class="zephyr-sharer stumbleupon left"></a>
				</div>
			</div>
		</div>
	</div>
</div>