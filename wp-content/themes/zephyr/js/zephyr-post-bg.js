( function( $ ) {
	"use strict";
	var file_frame;
	jQuery('.upload_page_slider').live('click', function( event ){
		event.preventDefault();
		if ( file_frame ) {
			file_frame.remove();
		}
		var target = jQuery( this ).data( 'image_target' );
		var input = jQuery( this ).data( 'image_input' );
		file_frame = wp.media.frames.file_frame = wp.media({
			title: jQuery( this ).data( 'uploader_title' ),
			button: { text: jQuery( this ).data( 'uploader_button_text' ), },
			multiple: false
		});
		file_frame.on( 'select', function() {
			attachment = file_frame.state().get('selection').first().toJSON();
			var newval = attachment.id;
			jQuery(input).val(newval);
			jQuery.post(ajaxurl, {action:'wpsePTS_grid_action_ajax', ids : newval }, function(data){
				jQuery(target).html(data);
			});
		});
		file_frame.open();
	});
	jQuery('.zephyr_uploaded_img .media-modal-close').live('click', function(e) {
		e.preventDefault();
		var parent = $(this).parent();
		var attid = parent.data('attid');
		var newval = '';
		var i = parseInt(0);
		parent.fadeOut(300, function() {
			parent.remove();
			$('.zephyr_uploaded_img').each( function() {			
				i++;
				if ( i == 1 ) {
					newval += '' + $(this).data('attid');
				} else {
					newval += ',' + $(this).data('attid');
				}
			});
			$('#zephyr_post_bg').val(newval);
		});
	});
	if ( $('.post-format:checked').val() == 'gallery' ) {
		$('#postgal').show();
	}
	$('.post-format').change(function() {
		if ( this.value == 'gallery' ) {
			$('#postgal').fadeIn(300);
		} else {
			$('#postgal').fadeOut(300);
		}
	});
} )( jQuery );