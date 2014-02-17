<?php
function zephyr_excerpt_more( $more ) {
	return ' <a class="read-more" href="'. get_permalink( get_the_ID() ) . '">'.__('Read more', 'zephyr').'</a>';
}
add_filter( 'excerpt_more', 'zephyr_excerpt_more' );

function get_first_oembed($id) {
    $meta = get_post_custom($id);
    $novid = true;
    foreach ($meta as $key => $value) {
        if (false !== strpos($key, 'oembed')) {
        	$novid = false;
            return $value[0];
        }
    }
}

function change_embed_size($html) {
    $height_pattern = "/height=\"[0-9]*\"/";
    $html = preg_replace($height_pattern, "height='462'", $html);
    $width_pattern = "/width=\"[0-9]*\"/";
    $html = preg_replace($width_pattern, "width='1147'", $html);
    return $html;
}

function zephyr_remove_first_iframe($zephyr_content) {
	$pattern = "#<iframe[^>]+>.*?</iframe>#is";
	return preg_replace($pattern, "", $zephyr_content);
}

function get_avatar_url($get_avatar){
    preg_match("/src='(.*?)'/i", $get_avatar, $matches);
    return $matches[1];
}

// prepare quote content for output
function zephyr_quote_content($zephyr_content) {
	if ( has_post_format( 'quote' ) ) {
		preg_match( '/<blockquote.*?>/', $zephyr_content, $matches );
		if ( empty( $matches ) ) {
			$zephyr_content = "<blockquote>{$zephyr_content}</blockquote>";
		}
	}
	return $zephyr_content;
}
add_filter( 'the_content', 'zephyr_quote_content' );

// pagination

function zephyr_pagination($pages = '', $range = 2) {
	if ( !get_theme_mod('zephyr_infinite') ) {
		$showitems = ($range * 2)+1;
		global $paged;
		if(empty($paged)) $paged = 1;
		if($pages == '') {
			global $wp_query;
			$pages = $wp_query->max_num_pages;
			if(!$pages)	{
				$pages = 1;
			}
		}
		if(1 != $pages) {
			echo "<div class='row paginationrow'>";
			echo "<div class='zephyr-pagination col-md-10 col-md-offset-2'>";
			if($paged > 2 && $paged > $range+1 && $showitems < $pages) echo "<a class='first' href='".get_pagenum_link(1)."'>".__('First', 'zephyr')."</a>";
			if($paged > 1 && $showitems < $pages) echo get_previous_posts_link(__('Prev', 'zephyr'));
			for ($i=1; $i <= $pages; $i++) {
				if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems )) {
					echo ($paged == $i)? "<span class='current'>".$i."</span>":"<a href='".get_pagenum_link($i)."' class='inactive' >".$i."</a>";
				}
			}
			if ($paged < $pages && $showitems < $pages) echo get_next_posts_link(__('Next', 'zephyr'));
			if ($paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages) echo "<a href='".get_pagenum_link($pages)."'>".__('Last', 'zephyr')."</a>";
			echo "</div>\n";
			echo "</div>\n";
		}
    }
}

// favicon option

function zephyr_favicon() {
$favicon = get_theme_mod('zephyr_favicon');
if ( !empty($favicon) ) {
	echo '<link rel="shortcut icon" href="'.get_theme_mod('zephyr_favicon').'" />';
}
}
add_action('wp_head', 'zephyr_favicon');

//parse twitter text

function tweet_html_text(array $tweet) {
    $text = $tweet['text'];

    // hastags
    $linkified = array();
    foreach ($tweet['entities']['hashtags'] as $hashtag) {
        $hash = $hashtag['text'];

        if (in_array($hash, $linkified)) {
            continue; // do not process same hash twice or more
        }
        $linkified[] = $hash;

        // replace single words only, so looking for #Google we wont linkify >#Google<Reader
        $text = preg_replace('/#\b' . $hash . '\b/', sprintf('<a href="https://twitter.com/search?q=%%23%2$s&src=hash">#%1$s</a>', $hash, urlencode($hash)), $text);
    }

    // user_mentions
    $linkified = array();
    foreach ($tweet['entities']['user_mentions'] as $userMention) {
        $name = $userMention['name'];
        $screenName = $userMention['screen_name'];

        if (in_array($screenName, $linkified)) {
            continue; // do not process same user mention twice or more
        }
        $linkified[] = $screenName;

        // replace single words only, so looking for @John we wont linkify >@John<Snow
        $text = preg_replace('/@\b' . $screenName . '\b/', sprintf('<a href="https://www.twitter.com/%1$s" title="%2$s">@%1$s</a>', $screenName, $name), $text);
    }

    // urls
    $linkified = array();
    foreach ($tweet['entities']['urls'] as $url) {
        $url = $url['url'];

        if (in_array($url, $linkified)) {
            continue; // do not process same url twice or more
        }
        $linkified[] = $url;

        $text = str_replace($url, sprintf('<a href="%1$s">%1$s</a>', $url), $text);
    }

    return $text;
}

