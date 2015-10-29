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

function system_settings_general()
{
?>
					<table class="form-table">
						<tr valign="top">
							<th>Font Icons</th>
							<td>
								<fieldset>
									<label for="enable_swp_icons">
										<input name="<?php echo SushiWP()->options['enable_swp_icons']['name']; ?>" type="checkbox" id="enable_swp_icons" value="1" <?php checked( '1', SushiWP()->swp_get_option( 'enable_swp_icons' ) ); ?> />
										<?php echo 'Enable at Front-end'; ?>
										<?php swp_tips_button( 'enable_swp_icons' ); ?>
									</label>
								</fieldset>
							</td>
						</tr>
						<tr valign="top">
							<th>CSS3 PIE</th>
							<td>
								<fieldset>
									<label for="enable_css3_pie">
										<input name="<?php echo SushiWP()->options['enable_css3_pie']['name']; ?>" type="checkbox" id="enable_css3_pie" value="1" <?php checked( '1', SushiWP()->swp_get_option( 'enable_css3_pie' ) ); ?> />
										<?php echo 'Enable CSS3 Pie for IE8 and Below'; ?>
										<?php swp_tips_button( 'enable_css3_pie' ); ?>
									</label>
								</fieldset>
							</td>
						</tr>
						<tr valign="top">
							<th>WordPress Overrides</th>
							<td>
								<fieldset>
									<label for="hide_wp_adminbar">
										<input name="<?php echo SushiWP()->options['hide_wp_adminbar']['name']; ?>" type="checkbox" id="hide_wp_adminbar" value="1" <?php checked( '1', SushiWP()->swp_get_option( 'hide_wp_adminbar' ) ); ?> />
										<?php echo 'Hide Admin Bar When Logged On'; ?>
									</label>
								</fieldset>
								<fieldset>
									<label for="disable_wp_about_pages">
										<input name="<?php echo SushiWP()->options['disable_wp_about_pages']['name']; ?>" type="checkbox" id="disable_wp_about_pages" value="1" <?php checked( '1', SushiWP()->swp_get_option( 'disable_wp_about_pages' ) ); ?> />
										<?php echo 'Disable WordPress About Pages <small><em>(About, Freedom, Credits...)</em></small>'; ?>
									</label>
								</fieldset>
								<fieldset>
									<label for="disable_wp_update_notif">
										<input name="<?php echo SushiWP()->options['disable_wp_update_notif']['name']; ?>" type="checkbox" id="disable_wp_update_notif" value="1" <?php checked( '1', SushiWP()->swp_get_option( 'disable_wp_update_notif' ) ); ?> />
										<?php echo 'Disable Dashboard Update Notifications'; ?>
									</label>
								</fieldset>
								<fieldset>
									<label for="disable_wp_widgets_ui">
										<input name="<?php echo SushiWP()->options['disable_wp_widgets_ui']['name']; ?>" type="checkbox" id="disable_wp_widgets_ui" value="1" <?php checked( '1', SushiWP()->swp_get_option( 'disable_wp_widgets_ui' ) ); ?> />
										<?php echo 'Disable WordPress Widgets'; ?>
									</label>
								</fieldset>
								<fieldset>
									<label for="disable_wp_theme_editor">
										<input name="<?php echo SushiWP()->options['disable_wp_theme_editor']['name']; ?>" type="checkbox" id="disable_wp_theme_editor" value="1" <?php checked( '1', SushiWP()->swp_get_option( 'disable_wp_theme_editor' ) ); ?> />
										<?php echo 'Disable Theme Editor Menu'; ?>
									</label>
								</fieldset>
								<fieldset>
									<label for="disable_wp_thumbnails" title="Adding images to Media Library will no longer generate thumbnails.">
										<input name="<?php echo SushiWP()->options['disable_wp_thumbnails']['name']; ?>" type="checkbox" id="disable_wp_thumbnails" value="1" <?php checked( '1', SushiWP()->swp_get_option( 'disable_wp_thumbnails' ) ); ?> />
										<?php echo 'Disable Media Thumbnails Generation'; ?>
									</label>
								</fieldset>
							</td>
						</tr>
						<tr valign="top">
							<th>Starter Options</th>
							<td>
								<fieldset>
									<label for="force_wordpress_admin_skin">
										<input name="<?php echo SushiWP()->options['force_wordpress_admin_skin']['name']; ?>" type="checkbox" id="force_wordpress_admin_skin" value="1" <?php checked( '1', SushiWP()->swp_get_option( 'force_wordpress_admin_skin' ) ); ?> />
										<?php echo 'Force Default Wordpress Dashboard Styles'; ?>
										<?php swp_tips_button( 'force_wordpress_admin_skin' ); ?>
									</label>
								</fieldset>	
								<fieldset>
									<label for="default_footer_texts">
										<input name="<?php echo SushiWP()->options['default_footer_texts']['name']; ?>" type="checkbox" id="default_footer_texts" value="1" <?php checked( '1', SushiWP()->swp_get_option( 'default_footer_texts' ) ); ?> />
										<?php echo 'Use Default Footer Texts'; ?>
										<?php swp_tips_button( 'default_footer_texts' ); ?>
									</label>
								</fieldset>								
							</td>
						</tr>
					</table>
<?php
}

