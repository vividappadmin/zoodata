<?php
/**
 * Require all necessary libraries, files, etc.
 */
require_once( 'sushi-constants.php' );
require_once( 'sushi-functions.php' );
require_once( 'sushi-admin.php' );
require_once( 'sushi-media.php' );

/**
 * Sushi Digital Wordpress helper class.
 *
 * @category 	Wordpress
 * @package 	WordPress
 * @subpackage	Sushi
 * @author		~Kai~
 * @version		Version 1.0.0
 * @copyright	Copyright (c) 2013 Sushi Digital Pty. Ltd.( http://www.sushidigital.com.au )
 * @since		Class available since Release 1.0.0
 *
 */
class Sushi_WP
{
	// Singleton
	static $_instance = null;
	
	// Timthumb valid parameters
	protected $timthumbParams = array( 
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
	// Timthumb initial parameters
	protected $timthumbDefault = array(
		"q" => 95,
		"zc" => 1
	);
	//
	protected $mediaDefault = array(
		'post_status' => 'inherit',
		'post_type' => 'attachment',
		'order' => 'ASC',
		'orderby' => 'ID'
	);
	
	// Sushi Library directory path.
	public $libraryDir;
	// Timthumbs directory.
	public $timthumbURL;
	// Home URL.
	public $homeURL;
	// Admin directory URL. /wp-admin
	public $adminURL;
	// Includes directory URL. /wp-includes
	public $includesURL;
	// Content directory URL. /wp-content
	public $contentURL;
	// Plugins directory URL. /wp-content/plugins
	public $pluginsURL;
	// Upload directory URL. /wp-content/uploads
	public $uploadDir;
	// Active theme template directory URL.
	public $templateURL;
	// Stylesheet URL
	public $stylesheetURL;	
	
	/**
	 * Constructor.
	 */
	public function __construct( $options = null )
	{
		$this->initialize();
		
		// Add Sushi Theme settings to Dashboard.
		add_action( 'admin_menu', 'add_sushi_theme_menu' );
	}
	
	/**
	 * Initialize Sushi_WP.
	 */
	private function initialize()
	{
		$this->libraryDir 		= dirname(__FILE__);
		$this->homeURL 			= home_url();
		$this->adminURL 		= rtrim( admin_url(), '/' );
		$this->includesURL 		= rtrim( includes_url(), '/' );
		$this->contentURL 		= content_url();
		$this->pluginsURL 		= plugins_url();
		$this->uploadDir 		= wp_upload_dir();
		$this->templateURL 		= get_bloginfo( 'template_url' );
		$this->stylesheetURL	= get_bloginfo( 'stylesheet_url' );
		$this->timthumbURL 		= $this->templateURL . '/' . basename( $this->libraryDir ) . '/timthumb/timthumb.php';		
	}
	
	/**
	 * Returns all medias in Media Library.
	 *
	 * @return array	array of Sushi_WP_Media objects or empty array.
	 */
	public function getAllMedias()
	{	
		return Sushi_WP_Media::getMedia();
	}
	
	/**
	 * Returns medias by ID.
	 *
	 * @param string/integer	$title	the ID of media [ID]
	 *
	 * @return object	the Sushi_WP_Media object or null.
	 */
	public function getMediaById( $id )
	{
		if ( intval( $id ) )
		{
			$media = Sushi_WP_Media::getMedia( array( "ID" => $id ) );
			return is_null( $media ) ? null : current( $media );
		}
		return null;
	}
	
	/**
	 * Returns medias by title.
	 *
	 * @param string	$title	the title of media [post_title]
	 *
	 * @return array	array of Sushi_WP_Media objects or empty array.
	 */
	public function getMediaByTitle( $title )
	{
		return Sushi_WP_Media::getMedia( array( "post_title" => $title ) );
	}
	
	/**
	 * Returns medias by mime type.
	 *
	 * @param string	$type	the mime type or media type [post_mime_type]
	 *
	 * @return array	array of Sushi_WP_Media objects or empty array.
	 */
	public function getMediaByMimeType( $type )
	{
		switch ( $type )
		{
			case 'jpeg':
			case 'jpg':
			case 'png':
			case 'gif':
			case 'bmp':
			case 'ico':
			case 'tiff':
			
				if ( $type === 'jpg' ) $type = 'jpeg';				
				if ( $type === 'ico' ) $type = 'x-icon';					
				$type = 'image/' . $type;
				
				return Sushi_WP_Media::getMedia( array( "post_mime_type" => $type ) );
				
			case 'image': // common image types
				return array_merge(
					Sushi_WP_Media::getMedia( array( "post_mime_type" => 'image/jpeg' ) ),
					Sushi_WP_Media::getMedia( array( "post_mime_type" => 'image/png' ) ),
					Sushi_WP_Media::getMedia( array( "post_mime_type" => 'image/gif' ) )
				);
				
			case 'mp3':
				return Sushi_WP_Media::getMedia( array( "post_mime_type" => 'audio/mpeg' ) );
			
			default:
				return Sushi_WP_Media::getMedia( array( "post_mime_type" => $type ) );
		}
	}
	
	/**
	 * Returns timthumb src.
	 *
	 * @param array	$params	array of timthumb parameters
	 *
	 * @return string	the src string value of the image.
	 */
	public function getTimthumbSrc( array $params )
	{
		$params = array_merge( $this->timthumbDefault, $params );
		foreach ( $params as $key => $val )
		{
			if ( in_array( $key, $this->timthumbParams ) )
			{
				$query[] = $key . '=' . $val;
			}
		}
		return $this->timthumbURL . '?' . implode( '&', $query );
	}
	
	/**
	 * Returns timthumbed <img>.
	 *
	 * @param array	$attributes	array of html attributes
	 * @param array	$params		array of timthumb parameters
	 * 
	 * @return html	the <img> element.
	 */
	public function getTimthumbImage( array $attributes, array $params )
	{
		$params = array_merge( $this->timthumbDefault, $params );
		foreach ( $attributes as $key => $val )
		{
			$attrs[] = $key . '="' . $val . '"';
		}
		return '<img src="' . $this->getTimthumbSrc( $params ) . '" ' . implode( " ", $attrs ) . ' />';
	}
	
	/**
	 * Returns copyright text.
	 *
	 * @return string	the copyright text.
	 */
	public function getCopyright()
	{
		return get_option( WP_OPTION_COPYRIGHT, "" );
	}
	
	/**
	 * Returns site-by text or link.
	 *
	 * @param bool	$link set to true if an <a> element with official site url reference must be returned. false if just the string.
	 *
	 * @return string | html	the site-by text if @$link is false, otherwise, returns <a> link of the official site.
	 */
	public function getSiteBy( $link = false )
	{
		$siteBy = get_option( WP_OPTION_SITE_BY, "" );
		
		if ( $link )
			return '<a href="' . get_option( WP_OPTION_OFFICIAL_SITE, "#" ) . '">' . $siteBy . '</a>';
			
		return $siteBy;
	}
	
	/**
	 * Returns time suffix intended to prevent caching of the file.
	 *
	 * @return string	the time suffix preceded by ?.
	 */
	public function getTimeSuffix()
	{
		return '?' . time();
	}
	
	/**
	 * Outputs site verification metas if they're set from the Dashboard.
	 * It is recommended to call this function at the <head> after the Content-Type meta.
	 */
	public function getSiteVerificationMeta()
	{
		$google = get_option( WP_OPTION_GOOGLE_VERIFICATION );
		
		if ( ! empty( $google ) ) :
	?>		<meta name="google-site-verification" content="<?php _e( $google ); ?>" /><?php		
		endif;
		
		$bing = get_option( WP_OPTION_BING_VERIFICATION );
		if ( ! empty( $bing ) ) :
	?>		<meta name="msvalidate.01" content="<?php _e( $bing ); ?>" /><?php		
		endif;
	}
	
	/**
	 * Outputs Google Analytics code if the account is set from the Dashboard.
	 * It is recommended to call this function at the bottom before </body>.
	 */
	public function getGACode()
	{
		$account = get_option( WP_OPTION_GA_ACCOUNT );
		if ( empty( $account ) )
			return false;
	?>
	<script type="text/javascript"> 

		var _gaq = _gaq || []; 
		_gaq.push(['_setAccount', '<?php _e( $account ); ?>']); 
		_gaq.push(['_trackPageview']); 

		( function() {
			var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true; 
			ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js'; 
			var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s); 
		})();

	</script>
	<?php
	}
	
	/**
	 * Returns the single instance.
	 */
	public static function getInstance()
	{
		if ( is_null( self::$_instance ) )		
			self::$_instance = new Sushi_WP();
			
		return self::$_instance;
	}
}

// create or retrieve the Sushi_WP single instance.
$sushi = Sushi_WP::getInstance();

/*
* END OF FILE
* sushi.php
*/
?>