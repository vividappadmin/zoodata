<?php
/**
 * Sushi WordPress Starter System
 * Copyright (C) 2014-2015, Sushi Digital Pty. Ltd. - http://sushidigital.com.au
 * 
 * This program is not a free software; this program is an intellectual
 * property of Sushi Digital Pty. Ltd. and CANNOT be REDISTRIBUTED, COPIED, 
 * MODIFIED or USED by ANY MEANS outside and/or unrelated to the company.
 * Disregarding this copyright notice is an act of copyright infringement, 
 * and is subject to civil and criminal penalties.
 */

if ( ! defined( 'ABSPATH' ) ) {
	wp_die( '<p>&ldquo;A very unpleasant time to be lost my friend; the night is dark and full of terrors.&rdquo;</p>' );
}
 
define( 'LIB_ABSPATH', 				dirname( __FILE__ ) );
define( 'SWP_DEFAULT_PACKAGE', 		'standard' );
define( 'SWP_DEFAULT_ADMIN_SKIN', 	'sashimi' );

/**
 * Represents main Sushi WordPress starter class.
 *
 * @class Sushi
 * @version 3.2.0
 * @author	Kai
 */
final class Sushi
{
	/**
	 * @var Sushi The single instance of the class	 
	 */	
	protected static $_instance = null;

	//////////////////////////////////////////
	//	DATA MEMBERS
	//////////////////////////////////////////////
	
	public $settings;
	
	public $packages;
	
	public $admin_skins;
	
	public $active_package;
		
	public $labels;
	
	public $errors;
		
	public $options;

	public $option_prefix;

	public $config;

	public $am;
	
	protected $active_admin_skin = null;

	//////////////////////////////////////////
	//	INITIALIZATION
	//////////////////////////////////////////////
	
	/**
	 * Singleton
	 *
	 * Ensures only one instance of Sushi class is loaded or can be loaded.
	 *
	 * @see Sushi()
	 * @return Sushi - Main instance
	 */
	public static function get_instance() 
	{
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}	
	
	/**
	 * Constructor.
	 */
	public function __construct()
	{		
		// Initialize
		$this->init_settings();
		$this->init_options();		
		
		// Add init callback
		add_action( 'init', array( $this, 'init' ) );
		add_action( 'template_redirect', array( $this, 'regulate_routes' ) );	
		add_action( 'admin_init', array( $this, 'regulate_routes' ) );
		// Initialize Packages		
		add_action( 'swp_loaded', array( $this, 'init_packages' ) );
		
		// Clean up WordPress defaults such as, options, page, post, comments, etc
		$this->cleanup_wp_defaults();		
	}
	
	public function init()
	{
		// Prepares SWP options
		$this->prep_options();
		// Handles options
		$this->regulate_options();		
		
		$this->init_actions_and_filters();		
		$this->load_scripts();
		$this->load_admin_skin();
		$this->register_shortcodes();
		
		if ( is_admin() ) 
		{			
			require_once( swp_admin_dir( '/admin.php' ) );
			require_once( swp_admin_dir( '/includes/tips-and-guides.php' ) );
			
			require_once( swp_admin_dir( '/includes/class-assets-manager.php' ) );

			$this->config->add_setting_tab( 'general', 'General', 'system_settings_general' );
			$this->config->add_setting_tab( 'seo-tools', 'SEO Tools', 'system_settings_seo_tools' );

			apply_filters( 'swp_config_init', $this->config );

			$this->am = new Assets_Manager();
			$this->am->config = new Sushi_SystemSettings( $this->settings->menus->subs['assets']['slug'], $this->settings->system_assets_manager );
			$this->am->config->add_setting_tab( 'assets', 'Assets', 'am_assets' );
			$this->am->config->add_setting_tab( 'dirs', 'Directories', 'am_directories' );
			
			swp_addnload_js( 'swp-admin', swp_assets_url( '/scripts/swp-admin.js' ), array( 'jquery' ) );
		}
	}
	
	public function init_admin()
	{
		// Load library default dashboard style override
		swp_add_css( 'sushi-dashboard', swp_assets_url( '/styles/dashboard.css' ) );
		// Load SWP admin scripts
		add_action( 'admin_enqueue_scripts', array( $this, 'load_admin_scripts' ) );
		// Load SWP styles to customize.php
		add_action( 'customize_controls_print_styles', 'swp_customize_print_styles', 99 );
		
		if ( $this->swp_get_option( 'default_footer_texts' ) != '1' ) {
			// Filter Dashboard footer
			add_filter( 'update_footer', 'swp_update_footer' );
		}
		
		$this->register_system_settings();
		$this->filter_admin_menus();
		$this->override_wp_menus();
	}
	
