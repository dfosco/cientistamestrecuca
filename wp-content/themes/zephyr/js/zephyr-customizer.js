( function( $ ) {
	wp.customize( 'zephyr_line_color', function( value ) {
		value.bind( function( newval ) {
			$('header, footer, .sidew, .sidew-r, .contw, .sidebar-list li, #category-top, #content.contw, #content.contl, .search-results #content > .col-md-12 > h1:after, .page #content > .col-md-12 > h1:after, .navbar-default .navbar-collapse, .container.boxed').css('border-color', newval );
			$('.title-sep, #author-top .separator, .zephyr-chapter-top .separator').css('background-color', newval );
			$('nav#main-top ul li ul:before').css({ 'border-color': 'transparent transparent '+newval });
		} );
	} );
	wp.customize( 'zephyr_accent_color', function( value ) {
		value.bind( function( newval ) {
			$('.accentbg, .zephyr-tags a.zephyr-tag:hover, .widget_calendar #wp-calendar td a:hover, .form-submit input#submit, .tagcloud a:hover, #zephyr-widget-sidebar .carousel-indicators li.active, .form-submit input').css('background-color', newval );
			$('.accentborder').css('border-color', newval);
			$('.accentcolor, .comments-list .bypostauthor h5, .comments-list .bypostauthor h5 a').css('color',newval);
		} );
	} );
	wp.customize( 'zephyr_back_over', function( value ) {
		value.bind( function( newval ) {
			var val = newval / 100;
			$('#bgoverlay').css({
				'-ms-filter' : 'progid:DXImageTransform.Microsoft.Alpha(Opacity='+newval+')',
				'filter' : 'alpha(opacity='+newval+')',
				'-moz-opacity' : val,
				'-khtml-opacity' : val,
				'opacity' : val
			});
		});
	});
	wp.customize( 'zephyr_top_header_color', function( value ) {
		value.bind( function( newval ) {
			$('#logo.col-md-12').css('background-color', newval);
		} );
	} );
	wp.customize( 'zephyr_bottom_header_color', function( value ) {
		value.bind( function( newval ) {
			$('#nav-search.col-md-12').css('background-color', newval);
		} );
	} );
} )( jQuery );