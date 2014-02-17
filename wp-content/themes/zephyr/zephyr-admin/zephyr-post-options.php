<?php
add_action( 'add_meta_boxes', 'zephyr_post_meta_box_add' );
function zephyr_post_meta_box_add()
{
	add_meta_box( 'zephyr-post-layout', 'Post layout', 'zephyr_post_meta_box_cb', 'post', 'normal', 'high' );
}

function zephyr_post_meta_box_cb( $post )
{
	$values = get_post_custom( $post->ID );
	$gallery_slider = isset( $values['zephyr_meta_box_post_slider'] ) ? esc_attr( $values['zephyr_meta_box_post_slider'][0] ) : '';
	$zephyr_post_bg = isset( $values['zephyr_post_bg'] ) ? esc_attr( $values['zephyr_post_bg'][0] ) : '0';
	wp_nonce_field( 'zephyr_meta_box_nonce', 'meta_box_nonce' );
	?>
	<div id="postgal">
	<p><h4><?php _e('Display gallery as slider?', 'zephyr'); ?></h4></p>
	<p>
		<label for="post-slider" class="zephyr-ad" title="Post slider">
			<img src="<?php echo get_template_directory_uri(); ?>/img/sidebar-left.png" />
			<input type="checkbox" name="zephyr_meta_box_post_slider" id="post-slider" value="post-slider" <?php checked( $gallery_slider, 'post-slider' ); ?> />
		</label>
	</p>
	</div>
	<p><h4><?php _e('Post background', 'zephyr'); ?></h4></p>
	<p>
		<div id="zephyr_post_bg_preview">
			<?php wpsePTS_grid_action_ajax($zephyr_post_bg); ?>
		</div>
		<input type="hidden" name="zephyr_post_bg" id="zephyr_post_bg" value="<?php echo $zephyr_post_bg; ?>" />
		<div class="wp-media-buttons"><a title="<?php _e('Choose Image', 'zephyr'); ?>" data-uploader_title="<?php _e( 'Post Background Image' , 'zephyr' ); ?>" data-uploader_button_text="<?php _e('Insert image', 'zephyr'); ?>" class="upload_page_slider button add_media" data-image_target="#zephyr_post_bg_preview" data-image_input="#zephyr_post_bg" id="" href="#"><span class="wp-media-buttons-icon"></span> <?php _e('Choose Image', 'zephyr'); ?></a></div>
		<div class="clearfix"></div>
	</p>

	<?php	
}


add_action( 'save_post', 'zephyr_post_meta_box_save' );
function zephyr_post_meta_box_save( $post_id )
{
	if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) { return; }
	if( !isset( $_POST['meta_box_nonce'] ) || !wp_verify_nonce( $_POST['meta_box_nonce'], 'zephyr_meta_box_nonce' ) ) { return; }
	$allowed = array( 
		'a' => array(
			'href' => array()
		)
	);
	$gallery_slider = ( isset( $_POST['zephyr_meta_box_post_slider'] ) && $_POST['zephyr_meta_box_post_slider'] ) ? $_POST['zephyr_meta_box_post_slider'] : '0';
	update_post_meta( $post_id, 'zephyr_meta_box_post_slider', $gallery_slider );
	$zephyr_post_bg = ( isset( $_POST['zephyr_post_bg'] ) && $_POST['zephyr_post_bg'] ) ? $_POST['zephyr_post_bg'] : '0';
	update_post_meta( $post_id, 'zephyr_post_bg', $zephyr_post_bg );

}
?>