	public function init_admin_menus()
	{
		foreach ( $this->settings->menus as $i => $menu ) {		
			switch ( $i ) {
				case 'main':
					add_menu_page( __( $menu['title'], 'swp'), __('System', 'swp'), $menu['cap'], $menu['slug'], array( $this, 'admin_menu_handler' ), 'none', SWP_MENUPOS_SYSLIB );	
					add_submenu_page( $menu['slug'], __( $menu['title'], 'swp' ), __( $menu['menu'], 'swp' ), $menu['cap'], $menu['slug'], array( $this, 'admin_menu_handler' ) );
					break;
				case 'subs':
					foreach ( $menu as $key => $submenu ) {
						if ( $submenu['enabled'] ) {
							add_submenu_page( $this->settings->menus->main['slug'], __( $submenu['title'], 'swp' ), __( $submenu['menu'], 'swp' ), $submenu['cap'], $submenu['slug'], array( $this, 'admin_menu_handler' ) );
						}
					}					
					break;
				default:
					break;
			}
		}
		
	}
	
	public function init_settings()
	{
		require( ABSPATH . WPINC . '/version.php' );
		require( LIB_ABSPATH . '/settings.php' );

		$this->option_prefix 		= 'swp_option_';	
		
		$this->settings = (object)array(
			'model' 				=> 'Sashimi',
			'version' 				=> '3.2',	
			'wp_version' 			=> $wp_version,
			'package_mode'			=> '',
			'official_siteurl'		=> 'http://www.sushidigital.com.au',
			'company_name'			=> 'Sushi Digital Online Solutions Inc.',
			'system_settings'		=> 'swp-system-settings',
			'system_assets_manager'	=> 'swp-system-assets-manager',
			'default_package'		=> SWP_DEFAULT_PACKAGE,
			'default_admin_skin'	=> SWP_DEFAULT_ADMIN_SKIN,
			'menus'					=> (object)array(
				'main'					=> array(
					'slug'	=> 'system-overview',
					'menu'	=> 'Overview',
					'title'	=> 'System Overview',
					'cap'	=> swp_get_highest_role_cap( 'editor' )
				),
				'subs'					=> array()
			)
		);
		
		$this->swp_system_add_submenu( 'config', 'system-config', 'Configuration', 'System Configuration', apply_filters( 'swp_config_menu_role_cap', swp_get_highest_role_cap( 'editor' ) ) );		
		$this->swp_system_add_submenu( 'packages', 'system-packages', 'Packages', 'System Packages', swp_get_highest_role_cap( 'administrator' ) );
		$this->swp_system_add_submenu( 'assets', 'system-assets', 'Assets Manager', 'System Assets Manager', swp_get_highest_role_cap( 'administrator' ), false );
		$this->swp_system_add_submenu( 'skins', 'system-skins', 'Schemes & Skins', 'System Schemes & Skins', swp_get_highest_role_cap( 'administrator' ), false );
		
		$this->settings->standard = array(
			'UniqueID'		=> 'standard',
			'Name'			=> 'Standard',
			'ModeName'		=> 'Standard',
			'Description'	=> 'The default package. The standard template used for multi pages, informational to e-commerce websites. Fully equipped with the current system\'s built-in functions and features. See <a href="#">Documentation</a>.',
			'Version'		=> $this->settings->version,
			'Authors'		=> 'Sushi Katana Team'
		);
		
		$this->settings->footer_sigs = apply_filters( 'swp_footer_sigs', 
			array( 
				'regular' => array(
					'title' => 'Regular',
					'label' => 'For old websites with more than 1 year history (usually revamp) or new website with more than 11 pages.',
					'uri'	=> '/services/sushi-digital-website-design-development/',
					'link'	=> '<a title="Sushi Digital" href="{official}">Sushi Digital</a> <a href="{webdesign}" title="Sushi Digital Website Design Perth">Website Design Perth</a>'
				), 
				'ecommerce' => array(
					'title' => 'e-Commerce',
					'label' => 'For e-commerce websites.',
					'uri'	=> '/services/sushi-digital-e-commerce-shopping-carts/',
					'link' => '<a title="Sushi Digital" href="{official}">Sushi Digital</a> <a href="{ecommerce}" title="e-Commerce Design Perth">Website Design Perth</a>'
				), 
				'new' => array(
					'title' => 'Newly Built Website',
					'label' => 'For new websites with less than 10 pages  (fresh domain and young authority website).',
					'link' 	=> '<a title="Sushi Digital" href="{official}">Sushi Digital</a> Website Design Perth'
				), 
				'onepage' => array(
					'title' => 'One-Page Website',
					'label' => 'For new and One-page websites (fresh and no authority site).',
					'link' 	=> '<a rel="nofollow" title="Sushi Digital" href="{official}">Sushi Digital</a> Website Design Perth'
				)
			)
		);
		
		require_once( swp_admin_dir( '/includes/class-system-settings.php' ) );			
		
		$this->config = new Sushi_SystemSettings( $this->settings->menus->subs['config']['slug'], $this->settings->system_settings );		
	}
	
