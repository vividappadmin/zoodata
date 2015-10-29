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

function swp_title()
{
	wp_title( '|', true, 'right' );
}

function _swp_title( $title, $sep )
{
	global $wp_query;
	
	if ( is_home() || is_front_page() )
		return get_bloginfo( 'name' );
	
	$pageobj = $wp_query->get_queried_object();
	if ( is_page() || is_single() )
		$pagetitle = $pageobj->post_title;
	else
		$pagetitle = get_bloginfo( 'name' );
		
	$title = sprintf( '%s | %s', $pagetitle, get_bloginfo( 'name' ) );
	
	return $title;
}
add_filter( 'wp_title', '_swp_title', 14, 2 );

function swp_head()
{
	// before wp_head action hook
	do_action( 'swp_before_head' );
	// require jquery at all times.
	swp_load_js( 'jquery' );
	// call wp_head().
	wp_head();
	// print scripts
	do_action( 'swp_print_scripts' );
	// after wp_head action hook
	do_action( 'swp_after_head' );
}

function swp_footer()
{	
	// before wp_footer action hook
	do_action( 'swp_before_footer' );
	// call wp_footer().
	wp_footer();
	// after wp_footer action hook
	do_action( 'swp_after_footer' );
}

/**
 * Copyright HTML.
 *
 * @since Sashimi 3.0.2
 *
 * @return Returns a copyright HTML.
 */
function swp_copyright()
{
	return apply_filters( 'swp_copyright', sprintf( 'Copyright &copy; %s <a href="%s">%s</a>. All Rights Reserved.', date( 'Y' ), home_url( '/' ), get_bloginfo( 'name' ) ) );
}

function swp_footer_sig( $override = null )
{
	$sig = SushiWP()->swp_get_option( 'footer_sig' );
	if ( $override !== null ) {
		$sig = $override;
	}
	
	if ( ! isset( SushiWP()->settings->footer_sigs[$sig] ) ) {
		return false;
	}
	
	$ourl = SushiWP()->settings->official_siteurl;

	$keys = array(
		'/{official}/',
		'/{webdesign}/',
		'/{ecommerce}/'
	);

	// Original URL's
	$values = array(
		$ourl,
		$ourl . apply_filters( 'sig_permalink_webdesign', SushiWP()->settings->footer_sigs['regular']['uri'] ),
		$ourl . apply_filters( 'sig_permalink_ecommerce', SushiWP()->settings->footer_sigs['ecommerce']['uri'] )
	);
	
	$html = preg_replace( $keys, $values, SushiWP()->settings->footer_sigs[$sig]['link'] );
	
	return apply_filters( 'swp_footer_sig', $html );
}

/**
 * Retrieves the associated featured image (post thumbnail).
 *
 * @since 3.0
 *
 * @param string $return           	Return types ( 'id', 'src', 'object', 'timthumbimg', 'timthumbsrc' ). Default is 'timthumbimg'.
 * @param int	 $post_id			ID of the post. If post id is not specified, it assumes it's inside the loop. Default is null.
 * @param array	 $tt_params         Timthumb parameters.
 * @param array	 $tt_attrs          Timthumb attributes.
 */
function get_featured_img( $return = 'timthumbimg', $tt_params = array(), $tt_attrs = array(), $post_id = null ) 
{
	if ( !current_theme_supports( 'post-thumbnails' ) ) {
		echo '<p>Sorry, your Wordpress setup doesn\'t seem to support post thumbnails. Please see add_theme_support() function.</p>';		
	}	
		
	// Ensure $return has a correct value.
	if ( ! in_array( $return, array( 'id', 'src', 'object', 'timthumbimg', 'timthumbsrc' ) ) )
		$return = 'timthumbimg';
		
	// Check if we are inside a wordpress loop and if the template has featured img.
	if ( in_the_loop() && !has_post_thumbnail() ) {	
		return false;
	}
	
	$post_id = ( $post_id === null ) ? get_the_ID() : $post_id;
	
	$img = swp_get_attachment( $post_id );
	
	if ( $img ) {		
				
		$params	= array_merge( array( 'src' => $img['url'], 'w' => $img['width'], 'h' => $img['height'] ), $tt_params );
		$attrs 	= array_merge( array( 'src' => $img['url'], 'title' => $img['title'], 'alt' => $img['alt'] ), $tt_attrs );
	
		switch ( $return ) {
			case 'id':
				return $img['id'];
			case 'src':
				return $img['url'];
			case 'timthumbimg':				
				return get_timthumb_img( $attrs, $params );
			case 'timthumbsrc':
				return get_timthumb_src( $params );
			default:
				return $img;
		}
	}
	
	return false;
}

