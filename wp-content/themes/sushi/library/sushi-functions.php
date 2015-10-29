<?php
/**
 * Native Helper functions.
 */
 
/*
* Retrieves a formatted page title.
*/
if ( ! function_exists( "get_page_title" ) ):

function get_page_title()
{	
	bloginfo("name");

	if ( !( is_home() || is_front_page() ) )			
			echo( " | " );	
	
	wp_title(""); 
	
}
endif;

/*
* Retrieves the post or page ID you are currently viewing.
*/
if ( ! function_exists( "get_current_url" ) ):

function get_current_url()
{	
	$url = (( @$_SERVER["HTTPS"] == "on" ) ? "https://" : "http://" );
	
	if ($_SERVER["SERVER_PORT"] !== "80")
		$url .= $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . $_SERVER["REQUEST_URI"];
	else 
		$url .= $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
		
	return $url;	
}
endif;

/*
* Retrieves the post or page ID you are currently viewing.
*/
if ( ! function_exists( "get_id" ) ):

function get_id( $url = NULL )
{	
	if ( $url === NULL )
		$url = get_current_url();
		
	return url_to_postid( $url );
}
endif;

/*
 * Pre-formatted print_r. For debugging purposes.
 
function _pr( $mixed )
{	
	print( "<pre>" );
	print_r( $mixed );
	print( "</pre>" );
}*/

/*
* Shortens text.
*/
if ( ! function_exists( "shorten_text" ) ):

function shorten_text( $text, $limit = 20, $suffix = "...", $preserve_html = false )
{	
	if ( !$preserve_html )
		$text = strip_tags( $text );
	
	$words = explode( " ", $text );
	$limit = ( $limit > sizeof( $words ) ) ? sizeof( $words ) : $limit;
	$words = array_slice( $words, 0, $limit );
	$text = implode( " ", $words );
	
	return $text . $suffix;
}

endif;

function quotify( $mixed )
{
	switch ( gettype( $mixed ) )
	{
		case 'integer':
			return $mixed;
			
		case 'string':
			return "'" . addslashes( $mixed ) . "'";
			
		default:
			sprintf( "Your argument must be a string or integer." );
			break;
	}
	return false;
}



?>