	public function init_options()
	{
		$prefix = $this->option_prefix;

		$GROUP_GENERAL 	= sprintf( '%s-general', $this->settings->system_settings );
		$GROUP_SEOTOOLS = sprintf( '%s-seo-tools', $this->settings->system_settings );
		
		$this->options = array(
			// Active package
			'active_package' => array( 
				'name' 		=> $prefix . 'active_package', 
				'default' 	=> SWP_DEFAULT_PACKAGE,
				'autoload'	=> 'no',
			),
			// Active admin skin
			'active_admin_skin' => array( 
				'name' 		=> $prefix . 'active_admin_skin', 
				'default' 	=> SWP_DEFAULT_ADMIN_SKIN,
				'autoload'	=> 'no'
			),
			// Successful sample page and post cleanup
			'first_run'	=> array( 
				'name' 		=> $prefix . 'first_run', 
				'default' 	=> '1',
				'autoload'	=> 'no'
			),
			// Successful sample page and post cleanup
			'google_ad_code'	=> array( 
				'name' 		=> $prefix . 'google_ad_code', 
				'default' 	=> '',
				'autoload'	=> 'yes',
				'group'		=> $GROUP_SEOTOOLS
			),
			// Enable/Disable media thumbnails generation
			'google_ad_code_footer'	=> array( 
				'name' 		=> $prefix . 'google_ad_code_footer', 
				'default' 	=> '1',
				'autoload'	=> 'yes',
				'group'		=> $GROUP_SEOTOOLS
			),
			// Enable/Disable media thumbnails generation
			'disable_wp_thumbnails'	=> array( 
				'name' 		=> $prefix . 'disable_wp_thumbnails', 
				'default' 	=> '1',
				'autoload'	=> 'yes',
				'group'		=> $GROUP_GENERAL
			),
			// Enable/Disable WordPress update notification
			'disable_wp_about_pages' => array( 
				'name' 		=> $prefix . 'disable_wp_about_pages', 
				'default' 	=> '1',
				'autoload'	=> 'yes',
				'group'		=> $GROUP_GENERAL
			),
			// Enable/Disable WordPress update notification
			'disable_wp_update_notif' => array( 
				'name' 		=> $prefix . 'disable_wp_update_notif', 
				'default' 	=> '1',
				'autoload'	=> 'yes',
				'group'		=> $GROUP_GENERAL
			),
			// Enable/Disable WordPress Theme Editor
			'disable_wp_theme_editor' => array( 
				'name' 		=> $prefix . 'disable_wp_theme_editor', 
				'default' 	=> '1',
				'autoload'	=> 'yes',
				'group'		=> $GROUP_GENERAL,
				'data'		=> array(
					'menu'		=> 'theme-editor.php'
				)
			),
			// Enable/Disable WordPress Widgets Interface
			'disable_wp_widgets_ui' => array( 
				'name' 		=> $prefix . 'disable_wp_widgets_ui', 
				'default' 	=> '',
				'autoload'	=> 'yes',
				'group'		=> $GROUP_GENERAL,
				'data'		=> array(
					'menu'		=> 'widgets.php'
				)
			),
			// Hide/Show Admin Bar
			'hide_wp_adminbar' => array( 
				'name' 		=> $prefix . 'hide_wp_adminbar', 
				'default' 	=> '1',
				'group'		=> $GROUP_GENERAL,
				'autoload'	=> 'yes'
			),
			// Enable SWP Font Icons Pack
			'enable_swp_icons' => array( 
				'name' 		=> $prefix . 'enable_swp_icons', 
				'default' 	=> '',
				'group'		=> $GROUP_GENERAL,
				'autoload'	=> 'yes'
			),
			// Default footer signature
			'footer_sig' => array( 
				'name' 		=> $prefix . 'footer_sig', 
				'default' 	=> 'new',
				'group'		=> $GROUP_SEOTOOLS,
				'autoload'	=> 'yes'
			),
			// Redirect 404 Page to Home URL
			'redirect_404' => array( 
				'name' 		=> $prefix . 'redirect_404', 
				'default' 	=> '',
				'group'		=> $GROUP_SEOTOOLS,
				'autoload'	=> 'yes'
			),
			// Enable/Disable CSS3 PIE script
			'enable_css3_pie'	=> array( 
				'name' 		=> $prefix . 'enable_css3_pie', 
				'default' 	=> '',
				'autoload'	=> 'yes',
				'group'		=> $GROUP_GENERAL
			),
			// Force default skin
			'force_wordpress_admin_skin'	=> array( 
				'name' 		=> $prefix . 'force_wordpress_admin_skin', 
				'default' 	=> '',
				'autoload'	=> 'yes',
				'group'		=> $GROUP_GENERAL
			)
			,
			// Rever to default footer texts
			'default_footer_texts'	=> array( 
				'name' 		=> $prefix . 'default_footer_texts', 
				'default' 	=> '',
				'autoload'	=> 'yes',
				'group'		=> $GROUP_GENERAL
			)
		);
	}
	