function swp_get_attachment( $post_id, $object = false )
{
	$thumb_id 	= get_post_thumbnail_id( $post_id );
	$attachment = wp_get_attachment_image_src( $thumb_id, 'full' );	
	$img 		= get_post( $thumb_id );

	$result = array(
		'id'			=> $img->ID,
		'author'		=> $img->post_author,
		'date'			=> $img->post_date,
		'date_gmt'		=> $img->post_date_gmt,
		'description'	=> $img->post_content,
		'title'			=> $img->post_title,
		'caption'		=> $img->post_excerpt,
		'name'			=> $img->post_name,
		'url'			=> $img->guid,
		'mime_type'		=> $img->post_mime_type,
		'alt'			=> get_post_meta( $thumb_id, '_wp_attachment_image_alt', true ),
		'width'			=> $attachment[1],
		'height'		=> $attachment[2],
		'ext'			=> pathinfo( $img->guid, PATHINFO_EXTENSION )
	);

	if ( $object === true ) {
		return (object) $result;
	}

	return $result;
}

function get_timthumb_img( array $attributes, array $params )
{
	$params = array_merge( swp_timthumb_def_params(), $params );	
	foreach ( $attributes as $key => $val ) {
		$attrs[] = $key . '="' . $val . '"';		
	}
	return sprintf( '<img src="%s" %s />', get_timthumb_src( $params ), implode( " ", $attrs ) );
}

function get_timthumb_src( array $params )
{
	$params = array_merge( swp_timthumb_def_params(), $params );	
	foreach ( $params as $key => $val ) {
		if ( in_array( $key, swp_timthumb_default_params_list() ) ) {
			$query[] = $key . '=' . $val;
		}
	}
	return sprintf( '%s?%s', swp_timthumb_url(), @implode( '&', $query ) );
}

function swp_popular_posts( $limit = 5, $category_param = '', $category_values = '', $title_limit = 5 )
{	
	if ( ! empty( $category_param ) && ! empty( $category_values ) &&
		in_array( $category_param, array( 'cat', 'category_name', 'category__and', 'category__in', 'category__not_in' ) ) ) {
		
		if ( gettype( $category_values ) == 'string' ) {
			$category_values = trim( $category_values );
			$category = sprintf( '&%s=%s', $category_param, rtrim( $category_values, ',' ) );
		} else if (  gettype( $category_values ) == 'array' ) {
			$category = sprintf( '&%s=%s', $category_param, @implode( ',', $category_values ) );
		} else {
			$category = '';
		}
	} else {
		$category = '';
	}	
	
	$popular = new WP_Query( sprintf( 'orderby=comment_count&posts_per_page=%s%s', $limit, $category ) );
	if ( $popular->have_posts() ) : 
		while ( $popular->have_posts() ) : $popular->the_post();
?>
	<li id="<?php echo 'post-' . get_the_id(); ?>"><a href="<?php echo get_permalink(); ?>"><?php echo wp_trim_words( get_the_title(), $title_limit, '...' ); ?></a></li>
<?php
		endwhile;
		wp_reset_postdata();
	endif;
}

