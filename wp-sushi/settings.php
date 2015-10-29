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

if ( ! class_exists( 'Sushi' ) ) {
	wp_die( '<p>&ldquo;A very unpleasant time to be lost my friend; the night is dark and full of terrors.&rdquo;</p>' );
}

// Library root directory and URL.
define( 'LIBRARY_URL', home_url( '/' ) . 'wp-sushi' );
 
require( LIB_ABSPATH . '/default-constants.php' );

swp_library_dir_constants();
swp_admin_constants();

require( LIB_ABSPATH . '/functions.php' );

if ( is_admin() || is_wp_login_page() ) {
	require( SWP_ADMIN_DIR . '/functions.php' );
}

// Sushi Wordpress Starter version model.
define( 'SWP_SYSTEM_MODEL', $this->settings->model );

// Sushi Wordpress Starter version number.
define( 'SWP_SYSTEM_VERSION', $this->settings->version );

// Sushi Wordpress Starter 3.0 default admin skin.
define( 'SWP_STARTER_DEFAULT_ADMIN_SKIN', 'sashimi' );

require( LIB_ABSPATH . '/load.php' );

/**
 * END OF FILE
 * settings.php
 */
?>