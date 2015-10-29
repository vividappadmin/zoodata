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

function swp_js_redirect( $url )
{
	echo '<script type="text/javascript">';
	echo sprintf( 'swp_redirect( "%s" );', $url );
	echo '</script>';	
}

function swp_get_tips( $id )
{
	$func = 'tips_' . $id;

	if ( empty( $id ) || ! function_exists( $func ) ) {		
		return '<p><em>Oops! Sorry, unable to load the associated guide. <code> Error: Missing Resource.</code> Please contact a Starter Administrator.</em></p>';
	}	
	
	return call_user_func( $func );
}

/*
* END OF FILE
* admin/functions.php
*/
?>