/* 
* GLOBAL TOOLS AND UTILITIES SCRIPTS
* Place all custom js/jquery scripts here.
*
*/

/* Initialize and/or execute, code jQuery Scripts here */
jQuery( function($) {
	
	/* Initialize plugins to execute */
	$( document ).SushiPlugins({
		placeholder: true
	});
	
	$( "#cf7-submit" ).click( function(e) {
		$( ".wpcf7-response-output" ).delay( 1000 ).queue( function() {
			var $msg = $( this );
			if ( $msg.length )
			{
				$msg.delay( 4000 ).fadeOut( 500, function() {
									
				});
			}
			$( this ).dequeue(); 
		});
	});
	 
	$( "#contact-form7 #cf7-contactno" ).keydown( function( event ) {
        // Allow: backspace, delete, tab, escape, and enter
        if ( event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 27 || event.keyCode == 13 || 
             // Allow: Ctrl+A Select All
            (event.keyCode == 65 && event.ctrlKey === true) || 
			 // Allow: Ctrl+V Paste
            (event.keyCode == 86 && event.ctrlKey === true) ||
             // Allow: home, end, left, right
            (event.keyCode >= 35 && event.keyCode <= 39)) {
                 // let it happen, don't do anything
                 return;
        }
        else {
            // Ensure that it is a number and stop the keypress
            if (event.shiftKey || (event.keyCode < 48 || event.keyCode > 57) && (event.keyCode < 96 || event.keyCode > 105 )) {
                event.preventDefault(); 
            }   
        }
    });

	$(".current_page_item > a").click( function(e) {
     		e.preventDefault();    
	}).css("cursor", "default");
	
	$("#main-nav ul > li.has-sub > a").removeAttr('href');

	/*$('.comment-blurb .comment-content').readmore({
		  speed: 75,
  		  maxHeight: 75,
  		  moreLink: '<a href="#"><span class="sep"> | </span>Read more</a>',
  		  lessLink: '<a href="#"><span class="sep"> | </span>Close</a>'
	});*/

    $(document).ready(function(){
    	var showChar = 100;
    	var ellipses = '...';
    	var morelink = '<font class="sep"> | </font>Read more';
    	var lesslink = '<font class="sep"> | </font>Close';

        $('li.comment div.comment-content').each(function(){
        	var contentwp = $(this).html();
            var content     = $(this).text();
            var trimcontent = $.trim(content);

        	//console.log(content);

        	if( trimcontent.length > showChar ) {
        		var charsContent = trimcontent.substr(0, showChar);
        		var fullContent  = trimcontent.substr(showChar, trimcontent.length - showChar );

        		var html = charsContent + '<span class="moreellipses">' + ellipses + '&nbsp;</span>&nbsp;<span class="morecontent"><span> ' + fullContent + '</span><a href="#" class="morelink">' + morelink + '</a></span>';
        		//var html = c + '<span class="moreellipses">' + ellipsestext+ '&nbsp;</span><span class="morecontent"><span>' + h + '</span>&nbsp;&nbsp;<a href="" class="morelink">' + moretext + '</a></span>';

        		$(this).html(html);

        		//console.log(html);
        	}
        });


        $('.morelink').click(function(){
        	if($(this).hasClass("less")) {
	            $(this).removeClass("less");
	            $(this).html(morelink);
	        } else {
	            $(this).addClass("less");
	            $(this).html(lesslink);
	        }
	        $(this).parent().prev().toggle();
	        //$(this).parent().toggle();
	        //$(this).prev().find().toggle();
	        $(this).prev().toggle();
	        return false;
        });

    });
	
	parallax_scroll( $ );
	slider( $ );
	horizontal_menu( $ );
	hover_icons( $ );
	bounce_icon( $ );
	back_to_top( $ );
	ajax_next_slide( $ );
	ajax_prev_slide( $ );

	/*Slider Roll Over*/
	$(window).load(function(){
		if($('body').hasClass('category') && ! $('body').hasClass('category-10') && ! $('body #inner').hasClass('blog-category') ) {
			url = window.location.href;
			spliturl = url.split('/');
			newurl = spliturl[0]+"/"+spliturl[1]+"/"+spliturl[2]+"/"+'sectors'+"/"+spliturl[3];
			//alert(newurl);
			window.location.href = newurl;
			//alert(url);
		}

		flag = 0;
		$("#menu-main li").each(function(){
			if($(this).hasClass('current_page_item'))
				flag = 1;
		});
		if( flag == 1 ){
			var $el, leftPos, newWidth;

			/* Add Magic Line markup via JavaScript, because it ain't gonna work without */
					if ( $("#magic-line").length === 0 )	
						$("#menu-main").append("<li id='magic-line'></li>");
				    
				    /* Cache it */
				    var $magicLine = $("#magic-line");

					var current_item = $(".current_page_item");                                                                    
					
					
					if ( $(".current_page_parent").length !== 0 )
					{
						 current_item = $(".current_page_parent");		 
					}

					/*if(!$('body').hasClass('home')){
						$magicLine
				        .width( $(".current_page_item").width() )
				        .css("left", ( ( $(".current_page_item").length > 0 ) ? $(".current_page_item").find("a").offset().left : $("#menu-main li a:first-child").offset().left ) - $("#menu-main").offset().left)
				        .data("origLeft", $magicLine.position().left)
				        .data("origWidth", $magicLine.width());
					}
					
					$("#menu-main > li a").click(function(){
						$magicLine
				        .width( current_item.width() )
				        .css("left", ( ( current_item.length > 0 ) ? current_item.find("a").offset().left : $("#menu-main li a:first-child").offset().left ) - $("#menu-main").offset().left)
				        .data("origLeft", $magicLine.position().left)
				        .data("origWidth", $magicLine.width());
					});*/

					//if($('body').hasClass('page')){
					/*if($('body').hasClass('home'))
						current_width_t = current_item.first().width();
					else*/
						current_width_t = current_item.first().width()-34;
					//current_width_t = current_item.first().width()
					$magicLine
				    .width(current_width_t)
				    .css("left", ( ( current_item.length > 0 ) ? current_item.find("a").offset().left : $("#menu-main li a:first-child").offset().left ) - $("#menu-main").offset().left)
				    .data("origLeft", $magicLine.position().left)
				    .data("origWidth", $magicLine.width());
					//}

				    $("#menu-main li a").hover(function() {     
						
						$el = $(this);
									
						leftPos = $el.offset().left  - $("#menu-main").offset().left;
						
						newWidth = $el.parent().width();
					
						$magicLine.stop().animate({
							left: leftPos,
							width: newWidth
						});
						
						if ( $el.parent().parent().attr("id")  === "menu-main" )
						{
							$magicLine.data("curLeft", leftPos );
							$magicLine.data("curWidth", newWidth );
						}
						else
						{
							$magicLine.stop().animate({
								left: $magicLine.data("curLeft"),
								width: $magicLine.data("curWidth")
							});
						}
				    },
					function() {
						
							$magicLine.stop().animate({
								left: $magicLine.data("origLeft"),
								width: $magicLine.data("origWidth")+34
							});
						
				    });
				    /*Reset*/
				    current_width_t = "";
				}
		});

	
	$(window).load(function(){
		fullWidthImage(1920, 451,'.heading', '');
		fullWidthImage(1920, 451,'.smiley', ''); 
		function fullWidthImage(origWidth, origHeight, imageSelector){
			var args = Array.prototype.slice.call( arguments, 2 );
			$.each(args,function(i,img){
				var newWidth = $(img).width();
				var newHeight = newWidth * origHeight / origWidth;
				$(img).css('height',newHeight);
				
				$( window ).resize( function() {
					newWidth = $(img).width();
					newHeight = newWidth * origHeight / origWidth;
					$(img).css('height',newHeight);
					if($('.heading').length > 0){
						var path = $('#bgUrl').text();
						var imgpath = location.host +'/wp-content/themes/sushi/library/timthumb/timthumb.php?src=' + path + '&h='+ parseInt(newHeight) + '&w=' + parseInt(newWidth);
						$('.heading').css('background-image', 'url("'+ imgpath +'")');
					}
				});
				
			});
		
		}
		
		
		function heading(){
			var newW = $('.heading').width();
			var newH = $('.heading').height();
			var path = $('#bgUrl').text();
			var imgpath = 'http://'+location.host +'/wp-content/themes/sushi/library/timthumb/timthumb.php?src=' + path + '&h='+ newH + '&w=' + newW;
			$('.heading').css('background-image', 'url("'+ imgpath +'")');
		}
		
		heading();
		
		$( window ).resize( function() {
			heading();
		} );
		
		if($('html').hasClass('ie8')){
			var bgURL = $("#bgUrl").text();
			var css1 = "progid:DXImageTransform.Microsoft.AlphaImageLoader( src='"+bgURL+"', sizingMethod='scale');"; 
			var css2 = "'progid:DXImageTransform.Microsoft.AlphaImageLoader( src='"+bgURL+"', sizingMethod='scale')';";
			$(".heading").css('filter',css1);
			$(".heading").css('ms-filter',css2);
		}
	});
	var postlink = $(".postlink").text();
	var posttitle = $(".posttitle").text();
	var twitter = 'http://twitter.com/share?text=';
	var posttwitter = twitter + posttitle + '&url=' + postlink;
	$(".wpsocialite li a.twitter-share").attr('href',posttwitter);
	
	$('body').on('backstretch.show', function() {
        var id = $(this).data("backstretch").index; 
/* 		console.log($(this));
		console.log("id="+id); */
		var height = $('#'+id).data('height');
		var width = $('#'+id).data('width');
		$('.backstretch').find('img').attr({'height' : height, 'width' : width});
	}); 
		
});