function system_settings_seo_tools()
{
?>
					<table class="form-table">
						<tr valign="top">
							<th><label for="google_ad_code"><?php echo 'Google Ad Code'; ?></label></th>
							<td>
								<fieldset>
									<?php $code = SushiWP()->swp_get_option( 'google_ad_code', '' ); ?>
									<textarea name="<?php echo SushiWP()->options['google_ad_code']['name']; ?>" id="google_ad_code" rows="8" cols="30" <?php echo empty( $code ) ?  'placeholder="Paste your script here..."' : ''; ?>><?php echo $code; ?></textarea>
								</fieldset>
								<fieldset>
									<label for="google_ad_code_footer" title="Whether to place GA codes at the footer or header.">
										<input name="<?php echo SushiWP()->options['google_ad_code_footer']['name']; ?>" type="checkbox" id="google_ad_code_footer" value="1" <?php checked( '1', SushiWP()->swp_get_option( 'google_ad_code_footer' ) ); ?> />
										<?php echo 'Place GA Code at the footer'; ?>
										<?php swp_tips_button( 'google_ad_code_footer' ); ?>
									</label>

								</fieldset>
							</td>
						</tr>
						<tr valign="top">
							<th><label><?php echo 'Footer Signature'; ?></label></th>
							<td>
								<div><em>Select the footer signature to use.</em> <?php swp_tips_button( 'footer_sig' ); ?></div>
								<br />
								<fieldset>
								<?php 
								$current = SushiWP()->swp_get_option( 'footer_sig' );
								$sigs = SushiWP()->settings->footer_sigs;
							
								foreach ( $sigs as $id => $sig ) {									
									echo "<fieldset>\n";
									echo sprintf( '<label><strong>%s</strong></label><br />', $sig['title'] );
									echo sprintf( '<label><input type="radio" name="%4$s" value="%1$s" %2$s /> %3$s</label>', $id, ( $current == $id ) ? 'checked="checked"' : '', htmlentities( $sig['link'] ), SushiWP()->options['footer_sig']['name'] );						
									echo sprintf( '<br /><small>%s</small><br />', $sig['label'] );
									echo sprintf( '<small>%s</small><br /><br />', swp_footer_sig( $id ) );
									echo "</fieldset>\n";
								}
								?>
								</fieldset>								
							</td>
						</tr>
						<tr valign="top">
							<th><label><?php echo 'Error 404'; ?></label></th>
							<td>
								<fieldset>
									<label for="redirect_404">
										<input name="<?php echo SushiWP()->options['redirect_404']['name']; ?>" type="checkbox" id="redirect_404" value="1" <?php checked( '1', SushiWP()->swp_get_option( 'redirect_404' ) ); ?> />
										<?php echo 'Redirect 404 Page to Home URL'; ?>
									</label>
								</fieldset>
							</td>
						</tr>
					</table>
<?php
}

$tab = $_GET['tab'];

?>
<div class="wrap">
	<h2><span class="swp-icon-settings">&nbsp;</span><?php echo __( 'System Configuration', 'swp' ); ?></h2>

	<?php if ( ! empty( SushiWP()->config->tabs ) ) : 

		if ( ! in_array( $tab, array_keys( SushiWP()->config->tabs ) ) ) {	
			$tab = current( array_keys( SushiWP()->config->tabs ) );	
		}
		
		SushiWP()->config->authenticate( $tab );

	endif; ?>

	<?php if ( isset( $_GET['settings-updated'] ) && $_GET['settings-updated'] == 'true' ) : ?>
	<div id="message" class="updated"><p>Settings saved.</p></div>
	<?php elseif ( isset( $_GET['error'] ) ) : ?>
	<div id="message" class="error"><p>Failed to save settings.</p></div>
	<?php endif; ?>

	<form action="options.php" method="post">
	<?php SushiWP()->config->render_settings(); ?>				
	</form>

</div>

<?php
/*
* END OF FILE
* admin/menu-settings.php
*/
?>