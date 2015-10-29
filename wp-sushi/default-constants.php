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
 
function swp_library_dir_constants()
{	
	define( 'SWP_ADMIN_DIR', LIB_ABSPATH . '/admin' );
	define( 'SWP_ADMIN_URL', LIBRARY_URL . '/admin' );
	
	define( 'SWP_ASSETS_DIR', LIB_ABSPATH . '/assets' );
	define( 'SWP_ASSETS_URL', LIBRARY_URL . '/assets' );	

	define( 'SWP_ADMIN_SKINS_DIR', SWP_ADMIN_DIR . '/armory' );
	define( 'SWP_ADMIN_SKINS_URL', SWP_ADMIN_URL . '/armory' );
	
	define( 'SWP_PACKAGES_DIR', LIB_ABSPATH . '/packages' );
	define( 'SWP_PACKAGES_URL', LIBRARY_URL . '/packages' );
	
	define( 'SWP_TIMTHUMB_URL', SWP_ASSETS_URL . '/scripts/timthumb/timthumb.php' );
}

function swp_admin_constants()
{
	define( 'SWP_MENUPOS_SYSLIB', 501 );
}

function swp_timthumb_default_params_list()
{
	return array( 
		"src",	// image path
		"w",	// width
		"h",	// height
		"q",	// quality ( 1-100 )
		"zc", 	// zoom / crop ( 0-3 )
		"a", 	// alignment ( c, t, l, r, b, tl, tr, bl, br )
		"f", 	// filters ( see documentation )
		"s", 	// sharpen ( see documentation )
		"cc", 	// canvas colour ( hex color )
		"ct" 	// canvas transparency ( true, false )
	);
}

function swp_timthumb_def_params()
{
	return array(
		'q' => 100,
		'zc' => 1,
		'src' => ''
	);
}

/**
 * END OF FILE
 * default-constants.php
 */ 
?>