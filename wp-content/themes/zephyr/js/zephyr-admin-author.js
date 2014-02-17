	var file_frame;
	jQuery('.upload_image_button').live('click', function( event ){
		event.preventDefault();
		if ( file_frame ) {
			file_frame.remove();
			//
		}
		var target = jQuery( this ).data( 'image_target' );
		file_frame = wp.media.frames.file_frame = wp.media({
			title: jQuery( this ).data( 'uploader_title' ),
			button: { text: jQuery( this ).data( 'uploader_button_text' ), },
			multiple: false
		});
		file_frame.on( 'select', function() {
			attachment = file_frame.state().get('selection').first().toJSON();
			// Do something with attachment.id and/or attachment.url here
			jQuery(target).val(attachment.url);
		});
		file_frame.open();
	});