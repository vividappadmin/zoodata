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

function swp_upload_dir( $index )
{
	$indeces = array( 'path', 'url', 'subdir', 'basedir', 'baseurl', 'error' );	
	if ( in_array( $index, $indeces ) ) {
		$udir = wp_upload_dir();
		return sanitize_path( $udir[$index] );
	}	
	return NULL;
}

function swp_assets_dir( $file = '' )
{
	$dir = SWP_ASSETS_DIR;

	if ( ! empty( $file ) )
		$dir .= '/' . ltrim( $file, '/' );
	
	return ( file_exists( $dir ) ) ? $dir : NULL;
}

function swp_assets_url( $file = '' )
{
	$url = SWP_ASSETS_URL;

	if ( !empty( $file ) )
		$url .= '/' . ltrim( $file, '/' );

	return $url;
}

function swp_admin_dir( $file = '' )
{
	$dir = SWP_ADMIN_DIR;

	if ( ! empty( $file ) )
		$dir .= '/' . ltrim( $file, '/' );
	
	return ( file_exists( $dir ) ) ? $dir : NULL;
}

function swp_admin_url( $file = '' )
{
	$url = SWP_ADMIN_URL;

	if ( !empty( $file ) )
		$url .= '/' . ltrim( $file, '/' );

	return $url;
}

function swp_timthumb_url()
{
	if ( ! defined( 'SWP_TIMTHUMB_URL' ) )
		return SWP_ASSETS_URL . '/scripts/timthumb/timthumb.php';
		
	return SWP_TIMTHUMB_URL;
}

function swp_admin_skin_dir( $file = '' )
{
	$dir = SWP_ADMIN_SKINS_DIR;

	if ( ! empty( $file ) )
		$dir .= '/' . ltrim( $file, '/' );
	
	return ( file_exists( $dir ) ) ? sanitize_path( $dir ) : NULL;
}

function swp_admin_skin_url( $file = '' )
{
	$url = SWP_ADMIN_SKINS_URL . '/' . SWP_CURRENT_SKIN_URL;

	if ( !empty( $file ) )
		$url .= '/' . ltrim( $file, '/' );

	return $url;
}

function swp_active_admin_skin_url( $file = '' )
{	
	$url = SushiWP()->current_admin_skin->settings['url'];

	if ( !empty( $file ) )
		$url .= '/' . ltrim( $file, '/' );

	return $url;
}

function swp_option_state( $option )
{	
	$value = SushiWP()->swp_get_option( $option );
	
	if ( ! empty( $value ) ) {
		return true;
	}	
	return false;
}
 
/**
 * Setup the sushi wp theme.
 */
function swp_after_theme_setup()
{
	// This theme uses a custom image size for featured images, displayed on "standard" posts.
	add_theme_support( 'post-thumbnails' );
	// Enable HTML5 output for the search form
	add_theme_support( 'html5', array('search-form') );	
	// This theme uses wp_nav_menu() in one location.
	register_nav_menu( 'primary', 'Main Navigation' );	
	// Hide/Show Admin Bar
	if ( SushiWP()->swp_get_option( 'hide_wp_adminbar' ) == 1 ) {			
		show_admin_bar( false );
	} else {
		show_admin_bar( true );
	}
	// Remove WordPress Tag Generator
	remove_action('wp_head', 'wp_generator');
	// After theme setup extension
	do_action( 'swp_after_theme_setup' );
}
add_action( 'after_setup_theme', 'swp_after_theme_setup' );

function swp_output_google_ad_code()
{
	$code = SushiWP()->swp_get_option( 'google_ad_code', '' );
	
	if ( empty( $code ) ) {
		return;
	}
	
	echo sprintf( '<script>%2$s%1$s%2$s</script>', strip_tags( $code ), PHP_EOL );
}

/**
 * Creates an argument for nav menu item. This does not create an actual menu item. 
 *
 * @since 3.2
 * @return array
 */
function swp_create_nav_menu_item( $title, $classes, $url, $description = '', $status = 'publish', $menu_item_id = 0, $object_id = 0, $object = '', $parent_id = 0, $position = 0, $type = 'custom', $attr_title = '', $target = '', $xfn = '' )
{
	$args = array(
		'menu-item-db-id' => $menu_item_id,
		'menu-item-object-id' => $object_id,
		'menu-item-object' => $object,
		'menu-item-parent-id' => $parent_id,
		'menu-item-position' => $position,
		'menu-item-type' => $type,
		'menu-item-title' => $title,
		'menu-item-url' => $url,
		'menu-item-description' => $description,
		'menu-item-attr-title' => $attr_title,
		'menu-item-target' => $target,
		'menu-item-classes' => ( empty( $classes ) ? sanitize_title( $title ) : $classes ),
		'menu-item-xfn' => $xfn,
		'menu-item-status' => $status,
	);
	
	return $args;
}

/**
 * Create a nav menu.
 *
 * @param string $menu_name
 * @param array $items (optional) An array that contains single or multiple nav menu item arguments. @see swp_create_nav_menu_item().
 * @since 3.2
 * @return array
 */
function swp_create_nav_menu( $menu_name, $items = false )
{
	if ( ! wp_get_nav_menu_object( $menu_name ) ) {
		// create menu
		$menu_id = wp_create_nav_menu( $menu_name );
		// create items
		if ( $items !== false ) {
			foreach( $items as $item ) {
				wp_update_nav_menu_item( $menu_id, 0, $item );
			}
		}
		// return menu id
		return $menu_id;
	}
	
	return false;
}

function swp_set_main_nav( $menu_id )
{
	
}

/**
 * END OF FILE
 * core.php
 */
?>