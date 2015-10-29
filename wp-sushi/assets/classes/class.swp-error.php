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

class SWP_Error
{
	var $errors;

	function __construct()
	{
		$this->errors = array();
	}

	function add( $code, $message, $data = array() )
	{
		$error[$code] = array(
			'message'	=> $message,
			'data'		=> $data
		);

		$this->errors[] = $error;
	}

	function remove( $code )
	{
		if ( ! isset( $this->errors[$code] ) ) {
			return false;
		}

		unset( $this->errors[$code] );
	}

	function get_error_message( $code )
	{
		if ( ! isset( $this->errors[$code] ) ) {
			return false;
		}

		return $this->errors[$code]['message'];
	}

	function get_error_codes()
	{
		return array_keys( $this->errors );
	}

	function get_error( $code )
	{
		if ( ! isset( $this->errors[$code] ) ) {
			return false;
		}

		return $this->errors[$code];
	}
}

/*
* END OF FILE
* asses/classes/class.swp-error.php
*/
?>