	public function init_actions_and_filters()
	{
		add_action( 'wp_enqueue_scripts', array( $this, 'load_late_scripts' ), 999 );		
		add_action( 'swp_print_scripts', array( $this, 'print_scripts' ) );
		
		if ( is_admin() ) 
		{
			add_action( 'admin_init', array( $this, 'init_admin' ) );			
			add_action( 'admin_menu', array( $this, 'init_admin_menus' ) );
			
			add_filter( 'admin_title', 'swp_admin_title', 10, 2 );
			
			if ( $this->swp_get_option( 'default_footer_texts' ) != '1' ) {
				add_filter( 'admin_footer_text', 'swp_admin_footer_text' );
			}
			
			add_action( 'admin_footer', 'swp_tips_javascript' );
		}
		
		if ( $this->swp_get_option( 'google_ad_code_footer' ) == '1' ) {
			add_action( 'swp_after_footer', 'swp_output_google_ad_code' );
		} else {
			add_action( 'swp_after_head', 'swp_output_google_ad_code' );
		}
	}	

	//////////////////////////////////////////
	//	PUBLIC METHODS
	//////////////////////////////////////////////
	
	public function regulate_routes()
	{
		global $pagenow;
		
		if ( is_admin() ) {

			switch( $pagenow ) {
				case 'about.php':
				case 'credit.php':
				case 'freedoms.php':
					if ( swp_option_state( 'disable_wp_about_pages' ) ) {
						wp_redirect( admin_url() );
					}
					break;
				case 'theme-editor.php':
					if ( swp_option_state( 'disable_wp_theme_editor' ) ) {
						wp_redirect( admin_url() );
					}
					break;
				case 'update-core.php':
					if ( swp_option_state( 'disable_wp_update_notif' ) ) {
						wp_redirect( admin_url() );
					}
					break;
				default:
					break;
			}
		} else {
			if ( is_404() ) {
				if ( swp_option_state( 'redirect_404' ) ) {
					wp_redirect( home_url() );
				}
			}
		}
	}

	public function load_scripts()
	{
		// Add SWP Font Icons
		swp_add_css( 'swp-icons', swp_assets_url( '/styles/icons/icons.css' ) );
		// Add and Load Sushi jQuery Plugins
		swp_addnload_js( 'sushi-plugins', SWP_ASSETS_URL . '/scripts/jquery.sushi.min.js', array( 'jquery' ) );
		// enqueue styles and scripts
		do_action( 'swp_load_frontend_scripts' );
	}
	