// get social profiles dropdown 

function zephyr_social_dropdown() {
	global $zephyr_options;
	$socials = json_decode($zephyr_options['socials'], true);
	if ( !empty($socials) ) {
		if ( count($socials) %2 !== 0 ) {
			$socials[] = Array( 'link' => '', 'image' => get_template_directory_uri().'/img/nosocial.png' );
		}
		echo '<a href="#" class="dropdown-toggle" data-toggle="dropdown"></a>';
		echo '<ul class="socialsdropdown">';
		foreach ( $socials as $social ) {
			echo '<li>';
			if ( $social['link'] == '' ) {
				echo '<img src="'.$social['image'].'" alt="'.__('Icon', 'zephyr').'" />';
			} else {
				echo '<a target="_blank" href="'.$social['link'].'"><img src="'.$social['image'].'" alt="'.__('Icon', 'zephyr').'" /></a>';
			}
			echo '</li>';
		}	
		echo '</ul>';
	}
}

// get user set avatar with fallback to wp default

function zephyr_get_avatar($author, $size) {
	$avatar = get_the_author_meta( 'zephyr-author-avatar', $author );
	if ( $avatar ) {
		return '<img width="'.$size.'" src="'.$avatar.'" alt="'.get_the_author_meta('nickname', $author).'" />';
	} else {
		return get_avatar($author, $size);
	}
}

// add infinite scroll ajax action

add_action('wp_ajax_zephyr_infinite_scroll', 'zephyr_get_nextpage');  

function zephyr_get_nextpage() {
	$loopFile = $_POST['loop_file'];
    $paged = $_POST['page_no'];
    $vv = stripslashes($_POST['vars']);
    $vars = json_decode($vv, true);
	$vars['paged'] = $paged;
	global $isms;
	global $zephyr_post_columns;
	$zephyr_post_columns = $vars['columns'];
	unset($vars['columns']);
	$isms = $_POST['mas'];
    query_posts($vars);
	global $wp_query; 
	if ( $wp_query->found_posts == 0 ) { 
		echo 0;
	} else {
		get_template_part( 'templates/'.$loopFile );
    }
    exit;  
}

function zephyr_get_ads_post($queryobject = '') {
	global $wp_query;
	global $zephyr_post_layout;
	global $zephyr_post_columns;
	if ( !empty($queryobject) ) {
		$postnum = ($queryobject->current_post + 1);
	} else {
		$postnum = ($wp_query->current_post + 1);
	}
	$zephyr_ads = get_option('theme_zephyr_ads');
	$adcode = $zephyr_ads['adsafter'];
	$displayafter = $zephyr_ads['postscount'];
	if ( !empty($adcode) ) {
		if ( $postnum%$displayafter == 0 ) {
			if ( $zephyr_post_layout == 'post-masonry' ) {
				if ( $zephyr_post_columns ) {
					echo '<div class="'.$zephyr_post_columns.' masonry-post">';
				} else {
					echo '<div class="col-md-6 masonry-post">';
				}
				echo $adcode;
				echo '</div>';			
			} else {
				echo '<div class="row">';
				echo '<div class="col-sm-2"></div><div class="col-sm-10">';
				echo $adcode;
				echo '</div>';
				echo '</div>';
			}
		}
	}
}

function zephyr_get_ads_sidebar($queryobject = '') {
	global $wp_query;
	if ( !empty($queryobject) ) {
		$postnum = ($queryobject->current_post + 1);
	} else {
		$postnum = ($wp_query->current_post + 1);
	}
	$zephyr_ads = get_option('theme_zephyr_ads');
	$adcode = $zephyr_ads['adssidebar'];
	$displayafter = $zephyr_ads['sidecount'];
	if ( !empty($adcode) ) {
		if ( $postnum%$displayafter == 0 ) {
			echo '<li>';
			echo $adcode;
			echo '</li>';
		}
	}
}

function zephyr_get_optin() {
	$optin_options = get_option( 'zephyr_optin_options' );
	if ( $optin_options['optin_enable'] ) {
		$optin_img = $optin_options['optinimage'];
		echo '<div id="zephyr-optin">';
			echo '<div id="zephyr-optin-image">';
				echo '<img src="'.$optin_img.'" alt="'.get_bloginfo('name').'" />';
			echo '</div>';
			echo '<div id="zephyr-optin-form" class="row accentbg">';
				echo '<div class="col-md-4">';
					echo '<label for="zephyr-optin-name" class="fonttwo">'.__('NAME', 'zephyr').':</label><input type="text" class="notv" id="zephyr-optin-name"><div class="border"></div>';
				echo '</div>';
				echo '<div class="col-md-4">';
					echo '<label for="zephyr-optin-mail" class="fonttwo">'.__('EMAIL', 'zephyr').':</label><input type="text" class="notv" id="zephyr-optin-mail"><div class="border"></div>';
				echo '</div>';
				echo '<div class="col-md-4">';
					echo '<a href="#" class="accentcolor zephyr-button" id="zephyr-optin-send">'.$optin_options['optinbutton'].'</a>';
				echo '</div><div class="clearfix"></div>';
			echo '</div>';
		echo '</div>';
	}
}

