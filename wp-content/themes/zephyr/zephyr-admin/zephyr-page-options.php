<?php
add_action( 'add_meta_boxes', 'zephyr_meta_box_add' );
function zephyr_meta_box_add()
{
	add_meta_box( 'zephyr-page-layout', 'Page layout', 'zephyr_meta_box_cb', 'page', 'normal', 'high' );
}

function zephyr_meta_box_cb( $post )
{
	$values = get_post_custom( $post->ID );
	$text = isset( $values['zephyr_meta_box_text'] ) ? esc_attr( $values['zephyr_meta_box_text'][0] ) : '';
	$selected = isset( $values['zephyr_meta_box_select'] ) ? esc_attr( $values['zephyr_meta_box_select'][0] ) : '';
	$display_posts = isset( $values['zephyr_display_posts'] ) ? esc_attr( $values['zephyr_display_posts'][0] ) : '';
	$full_content = isset( $values['zephyr_full_content'] ) ? esc_attr( $values['zephyr_full_content'][0] ) : '';
	$zephyr_page_layout = isset( $values['zephyr_meta_box_layout'] ) ? esc_attr( $values['zephyr_meta_box_layout'][0] ) : '';
	$zephyr_post_layout = isset( $values['zephyr_meta_box_post_info'] ) ? esc_attr( $values['zephyr_meta_box_post_info'][0] ) : '';
	$zephyr_post_columns = isset( $values['zephyr_meta_box_columns'] ) ? esc_attr( $values['zephyr_meta_box_columns'][0] ) : '';
	$zephyr_posts_centered = isset( $values['zephyr_meta_box_centered'] ) ? esc_attr( $values['zephyr_meta_box_centered'][0] ) : '';
	$zephyr_default_title = isset( $values['zephyr_meta_box_default_title'] ) ? esc_attr( $values['zephyr_meta_box_default_title'][0] ) : '';
	$zephyr_category = isset( $values['zephyr_category'] ) ? esc_attr( $values['zephyr_category'][0] ) : '';
	$zephyr_topslider = isset( $values['zephyr_page_slider'] ) ? esc_attr( $values['zephyr_page_slider'][0] ) : '0';
	wp_nonce_field( 'zephyr_meta_box_nonce', 'meta_box_nonce' );
	?>
	<p>
		<label for="zephyr_meta_box_layout"><?php _e('Sidebars', 'zephyr'); ?>:</label><br />
		<select name="zephyr_meta_box_layout" id="zephyr_meta_box_layout">
			<option value="0" <?php selected( $zephyr_page_layout, 0 ); ?>><?php _e('Use theme setting', 'zephyr'); ?></option>
			<option value="sidebar-left" <?php selected( $zephyr_page_layout, 'sidebar-left' ); ?>><?php _e('Sidebar Left', 'zephyr'); ?></option>
			<option value="sidebar-right" <?php selected( $zephyr_page_layout, 'sidebar-right' ); ?>><?php _e('Sidebar Right', 'zephyr'); ?></option>
			<option value="no-sidebar" <?php selected( $zephyr_page_layout, 'no-sidebar' ); ?>><?php _e('No sidebar', 'zephyr'); ?></option>
		</select>
	</p>
	<p>
		<label for="default-title" class="" title="Hide default title?">
			<input type="checkbox" name="zephyr_meta_box_default_title" id="default-title" value="default-title" <?php checked( $zephyr_default_title, 'on' ); ?> />
			<?php _e('Hide default title?', 'zephyr'); ?>
		</label>
	</p>
	<p>
		<label for="display-posts" class="" title="Display posts?">
			<input type="checkbox" name="zephyr_display_posts" id="display-posts" value="display-posts" <?php checked( $display_posts, 'on' ); ?> />
			<?php _e('Display posts instead of regular page?', 'zephyr'); ?>
		</label>
	</p>
	<p><h4><?php _e('Choose Category', 'zephyr'); ?></h4></p>
	<p>
		<?php 
		$categories = get_categories();
		echo '<select name="zephyr_category">';
			echo '<option value="0" '.selected( $zephyr_category, 0, false ).'>'.__('All categories', 'zephyr').'</option>';
		foreach ( $categories as $category ) {
			echo '<option value="'.$category->term_id.'" '.selected( $zephyr_category, $category->term_id, false ).'>'.$category->name.'</option>';
		}
		echo '</select>';
		?>
	</p>
	<p><h4><?php _e('Post layout', 'zephyr'); ?></h4></p>
	<p>
		<label for="post-info-left" class="zephyr-ad" title="Post info Left">
			<img src="<?php echo get_template_directory_uri(); ?>/img/icon-post-info-left.png" />
			<small><?php _e('Post info Left', 'zephyr'); ?></small><br />
			<input type="radio" name="zephyr_meta_box_post_info" id="post-info-left" value="post-info-left" <?php checked( $zephyr_post_layout, 'post-info-left' ); ?> />
		</label>
		<label for="post-info-right" class="zephyr-ad" title="Post info Right">
			<img src="<?php echo get_template_directory_uri(); ?>/img/icon-post-info-right.png" />
			<small><?php _e('Post info Right', 'zephyr'); ?></small><br />
			<input type="radio" name="zephyr_meta_box_post_info" id="post-info-right" value="post-info-right"  <?php checked( $zephyr_post_layout, 'post-info-right' ); ?> />
		</label>
		<label for="post-masonry" class="zephyr-ad" title="Masonry Layout">
			<img src="<?php echo get_template_directory_uri(); ?>/img/icon-masonry.png" />
			<small><?php _e('Masonry layout', 'zephyr'); ?></small><br />
			<input type="radio" name="zephyr_meta_box_post_info" id="post-masonry" value="post-masonry"  <?php checked( $zephyr_post_layout, 'post-masonry' ); ?> />
		</label>
	</p>
	<div class="zephyrpostcolumns">
	<p><h4><?php _e('Columns', 'zephyr'); ?></h4></p>
	<p>
		<label for="2-columns" class="zephyr-ad" title="Two columns">
			<img src="<?php echo get_template_directory_uri(); ?>/img/icon-masonry2col.png" />
			<small><?php _e('Two columns', 'zephyr'); ?></small><br />
			<input type="radio" name="zephyr_meta_box_columns" id="2-columns" value="col-md-6" <?php checked( $zephyr_post_columns, 'col-md-6' ); ?> />
		</label>
		<label for="3-columns" class="zephyr-ad" title="Three columns">
			<img src="<?php echo get_template_directory_uri(); ?>/img/icon-masonry3col.png" />
			<small><?php _e('Three columns', 'zephyr'); ?></small><br />
			<input type="radio" name="zephyr_meta_box_columns" id="3-columns" value="col-md-4"  <?php checked( $zephyr_post_columns, 'col-md-4' ); ?> />
		</label>
		<label for="4-columns" class="zephyr-ad" title="Four columns">
			<img src="<?php echo get_template_directory_uri(); ?>/img/icon-masonry4col.png" />
			<small><?php _e('Four columns', 'zephyr'); ?></small><br />
			<input type="radio" name="zephyr_meta_box_columns" id="4-columns" value="col-md-3"  <?php checked( $zephyr_post_columns, 'col-md-3' ); ?> />
		</label>
	</p>
	</div>
	<p><h4><?php _e('Make posts centered?', 'zephyr'); ?></h4></p>
	<p>
		<label for="posts-centered" class="zephyr-ad" title="Posts centered?">
			<img src="<?php echo get_template_directory_uri(); ?>/img/icon-centered-posts.png" />
			<input type="checkbox" name="zephyr_meta_box_centered" id="posts-centered" value="posts-centered" <?php checked( $zephyr_posts_centered, 'on' ); ?> />
		</label>
	</p>
	<p>
		<label for="full_content" class="" title="<?php _e('Show whole post content instead of excerpt?', 'zephyr'); ?>">
			<input type="checkbox" name="zephyr_full_content" id="full_content" value="full-content" <?php checked( $full_content, 'on' ); ?> />
			<?php _e('Show whole post content instead of excerpt?', 'zephyr'); ?>
		</label>
	</p>
	<p><h4><?php _e('Top page slider', 'zephyr'); ?></h4></p>
	<p>
		<div id="zephyr_page_slider">
			<?php wpsePTS_grid_action_ajax($zephyr_topslider); ?>
		</div>
		<input type="hidden" name="zephyr_page_slider_input" id="zephyr_page_slider_input" value="<?php echo $zephyr_topslider; ?>" />
		<div class="wp-media-buttons"><a title="<?php _e('Add Images', 'zephyr'); ?>" data-uploader_title="Top page slider" data-uploader_button_text="<?php _e('Insert images', 'zephyr'); ?>" class="upload_page_slider button add_media" data-image_target="#zephyr_page_slider" id="" href="#"><span class="wp-media-buttons-icon"></span> <?php _e('Add Images', 'zephyr'); ?></a></div>
		<div class="clearfix"></div>
	</p>
	<?php
}