// Parallax scroll fade effect
function parallax_scroll( $ ){	
	// Setup variables
	$window = $(window);
	$slide = $('.homeSlide');
	$body = $('body');
	
    //FadeIn all sections   
	$body.imagesLoaded( function() {
		setTimeout(function() {		      
		      // Resize sections
		      adjustWindow();		      
		      // Fade in sections
			  $body.removeClass('loading').addClass('loaded');			  
		}, 800);
	});
	
	function adjustWindow(){		
		// Init Skrollr
		var s = skrollr.init({
		    render: function(data) {		    
		        //Debugging - Log the current scroll position.
		        //console.log(data.curTop);
		    },			
			mobileCheck: function() {
                //hack - forces mobile version to be off
                return false;
            },
			forceHeight: false
		});	
		
		// Get window size
	    winH = $window.height();
	    
	    // Keep minimum height 550
	    if(winH <= 10) {
			winH = 10;
		} 
	    
	    // Resize our slides
	    $slide.height(winH);
	    
	    // Refresh Skrollr after resizing our sections
	    s.refresh($('.homeSlide'));

		$(window).bind('orientationchange', function(event) {
			// Get window size
			winH = $window.height();			
			// Keep minimum height 550
			if(winH <= 10) {
				winH = 10;
			} 			
			// Resize our slides
			$slide.height(winH);			
			// Refresh Skrollr after resizing our sections
			s.refresh($('.homeSlide'));
		});
	}
	
	$( document ).on('scroll', function() {	
		$( '.backstretch' ).css({ opacity: Math.abs( 1 - ($( window ).scrollTop() / $( window ).height()) ) } );
		//$( '.inner-content' ).css({"visibility": "inherit"});
	});
}

