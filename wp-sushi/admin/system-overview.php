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

function swp_system_overview()
{?>
<div class="wrap swp-wrap">
	<h2><span class="swp-icon-cogs">&nbsp;</span><?php _e( 'System Overview', 'swp' ); ?></h2>
	<?php swp_system_info(); ?>
	<?php swp_site_info(); ?>
</div>

<?php
wp_nonce_field( 'closedpostboxes', 'closedpostboxesnonce', false );
wp_nonce_field( 'meta-box-order', 'meta-box-order-nonce', false );
?>

<script type="text/javascript">
	//<![CDATA[
	jQuery( function($) {
		$('.if-js-closed').removeClass('if-js-closed').addClass('closed');
		// postboxes	
		//postboxes.add_postbox_toggles('swp-overview');	
		postboxes.add_postbox_toggles('swp');		
	});
	//]]>
</script>

<?php
}

function swp_system_info()
{?>
	<div id="swp-overview" class="metabox-holder">
		<div id="post-body" class="">
			<div class="has-sidebar-content">
			<?php do_meta_boxes('swp-overview', 'normal', null); ?>
			</div>
		</div>
	</div>
<?php
}

function swp_site_info()
{?>
<div id="swp-siteinfo" class="metabox-holder">
		<div id="post-body" class="">
			<div class="has-sidebar-content">
			<?php do_meta_boxes('swp-siteinfo', 'normal', null); ?>
			</div>
		</div>
	</div>
<?php
}

function swp_system_overview_show()
{
?>
	<div id="system-info">
		<table id="system-overview-table" border="0" cellpadding="0" cellspacing="0">
			<tr>
				<td width="50%">
					<table class="system-overview-list" border="0" cellpadding="0" cellspacing="0">
						<tr>
							<td class="label">Model: </td>
							<td class="field"><strong><?php echo SushiWP()->settings->model; ?></strong></td>
						</tr>
						<tr>
							<td class="label">Version: </td>
							<td class="field"><strong><?php echo SushiWP()->settings->version; ?></strong></td>
						</tr>
						<tr>
							<td class="label">Core:</td>
							<td class="field"><strong>WordPress <?php echo SushiWP()->settings->wp_version; ?></strong></td>
						</tr>
						<tr>
							<td class="label">Package Mode:</td>
							<td class="field"><strong><?php echo SushiWP()->settings->package_mode; ?></strong></td>
						</tr>
						<tr>
							<td class="label">Status:</td>
							<td class="field"><strong><?php echo SWP_STARTER_MODE; ?></strong></td>
						</tr>
						<tr>
							<td class="label">&nbsp;</td>
							<td class="field"></td>
						</tr>
						<tr>
							<td class="label">Admin Theme:</td>
							<td class="field"><strong><?php echo SushiWP()->get_active_Skin()->name; ?></strong></td>
						</tr>
						<tr>
							<td class="label">&nbsp;</td>
							<td class="field"></td>
						</tr>
						<tr>
							<td class="label">Browser Info:</td>
							<td class="field"><strong><?php echo $_SERVER['HTTP_USER_AGENT']; ?></strong></td>
						</tr>
						<tr>
							<td class="label">Local Date &amp; Time:</td>
							<td class="field">
							<?php
							$now = new DateTime( 'UTC' );
							$now->setTimeZone( new DateTimeZone( 'Australia/Perth' ) );
							?>
								<strong><?php echo sprintf( '%s', $now->format( 'l, g:ia jS F Y' ) ); ?></strong>
							</td>
						</tr>
					</table>
				</td>
				<td width="50%">
					<table class="system-overview-list" border="0" cellpadding="0" cellspacing="0">
						<tr>
							<td class="label">
								<?php 
								$s = sizeof( get_option( 'active_plugins' ) );
								echo sprintf( 'Active Plugin%s (%s) :', ( $s > 1 ) ? 's' : '', $s ); ?>
							</td>
							<td class="field">
								<?php
								$plugins = get_option( 'active_plugins' );
								if ( ! empty( $plugins ) ) : ?>								
								<ul>
								<?php								
								foreach ( $plugins as $plugin ) {
									$info = get_plugin_data( sanitize_path( WP_PLUGIN_DIR . '/' . $plugin ) );
									echo sprintf( '<li><strong>%s %s</strong></li>', $info['Name'], $info['Version'] );
								}
								?>
								</ul>
								<?php else :?>
								<b><em>No active plugins...</em></b>
								<?php endif; ?>
							</td>
						</tr>
					</table>
				</td>				
			</tr>
		</table>		
	</div>
<?php 
}

function swp_system_siteinfo_show()
{
	global $current_user;
?>
	<div id="site-info">
		<ul class="system-overview-list">
			<li>URL: <a href="<?php echo home_url( '/' ); ?>"><strong><?php echo home_url( '/' ); ?></strong></a></li>
			<li>Site Title: <strong><?php echo get_bloginfo( 'name' ); ?></strong></li>
			<li>Site Description: <b><?php echo get_bloginfo( 'description' ); ?></b></li>
			<li>&nbsp;</li>
			<li>Display Name: <strong><?php echo $current_user->data->user_nicename;  ?></strong></li>
			<li>Login: <strong><?php echo $current_user->data->user_login; ?></strong></li>
			<li>Email: <strong><?php echo $current_user->data->user_email; ?></strong></li>
			<li>
			<?php
				$r = sizeof( $current_user->roles );
				echo sprintf( 'Access Level%s: <strong>%s</strong>', ( $r > 1 ) ? 's' : '', ucwords( implode( ', ', $current_user->roles ) ) );
			?>
			</li>
		</ul>
	</div>
<?php 
}


add_meta_box( 'swp_system_overview', __('System Information', 'swp'), 'swp_system_overview_show', 'swp-overview', 'normal', 'default');
add_meta_box( 'swp_system_siteinfo', __('Site and User Information', 'swp'), 'swp_system_siteinfo_show', 'swp-siteinfo', 'normal', 'default');

/**
 * END OF FILE
 * admin/menu-main.php
 */
?>