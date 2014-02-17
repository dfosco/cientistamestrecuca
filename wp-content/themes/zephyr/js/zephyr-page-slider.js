( function( $ ) {
	var file_frame;
	jQuery('.upload_page_slider').live('click', function( event ){
		event.preventDefault();
		if ( file_frame ) {
			file_frame.remove();
		}
		var target = jQuery( this ).data( 'image_target' );
		file_frame = wp.media.frames.file_frame = wp.media({
			title: jQuery( this ).data( 'uploader_title' ),
			button: { text: jQuery( this ).data( 'uploader_button_text' ), },
			multiple: true
		});
		file_frame.on( 'select', function() {
			attachment = file_frame.state().get('selection').toJSON();
			var insert = '';
			var i = 0;
			jQuery.each( attachment, function() {
				i++;
				if ( i == 1 ) {
					insert += jQuery(this).attr('id');
				} else {
					insert += ',' + jQuery(this).attr('id');
				}
			});
			var oldval = jQuery('#zephyr_page_slider_input').val();
			if ( oldval == '0' || oldval == '' ) { 
				var newval = insert; 
			} else {
				var newval = oldval+','+insert;
			}
			jQuery('#zephyr_page_slider_input').val(newval);
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
			$('#zephyr_page_slider_input').val(newval);
		});
	})
	if ( $('input[name="zephyr_meta_box_post_info"]:checked').val() == 'post-masonry' ) {
		$('.zephyrpostcolumns').show();
	} else {
		$('.zephyrpostcolumns').hide();
	}
	$('input[name="zephyr_meta_box_post_info"]').change(function() {
		if ( this.value == 'post-masonry' ) {
			$('.zephyrpostcolumns').fadeIn(300);
		} else {
			$('.zephyrpostcolumns').fadeOut(300);
		}
	});
} )( jQuery );