// Sliders
function slider( $ ){	
	$(".case-slides").flexslider({
		animation 		: "slide",
		controlNav 		: false,
		directionNav 	: true,
		animationLoop 	: true,
		useCSS 			: false,
		easing 			: "swing", 
	});
	
	$(".testimonial").flexslider({
		animation: "fade",
		directionNav: false,
		smoothHeight: true
	});
	
	if( !$("ol.flex-control-paging li").length ) {
		$("ol.flex-control-paging").addClass("hide");
	}
}

// Menu sliding
function horizontal_menu( $ ){
	$("ul.menu li").hover(function() {
        $(this).children('ul.sub-menu')
            .stop(true, true).delay(25).animate({ "height": "show", "opacity": "show" }, 300 );
    }, function(){
        $(this).children('ul.sub-menu')
            .stop(true, true).delay(25).animate({ "height": "hide", "opacity": "hide" }, 300 );
    });
	// $('ul.sub-menu > li > a').hover(function(){
		// $(this).stop().animate({paddingBottom:10}, 400);
	// },function(){
		// $(this).stop().animate({paddingBottom:0}, 400);
	// });
}

// Social icon animations
function hover_icons( $ ){
	$('#social-icons a').hover(function(){
		$(this).stop().animate({marginTop:-7}, 400);
	},function(){
		$(this).stop().animate({marginTop:0}, 400);
	});
}

// Bouncing icon
function bounce_icon( $ ){
	/*$(function() {
		var $arrow = $("#home-arrow"),flag = 1;
		var timer;
		bounce();
		function bounce() {
			timer = setInterval(function() {
					   if(flag == 1) {
							flag = -1;
						} else {
							flag = 1;
						}
						$arrow.animate({ bottom: "+="+(flag*10)}, 500)
					},500);
		}               

		$arrow.hover(function() {       
			clearInterval(timer);
		}, function() {
			bounce();
		});
	});*/
	
	$('#home-arrow').click(function(event) {
		event.preventDefault();
		var element = $(this).attr('href');
		console.log( element )
		$('html, body').animate({
			scrollTop: $(element).offset().top -170
		}, 1000);
	});
}

