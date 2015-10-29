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
 
require_once( ABSPATH . 'wp-admin/admin.php' );

if ( ! current_user_can( 'manage_options' ) ) {
	wp_die( "You ain't got enough permissions to access this page, mate. ;)" );
}

include_once( swp_admin_dir( '/includes/class-packages-list-table.php' ) );

$active_package = SushiWP()->swp_get_option( 'active_package' );
if ( $active_package !== SWP_DEFAULT_PACKAGE && ! file_exists( SWP_PACKAGES_DIR . '/' . $active_package . '/package.php' ) ) {
	SushiWP()->swp_set_option( 'active_package', SWP_DEFAULT_PACKAGE );
	$msg = sprintf( 'The package <code>%s</code> has been deactivated due to an error: Package file does not exist. Please reinstall Sushi Wordpress Starter core files.', '"' . $active_package . '"'  );
}
	
$title = __( 'Schemes & Skins' );

$package_table = new Sushi_Packages_List_Table();
$package_table->prepare_items();

$action	 = $package_table->current_action();
$page	 = isset( $_REQUEST['page'] ) ? $_REQUEST['page'] : '' ;
$package = isset( $_REQUEST['package'] ) ? $_REQUEST['package'] : '';

$_SERVER['REQUEST_URI'] = remove_query_arg( array( 'error', 'activate', 'deactivate', '_error_nonce'), $_SERVER['REQUEST_URI'] );

switch ( $action ) {
	case 'activate':		
		/* Activating a package will deactivate the current active package. */
		if ( swp_activate_package( @$_REQUEST['package'] ) ) {
			do_action( 'swp_activate_package', $package );
		}
		break;
	case 'deactivate':
		/* Deactivating a package will reactivate the default package. */
		do_action( 'swp_deactivate_package' );				
		break;
	default:
		break;
}

function swp_activate_package( $package )
{
	if ( is_null( $package ) ) {
		return false;
	}
	
	if ( $package === SushiWP()->settings->default_package ) {
		SushiWP()->swp_set_option( 'active_package', SushiWP()->settings->default_package );
		return true;
	}
	
	$file = sanitize_path( SWP_PACKAGES_DIR . '/' . $package . '/package.php' );
	
	if ( file_exists( $file ) ) {			
		require_once( $file );
		
		return true;
	} 
	
	return false;
}

if ( ! empty( $msg ) ) {
?><div id="message" class="error"><p><?php echo $msg; ?></p></div><?php
}

if ( isset( $_GET['error'] ) ) :	
	$msg = __( 'Failed to activate package.' );
?>
	<div id="message" class="error"><p><?php echo $msg; ?></p></div>
<?php elseif ( isset( $_GET['activate'] ) ) : ?>
	<div id="message" class="updated"><p><?php _e( 'Package <strong>activated</strong>.' ); ?></p></div>
<?php elseif ( isset( $_GET['deactivate'] ) ) : ?>
	<div id="message" class="updated"><p><?php _e( 'Package <strong>deactivated</strong>. Reverted to default package.' ); ?></p></div>
<?php endif; ?>
<div class="wrap swp-wrap">	
	<h2><span class="swp-icon-books">&nbsp;</span><?php echo $title; ?></h2>
	
	<form id="packages-form" method="get">
		<input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>" />
		<?php $package_table->display(); ?>
	</form>
</div>
<?php
/**
 * END OF FILE
 * admin/menu-package.php
 */
?>