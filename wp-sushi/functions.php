<?php
/**
 * Sushi WordPress Starter System
 * Copyright (C) 2013-2014, Sushi Digital Pty. Ltd. - http://sushidigital.com.au
 * 
 * This program is not a free software; this program is an intellectual
 * property of Sushi Digital Pty. Ltd. and CANNOT be REDISTRIBUTED, COPIED, 
 * MODIFIED or USED by ANY MEANS outside and/or unrelated to the company.
 * Disregarding this copyright notice is an act of copyright infringement, 
 * and is subject to civil and criminal penalties.
 */

/**
 * Displays a pre-formatted print_r. Useful for debugging and tracing.
 *
 * @since 2.1
 *
 * @param mixed $mixed The data to print.
 */
function _pr( $mixed )
{	
	print( "<pre>" );
	print_r( $mixed );
	print( "</pre>" );
}

/**
 * Just a var_dump shortcut.
 *
 * @since 3.1
 *
 * @param mixed $mixed The data to dump.
 */
function _vd( $mixed )
{	
	print( "<pre>" );
	var_dump( $mixed );
	print( "</pre>" );
}

/**
 * Get the current URL.
 *
 * @since Sashimi 3.0
 * @return string The current URL.
 */
function current_url()
{	
	$url = (( @$_SERVER["HTTPS"] == "on" ) ? "https://" : "http://" );
	
	if ($_SERVER["SERVER_PORT"] !== "80")
		$url .= $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . $_SERVER["REQUEST_URI"];
	else 
		$url .= $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
		
	return $url;
}

function sanitize_path( $path )
{
	return str_replace( '\\', '/', $path );
}

/**
 * Properly quotes a string or integer variable. Useful with SQL query strings.
 *
 * @since Sashimi 3.0
 *
 * @param int|string $mixed The variable to quote.
 * @return int|string The quoted string or non-quoted integer.
 */
function swp_enquote( $mixed )
{
	switch ( gettype( $mixed ) ) 
	{
		case 'integer':
			return $mixed;
			
		case 'string':
			return "'" . addslashes( $mixed ) . "'";
			
		default:
			return $mixed;
			break;
	}
}

function callback_require( $args, $source )
{
	return create_function( $args, "require( '" . $source . "' );" );
}

/**
 * Identifies if you are currently viewing WP login page.
 *
 * @since 2.2
 * 
 * @return bool Returns true or false.
 */
function is_wp_login_page()
{
    return in_array( $GLOBALS['pagenow'], array( 'wp-login.php', 'wp-register.php' ) );
}

function is_ipad()
{
	return ( strpos( $_SERVER['HTTP_USER_AGENT'], 'iPad;' ) !== false ) ? true : false;
}

function is_ipod()
{
	return ( strpos( $_SERVER['HTTP_USER_AGENT'], 'iPod;' ) !== false ) ? true : false;
}

function is_iphone()
{
	return ( strpos( $_SERVER['HTTP_USER_AGENT'], 'iPhone;' ) !== false ) ? true : false;
}

/**
 * Get the ID of the current loaded template or permalink.
 *
 * @since Sashimi 3.0
 *
 * @param string $url Optional. A wordpress permalink.
 * @return int ID of the post, page or category that resides at the current or given URL, or 0 on failure.
 */
function swp_template_id( $permalink = NULL )
{	
	global $wp_query;
	
	if ( ! empty( $permalink ) )						
		return url_to_postid( $permalink );		
	
	return isset( $wp_query->queried_object_id ) ? $wp_query->queried_object_id : 0;
}

/**
 * Creates an external stylesheet link.
 * 
 * $media values can be, 'all', 'screen', 'print', 'handheld', etc.
 * For all media types visit http://www.w3schools.com/css/css_mediatypes.asp.
 *
 * @since Sashimi 3.0
 *
 * @param string $file The stylesheet URL.
 * @param string $media Optional. The media type. Default is 'all'.
 * @param stromg $id Optional. ID attribute of the link.
 * @return string Link tag of an external stylesheet.
 */
