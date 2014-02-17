jQuery(document).ready(function($) {  
	"use strict";
	$('.zephyr-social-input').click( function() {
		var socialrows = $('#socialrows');
		var link = $('#zsociallink').val();
 		var selected = $('#ddslick').data('ddslick');
 		var value = link+","+selected.selectedData.imageSrc;
 		var newinput = '<input type="hidden" value="'+value+'" name="theme_zephyr_options[socials][]" />';
 		socialrows.append('<div class="socialrow"><div class="socials-list"><img src="'+selected.selectedData.imageSrc+'" /><span> - '+link+'</span> <a href="#" class="remove-social">Remove</a>'+newinput+'</div></div>');
		$('#zsociallink').val('');
		$('#ddslick').ddslick('select', {index: 0 })
	});
	$('#ddslick').ddslick({
		height : 300,
		width : 200
	});
	$('.remove-social').live('click', function() {
		$(this).parent().parent().remove();
	});
});