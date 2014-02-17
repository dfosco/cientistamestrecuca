<?php
function fetch_fb_url($url){


}

function zephyr_getfb_feed($page_id, $graph_query, $access_token, $limit) {
	$fburl = 'https://graph.facebook.com/' . $page_id . '/' . $graph_query . '?access_token=' . $access_token . '&limit=' . $limit;
	$getfeed = wp_remote_get($fburl);
	return json_decode($getfeed['body']);
}

function zephyr_getfb_avatar($page_id) {
	return 'http://graph.facebook.com/'.$page_id.'/picture?height=75&amp;width=75';
}
function zephyr_linkify($text) {
return preg_replace('@(https?://([-\w\.]+)+(:\d+)?(/([-\w/_\.]*(\?\S+)?)?)?)@', '<a rel="nofollow" target="_blank" href="$1">$1</a>', $text);
}

?>