function create_css_link( $file, $media = 'all', $id = '' )
{
	$media_types = array( 'all', 'aural', 'braille', 'embossed', 'handheld', 'print', 'projection', 'screen', 'tty', 'tv' );
	$media = in_array( $media, $media_types ) ? $media : 'all';
	
	return sprintf( '<link%s rel="stylesheet" type="text/css" href="%s" media="%s" />', ( !empty( $id ) ) ? ' id="'.$id.'"' : $id, $file, $media );
}

/**
 * Creates a favicon link.
 * 
 * @since Sashimi 3.0
 *
 * @param string $file The favicon URL.
 * @return string Link tag of the favicon.
 */
function create_favicon_link( $file )
{
	return sprintf( '<link rel="shortcut icon" type="image/x-icon" href="%s?%s" />', $file, 't=' . time() );
}

/**
 * Creates an external javascript script file.
 *
 * @since Sashimi 3.0
 *
 * @param string $src The URL of an external script file.
 * @return string External script tag.
 */
function create_ext_js( $src )
{
	return sprintf( '<script type="text/javascript" src="%s"></script>', $src );
}

/**
 * Prints an IE version conditional statement.
 *
 * @since Sashimi 3.0
 *
 * @param string $condition The condition string (lt, lte, etc.).
 * @param string $version IE's version to evaluate.
 * @param string $content The stuff to be executed inside (styles, scripts, etc.). 
 * @return string The conditional statement.
 */
function ie_conditional( $condition, $version, $content )
{
	return sprintf( '<!--[if %s IE %s]>%4$s%s%4$s<![endif]-->%4$s', $condition, $version, $content, "\n" );
}

/**
 * Wrapper function. Registers a stylesheet file into wordpress.
 *
 * @since Sashimi 3.0
 */
function swp_add_css( $handle, $src, $deps = array(), $media = 'all', $renew = false )
{
	$media_types = array( 'all', 'aural', 'braille', 'embossed', 'handheld', 'print', 'projection', 'screen', 'tty', 'tv' );
	$media = in_array( $media, $media_types ) ? $media : 'all';
	
	if ( $renew ) wp_deregister_style( $handle );
	
	wp_register_style( $handle, $src, $deps, SWP_SYSTEM_VERSION, $media );	
}

/**
 * Wrapper function. Loads or enqueues a registered stylesheet.
 *
 * @since Sashimi 3.0
 */
function swp_load_css( $handle )
{
	wp_enqueue_style( $handle );
}

function swp_addnload_css( $handle, $src, $deps = array(), $media = 'all', $renew = false )
{
	swp_add_css( $handle, $src, $deps, $media, $renew );
	swp_load_css( $handle );
}

function swp_add_js( $handle, $src, $deps = array(), $in_footer = false, $renew = false )
{
	if ( $renew ) wp_deregister_script( $handle );
		
	wp_register_script( $handle, $src, $deps, SWP_SYSTEM_VERSION, $in_footer );
	
}

/**
 * Wrapper function. Loads or enqueues a registered script.
 *
 * @since Sashimi 3.0
 */
function swp_load_js( $handle )
{
	wp_enqueue_script( $handle );
}

function swp_addnload_js( $handle, $src, $deps = array(), $in_footer = false, $renew = false )
{
	swp_add_js( $handle, $src, $deps, $in_footer, $renew );
	swp_load_js( $handle );
}

function swp_post_id_by_slug( $slug )
{
	$post = get_page_by_path( $slug );
	if ( $post ) {
		return $post->ID;
	}
	
	return null;
}

function swp_get_highest_role_cap( $role )
{
	$cap = 'activate_plugins';

	switch ( $role ) {
		case 'administrator':			
		default:
			$cap = 'activate_plugins';
			break;
		case 'editor':
			$cap = 'moderate_comments';
			break;
		case 'author':
			$cap = 'edit_published_posts';
			break;
		case 'contributor':
			$cap = 'edit_posts';
			break;
		case 'subscriber':
			$cap = 'read';
			break;
	}

	return $cap;
}

/**
 * END OF FILE
 * functions.php
 */
?>