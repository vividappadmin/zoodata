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
 
class Assets_Manager
{
	var $directories;

	var $assets;

	var $ui;

	var $filters;

	var $rules;

	private $options;

	function __construct()
	{
		$this->filters 	= array( 'css', 'js', 'htc' );
		$this->rules	= array( 'all', 'desktop', 'mobile' );

		add_action( 'init', array( $this, 'init' ) );
		// Options must be hooked to 'swp_options' to be added and prepped internally.
		add_filter( 'swp_options', array( $this, 'init_options' ) );
	}

	function init()
	{
		if ( is_admin() ) 
		{
			add_action( 'admin_init', array( $this, 'init_admin' ) );
		}
	}

	function init_admin()
	{
		$this->load_assets();
	}

	function init_options()
	{
		$prefix		= SushiWP()->option_prefix;

		$def_paths = array(
			'template/css'	=> array(
				'path'			=> get_template_directory_uri() . '/css',
				'enabled'		=> true,
				'default'		=> true,
				'patterns'		=> array( 'css' )
			),
			'template/js'	=> array(
				'path'			=> get_template_directory_uri() . '/js',
				'enabled'		=> true,
				'default'		=> true,
				'patterns'		=> array( 'js' )
			)
		);

		if ( swp_get_option( 'asset_paths' ) !== false ) {
			$directories = swp_get_option( 'asset_paths' );
			$this->directories = unserialize( $directories );
		} else {
			$this->directories = $def_paths;
		}

		$this->assets = array(
			array(
				'filename'	=> 'global.css',
				'rules'		=> 'all',
				'directory'	=> 'template/css',
				'enabled'	=> true
			),
			array(
				'filename'	=> 'global.js',
				'rules'		=> 'all',
				'directory'	=> 'template/js',
				'enabled'	=> true
			)
		);

		if ( swp_get_option( 'assets' ) !== false ) {
			$assets = swp_get_option( 'assets' );
			$this->assets = unserialize( $assets );
		} else {
			$this->assets = $def_assets;
		}

		$this->options = array(
			// Enable Assets Manager
			'asset_manager_enabled'	=> array(
				'name' 		=> $prefix . 'asset_manager_enabled', 
				'default' 	=> '1',
				'group'		=> 'system_assets_manager',
				'autoload'	=> 'yes'
			),
			// Assets directories
			'asset_paths' => array( 
				'name' 		=> $prefix . 'asset_paths', 
				'default' 	=> serialize( $this->directories ),
				'group'		=> 'system_assets_manager',
				'autoload'	=> 'yes'
			),

			'assets'	=> array(
				'name' 		=> $prefix . 'assets', 
				'default' 	=> serialize( $this->assets ),
				'group'		=> 'system_assets_manager',
				'autoload'	=> 'yes'
			)
		);
		
		return array_merge( $options, $this->options );
	}



	function load_assets()
	{

	}

	function add_directory( $id, $path )
	{
		if ( in_array( $id, $this->directories ) ) {
			throw new Exception( '' );
		}
	}

	function add_asset( $dir_id, $filename, $enabled = true, $default = false )
	{

	}
}
?>