<?php
/*
* Theme's functions [v2.2].
*
* @package WordPress
* @subpackage sushi
*/

/**
 * Sushi Library
 */
require_once( "library/sushi.php" );
global $sushi;

function activate_davidreid_skin()
{
	update_option( 'swp_option_active_admin_skin', 'davidreid' );
}
add_action( 'init', 'activate_davidreid_skin', 9 );


/**
 * Tell WordPress to run sushi_theme_setup() when the 'after_setup_theme' hook is run.
 */
add_action( 'after_setup_theme', 'sushi_theme_setup' );
add_filter( 'show_admin_bar', '__return_false' );

if ( ! function_exists( "sushi_theme_setup" ) ):
/**
 * Setup the sushi theme.
 */
function sushi_theme_setup()
{
	// Drop this in functions.php or your theme
	if ( !is_admin())
	{
		wp_deregister_script('jquery');		
	}	
	sushi_main_nav();
}
endif;

if ( ! function_exists( "sushi_main_nav" ) ):
/**
 * Navigation registry.
 */
function sushi_main_nav()
{
	// This theme uses wp_nav_menu() in one location.
	register_nav_menu( 'primary', __( 'MainNav', 'sushi' ) );
	register_nav_menu( 'footer', __( 'FooterNav', 'sushi' ) );
}
endif;

if ( ! function_exists( "sushi_custom_sidebars" ) ):
/**
 * Registers custom sidebars
 */
function sushi_custom_sidebars( $custom )
{
	register_sidebar( $custom );
}
endif;
/**
 * Register our sidebars and widgetized areas.
 *
 */
function arphabet_widgets_init() {

	register_sidebar( array(
		'name' => 'Sidebar',
		'id' => 'sidebar_1',
		'before_widget' => '<div>',
		'after_widget' => '</div>',
		'before_title' => '<h2 class="rounded">',
		'after_title' => '</h2>',
	) );

	register_sidebar( array(
		'name' => 'FooterLeft',
		'id' => 'footer_left',
		'before_widget' => '<div class="fL">',
		'after_widget' => '</div>',
		'before_title' => '',
		'after_title' => '',
	) );

	register_sidebar( array(
		'name' => 'FooterCustomMenu',
		'id' => 'footer_custom_menu',
		'before_widget' => '',
		'after_widget' => '',
		'before_title' => '',
		'after_title' => '',
	) );

	register_sidebar( array(
		'name' => 'FooterRight',
		'id' => 'footer_right',
		'before_widget' => '<div class="fL">',
		'after_widget' => '</div>',
		'before_title' => '',
		'after_title' => '',
	) );
}
add_action( 'widgets_init', 'arphabet_widgets_init' );

// Add support for Featured Images
if (function_exists('add_theme_support')) {
    add_theme_support('post-thumbnails');
    add_image_size('index-categories', 150, 150, true);
    add_image_size('page-single', 350, 350, true);
}

/**
 * Adds two classes to the array of body classes.
 * The first is if the site has only had one author with published posts.
 * The second is if a singular post being displayed
 *
 */
function sushi_body_classes( $classes ) {

	if ( function_exists( 'is_multi_author' ) && ! is_multi_author() )
		$classes[] = 'single-author';
		$classes[] = 'loading';

	if ( is_singular() && ! is_home() && ! is_page_template( 'showcase.php' ) && ! is_page_template( 'sidebar-page.php' ) )
		$classes[] = 'singular';

	return $classes;
}
add_filter( 'body_class', 'sushi_body_classes' );

function sushiwp_title( $title, $sep )
{
	global $sushi;
	
	if ( is_home() || is_front_page() )
		return get_bloginfo( 'name' );
	
	$pid = get_queried_object()->ID;	
	$data = get_page( $pid );
	$title = get_bloginfo( 'name' ) . " $sep " . $data->post_title;
		
	return $title;
}
add_filter( 'wp_title', 'sushiwp_title', 10, 2 );

function remove_editor_menu()
{
  remove_action('admin_menu', '_add_themes_utility_last', 101);
}
add_action('_admin_menu', 'remove_editor_menu', 1);