	public function print_scripts()
	{
		$text = '';
		$js_lt9 	= array( SWP_ASSETS_URL . '/scripts/html5.js' );		
		$css_lt9 	= array();
		$style_lt9	= array( sprintf( '* { *behavior: url( "%s" ); }', SWP_ASSETS_URL . '/scripts/boxsizing.htc' ) );

		if ( swp_option_state( 'enable_css3_pie' ) ) {
			$js_lt9[]	= SWP_ASSETS_URL . '/scripts/PIE.js';
		}		
		
		$scripts = apply_filters( 'swp_ie_lt9', array(
			'js'	=> $js_lt9,
			'css'	=> $css_lt9,
			'style'	=> $style_lt9
		) );
	
		if ( ! empty( $scripts['js'] ) ) 
		{
			foreach ( $scripts['js'] as $js ) {
				$text .= sprintf( '<script src="%1$s"></script>%2$s', $js, PHP_EOL );
			}
		}
		
		if ( ! empty( $scripts['css'] ) ) 
		{
			foreach ( $scripts['css'] as $css ) {
				$text .= sprintf( '<link type="type/css" href="%1$s" />%2$s', $css, PHP_EOL );
			}
		}
		
		if ( ! empty( $scripts['style'] ) ) 
		{
			$text .= '<style type="text/css">' . PHP_EOL;
			foreach ( $scripts['style'] as $style ) {			
				$text .= '	' . $style . PHP_EOL;			
			}
			$text .= '</style>';
		}
		
		echo create_favicon_link( get_template_directory_uri() . '/favicon.ico' ) . "\n";
		echo ie_conditional( 'lt', 9, $text );
	}

	public function load_late_scripts()
	{
		// enqueue styles and scripts that must go last at all times in their respective places.
		do_action( 'swp_load_late_scripts' );
		
		if ( is_admin_bar_showing() ) {
			swp_load_css( 'sushi-admin-skin-dashboard', SWP_CURRENT_SKIN_URL . '/css/dashboard.css' );
		}
		
		if ( $this->swp_get_option( 'enable_swp_icons' ) == '1' ) {
			swp_load_css( 'swp-icons' );
		}
		
		swp_addnload_css( 'global-stylesheet', get_template_directory_uri() . '/css/global.css' );	
		swp_addnload_js( 'global-js', get_template_directory_uri() . '/js/global.js', array( 'jquery' ), true );			
	}
	
	public function load_admin_scripts()
	{
		swp_load_css( 'swp-icons' );
		swp_load_css( 'sushi-dashboard' );
		swp_load_css( 'sushi-admin-skin-dashboard' );

		swp_load_js( 'jquery' );	
		swp_load_js( 'sushi-plugins' );
		
		$this->print_scripts();

		if ( isset($_GET['page']) )
		{
			switch ( $_GET['page'] )
			{
				case 'system-overview':
					swp_load_js( 'jquery-ui-core' );
					swp_load_js( 'jquery-ui-draggable' );
					swp_load_js( 'jquery-ui-droppable' );
					swp_load_js( 'postbox');
					add_thickbox();
					break;
				default:
					break;
			}
		}
	}
	
	public function load_admin_skin()
	{
		/* Set active skin. */
		$active_skin = $this->swp_get_option( 'active_admin_skin' );
				
		if ( $active_skin === false )
		{
			if ( file_exists( SWP_ADMIN_SKINS_DIR . '/' . $this->settings->default_admin_skin . '/specs.php' ) ) {
				$active_skin = SWP_STARTER_DEFAULT_ADMIN_SKIN;
			} else {
				$active_skin = 'wordpress';
			}
			$this->_swp_set_option_default( 'active_admin_skin', $active_skin );
		} 

		if ( $active_skin != 'wordpress' )
		{
			$skin_file = SWP_ADMIN_SKINS_DIR . '/' . $active_skin . '/specs.php';
			
			if ( file_exists( $skin_file ) ) 
			{
				do_action( 'swp_admin_skin_init' );
				
				if ( $this->swp_get_option( 'force_wordpress_admin_skin' ) != 1 ) {
					require( $skin_file );
					$this->active_admin_skin = apply_filters( 'swp_set_active_skin', null );
				}
				
				do_action( 'swp_admin_skin_loaded' );	
			} else {
				// resets back to normal wordpress login
				$this->swp_set_option( 'active_admin_skin', 'wordpress' );
			}
		}
		
		if ( $active_skin === 'wordpress' )
		{
			$this->active_admin_skin = null;
		}
	}
	
	public function register_shortcodes()
	{
		add_shortcode( 'swp_sitemap', 'swp_sitemap' );
	}
	
