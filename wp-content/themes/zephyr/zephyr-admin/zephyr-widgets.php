<?php
function zephyr_widget_scripts($hook) {
	if( $hook == 'widgets.php' ) {
		wp_enqueue_media();
		wp_enqueue_script( 'zephyr-widget-js', get_template_directory_uri() . '/js/zephyr-admin-widgets.js', array('jquery'), '1.0' );
 	}
}
add_action('admin_enqueue_scripts', 'zephyr_widget_scripts');
add_action( 'widgets_init', 'zephyr_widgets' );

function zephyr_widgets() {
	register_widget( 'Zephyr_Widget_Author' );
	register_widget( 'Zephyr_Widget_Slider' );
	register_widget( 'Zephyr_Widget_Gallery' );
	register_widget( 'Zephyr_Widget_Video' );
	register_widget( 'Zephyr_Widget_Twitter' );
	register_widget( 'Zephyr_Widget_Facebook' );
}

class Zephyr_Widget_Slider extends WP_Widget {

	function Zephyr_Widget_Slider() {
		$widget_ops = array( 'classname' => 'zephyr-slider', 'description' => __('An image slider widget', 'zephyr') );
		
		$zephyr_control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'zephyr-widget-slider' );
		
		$this->WP_Widget( 'zephyr-widget-slider', __('Image Slider Widget', 'zephyr'), $widget_ops, $zephyr_control_ops );
	}
	
	function widget( $args, $instance ) {
		extract( $args );

		//Our variables from the widget settings.
		$title = apply_filters('widget_title', $instance['title'] );
		$images = explode(',',$instance['images']);
		echo $before_widget;

		// Display the widget title 
		if ( $title ) {
			echo $before_title . $title . $after_title;
		}
		?>
		<div data-ride="carousel" class="carousel slide" id="slider-<?php echo $this->id; ?>">
			<ol class="carousel-indicators">
				<?php 
				$i = 0;
				foreach ( $images as $image ) { 
					if ( $i == 0 ) {
					echo '<li class="active" data-slide-to="'.$i.'" data-target="#slider-'.$this->id.'"></li>';
					} else {
					echo '<li class="" data-slide-to="'.$i.'" data-target="#slider-'.$this->id.'"></li>';
					}
					$i++;
				} ?>
			</ol>
			<div class="carousel-inner">
				<?php 
				$i = 0;
				foreach ( $images as $image ) {
					$image = wp_get_attachment_image_src( $image, 'zephyr-galllery-3col' );
					if ( $i == 0 ) {
						echo '<div class="item active">';
					} else {
						echo '<div class="item">';
					}
						echo '<img width="180" alt="Carousel Widget" src="'.$image[0].'">';
					echo '</div>';
					$i++;
				} ?>
			</div>
		</div>
		<?php
		echo $after_widget;
	}
	 
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['images'] = strip_tags( $new_instance['images'] );
		return $instance;
	}
	
	function form( $instance ) {

		//Set up some default widget settings.
		$defaults = array( 'title' => __('Image Slider', 'zephyr'), 'images' => '0' );
		$instance = wp_parse_args( (array) $instance, $defaults );
		 ?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'zephyr'); ?></label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" type="text" class="widefat" />
		</p>
		<p>
			<div class="<?php echo $this->get_field_id( 'images' ); ?>">
				<?php wpsePTS_grid_action_ajax($instance['images']); ?>
			</div>
			<input type="hidden" name="<?php echo $this->get_field_name( 'images' ); ?>" id="<?php echo $this->get_field_id( 'images' ); ?>" value="<?php echo $instance['images']; ?>" />
			<div class="wp-media-buttons"><a title="<?php _e('Add Images', 'zephyr'); ?>" data-uploader_title="<?php _e('Slider widget images', 'zephyr'); ?>" data-uploader_button_text="<?php _e('Insert images', 'zephyr'); ?>" class="upload_widget_images button add_media" data-image_target=".<?php echo $this->get_field_id( 'images' ); ?>" data-image_input="#<?php echo $this->get_field_id( 'images' ); ?>" id="" href="#"><span class="wp-media-buttons-icon"></span> <?php _e('Add Images', 'zephyr'); ?></a></div>
			<div class="clearfix"></div>
		</p>

	<?php
	}
}

class Zephyr_Widget_Author extends WP_Widget {

	function Zephyr_Widget_Author() {
		$widget_ops = array( 'classname' => 'zephyr-author', 'description' => __('A widget that displays author info', 'zephyr') );
		
		$zephyr_control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'zephyr-widget-author' );
		