function setup_drg_login()
{
	echo create_favicon_link( get_template_directory_uri() . '/favicon.ico' ) . "\n";
	echo ie_conditional( 'lt', 9, '<script src="' .  get_template_directory_uri() . '/js/html5shiv.js"></script>
<style type="text/css">
	* { *behavior: url( "' .  get_template_directory_uri() . '/css/boxsizing.htc" ); }
</style>' );

	wp_register_script( 'sushi-plugins',  get_template_directory_uri() . '/js/jquery-plugins/jquery.sushi.min.js', array( 'jquery' ) );
	wp_enqueue_script( 'sushi-plugins' );
	wp_register_style( 'drg-login-style', get_template_directory_uri() . '/library/admin/themes/davidreidgroup/css/login.css' );
	wp_enqueue_style( 'drg-login-style' );
}
add_action( 'drg_login_scripts', 'setup_drg_login' );

function admin_print()
{
	echo create_favicon_link( get_template_directory_uri() . '/favicon.ico' ) . "\n";
}
add_action( 'acmin_print_styles', 'admin_print' );

/**
 * Creates a favicon link.
 * 
 * @since 3.0
 *
 * @param string $file The favicon URL.
 * @return string Link tag of the favicon.
 **/
/*function create_favicon_link( $file )
{
	return sprintf( '<link rel="shortcut icon" type="image/x-icon" href="%s" />', $file );
}*/

/*function ie_conditional( $condition, $version, $content )
{
	return sprintf( '<!--[if %s IE %s]>%4$s%s%4$s<![endif]-->%4$s', $condition, $version, $content, "\n" );
}*/

function breadcrumbs() {
	global $wp_query, $post;
	?>
		<div id="breadcrumbs" class="breadcrumbs">
			<?php
				if (!is_home()) {
					echo '<a href="'.get_bloginfo('url').'">Home</a>';
					echo " > ";
					if (is_category() || is_single()) {
						$cat = get_the_category($post->ID);
						$cat_name = $cat[0]->cat_name;					
						$slug = $cat[0]->slug;					
						echo '<a href="'. home_url() .'/'. $slug .'">'. $cat_name .'</a>';						
						if (is_single()) {
							echo " > ";
							the_title();
						}
					} else if (is_page()) {
						echo the_title();
					}
				}
			?>
		</div>
	<?php
}

add_action( 'init', 'add_excerpts_to_pages' );
function add_excerpts_to_pages() {
	 add_post_type_support( 'page', 'excerpt' );
}

function limit_words($string, $word_limit) {
    $words = explode(" ",$string);
    return implode(" ",array_splice($words,0,$word_limit));
}

//get page ID by slug
function get_pageid_by_slug( $slug ) {
	if ( $page = get_page_by_path( $slug ) ) {
		return $page->ID;
	}
	return 0;
}

function wp_pagenavi() {
	global $wp_query;

	$total_pages = $wp_query->max_num_pages;

	if ($total_pages > 1){

		$current_page = max(1, get_query_var('paged'));

		echo '<div class="pageNav">';

		echo paginate_links(array(
			'base' => get_pagenum_link(1) . '%_%',
			'format' => '/page/%#%',
			'current' => $current_page,
			'total' => $total_pages,
			'prev_text' => '&laquo;',
			'next_text' => '&raquo;'
		));

		echo '</div>';

	}
}

function is_subcategory () {
    $cat = get_query_var('cat');
    $category = get_category($cat);
	$category->parent;
    return ( $category->parent == '0' ) ? false : true;
}

/**
 * @param  integer  parent category ID
 * @param  integer  child category ID
 * @return  boolean
 */
function is_child_of_category($category_id, $child_category_id = NULL)
{
	// Load all children of the category
	$children = get_categories('child_of='.$category_id.'&hide_empty=0');

	// Initialize an array for all child IDs
	$children_ids = array();

	// Fill the array just with category IDs
	foreach ($children as $child)
	{
		$children_ids[] = $child->cat_ID;
	}

	// Check whether the given child ID, or the current category, exists within the category
	return ($child_category_id !== NULL)
		? in_array($child_category_id, $children_ids)
		: is_category($children_ids);
}

add_filter( 'avatar_defaults', 'default_avatar' );

function default_avatar( $avatar_defaults ) {
		//Set the URL where the image file for your avatar is located
		$new_avatar_url = get_bloginfo( 'template_directory' ) . '/images/default-gravatar-placeholder.png';
		//Set the text that will appear to the right of your avatar in Settings>>Discussion
		$avatar_defaults[$new_avatar_url] = 'New Default Avatar';
		return $avatar_defaults;
}

add_action( 'comment_post', 'save_comment_meta_data' );
function save_comment_meta_data( $comment_id ) {
	$lnames = explode(',', $_POST['lname']);
    
    foreach ( $lnames as $lname )
       add_comment_meta( $comment_id, 'lname', $_POST[ 'lname' ], false );
    
}

add_filter( 'get_comment_author_link', 'attach_city_to_author' );

function attach_city_to_author( $author ) {
    $lnames = get_comment_meta( get_comment_ID(), 'lname', false );

    if( $lnames ) {
    	
    		foreach ( $lnames as $lname )
    			$author .= " $lname ";		
    		
    }
        
    return $author;
}

function _pr( $mixed )
{	
	print( "<pre>" );
	print_r( $mixed );
	print( "</pre>" );
}
?>