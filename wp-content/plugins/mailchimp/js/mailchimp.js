/* Form submission functions for the MailChimp Widget */
;(function($){
	$(function($) {		
		
		if ( ( $.BrowserInfo && $.BrowserInfo.Name === 'ie' ) || ( $.browser && $.browser.msie ) ) {
			// Sushi ~Kai~ modification, clears up IE placeholders
			$('#mc_signup_submit').click( function(e) {		
				$( "#mc_signup_form" ).each( function( i, form ) {							
					$( this ).find( "input:text,textarea" ).each( function( i, el ) {										
						if ( $( el ).attr( 'placeholder' ) === $( el ).val() )
							$( el ).val( '' );
					});			
				});
			});
		}
		
		// Change our submit type from HTML (default) to JS
		$('#mc_submit_type').val('js');
			
		// Attach our form submitter action
		$('#mc_signup_form').ajaxForm({
			url: mailchimpSF.ajax_url, 
			type: 'POST', 
			dataType: 'text',
			beforeSubmit: mc_beforeForm,
			success: mc_success
		});
		
	});
	
	function mc_beforeForm(){		
		// Disable the submit button
		$('#mc_signup_submit').attr("disabled","disabled");		
	}
	function mc_success(data){
		// Re-enable the submit button
		$('#mc_signup_submit').removeAttr("disabled");
		
		// Put the response in the message div
		$('#mc_message').html(data);
		
		// See if we're successful, if so, wipe the fields
		var reg = new RegExp("class='mc_success_msg'", 'i');
		if (reg.test(data)){
			$('#mc_signup_form').each(function(){
				this.reset();
			});
			$('#mc_submit_type').val('js');			
		}
		
		if ( ( $.BrowserInfo && $.BrowserInfo.Name === 'ie' ) || ( $.browser && $.browser.msie ) ) { 
			$( "#mc_signup_form" ).each( function( i, form ) {							
				$( this ).find( "input:text,textarea" ).each( function( i, el ) {										
					if ( '' === $( el ).val() )
						$( el ).val( $( el ).attr( 'placeholder' ) );
				});			
			});
		} 
		
		var $msg = $( "#mc_message" );
		if ( $msg.length )
		{
			var filtered = ( $msg.find( ".mc_error_msg" ).length ) ? $msg.find( ".mc_error_msg" ).html().replace( /BR/g, 'br') : '';
			var lines = filtered.replace( new RegExp( '<br>$' ), '' ).split('<br>');			
			var $fields = $( "#mc_signup_form" ).find( ".mc_merge_var" );			
			
			$fields.each( function( i, el )
			{			
				var hasMatch = false;
				
				if ( lines.length >= 1 )
				{	
					for ( var j=0; j < lines.length; j++ )
					{
						var segs = lines[j].split(':');

						console.log(segs);
						if ( segs.length <= 1 && $("#mc_sushi_using_pretag").val() == 'on' ) 
						{
							console.log( '[Sushi Modified Mailchimp : Distribute validation errors] - Unfiltered error, "' + filtered + '". No need to panic though, just satisfy the said error.' );
							hasMatch = false;
							break;
						}
							
						var name = $(el).find('.mc_input').eq(0).attr('name');
						
						if ( segs[1] === name )
						{
							console.log(segs[1]);

							var err = $( '<span class="mc_sushi_err">' + segs[2] + '</span>' );
							err.mouseover( function(e) { $(this).animate({ opacity: 0}, 800, function() { $(this).hide(); } );	});
							
							$(el).find('.mc_sushi_err').remove();
							$(el).append( err );
							
							hasMatch = true;
						}						
					}
				}			
				
				if ( !hasMatch )
					$(el).find('.mc_sushi_err').remove();
			});				
		}
		
		if ( $.browser )
			$.scrollTo('#mc_signup', {offset: {top: -28}});
	}
})(jQuery);