	public function admin_menu_handler()
	{
		switch ( $_GET['page'] )
		{
			case 'system-overview':
				include_once( swp_admin_dir( '/system-overview.php' ) );
				swp_system_overview();
				break;
			case 'system-assets':				
				include_once( swp_admin_dir( '/system-assets-manager.php' ) );				
				break;		
			case 'system-packages':				
				include_once( swp_admin_dir( '/system-package.php' ) );				
				break;
			case 'system-skins':				
				include_once( swp_admin_dir( '/system-skins.php' ) );				
				break;
			case 'system-config':
				include_once( swp_admin_dir( '/system-configuration.php' ) );				
				break;
			default:
				apply_filters( 'swp_menu_handler', $_GET['page'] );
				break;
		}		
	}
	
	public function register_system_settings()
	{
		// Register System Settings
		foreach( $this->options as $option => $val ) {
			if ( $val['autoload'] === 'yes' ) {				
				register_setting( $val['group'], $val['name'] );				
			}
		}
	}
	
	public function filter_admin_menus()
	{
		do_action( 'filter_admin_menus' );
	}

	public function swp_system_add_submenu( $menu, $slug, $menu_title, $title, $cap = 'activate_plugins', $enabled = true )
	{
		$m = array(
			'slug'		=> $slug,
			'menu'		=> $menu_title,
			'title'		=> $title,
			'cap'		=> $cap,
			'enabled' 	=> $enabled
		);

		$this->settings->menus->subs[$menu] = $m;
	}

	public function swp_add_admin_skin( $id, $name, $description, $author, $author_url, $version )
	{
		if ( $this->admin_skins ) {

			foreach ( $this->admin_skins as $skin ) {
				if ( $skin['id'] == $id )
					return false;
			}

			$skin = array(
				'id'			=> $id,
				'name' 			=> $name,
				'decription' 	=> $description,
				'author'		=> $author,
				'author_url'	=> $author_url,
				'version' 		=> $version
			);

			array_push( $this->admin_skins, $skin );

			return $skin;
		}

		return false;
	}
	
	public function swp_get_option( $option, $default = false )
	{
		return get_option( $this->options[$option]['name'], $default );
	}
	
	public function swp_set_option( $option, $value = '' )
	{
		$value = empty( $value ) ? $this->options[$option]['default'] : $value;
		return update_option( $this->options[$option]['name'], $value );
	}
	
	public function swp_insert_options( array $options, $append = false )
	{
		if ( $append ) {
			$this->options += $options;
		} else {
			$this->options = $options + $this->options;
		}
		
		return $this->options;
	}
	
	/**
	 * Get all valid packages from the packages directory. 
	 *
	 * @param	string  Additional path
	 * @access	public
	 * @return	array
	 */
	public function get_packages( $packages_folder = '' )
	{
		$packages_root = SWP_PACKAGES_DIR;
		$packages_url = SWP_PACKAGES_URL;
		$packages = array();

		if ( ! empty( $packages_folder ) ) {
			$packages_root .= $packages_folder;
			$packages_url .= $packages_folder;
		}

		$packages_dir = @opendir( $packages_root );

		while( ( $dir = readdir( $packages_dir) ) !== false ) {

			if ( substr( $dir, 0, 1) == '.' )
				continue;

			$package_dir = $packages_root . '/' . $dir;

			if ( is_dir( $package_dir ) ) {
				
				if ( file_exists( $package_dir . '/package.php' ) ) {

					$package_data = $this->get_package_data( $package_dir . '/package.php' );

					foreach ( array( 'png', 'jpg', 'gif' ) as $ext ) {
						if ( ! file_exists( $package_dir . '/screenshot.' . $ext ) ) {
							continue;
						} else {
							$screenshot = $packages_url . '/' . $dir . '/screenshot.' . $ext;	
							break;
						}
					}

					if ( empty( $package_data['UniqueID'] ) )
						$package_data['UniqueID'] = $dir;

					$package = array();
					$package = array_merge( $package, $package_data );
					$package['dir'] = sanitize_path( $package_dir );					
					
					$packages[$dir] = $package;
				}
			}
		}
		
		$tmp[SWP_DEFAULT_PACKAGE] = $this->settings->standard;
		
		if ( ! empty( $tmp ) ) {
			$packages = $tmp + $packages;
		}
		
		return $packages;
	}
	