function swp_sitemap( $options = array(), $display = false )
{
	global $post;
	
	/***
	 * $options -- indvidual pages output preferences
	 *		_global			-- global top level pref
	 *			order			-- ASC/DESC
	 *			orderby			-- none, ID, author, title, name, date, modified,
	 *						   parent, rand, comment_count, menu_order, meta_value,
	 *						   meta_value_num, post__in
	 *		_excludes		-- array of slugs to exclude ( top level pages only )
	 *		<page_slug>		-- specific page/child page slug
	 *			type 			-- post/page(default)
	 *			categeory_name 	-- name of the category, used if type is 'post'
	 *			show_children	-- true(default)/false
	 *			order
	 *			orderby
	 *			exludes			-- child page slug to exclude
	 * Ex. 
	 * // this will dis
	 * $options = array(
	 *		'some-slug'	=> array(
	 *			'type'			=> 'post',
	 *			'category_name'	=> 'news'
	 *		)
	 *	);
	 **/
	
	$options = apply_filters( 'swp_sitemap_options', $options );
	
	$def_options = array(
		'_global'	=> array(
			'order'			=> 'ASC',
			'orderby'		=> 'menu_order'
		),
		'_excludes'			=> array()
	);
	
	$options = array_replace_recursive( $def_options, $options );
		
	$exclude_ids = array();
	
	foreach ( $options['_excludes'] as $slug ) {
		$id = swp_post_id_by_slug( $slug );
		$exclude_ids[] = $id;
	}
	
	$args = array(
		'post_type'		=> 'page',
		'post_status'	=> 'publish',
		'order'			=> $options['_global']['order'],
		'orderby'		=> $options['_global']['orderby'],
		'post_parent'	=> 0
	);
	
	if ( ! empty( $exclude_ids ) ) {
		$args['post__not_in'] = $exclude_ids;
	}
	
	$pages = new WP_Query( $args );
	
	$sitemap = ''; 
	
	if ( $pages->have_posts() ) :
		$sitemap .= '<ul>';
		while ( $pages->have_posts() ) : $pages->the_post();
		
			$o = $options;
			$s = $pages->post->post_name;
			$id	=  get_the_id();
			$order = ( isset( $o[$s]['order'] ) ? $o[$s]['order'] : $options['_global']['order'] );
			$orderby = ( isset( $o[$s]['orderby'] ) ? $o[$s]['orderby'] : $options['_global']['orderby'] );
			
			if ( isset( $o[$s]['show_children'] ) && $o[$s]['show_children'] !== true ) {
				continue;
			}
			
			if ( isset( $o[$s]['type'] ) && $o[$s]['type'] == 'post' ) {
				$args = array(
					'category_name'		=> $o[$s]['category_name'],
					'post_type'			=> 'post',
					'post_status'		=> 'publish',
					'order'				=> $order,
					'orderby'			=> $orderby,
					'posts_per_page'	=> -1
				);				
			} else {		
				$args = array(
					'post_type'			=> 'page',
					'post_status'		=> 'publish',
					'order'				=> $order,
					'orderby'			=> $orderby,
					'post_parent'		=> $id
				);				
			}
				
			$children = new WP_Query( $args );
		
			if ( $children->have_posts() ) :				
				$sitemap .= sprintf( '<li><a href="%1$s">%2$s</a>%3$s<ul>', get_permalink(), get_the_title(), PHP_EOL );				
				while ( $children->have_posts() ) : $children->the_post();					
					if ( isset( $o[$s]['excludes'] ) && in_array( $children->post->post_name, $o[$s]['excludes'] ) ) {
						continue;
					}
					$sitemap .= sprintf( '<li><a href="%1$s">%2$s</a></li>', get_permalink(), get_the_title() );				
				endwhile;
				wp_reset_postdata();
				wp_reset_query();
				$sitemap .= sprintf( '</ul></li>' );
			else :			
				$sitemap .= sprintf( '<li><a href="%1$s">%2$s</a></li>', get_permalink(), get_the_title() );			
			endif;			
						
		endwhile;
		$sitemap .= '</ul>';
	endif;
	
	if ( $display ) {
		echo apply_filters( 'swp_sitemap', $sitemap );
		return;
	}
	
	return apply_filters( 'swp_sitemap', $sitemap );
}

function starter_html()
{
	global $pagenow;
?>	
<?php echo create_css_link( swp_assets_url( '/styles/starter.css' ) ); ?>	
	<div class="main-container">
		<header>
			<div id="logo">
				<a href="#"><img src="<?php echo swp_assets_url( '/images/sd-logo.png' ); ?>" /></a>
			</div>
			<h1 class="right"><?php echo sprintf( 'Sushi Wordpress Starter v%s', SushiWP()->settings->version ); ?></h1>
			<div class="clr"></div>
		</header>
		<div id="content-area">		
			<nav id="main-nav">	
				<ul>
					<li class="menu-main <?php echo ( is_front_page() || is_home() ) ? 'current_page_item' : ''; ?>"><?php echo sprintf( '<a href="%s">Main</a>', home_url() ); ?></li>
				</ul>
				<?php wp_nav_menu( array( 'container' => '' ) ); ?>
				<ul>
					<li class="menu-dashboard"><?php echo sprintf( '<a href="%s">Dashboard</a>', admin_url() ); ?></li>
				</ul>
			</nav>
			<div class="main-content left">			
			<?php if ( is_front_page() || is_home() ) : ?>
				<h2>Project Information</h2>				
				<p>
					<strong>Name:</strong> <?php echo get_bloginfo( 'name' ); ?><br />
					<strong>Description:</strong> <?php echo get_bloginfo( 'description' ); ?><br />
					<strong>URL:</strong> <?php echo home_url(); ?><br /><br />
					<strong>System:</strong> <?php echo SushiWP()->settings->model . ' v' . SushiWP()->settings->version; ?><br />
					<strong>Core: </strong> WordPress v<?php echo SushiWP()->settings->wp_version; ?><br />
					<strong>Mode:</strong> <?php echo SWP_STARTER_MODE; ?>
				</p>				
			<?php else : ?>
				<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
					<h2><?php the_title(); ?></h2>
					<?php the_content(); ?>				
				<?php endwhile; endif; ?>
			<?php endif; ?>
			<?php if ( is_404() ) : ?>
				<h2>Error 404 - Page Not Found</h2>
				<p>Sorry, it appears that the page you are trying to view does not exist.<br />Make sure the URL is spelled correctly.</p>				
			<?php endif; ?>
			</div>
			<div class="clr"></div>
		</div>
		<footer>
			<p class="copyright left"><?php echo swp_copyright(); ?></p>
			<p class="site-by right"><?php echo swp_footer_sig(); ?></p>
			<div class="clr"></div>			
		</footer>
	</div>
	<!-- /main-container -->
<?php
}

/**
 * END OF FILE
 * template.php
 */
?>