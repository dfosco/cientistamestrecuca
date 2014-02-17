jQuery(function($) {
	"use strict";
	$.fn.zephir_acc = function() {
		var th = this;
		function collapsePanel(item) {
			var h = item.parent().find('.zephir_acc_heading').height();
			item.css({'max-height':h+'px'}).addClass('collapsed');
		}
		$(this).find('.panel-title a').click( function(e) {
			e.preventDefault();
			var i = $(this).parent().parent().parent().find('.zephir_acc_panel');
			if ( i.hasClass('collapsed') ) {
				collapsePanel($(th).find('.zephir_acc_panel').not('.collapsed'));
				i.css({'max-height':'500px'}).removeClass('collapsed');
			} else {
				collapsePanel(i);
			}
		});
		$(th).find('.zephir_acc_panel').each( function() { collapsePanel($(this)); });
	};
	
	function createCookie(name, value, days) {
		if (days) {
			var date = new Date();
			date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
			var expires = "; expires=" + date.toGMTString();
		}
		else var expires = "";
		document.cookie = name + "=" + value + expires + "; path=/";
	}
	
	function getCookie(c_name) {
		if (document.cookie.length > 0) {
			var c_start = document.cookie.indexOf(c_name + "=");
			if (c_start != -1) {
				c_start = c_start + c_name.length + 1;
				var c_end = document.cookie.indexOf(";", c_start);
				if (c_end == -1) {
					c_end = document.cookie.length;
				}
				return unescape(document.cookie.substring(c_start, c_end));
			}
		}
		return "";
	}
	
	function validateEmail(email) { 
		var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
		return re.test(email);
	}

	function resizeBackVideo(ww, wh) {
		if ( typeof bgv !== 'undefined' ) {
			if ( ww < wh || parseInt( ww / wh ) < 1.7 ) {
				bgv.setPlayerSize(ww*2,wh);
			} else {
				bgv.setPlayerSize(ww,wh);
			}
		} else {
			return false;
		}
	}
	function layoutSidebar(ms) {
		var hh = $('header').outerHeight();
		var fh = $('footer').outerHeight();
		var sh = $(document).height() - fh - hh;
		$('#sidebar').height(sh);
		var mslimit = parseInt($('footer').offset().top - $('.sidebar-list').outerHeight() );
		if ( Zephyr.stickysidebar == '0' ) {
			ms.trigger('detach.ScrollToFixed');
			ms.scrollToFixed({ top: '0', limit : mslimit, removeOffsets: true });
		}
	}
	function rgb2hex(rgb){
		rgb = rgb.match(/^rgb\((\d+),\s*(\d+),\s*(\d+)\)$/);
		if ( rgb ) {
			return "#" +
			("0" + parseInt(rgb[1],10).toString(16)).slice(-2) +
			("0" + parseInt(rgb[2],10).toString(16)).slice(-2) +
			("0" + parseInt(rgb[3],10).toString(16)).slice(-2);		
		}
	}
	function alignLogo() {
		if ( Zephyr.showlinestop == 0 && $('#logo').hasClass('col-md-12') ) {
			var lw = $('header').width() - parseInt($('#logo').css('padding-left')) - parseInt($('#logo').css('padding-right'));
			if ( $('#logo').css('background-image') !== 'none' ) {
				$('.boxed #logo').width(lw+2).css({'marginLeft': '-1px'});
				$('#logo').css({'border-bottom':'none'});
			}
			if ( $('#logo').css('background-color') !== '#FFFFFF' && rgb2hex($('#logo').css('background-color')) !== '#ffffff' ) {
				$('.boxed #logo').width(lw+2).css({'marginLeft': '-1px'})
				$('#logo').css({'border-bottom':'none'});
			}
		}
		if ( Zephyr.showlinesbottom == 0 && $('#nav-search').hasClass('col-md-12') ) {
			var nw = $('header').width() - parseInt($('#nav-search').css('padding-left')) - parseInt($('#nav-search').css('padding-right'));
			if ( $('#nav-search').css('background-color') !== '#FFFFFF' && rgb2hex($('#nav-search').css('background-color')) !== '#ffffff' ) {
				$('.boxed #nav-search').width(nw+2).css({'marginLeft': '-1px'});
				$('#nav-search').css({'marginBottom':'-1px'});
			}		
		}
	}
	$.fn.startCount = function() {
		var countt =  $(this).find('.count');
		if ( !countt.hasClass('counted') ) {
			countt.addClass('counted');
			$({countNum: countt.text()}).animate({countNum: countt.data('count')}, {
			  duration: 2000,
			  easing:'linear',
			  step: function() {
				countt.text(Math.floor(this.countNum));
			  },
			  complete: function() {
				countt.text(this.countNum);
			  }
			});
		}
	}
	$(".fancybox").fancybox();
	$('.zephir_acc').zephir_acc();
	alignLogo();
	var ms = $('.sidebar-list');
	var wh = $(window).height();
	var ww = $(window).width();
	var isms = false;
  	var $el;
	var sidebars =  $('.sidepost');
	if ( Zephyr.sidemenu !== '' && Zephyr.sidemenu !== 'regular' ) {
		$('#mobile-menu-button').attr('data-toggle', 'rien');
		$('#mobile-menu-button').sidr({
			name: 'zephyr-side-menu',
			source: '#header-menu-collapse',
			side: 'right'
		});
		$('.sidr').append('<a href="#" class="sidr-closemenu"></a>');
		$('.sidr-closemenu').click( function(e) {
			e.preventDefault();
			$.sidr('close', 'zephyr-side-menu');
		});
		$('section#main').click(function() {
			$.sidr('close', 'zephyr-side-menu');
		}); 
	}
	if ( ww > 768 ) {
		if ( ms.length > 0 ) {
			ms.height(wh);
			if ( Zephyr.stickysidebar == '0' ) {
				$el = ms.jScrollPane();
				var api = ms.data('jsp');
				var throttleTimeout;
				$(window).bind('resize', function() {
					if (!throttleTimeout) {
						throttleTimeout = setTimeout( function() {
							api.reinitialise();
							throttleTimeout = null;
						}, 50 );
					}
				});
			}
			layoutSidebar(ms);
		}
		if ( Zephyr.stickysidepost == 1 ) {
			sidebars.each( function() {
				var ph = $(this).parent().parent().height();
				var ot = $(this).parent().parent().offset().top;
				var th = $(this).height();
				var limit = ot + (ph - th);
				$(this).scrollToFixed({
					marginTop: 10,
					limit: limit,
					left: 0
				});
			});
		}
		if ( Zephyr.bgvideo ) {
			var isyouTubeUrl = /((http|https):\/\/)?(www\.)?(youtube\.com)(\/)?([a-zA-Z0-9\-\.]+)\/?/.test(Zephyr.bgvideo);
			if ( isyouTubeUrl ) {
				$('body').prepend('<div id="background-video"><video width="'+ww+'" height="'+wh+'"><source type="video/youtube" src="'+Zephyr.bgvideo+'" /></video></div>');
			} else {
				$('body').prepend('<div id="background-video"><video src="'+Zephyr.bgvideo+'"></video></div>');
			}
			var bgv = new MediaElementPlayer( '#background-video video', {
				defaultVideoWidth: '100%',
				defaultVideoHeight: '100%',
				enableAutosize: true,
				loop: true,
				features: [],
				videoWidth: '100%',
				videoHeight: '100%',
				success: function(mediaElement, domObject) {
					mediaElement.addEventListener('canplay', function() {
						mediaElement.setVolume(0);
						mediaElement.play();
					}, false);
				},
			});
			bgv.setPlayerSize(ww,wh);
		}
	}
	$(window).resize( function() {
		alignLogo();
		ww = $(window).width();
		wh = $(window).height();
		if ( ww < 768 ) {
			sidebars.trigger('detach.ScrollToFixed');
			ms.trigger('detach.ScrollToFixed');
			$('#sidebar').height('auto');
		} else {
			if ( Zephyr.bgvideo ) {
				resizeBackVideo(ww,wh);
			}
		}
	});
	$('.form-row input, .form-row textarea').focus( function() {
		var parent = $(this).parent();
		if ( parent.prop("tagName") == 'SPAN') { parent = parent.parent(); }
		parent.find('label').addClass('act');
		parent.addClass('act');
	});
	$('.form-row input, .form-row textarea').focusout( function() {
		var parent = $(this).parent();
		if ( parent.prop("tagName") == 'SPAN') { parent = parent.parent(); }
		parent.find('label').removeClass('act');
		parent.removeClass('act');
	});
	if (typeof $el !== 'undefined')  {
    var extensionPlugin;
		extensionPlugin     = {       
			extPluginOpts   : {
				mouseLeaveFadeSpeed : 500,
				hovertimeout_t      : 1000,
				useTimeout          : false,
				deviceWidth         : 980
			},
			hovertimeout    : null,

			isScrollbarHover: false,
		 
			elementtimeout  : null,
		 
			isScrolling     : false,

			addHoverFunc    : function() {

				if( $(window).width() <= this.extPluginOpts.deviceWidth ) return false;
			 
				var instance        = this;
				$.fn.jspmouseenter  = $.fn.show;
				$.fn.jspmouseleave  = $.fn.fadeOut;

				var $vBar           = this.getContentPane().siblings('.jspVerticalBar').hide();

				$el.bind('mouseenter.jsp',function() {
					$vBar.stop( true, true ).jspmouseenter();
					if( !instance.extPluginOpts.useTimeout ) return false;
					clearTimeout( instance.hovertimeout );
					instance.hovertimeout   = setTimeout(function() {
						if( !instance.isScrolling )
							$vBar.stop( true, true ).jspmouseleave( instance.extPluginOpts.mouseLeaveFadeSpeed || 0 );
					}, instance.extPluginOpts.hovertimeout_t );
				}).bind('mouseleave.jsp',function() {
					if( !instance.extPluginOpts.useTimeout )
						$vBar.stop( true, true ).jspmouseleave( instance.extPluginOpts.mouseLeaveFadeSpeed || 0 );
					else {
					clearTimeout( instance.elementtimeout );
					if( !instance.isScrolling )
							$vBar.stop( true, true ).jspmouseleave( instance.extPluginOpts.mouseLeaveFadeSpeed || 0 );
					}
				});
			 
				if( this.extPluginOpts.useTimeout ) {
					$el.bind('scrollstart.jsp', function() {
						clearTimeout( instance.hovertimeout );
						instance.isScrolling    = true;
						$vBar.stop( true, true ).jspmouseenter();
					}).bind('scrollstop.jsp', function() {
						clearTimeout( instance.hovertimeout );
						instance.isScrolling    = false;
						instance.hovertimeout   = setTimeout(function() {
							if( !instance.isScrollbarHover )
								$vBar.stop( true, true ).jspmouseleave( instance.extPluginOpts.mouseLeaveFadeSpeed || 0 );
						}, instance.extPluginOpts.hovertimeout_t );
					});
					var $vBarWrapper    = $('<div/>').css({
						position    : 'absolute',
						left        : $vBar.css('left'),
						top         : $vBar.css('top'),
						right       : $vBar.css('right'),
						bottom      : $vBar.css('bottom'),
						width       : $vBar.width(),
						height      : $vBar.height()
					}).bind('mouseenter.jsp',function() {
						clearTimeout( instance.hovertimeout );
						clearTimeout( instance.elementtimeout );
						instance.isScrollbarHover   = true;
						instance.elementtimeout = setTimeout(function() {
							$vBar.stop( true, true ).jspmouseenter();
						}, 100 );  

					}).bind('mouseleave.jsp',function() {
						clearTimeout( instance.hovertimeout );
						instance.isScrollbarHover   = false;
						instance.hovertimeout = setTimeout(function() {
							if( !instance.isScrolling )
								$vBar.stop( true, true ).jspmouseleave( instance.extPluginOpts.mouseLeaveFadeSpeed || 0 );
						}, instance.extPluginOpts.hovertimeout_t );
					});
					$vBar.wrap( $vBarWrapper );
				}
			}
		};
		var jspapi = $el.data('jsp');
		$.extend( true, jspapi, extensionPlugin );
		jspapi.addHoverFunc();
	}
	if ( $('.masonry-post').length > 1 ) {
		isms = true;
		$('#content').wrapInner('<div id="mascont"></div>');
		var $zephyr_container = $('#mascont');
		// initialize
		$zephyr_container.imagesLoaded( function() {
			$zephyr_container.isotope({
				itemSelector: '.masonry-post',
				onLayout: function( $elems, instance ) {
					$elems.each( function() {
						var th = $(this).find('.masonry-slide').height();
						var toalign = $(this).find('.masonry-slide').children().first()
						var ch = toalign.height();
						if ( ch < th ) {
							var nh = parseInt((th / 2) - (ch / 2));
							toalign.css({ 'margin-top' : nh+'px' });
						}
					});
				}
			});
		});
		$(window).resize( function() {
			$zephyr_container.isotope( 'reLayout' );
		});
		$('.overflow').click( function() {
			$(this).parent().addClass('noside');
			$(this).find('.over').remove();
		});
		$('.masonry-slide').append('<div class="over"></div>');
		$('.masonry-post-img').mouseleave( function() {
			$(this).removeClass('noside');
			$(this).find('.masonry-slide').append('<div class="over"></div>');
		});
	}
	if ( $('.counter-in').length > 1 ) {
		$(window).scroll(function () {
			if ($(window).scrollTop() >= $('.counter-in').position().top - (wh - 300) ) {
				$('.counter-in').startCount();
			}
		});
	}
	var noload = 0;
	if ( Zephyr.infinite !== '0' ) {
		
		var pageNumber = 2;
		$(window).scroll(function () {
			if  ($(window).scrollTop() == $(document).height() - $(window).height()){
				if ( !noload ) {
				loadArticle(pageNumber);
				pageNumber++;
				}
			}
		});
	}
	$(window).scroll( function() {
		if  ( $(window).scrollTop() > 200 ) {
			$('#scrolltotop').fadeIn(300);
		} else {
			$('#scrolltotop').fadeOut(300);
		}
	});
	$('#scrolltotop').click( function() {
		$("html, body").animate({ scrollTop: "0" });
	});
	function loadArticle(pageNumber) {
		$('#ajaxload').fadeIn(300);
		$.ajax({  
			url: Zephyr.ajaxurl,  
			type:'POST',  
			data: {
				action : 'zephyr_infinite_scroll',
				page_no : pageNumber,
				loop_file : 'loop',
				vars : Zephyr.queryvars,
				mas : isms
			},   
			success: function(html){
				if ( html !== '0' ) {
					if ( isms ) {
						$zephyr_container.isotope( 'insert', $(html) );
					} else {
						$(html).hide().appendTo('#content').fadeIn('300');
					}
					layoutSidebar(ms);
				} else {
					noload = 1;
				}
				$('#ajaxload').fadeOut(300);
			}  
		});  
		return false;  
	}
	
	if ( Zephyr.optin == '1' ) {
		var delay = Zephyr.optindelay * 1000;
		var days = Zephyr.optinhide;
		var cookie = getCookie('zephyrnopopup');
		if ( !cookie ) {
			setTimeout( function() {
				$.fancybox('#zephyr-optin', { 
					padding : 0,
					helpers     : { 
						overlay : {closeClick: false}
					},
					afterClose: function() {
						if ( days ) {
							createCookie('zephyrnopopup', '1', days)
						}
					}
				});
			}, delay);
		}
		$('#zephyr-optin-send').click( function() {
			var name = $('#zephyr-optin-name').val();
			var email = $('#zephyr-optin-mail').val();
			if ( name !== '' && validateEmail(email) ) {
				$.ajax({  
					url: Zephyr.ajaxurl,  
					type:'POST',  
					data: {
						name : name,
						email : email,
						action : 'zephyr_sendoptin'
					},
					success : function() {
						$.fancybox.close();
					}
				});
			} else {
				alert('Please fill in both fields');
			}
		});
	}
	if ( $('body').hasClass('no-sidebar') && $('.boxed').length > 0 ) {
		var hh = $('header').outerHeight();
		var fh = $('footer').outerHeight();
		$('#main').css( 'min-height' , parseInt(wh - hh - fh)+'px' );
	}
});