	/**
	 * Initialize active package. If no active package is set, default package shall be used.
	 *
	 * @access public
	 * @return void
	 */
	public function init_packages()
	{
		$this->packages = $this->get_packages();		
		
		if ( $this->swp_get_option( 'active_package' ) === false ) {
			$this->_swp_set_option_default( 'active_package' );
		}		
	
		$package = $this->swp_get_option( 'active_package' );
		
		if ( ! file_exists( SWP_PACKAGES_DIR . '/' . $package . '/package.php' ) ) {
			$package = $this->settings->default_package;
		}
		
		if ( $package !== $this->settings->default_package ) {		
			include_once( SWP_PACKAGES_DIR . '/' . $package . '/package.php' );
		}
		
		$this->settings->package_mode = $this->packages[$package]['ModeName'];	
	}	
	
	public function get_active_skin()
	{
		return $this->active_admin_skin;
	}
	
	//////////////////////////////////////////
	//	PRIVATE METHODS
	//////////////////////////////////////////////
	
	/**
	 * Retrieve package data.
	 *
	 * @access private
	 * @return array
	 */
	private function get_package_data( $package_file, $markup = true )
	{
		$def_headers = array(
			'UniqueID'		=> 'Unique ID',
			'Name'			=> 'Package Name',
			'ModeName'		=> 'Package Mode Name',
			'Description'	=> 'Description',
			'Version'		=> 'Version',
			'Authors'		=> 'Authors'
		);

		$package_data = get_file_data( $package_file, $def_headers );

		return $package_data;
	}
	
	/**
	 * This is where system configuration settings defaults are set.
	 *
	 * @access private
	 * @return void
	 */
	private function prep_options()
	{
		$this->options = apply_filters( 'swp_options', $this->options );
		
		foreach( $this->options as $option => $val ) {
			if ( $this->swp_get_option( $option ) === false && $val['autoload'] === 'yes' ) {			
				$this->_swp_set_option_default( $option );
			}
		}
	}
	
	/**
	 * This is where system configuration settings are being regulated.
	 *
	 * @access private
	 * @return void
	 */
	private function regulate_options()
	{
		if ( $this->swp_get_option( 'disable_wp_update_notif' ) == 1 ) {			
			add_action( 'admin_menu', 'swp_hide_nag' );
		}		
		
		if ( $this->swp_get_option( 'disable_wp_thumbnails' ) == 1 ) {			
			add_filter( 'intermediate_image_sizes_advanced', 'disable_wp_thumbnails_generation' );
		}
	}
	
	/**
	 * This is where WordPress settings/options are being overridden by the system configuration settings.
	 *
	 * @access private
	 * @return void
	 */
	private function override_wp_menus()
	{
		// Override widgets
		if ( $this->swp_get_option( 'disable_wp_widgets_ui' ) == 1 ) {			
			remove_submenu_page( 'themes.php', 'widgets.php' );
		}
		// Override theme editor
		if ( $this->swp_get_option( 'disable_wp_theme_editor' ) == 1 ) {			
			remove_submenu_page( 'themes.php', 'theme-editor.php' );
		}
	}
	
	/**
	 * Clean up WordPress entrails.
	 *
	 * @access private
	 * @return void
	 */
	private function cleanup_wp_defaults()
	{
		// Remove sample page and post
		if ( $this->swp_get_option( 'first_run' ) === false ) {
			// remove default blog description
			update_option( 'blogdescription', '' );
			// set syndication feeds by 20
			update_option( 'posts_per_rss', '20' );
			// set each article in a feed to 'summary=1'
			update_option( 'rss_use_excerpt', '1' );
			// delete samples
			wp_delete_post(1);
			wp_delete_post(2);
			// log first starter run
			$this->_swp_set_option_default( 'first_run' );
			// attempt to create a default menu
			$id = swp_create_nav_menu( 'MainNav' );
			// set as primary menu
			set_theme_mod( 'nav_menu_locations', array( 'primary' => $id ) );
		}
	}	
	
	private function _swp_set_option_default( $option )
	{
		return add_option( $this->options[$option]['name'], $this->options[$option]['default'], '', 'no' );
	}
}

/**
 * Global instance function. Use this instead of register_globals variable.
 */
function SushiWP()
{
	// Get instance
	$instance = Sushi::get_instance();	
	// Sushi WordPress loaded action hook
	do_action( 'swp_loaded' );	

	return $instance;
}

// Initialize Sushi Wordpress System
SushiWP();

/**
 * END OF FILE
 * sushi.php
 */
?>