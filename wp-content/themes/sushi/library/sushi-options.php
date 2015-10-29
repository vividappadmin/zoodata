<?php

if ( ! current_user_can( 'manage_options' ) )
	wp_die( __( 'You do not have sufficient permissions to manage options for this site.' ) );

$title = __( 'DRG Theme Settings' );

?>
<style type="text/css">
.hint {
	font-size: 11px;
	color: #999999;
	display: block;
}
.it { font-style: italic; }
</style>
<div class="wrap">
	<?php screen_icon(); ?>
	<h2><?php echo esc_html( $title ); ?></h2>
	<?php if ( $_POST["sushi-form"] === "TRUE" ) : ?>
	<?php
		update_option( WP_OPTION_COPYRIGHT, 			$_POST[ WP_OPTION_COPYRIGHT ] );
		update_option( WP_OPTION_SITE_BY, 				$_POST[ WP_OPTION_SITE_BY ] );
		update_option( WP_OPTION_OFFICIAL_SITE, 		$_POST[ WP_OPTION_OFFICIAL_SITE ] );
		update_option( WP_OPTION_GA_ACCOUNT, 			$_POST[ WP_OPTION_GA_ACCOUNT ] );
		update_option( WP_OPTION_GOOGLE_VERIFICATION, 	$_POST[ WP_OPTION_GOOGLE_VERIFICATION ] );
		update_option( WP_OPTION_BING_VERIFICATION, 	$_POST[ WP_OPTION_BING_VERIFICATION ] );
	?>
	<div class="updated"><p><strong><?php _e('Settings saved.' ); ?></strong></p></div> 
	<?php endif; ?>	
	<form id="sushi-theme" action="<?php _e( $_SERVER['REQUEST_URI'] ); ?>" method="post">
		<input type="hidden" name="sushi-form" value="TRUE" />
		<h3>General</h3>
		<table class="form-table">			
			<tr valign="top">
				<th scope="row"><label for="<?php _e( WP_OPTION_COPYRIGHT ); ?>">Copyright</label></th>
				<td>
					<input type="text" class="regular-text" value="<?php _e( form_option( WP_OPTION_COPYRIGHT ) ); ?>" id="<?php _e( WP_OPTION_COPYRIGHT ); ?>" name="<?php _e( WP_OPTION_COPYRIGHT ); ?>">					
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><label for="<?php _e( WP_OPTION_SITE_BY ); ?>">Site By</label></th>
				<td>
					<input type="text" class="regular-text" value="<?php _e( form_option( WP_OPTION_SITE_BY ) ); ?>" id="<?php _e( WP_OPTION_SITE_BY ); ?>" name="<?php _e( WP_OPTION_SITE_BY ); ?>">					
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><label for="<?php _e( WP_OPTION_OFFICIAL_SITE ); ?>">Official Site URL</label></th>
				<td>
					<input type="text" class="regular-text" value="<?php _e( form_option( WP_OPTION_OFFICIAL_SITE ) ); ?>" id="<?php _e( WP_OPTION_OFFICIAL_SITE ); ?>" name="<?php _e( WP_OPTION_OFFICIAL_SITE ); ?>">					
				</td>
			</tr>
		</table>
		<h3>SEO Options</h3>
		<table class="form-table">			
			<tr valign="top">
				<th scope="row"><label for="<?php _e( WP_OPTION_GA_ACCOUNT ); ?>">Google Analytics Account</label></th>
				<td>
					<input type="text" class="regular-text" value="<?php _e( form_option( WP_OPTION_GA_ACCOUNT ) ); ?>" id="<?php _e( WP_OPTION_GA_ACCOUNT ); ?>" name="<?php _e( WP_OPTION_GA_ACCOUNT ); ?>">
					<span class="hint it">( eg. 'UA-38159957-1' )</span>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><label for="<?php _e( WP_OPTION_GOOGLE_VERIFICATION ); ?>">Google Site Verification Code</label></th>
				<td>
					<input type="text" class="regular-text" value="<?php _e( form_option( WP_OPTION_GOOGLE_VERIFICATION ) ); ?>" id="<?php _e( WP_OPTION_GOOGLE_VERIFICATION ); ?>" name="<?php _e( WP_OPTION_GOOGLE_VERIFICATION ); ?>">
					<span class="hint it">&lt;meta name='google-site-verification' content='...' /&gt;</span>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><label for="<?php _e( WP_OPTION_BING_VERIFICATION ); ?>">Bing Validation Code</label></th>
				<td>
					<input type="text" class="regular-text" value="<?php _e( form_option( WP_OPTION_BING_VERIFICATION ) ); ?>" id="<?php _e( WP_OPTION_BING_VERIFICATION ); ?>" name="<?php _e( WP_OPTION_BING_VERIFICATION ); ?>">
					<span class="hint it">&lt;meta name='msvalidation.01' content='...' /&gt;</span>
				</td>
			</tr>
		</table>
		<div class="submit"><input type="submit" value="Save Settings" name="submit" class="button"></div>
	</form>

</div>