add_action('wp_ajax_zephyr_sendoptin', 'zephyr_sendoptin');  

function zephyr_sendoptin() {
	$name = $_POST['name'];
	$email = $_POST['email'];
	$optin_options = get_option( 'zephyr_optin_options' );
	$subject = $optin_options['optinsubject'];
	$message = $optin_options['optinmessage'].'<br /><br />';
	$uploaddir = wp_upload_dir();
	$file = $optin_options['optinfile'];
	$file = str_replace($uploaddir['baseurl'], '', $file);
	$file = $uploaddir['basedir'].$file;
	$attachments = array( $file );
	$headers = "MIME-Version: 1.0\r\n";
	$headers .= "Content-Type: text/html; charset=UTF-8\r\n";
	echo wp_mail( $email, $subject, $message, $headers, $attachments );
	$optinmails = get_option( 'zephyr_optin_emails' );
	$new_row = Array($name , $email);
	array_push( $optinmails, $new_row);
	update_option( 'zephyr_optin_emails', $optinmails );
	exit;
}

function zephyr_excerpt() {
	global $post;
	global $zephyr_full_content;
	if ( $zephyr_full_content == 'on' ) {
		the_content();
	} else {
		the_excerpt();
	}
}

// allow users to choose header layout

function zephyr_get_header() {
	$header_layout = get_theme_mod('zephyr_header_layout');
	if ( $header_layout == 'inline' || $header_layout == '' ) {
		zephyr_header_logo();
		zephyr_header_menu();	
	}
	if ( $header_layout == 'tworows' ) {
		zephyr_header_logo( 12 );
		zephyr_header_menu( 12 );
	}
}

function zephyr_header_menu( $width = '9' ) {
?>
	<div id="nav-search" class="col-md-<?php echo $width; ?> col-sm-<?php echo $width; ?> col-xs-12">
		<div class="row">
			<nav id="main-top" class="col-md-9 col-sm-10 col-xs-12 navbar navbar-default" role="navigation">
				<div class="navbar-header">
					<button type="button" id="mobile-menu-button" class="navbar-toggle" data-toggle="collapse" data-target="#header-menu-collapse">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
				</div>
				<div class="collapse navbar-collapse" id="header-menu-collapse">
					<?php wp_nav_menu( array( 'theme_location' => 'headermenu', 'menu_class' => 'nav-menu', 'container' => '', 'walker' => new Zephyr_Walker_Nav_Menu() ) ); ?>
					<div id="zephyr-mobile-search" class="visible-xs">
						<?php get_template_part( 'templates/search', 'mobile' ); ?>
					</div>
				</div>
			</nav>
			<div id="search-container" class="col-md-3 col-sm-2 col-xs-12">
				<div class="row">
					<div class="col-md-10 hidden-xs  col-sm-10">
						<?php get_search_form(); ?>
					</div>
					<div class="col-md-2 col-sm-2">
						<div class="social-links left">
							<?php zephyr_social_dropdown(); ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php
}

function zephyr_header_logo( $width = '3' ) {
	$desc = '';
	if ( get_theme_mod('zephyr_show_desc') ) { $desc = get_bloginfo('description'); }
	$align = get_theme_mod('zephyr_header_align');
	global $zephyr_cont;
	?>
		<div id="logo" class="<?php echo $zephyr_cont . ' '. $align; ?> sidew col-md-<?php echo $width; ?> col-sm-<?php echo $width; ?> col-xs-8">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
					<?php $logotext = get_theme_mod( 'zephyr_textlogo' );
					if ( get_theme_mod( 'zephyr_logo' ) !== '' ) { ?>
					<img src="<?php echo get_theme_mod( 'zephyr_logo'); ?>" data-at2x="<?php echo get_theme_mod( 'zephyr_logo_retina'); ?>"  alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" />
					<?php } else { 
						if ( $logotext == '' ) {
							$logotext = get_bloginfo('name');
						} 
						echo '<span id="zephyr-text-logo">'.$logotext.'</span>';
					} ?>
				</a>
				<?php if ( $desc ) {
					echo '<span class="zephyr-desc fontone hidden-xs">'.$desc.'</span>';
				} ?>
		</div>
	<?php
}