		$this->WP_Widget( 'zephyr-widget-author', __('Author Widget', 'zephyr'), $widget_ops, $zephyr_control_ops );
	}
	
	function widget( $args, $instance ) {
		extract( $args );

		//Our variables from the widget settings.
		$title = apply_filters('widget_title', $instance['title'] );

		echo $before_widget;

		// Display the widget title 
		if ( $title ) {
			echo $before_title . $title . $after_title;
		}
		?>
		<div id="author-top" class="col-md-12">
			<?php 
			$author = $instance['authorid'];
			echo zephyr_get_avatar($author, 78);
			?>
			<h1><?php the_author_meta('display_name', $author); ?></h1>
			<?php $nickname = get_the_author_meta('nickname', $author);
			if ( $nickname !== '' ) {
				echo '<h2>'.$nickname.'</h2>';
			} ?>
			<span class="separator"></span>
			<p class="author-bio"><?php the_author_meta('description', $author); ?></p>
		</div>
		<?php
		echo $after_widget;
	}
	 
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['authorid'] = strip_tags( $new_instance['authorid'] );
		return $instance;
	}

	
	function form( $instance ) {

		//Set up some default widget settings.
		$defaults = array( 'title' => __('Author of the month', 'zephyr'), 'authorid' => 1 );
		$instance = wp_parse_args( (array) $instance, $defaults );
		 ?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'zephyr'); ?></label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" type="text" class="widefat" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'authorid' ); ?>"><?php _e('Choose author:', 'zephyr'); ?></label>
			<?php wp_dropdown_users(
				Array(
					'name' => $this->get_field_name( 'authorid' ),
					'selected' => $instance['authorid']
				)
			); ?>
		</p>

	<?php
	}
}

class Zephyr_Widget_Gallery extends WP_Widget {

	function Zephyr_Widget_Gallery() {
		$widget_ops = array( 'classname' => 'zephyr-gallery-widget', 'description' => __('Gallery Widget', 'zephyr') );
		
		$zephyr_control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'zephyr-widget-gallery' );
		
		$this->WP_Widget( 'zephyr-widget-gallery', __('Gallery Widget', 'zephyr'), $widget_ops, $zephyr_control_ops );
	}
	
	function widget( $args, $instance ) {
		extract( $args );

		//Our variables from the widget settings.
		$title = apply_filters('widget_title', $instance['title'] );
		$ids = $instance['ids'];
		
		echo $before_widget;

		// Display the widget title 
		if ( $title ) {
			echo $before_title . $title . $after_title;
		}
		if ( $ids ) {
			echo do_shortcode('[gallery columns="4" ids="'.$ids.'"]');
		}
		echo $after_widget;
	}
	 
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['ids'] = strip_tags( $new_instance['ids'] );
		return $instance;
	}

	function form( $instance ) {
		//Set up some default widget settings.
		$defaults = array( 'title' => __('My images', 'zephyr'), 'ids' => '0' );
		$instance = wp_parse_args( (array) $instance, $defaults );
		 ?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'zephyr'); ?></label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" type="text" class="widefat" />
		</p>
		<p>
			<div class="<?php echo $this->get_field_id( 'ids' ); ?>">
				<?php wpsePTS_grid_action_ajax($instance['ids']); ?>
			</div>
			<input type="hidden" name="<?php echo $this->get_field_name( 'ids' ); ?>" id="<?php echo $this->get_field_id( 'ids' ); ?>" value="<?php echo $instance['ids']; ?>" />
			<div class="wp-media-buttons"><a title="<?php _e('Add Images', 'zephyr'); ?>" data-uploader_title="<?php _e('Gallery widget images', 'zephyr'); ?>" data-uploader_button_text="<?php _e('Insert images', 'zephyr'); ?>" class="upload_widget_images button add_media" data-image_target=".<?php echo $this->get_field_id( 'ids' ); ?>" data-image_input="#<?php echo $this->get_field_id( 'ids' ); ?>" id="" href="#"><span class="wp-media-buttons-icon"></span> <?php _e('Add Images', 'zephyr'); ?></a></div>
			<div class="clearfix"></div>
		</p>
	<?php
	}
}

class Zephyr_Widget_Video extends WP_Widget {

	function Zephyr_Widget_Video() {
		$widget_ops = array( 'classname' => 'zephyr-video-widget', 'description' => __('Use this widget to display a video.', 'zephyr') );
		
		$zephyr_control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'zephyr-widget-video' );
		
