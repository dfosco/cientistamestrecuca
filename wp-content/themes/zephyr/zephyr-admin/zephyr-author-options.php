<?php
add_action( 'show_user_profile', 'zephyr_author_fields' );
add_action( 'edit_user_profile', 'zephyr_author_fields' );

function zephyr_author_fields( $user ) { ?>
	<h3><?php _e('Author extra info', 'zephyr'); ?></h3>
	<table class="form-table">
		<tr>
			<th><label for="zephyr-author-avatar"><?php _e('Author avatar', 'zephyr'); ?></label></th>
			<td>
				<input type="text" name="zephyr-author-avatar" id="zephyr-author-avatar" value="<?php echo esc_attr( get_the_author_meta( 'zephyr-author-avatar', $user->ID ) ); ?>" class="regular-text" /><br />
				<span class="description"><?php _e('Author avatar url', 'zephyr'); ?></span>
				<div class="wp-media-buttons"><a title="<?php _e('Choose image', 'zephyr'); ?>" data-uploader_title="<?php _e('Author Avatar', 'zephyr'); ?>" data-uploader_button_text="<?php _e('Select image', 'zephyr'); ?>" class="upload_image_button button add_media" data-image_target="#zephyr-author-avatar" id="" href="#"><span class="wp-media-buttons-icon"></span> <?php _e('Choose Image', 'zehpyr'); ?></a></div>
			</td>
		</tr>
		<tr>
			<th><label for="zephyr-author-bg"><?php _e('Background image', 'zephyr'); ?></label></th>
			<td>
				<input type="text" name="zephyr-author-bg" id="zephyr-author-bg" value="<?php echo esc_attr( get_the_author_meta( 'zephyr-author-bg', $user->ID ) ); ?>" class="regular-text" /><br />
				<span class="description"><?php _e('Background image url', 'zephyr'); ?></span>
				<div class="wp-media-buttons"><a title="<?php _e('Choose image', 'zephyr'); ?>" data-uploader_title="<?php _e('Author Background Image', 'zephyr'); ?>" data-uploader_button_text="<?php _e('Insert image', 'zephyr'); ?>" class="upload_image_button button add_media" data-image_target="#zephyr-author-bg" id="" href="#"><span class="wp-media-buttons-icon"></span> <?php _e('Choose Image', 'zehpyr'); ?></a></div>
			</td>
		</tr>

	</table>
<?php }
add_action( 'personal_options_update', 'zephyr_save_author_fields' );
add_action( 'edit_user_profile_update', 'zephyr_save_author_fields' );

function zephyr_save_author_fields( $user_id ) {

	if ( !current_user_can( 'edit_user', $user_id ) )
		return false;

	update_user_meta( $user_id, 'zephyr-author-bg', esc_url($_POST['zephyr-author-bg']) );
	update_user_meta( $user_id, 'zephyr-author-avatar', esc_url($_POST['zephyr-author-avatar']) );
}