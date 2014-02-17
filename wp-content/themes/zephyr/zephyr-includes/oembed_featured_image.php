<?php

add_action( 'wp_insert_post', array( 'ofi', 'init' ) );

class ofi
{
    private static $_thumb_id;
    private static $_post_id;
    private static $built = false;
    public static function init( $post_id ) {
		if ( get_post_format( $post_id ) == 'video' ) {
			if ( self::$built ) {
			   self::build($post_id);
			   return;
			}

			global $wp_embed;

			self::$_post_id = absint( $post_id );

			if ( ! self::$_thumb_id = get_post_meta( self::$_post_id, '_thumbnail_id', true ) ) {
				if ( $zephyr_content = get_post_field( 'post_content', self::$_post_id, 'raw' ) ) {

					add_filter( 'oembed_dataparse', array( 'ofi', 'oembed_dataparse' ), 10, 3 );
					$wp_embed->autoembed( $zephyr_content );
					remove_filter( 'oembed_dataparse', array( 'ofi', 'oembed_dataparse' ), 10, 3 );

				}
			}
        }
    }
    public function build( $post_id ) {
        self::init( $post_id );
        self::$built = true;
    }
    public static function oembed_dataparse( $return, $data, $url ) {
        if ( ! empty( $data->thumbnail_url ) && ! self::$_thumb_id ) {
            if ( in_array( @ $data->type, array( 'video' ) ) ) {
                self::set_thumb_by_url( $data->thumbnail_url, @ $data->title );
            }
        }
    }
    public static function set_thumb_by_url( $url, $title = null ) {
        /* Following assets will already be loaded if in admin */
        require_once ABSPATH . 'wp-admin/includes/file.php';
        require_once ABSPATH . 'wp-admin/includes/media.php';
        require_once ABSPATH . 'wp-admin/includes/image.php';

        $temp = download_url( $url );

        if ( ! is_wp_error( $temp ) && $info = @ getimagesize( $temp ) ) {
            if ( ! strlen( $title ) )
                $title = null;

            if ( ! $ext = image_type_to_extension( $info[2] ) )
                $ext = '.jpg';

            $data = array(
                'name'     => md5( $url ) . $ext,
                'tmp_name' => $temp,
            );

            $id = media_handle_sideload( $data, self::$_post_id, $title );
            if ( ! is_wp_error( $id ) )
                return update_post_meta( self::$_post_id, '_thumbnail_id', self::$_thumb_id = $id );
        }

        if ( ! is_wp_error( $temp ) )
            @ unlink( $temp );
    }
}