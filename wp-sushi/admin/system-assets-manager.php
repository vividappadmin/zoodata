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


function am_assets()
{

}

function am_directories()
{
	
}

$tab = $_GET['tab'];

if ( ! in_array( $tab, array_keys( SushiWP()->am->config->tabs ) ) ) {	
	$tab = current( array_keys( SushiWP()->am->config->tabs ) );	
}

SushiWP()->am->config->active_tab = $tab;

?>
<div class="wrap swp-wrap">
	<h2><span class="swp-icon-drawer3">&nbsp;</span><?php _e( 'Assets Manager', 'swp' ); ?></h2>
	<form action="options.php" method="post">
		<?php SushiWP()->am->config->render_settings(); ?>
		<?php submit_button(); ?>
	</form>
</div>
<?php
/**
 * END OF FILE
 * admin/system-assets-manager.php
 */
?>