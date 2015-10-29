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
 
function swp_admin_title( $admin_title, $title )
{
	return sprintf( '%1$s &laquo; %2$s &#8212; Sushi Digital', $title, get_bloginfo( 'name' ) );
}

/**
 * Print styles for Customize.php
 */
function swp_customize_print_styles()
{
	echo create_css_link(  swp_active_admin_skin_url( '/css/dashboard.css' ) );
}

function swp_admin_footer_text( $text )
{
	return apply_filters( 'swp_admin_footer_text', sprintf( 'Brought to you by <a href="http://www.sushidigital.com.au" target="_blank">Sushi Digital Online Solutions Incorporated</a>, %s.', date( 'Y' ) ) );
}

function swp_update_footer( $text )
{
	return apply_filters( 'swp_update_footer', sprintf( '<strong>System:</strong> <a href="#" onclick="return false;">%s %s</a>', SushiWP()->settings->model, SushiWP()->settings->version ) );
}

function disable_wp_thumbnails_generation( $sizes )
{
    unset( $sizes['thumbnail'] );
    unset( $sizes['medium'] );
    unset( $sizes['large'] );
	
	return $sizes;
}

/**
 * Disable Dashboard update notices.
 */
function swp_hide_nag()
{
	global $submenu;  
	// remove notice
	remove_action( 'admin_notices', 'update_nag', 3 );
	// remove link
	unset($submenu['index.php'][10]);	
	
	return $submenu;
}

function remove_wp_logo_menus( $wp_admin_bar )
{	
	$wp_admin_bar->remove_node( 'about' );
	$wp_admin_bar->remove_node( 'wp-logo-external' );
	$wp_admin_bar->remove_node( 'updates' );
	$wp_admin_bar->remove_node( 'comments' );
}
add_action( 'admin_bar_menu', 'remove_wp_logo_menus', 999 );

function swp_tips_javascript()
{?>
<script type="text/javascript">
jQuery( function($) {

	$( 'a.swp-tips' ).on( 'click', function(e) {
		e.preventDefault();
		
		var id =  $(this).attr( 'id' );		
		
		var data = {
			action: 'swp_tips',
			tip_id: id
		};
		
		$.post( ajaxurl, data, function( response ) {
			var html = $( response ),
				tid = '#' + html.attr( 'id' );
			console.log( html );
			if ( $( tid ).length ) {
				$( tid ).fadeIn( 800 );
			} else {
				$( '#' + id ).after( html );
				$( tid ).fadeIn( 800, function() {
					var d = $( this );
					$( this ).find( '.close' ).on( 'click', function(e) {
						e.preventDefault();
						$( d ).fadeOut( 800 );
					});
				});
			}
		});
	});	
});
</script>
<?php
	
}

function swp_tips_callback()
{	
	$id = $_POST['tip_id'];
	$tip = swp_get_tips( str_replace( 'button-', '', $id ) );
	
	if ( $tip ) : ?>
<div id="swp-<?php echo $id; ?>" class="swp-tips-dialogue">
	<h4>Tips and Guides</h4>
	<?php echo $tip; ?>
	<a href="#" class="close swp-icon-close"></a>
</div>		
	<?php endif;

	die();
}
add_action( 'wp_ajax_swp_tips', 'swp_tips_callback' );

function swp_tips_button( $id )
{
	echo sprintf( '<a href="#" id="button-%s" class="swp-tips" title="Click to show Guides and Tips."><span class="swp-icon-info2"></span></a>', $id );
}


/**
 * END OF FILE
 * admin/admin.php
 */
?>