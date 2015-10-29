<?php
/**
 * Sushi Worpdress Starter System
 *
 * Sashimi theme configuration file.
 *
 * @author Sushi Katana team
 * @copyright 2013 Sushi Digital Pty. Ltd.
 * @since Sashimi 3.0
 * @package WordPress
 * @subpackage Sushi_WP
 */

class DavidReid_Skin
{
	/**
	 * @var Sushi The single instance of the class	 
	 */	
	protected static $_instance = null;
	
	var $settings;
	
	var $id;
	
	var $name;
	
	var $description;
	
	var $author;
	
	var $author_url;
	
	var $version;
	
	/**
	 * Singleton
	 *
	 * Ensures only one instance of DavidReid_Skin class is loaded or can be loaded.
	 *
	 * @see DavidReid_Skin()
	 * @return DavidReid_Skin - Main instance
	 */
	public static function get_instance() 
	{
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}	
	
	function __construct()
	{
		$this->id 			= 'davidreid';
		$this->name 		= 'David Reid';
		$this->description 	= 'David Reid Group skin';
		$this->author 		= 'Sushi Katana Division';
		$this->author_url 	= '';
		$this->version 		= '1.0';
			
		$this->settings = array(
			'path'	=> sanitize_path( SWP_ADMIN_SKINS_DIR . '/' . $this->id ),
			'url'	=> SWP_ADMIN_SKINS_URL . '/' . $this->id
		);		
		
		add_filter( 'swp_admin_footer_text', array( $this, 'admin_footer_text' ) );
		add_filter( 'swp_update_footer', array( $this, 'update_footer' ) );
		add_action( 'swp_admin_skin_loaded', array( $this, 'init' ) );
	}
	
	function init()
	{
		swp_add_css( 'sushi-admin-skin-dashboard', $this->settings['url'] . '/css/dashboard.css' );		
		
		if ( is_wp_login_page() )
		{
			$this->init_actions_and_filters();
		}	
		
	}

	function init_actions_and_filters()
	{
		add_action( 'login_head', array( $this, 'load_login_scripts' ), 99 );
		
		add_filter( 'login_speech', array( $this, 'filter_speech' ) );
		add_filter( 'login_message', array( $this, 'filter_message' ) );
		add_filter( 'login_errors', array( $this, 'filter_errors' ) );
		add_filter( 'login_messages', array( $this, 'filter_messages' ) );		
	}

	function load_login_scripts()
	{	
		echo create_favicon_link( get_template_directory_uri() . '/favicon.ico' ) . "\n";
		echo ie_conditional( 'lt', 9, '<script src="' .  SWP_ASSETS_URL . '/scripts/html5.js"></script>
	<style type="text/css">
		* { *behavior: url( "' .  SWP_ASSETS_URL . '/scripts/boxsizing.htc" ); }
	</style>' );
	}
	
	function admin_footer_text( $text )
	{
		return sprintf( 'Powered by <a href="http://davidreidgroup.com/" target="_blank">David Reid Group</a>' );
	}

	function update_footer( $text )
	{
		return sprintf( '<strong>System Version:</strong> <a href="#" onclick="return false;">%s</a>', SushiWP()->settings->version );
	}

	function get_image_src( $file, $force_echo = false )
	{	
		$path = $this->settings['url'] . '/images';
		$image = $path . '/' . $file;

		if ( $force_echo )
			echo $image;

		return $image;
	}

	/**
	 * Filters speech outputs.
	 *
	 * @param string $speech The speech to filter
	 */
	function filter_speech( $speech )
	{
		$speech = '<p class="balloon single"><span>' . $speech . '</span></p>';	

		return $speech . "\n";
	}

	/**
	 * Filters message outputs.
	 *
	 * @param string $message The message to filter
	 */
	function filter_message( $message )
	{
		if ( empty( $message ) )
			return null;

		$message = '<p class="balloon wp-msg"><span>' . strip_tags( $message, '<a><em><strong>' ) . '</span></p>';

		return $message . "\n";
	}

	/**
	 * Filters error outputs.
	 *
	 * @param string $errors The errors to filter
	 */
	function filter_errors( $errors )
	{
		$errors = '<p class="balloon error"><span>' . str_replace( array( '<strong>ERROR</strong>: ', '<a' ), array( '', '<a' ), $errors ) . '</span></p>';

		return $errors . "\n";
	}

	/**
	 * Filters messages.
	 *
	 * @param string $messages The messages to filter
	 */
	function filter_messages( $messages )
	{
		$messages = '<p class="balloon msg"><span>' . $messages . '</span></p>';

		return $messages . "\n";
	}
}

function davidreid_skin()
{
	return DavidReid_Skin::get_instance();
}
add_filter( 'swp_set_active_skin', 'davidreid_skin' );
?>