add_action( 'save_post', 'zephyr_meta_box_save' );
function zephyr_meta_box_save( $post_id )
{
	if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) { return; }
	if( !isset( $_POST['meta_box_nonce'] ) || !wp_verify_nonce( $_POST['meta_box_nonce'], 'zephyr_meta_box_nonce' ) ) { return; }
	$allowed = array( 
		'a' => array(
			'href' => array()
		)
	);
	$display_posts = ( isset( $_POST['zephyr_display_posts'] ) && $_POST['zephyr_display_posts'] ) ? 'on' : 'off';
	update_post_meta( $post_id, 'zephyr_display_posts', $display_posts );
	$full_content = ( isset( $_POST['zephyr_full_content'] ) && $_POST['zephyr_full_content'] ) ? 'on' : 'off';
	update_post_meta( $post_id, 'zephyr_full_content', $full_content );
	$zephyr_page_layout = ( isset( $_POST['zephyr_meta_box_layout'] ) && $_POST['zephyr_meta_box_layout'] ) ? $_POST['zephyr_meta_box_layout'] : '0';
	update_post_meta( $post_id, 'zephyr_meta_box_layout', $zephyr_page_layout );

	$zephyr_post_layout = ( isset( $_POST['zephyr_meta_box_post_info'] ) && $_POST['zephyr_meta_box_post_info'] ) ? $_POST['zephyr_meta_box_post_info'] : '0';
	update_post_meta( $post_id, 'zephyr_meta_box_post_info', $zephyr_post_layout );
	$zephyr_post_columns = ( isset( $_POST['zephyr_meta_box_columns'] ) && $_POST['zephyr_meta_box_columns'] ) ? $_POST['zephyr_meta_box_columns'] : 'col-md-6';
	update_post_meta( $post_id, 'zephyr_meta_box_columns', $zephyr_post_columns );
	$zephyr_posts_centered = ( isset( $_POST['zephyr_meta_box_centered'] ) && $_POST['zephyr_meta_box_centered'] ) ? 'on' : 'off';
	update_post_meta( $post_id, 'zephyr_meta_box_centered', $zephyr_posts_centered );
	$zephyr_default_title = ( isset( $_POST['zephyr_meta_box_default_title'] ) && $_POST['zephyr_meta_box_default_title'] ) ? 'on' : 'off';
	update_post_meta( $post_id, 'zephyr_meta_box_default_title', $zephyr_default_title );
	$zephyr_category = ( isset( $_POST['zephyr_category'] ) && $_POST['zephyr_category'] ) ? $_POST['zephyr_category'] : '0';
	update_post_meta( $post_id, 'zephyr_category', $zephyr_category );
	$zephyr_topslider = ( isset( $_POST['zephyr_page_slider_input'] ) && $_POST['zephyr_page_slider_input'] ) ? $_POST['zephyr_page_slider_input'] : '0';
	update_post_meta( $post_id, 'zephyr_page_slider', $zephyr_topslider );
}

add_action('wp_ajax_wpsePTS_grid_action_ajax', 'wpsePTS_grid_action_ajax');
function wpsePTS_grid_action_ajax($ids = '') {
	if ( empty($ids) && $ids !== '0' ) {
		$ids = $_POST['ids'];
	}
	$ids = explode(',',$ids);
	if ( $ids[0] !== '0' ) {
		foreach( $ids as $id ) {
			$imgsrc = wp_get_attachment_image_src( $id, array(80,80));
		?>
			<div class="zephyr_uploaded_img" data-attid="<?php echo $id; ?>">
				<a class="media-modal-close" title="Remove image" href="#">
					<span class="media-modal-icon"></span>
				</a>
				<img src="<?php echo $imgsrc[0] ?>" alt="Uploaded image" />
			</div>
		<?php } ?>
		<div class="clearfix"></div>
		<?php
		if ( isset($_POST['ids']) ) {
			exit;
		}
	} else {
		return false;
	}
}

?>