// Back to top
function back_to_top( $ ){
	$(window).scroll(function(){
		if($(window).scrollTop() > 200){
			$(".back-to-top").fadeIn(300);
		} else{
			$(".back-to-top").fadeOut(300);
		}
	});	
	$('.back-to-top').click(function() {
		  $('html, body').animate({ scrollTop:0 }, '800');
		  return false;
	});	
}

// Ajax slide
function ajax_next_slide( $ ){
	$( ".single-nav a[rel='next']" ).click( function(e) {
		e.preventDefault();
		var href = $( this ).attr( "href" );
		
		$( '#content-area .content-slide' ).addClass("position-left");	
		$(".post-content").css({
			height:$(".content-slide").height()
		});
		$.ajax({
			url: href,
			type: 'POST',
			dataType: 'html',
			beforeSend: function() {	
			},
			success: function( response ) {
				var $html = $( response );
				var $heading = $html.find( "#content-area .caption" ).html();
				var $bread = $html.find( ".breadcrumbs" ).html();
				var $content = $html.find( "#content-area .content-slide" ).html();
				var $nav = $html.find( "#content-area .single-nav" ).html();
				var $postC = $html.find( "#content-area .post-content" ).height();

				if( $('.post-content').hasClass( 'blog' ) )	{
					$(location).attr('href', href); //added 11-10-2014
				}
				
				$( '#content-area .caption' ).fadeOut( 500, function() {
						$( this ).html( $heading ).fadeIn( 500 );
				});
				$( '.breadcrumbs' ).fadeOut( 500, function() {
						$( this ).html( $bread ).fadeIn( 500 );
				});
				$( '#content-area .single-nav' ).html( $nav );
				$( '#content-area .content-slide' )
					.html( $content )				
					.animate({left: "0"}, 700, 
						function(){
							$( '#content-area .content-slide' ).removeClass("position-left");
							ajax_next_slide($);		
							ajax_prev_slide( $ )
							$( '#content-area .content-slide' ).removeAttr("style");							
							$(".post-content").css({height: "auto"});
						}
					);	
				slider( $ )					
			},
			complete: function() {
			},
			error: function() {
			}
		});		
	});
}

function ajax_prev_slide( $ ){
	$( ".single-nav a[rel='prev']" ).click( function(e) {
		e.preventDefault();
		var href = $( this ).attr( "href" );
		
		$( '#content-area .content-slide' ).addClass("position-right");
		$(".post-content").css({
			height:$(".content-slide").height()
		});
		$.ajax({
			url: href,
			type: 'POST',
			dataType: 'html',
			beforeSend: function() {				
			},
			success: function( response ) {
				var $html = $( response );
				var $heading = $html.find( "#content-area .caption" ).html();
				var $bread = $html.find( ".breadcrumbs" ).html();
				var $content = $html.find( "#content-area .content-slide" ).html();
				var $nav = $html.find( "#content-area .single-nav" ).html();

				if( $('.post-content').hasClass( 'blog' ) )	{	
					$(location).attr('href', href); //added 11-10-2014
				}
				
				$( '#content-area .caption' ).fadeOut( 500, function() {
						$( this ).html( $heading ).fadeIn( 500 );
				});
				$( '.breadcrumbs' ).fadeOut( 500, function() {
						$( this ).html( $bread ).fadeIn( 500 );
				});
				$( '#content-area .single-nav' ).html( $nav );
				$( '#content-area .content-slide' )
					.html( $content )				
					.animate({right: "0"}, 700, 
						function(){
							$( '#content-area .content-slide' ).removeClass("position-right");
							ajax_next_slide($);		
							ajax_prev_slide( $ )
							$( '#content-area .content-slide' ).removeAttr("style");
							$(".post-content").css({height: "auto"});
						}
					);	
				slider( $ )				
			},
			complete: function() {
			
			},
			error: function() {
			}
		});		
	});
}

$( document ).on( 'mouseover', "span.wpcf7-not-valid-tip", function(e) {
    $(this).delay( 1000 ).fadeOut( 'fast', function() {
        if ( $(this).prev().length ) {
            $(this).prev().focus(); 
        }
    });
});

$( document ).on( 'mouseover', "span.wpcf7-not-valid-tip", function(e) {
	$(this).fadeOut( 'fast', function() {
		if ( $(this).prev().length ) {
			$(this).prev().focus(); 
		}
	});
});

$( document ).on( 'focus', ".wpcf7 input[type='text'], .wpcf7 textarea", function() {
	if ( $(this).next().length ) {
		$(this).next().fadeOut( 'fast' );
	}
});

/*
* END OF FILE
* global.js
*/