		$this->WP_Widget( 'zephyr-widget-video', __('Video Widget', 'zephyr'), $widget_ops, $zephyr_control_ops );
	}
	
	function widget( $args, $instance ) {
		extract( $args );

		//Our variables from the widget settings.
		$title = apply_filters('widget_title', $instance['title'] );
		$video = $instance['video'];
		
		echo $before_widget;

		// Display the widget title 
		if ( $title ) {
			echo $before_title . $title . $after_title;
		}
		if ( $video ) {
			echo wp_oembed_get($video, array('width' => 399));
		}
		echo $after_widget;
	}
	 
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['video'] = strip_tags( $new_instance['video'] );
		return $instance;
	}

	function form( $instance ) {
		//Set up some default widget settings.
		$defaults = array( 'title' => __('Video', 'zephyr'), 'video' => '' );
		$instance = wp_parse_args( (array) $instance, $defaults );
		 ?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'zephyr'); ?></label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" type="text" class="widefat" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'video' ); ?>"><?php _e('Video url:', 'zephyr'); ?></label>
			<input id="<?php echo $this->get_field_id( 'video' ); ?>" name="<?php echo $this->get_field_name( 'video' ); ?>" value="<?php echo $instance['video']; ?>" type="text" class="widefat" />
		</p>
	<?php
	}
}

class Zephyr_Widget_Twitter extends WP_Widget {

	function Zephyr_Widget_Twitter() {
		$widget_ops = array( 'classname' => 'zephyr-twitter-widget', 'description' => __('Twitter feed Widget', 'zephyr') );
		
		$zephyr_control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'zephyr-widget-twitter' );
		
		$this->WP_Widget( 'zephyr-widget-twitter', __('Twitter Widget', 'zephyr'), $widget_ops, $zephyr_control_ops );
	}
	
	function widget( $args, $instance ) {
		extract( $args );

		//Our variables from the widget settings.
		$title = apply_filters('widget_title', $instance['title'] );
		$screenname = $instance['screenname'];
		$numposts = $instance['numposts'];
		$zephyr_options = get_option( 'theme_zephyr_options' );
		
		echo $before_widget;

		// Display the widget title 
		if ( $title ) {
			echo $before_title . $title . $after_title;
		}
		include_once(get_template_directory().'/zephyr-includes/wpTwitterApi.php');
		if ( empty($zephyr_options['twitter_key']) || empty($zephyr_options['twitter_secret']) ) {
			echo '<p>'.__('This widget needs to be configured before you can use it', 'zephyr').'</p>';
		} else {
			$settings = array(
				'consumer_key' => $zephyr_options['twitter_key'],
				'consumer_secret' => $zephyr_options['twitter_secret']
			);
			$twitter_api = new Wp_Twitter_Api( $settings );
			$query = 'count='.$numposts.'&screen_name='.$screenname;
			$response = $twitter_api->query( $query );
			echo '<ul class="twitter-feed">';
			foreach ( $response as $tweet) {
				echo '<li>';
				$date = new DateTime($tweet['created_at']);
				$formatted_date = $date->format('D, d M H:i');
				echo '<div class="twitter-date">'.$formatted_date.'</div>';
				echo '<p>'.tweet_html_text($tweet).'</p>';
				echo '</li>';
			}
			echo '</ul>';
			echo '<div class="centered">';
			echo '<a href="https://twitter.com/intent/user?screen_name='.$screenname.'" target="_blank" class="zephyr-button">'.__('Follow', 'zephyr').' '.$screenname.'</a>';
			echo '</div>';
		}
		echo $after_widget;
	}
	 
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['screenname'] = strip_tags( $new_instance['screenname'] );
		$instance['numposts'] = strip_tags( $new_instance['numposts'] );
		return $instance;
	}

	function form( $instance ) {
		//Set up some default widget settings.
		$defaults = array( 'title' => __('Latest Tweets', 'zephyr'), 'screenname' => '', 'numposts' => '3' );
		$instance = wp_parse_args( (array) $instance, $defaults );
		$zephyr_options = get_option( 'theme_zephyr_options' );
		if ( empty($zephyr_options['twitter_key']) || empty($zephyr_options['twitter_secret']) ) {
			echo '<p>'.__('Please fill in Twitter feed Settings under Appearance > Social options', 'zephyr').'</p>';
		} else {
		 ?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'zephyr'); ?></label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" type="text" class="widefat" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'screenname' ); ?>"><?php _e('Twitter username:', 'zephyr'); ?></label>
			<input id="<?php echo $this->get_field_id( 'screenname' ); ?>" name="<?php echo $this->get_field_name( 'screenname' ); ?>" value="<?php echo $instance['screenname']; ?>" type="text" class="widefat" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'numposts' ); ?>"><?php _e('Tweets to display:', 'zephyr'); ?></label>
			<input id="<?php echo $this->get_field_id( 'numposts' ); ?>" name="<?php echo $this->get_field_name( 'numposts' ); ?>" value="<?php echo $instance['numposts']; ?>" type="text" class="widefat" />
		</p>
	<?php
		}
	}
}

