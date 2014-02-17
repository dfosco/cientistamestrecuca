<div class="related-entries">
	<h4 class="border"><?php _e('Related entries', 'zephyr'); ?></h4>
	<div class="row">
		<?php  
		$max_articles = 3; 
		$cnt = 0;
		$article_tags = get_the_tags();
		$tags_string = '';
		if ($article_tags) {
			foreach ($article_tags as $article_tag) {
				$tags_string .= $article_tag->slug . ',';
			}
		}
		$tag_related_posts = get_posts('exclude=' . $post->ID . '&numberposts=' . $max_articles . '&tag=' . $tags_string);
		if ($tag_related_posts) {
			foreach ($tag_related_posts as $related_post) {
				if ( has_post_thumbnail($related_post->ID) ) {				
					$zephyr_thumb_id = get_post_thumbnail_id($related_post->ID);
					$zephyr_thumb_url = wp_get_attachment_image_src( $zephyr_thumb_id , 'zephyr-related');
				} else {
					$zephyr_thumb_url = array('0' => get_template_directory_uri().'/img/default-related.png');
				}
				$cnt++; 
				if ($cnt > $max_articles) { break; }
					echo '<div class="col-md-4">';
					echo '<a href="'.get_permalink($related_post->ID).'"><img src="'.$zephyr_thumb_url[0].'" alt="'.$related_post->post_title.'" /></a>';
					echo '<a href="'.get_permalink($related_post->ID).'" class="related-title">'.$related_post->post_title.'</a>';
					echo '</div>';
			}
		}
		if ($cnt < $max_articles) {
		
			$article_categories = get_the_category($post->ID);
			$category_string = '';
			foreach($article_categories as $category) { 
				$category_string .= $category->cat_ID . ',';
			}
			$cat_related_posts = get_posts('exclude=' . $post->ID . '&numberposts=' . $max_articles . '&category=' . $category_string);
			if ($cat_related_posts) {
				foreach ($cat_related_posts as $related_post) {
					if ( has_post_thumbnail($related_post->ID) ) {				
						$zephyr_thumb_id = get_post_thumbnail_id($related_post->ID);
						$zephyr_thumb_url = wp_get_attachment_image_src( $zephyr_thumb_id , 'zephyr-related');
					} else {
						$zephyr_thumb_url = array('0' => get_template_directory_uri().'/img/default-related.png');
					}
					$cnt++; 
					if ($cnt > $max_articles) { break; }
						echo '<div class="col-md-4">';
						echo '<a href="'.get_permalink($related_post->ID).'"><img src="'.$zephyr_thumb_url[0].'" alt="'.$related_post->post_title.'" /></a>';
						echo '<a href="'.get_permalink($related_post->ID).'" class="related-title">'.$related_post->post_title.'</a>';
						echo '</div>';
				}
			}
		}
		?>
	</div>
</div>

