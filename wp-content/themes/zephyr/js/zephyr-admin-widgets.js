( function( $ ) {
	"use strict";
	var file_frame;
	jQuery('.upload_image_button').live('click', function( event ){
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
			var attachment = file_frame.state().get('selection').toJSON();
			var insert = '';
			var i = 0;
			jQuery.each( attachment, function() {
				i++;
				if ( i == 1 ) {
					insert += jQuery(this).attr('url');
				} else {
					insert += ',' + jQuery(this).attr('url');
				}
			});
			jQuery(target).val(insert);
		});
		file_frame.open();
	});	
	var gal_frame;
	jQuery('.upload_widget_images').live('click', function( event ){
		event.preventDefault();
		if ( gal_frame ) {
			gal_frame.remove();
		}
		var target = jQuery( this ).data( 'image_target' );
		var input = jQuery( this ).data( 'image_input' );
		gal_frame = wp.media.frames.gal_frame = wp.media({
			title: jQuery( this ).data( 'uploader_title' ),
			button: { text: jQuery( this ).data( 'uploader_button_text' ), },
			multiple: true
		});
		gal_frame.on( 'select', function() {
			var attachment = gal_frame.state().get('selection').toJSON();
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
			var oldval = jQuery(input).val();
			if ( oldval == '0' || oldval == '' ) { 
				var newval = insert; 
			} else {
				var newval = oldval+','+insert;
			}
			jQuery(input).val(newval);
			jQuery.post(ajaxurl, {action:'wpsePTS_grid_action_ajax', ids : newval }, function(data){
				jQuery(target).html(data);
			});
		});
		gal_frame.open();
	});
	jQuery('.zephyr_uploaded_img .media-modal-close').live('click', function(e) {
		e.preventDefault();
		var parent = $(this).parent();
		var uploadedto = parent.parent();
		var input = uploadedto.parent().find('input[type=hidden]');
		var attid = parent.data('attid');
		var newval = '';
		var i = parseInt(0);
		parent.fadeOut(300, function() {
			parent.remove();
			uploadedto.find('.zephyr_uploaded_img').each( function() {			
				i++;
				if ( i == 1 ) {
					newval += '' + $(this).data('attid');
				} else {
					newval += ',' + $(this).data('attid');
				}
			});
			input.val(newval);
		});
	});
} )( jQuery );