class Zephyr_Widget_Facebook extends WP_Widget {

	function Zephyr_Widget_Facebook() {
		$widget_ops = array( 'classname' => 'zephyr-facebook-widget', 'description' => __('Facebook feed Widget', 'zephyr') );
		
		$zephyr_control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'zephyr-widget-facebook' );
		
		$this->WP_Widget( 'zephyr-widget-facebook', __('Facebook Widget', 'zephyr'), $widget_ops, $zephyr_control_ops );
	}
	
	function widget( $args, $instance ) {
		extract( $args );

		//Our variables from the widget settings.
		$title = apply_filters('widget_title', $instance['title'] );
		$pageid = $instance['pageid'];
		$numposts = $instance['numposts'];
		$fetch = $numposts * 2;
		$zephyr_options = get_option( 'theme_zephyr_options' );
		
		echo $before_widget;

		// Display the widget title 
		if ( $title ) {
			echo $before_title . $title . $after_title;
		}
		if ( empty($zephyr_options['facebook_token']) ) {
			echo '<p>'.__('This widget needs to be configured before you can use it', 'zephyr').'</p>';
		} else {
			include_once(get_template_directory().'/zephyr-includes/facebookapi.php');
			$access_token = $zephyr_options['facebook_token'];
			$newsfeed = zephyr_getfb_feed($pageid, 'feed', $access_token, $fetch);
			echo '<div class="centered zephyr-widget-fbtop">';
			echo '<a href="https://facebook.com/'.$pageid.'" target="_blank"><img class="round" src="'.zephyr_getfb_avatar($pageid).'" alt="'.$newsfeed->data[0]->from->name.'" /></a><br />';
			echo '<a class="fonttwo" href="https://facebook.com/'.$pageid.'" target="_blank">'.$newsfeed->data[0]->from->name.'</a>';
			echo '</div>';
			echo '<ul class="fb-feed centered">';
			$i = 0;
			foreach ( $newsfeed->data as $news) {
				if ( isset($news->message) ) {
					if ( $i == $numposts ) { break; }
					$date = new DateTime($news->created_time);
					$formatted_date = $date->format('D, d M H:i');
					$message = zephyr_linkify($news->message, 0, 160);
					echo '<li>';
					echo '<p>'.$message.'</p>';
					echo '<p class="fb-date fonttwo">'.$formatted_date.'</p>';
					echo '</li>';
					$i++;
				}
			}
			echo '</ul>';
		}
		echo $after_widget;
	}
	 
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['pageid'] = strip_tags( $new_instance['pageid'] );
		$instance['numposts'] = strip_tags( $new_instance['numposts'] );
		return $instance;
	}

	function form( $instance ) {
		//Set up some default widget settings.
		$defaults = array( 'title' => __('Facebook feed', 'zephyr'), 'pageid' => '', 'numposts' => '3' );
		$instance = wp_parse_args( (array) $instance, $defaults );
		$zephyr_options = get_option( 'theme_zephyr_options' );
		if ( empty($zephyr_options['facebook_token'])  ) {
			echo '<p>'.__('Please fill in Facebook feed Settings under Appearance > Social options', 'zephyr').'</p>';
		} else {
		 ?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'zephyr'); ?></label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" type="text" class="widefat" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'pageid' ); ?>"><?php _e('Page ID', 'zephyr'); ?></label>
			<input id="<?php echo $this->get_field_id( 'pageid' ); ?>" name="<?php echo $this->get_field_name( 'pageid' ); ?>" value="<?php echo $instance['pageid']; ?>" type="text" class="widefat" />
			<small><?php _e('If you have a Facebook page with a URL like this: https://www.facebook.com/page_name then the Page ID is just page_name. If your page URL is structured like this: https://www.facebook.com/pages/page_name/34352435 then the Page ID is actually the number at the end, so in this case 34352435.', 'zephyr'); ?></small>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'numposts' ); ?>"><?php _e('Posts to display:', 'zephyr'); ?></label>
			<input id="<?php echo $this->get_field_id( 'numposts' ); ?>" name="<?php echo $this->get_field_name( 'numposts' ); ?>" value="<?php echo $instance['numposts']; ?>" type="text" class="widefat" />
		</p>
	<?php
		}
	}
}