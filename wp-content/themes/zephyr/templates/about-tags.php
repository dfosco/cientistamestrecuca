<?php $tags = get_the_tags();
if ( !empty($tags) ) {
	$html = '<div class="zephyr-tags">';
	$html .= '<span class="zephyr-tag tags-title">'.__('Tags', 'zephyr').'</span>';
	foreach ( $tags as $tag ) {
		$tag_link = get_tag_link( $tag->term_id );
		$html .= "<a href='{$tag_link}' title='{$tag->name} Tag' class='zephyr-tag'>";
		$html .= "{$tag->name}</a>";
	}
	$html .= '</div>';
	echo $html;
}
?>