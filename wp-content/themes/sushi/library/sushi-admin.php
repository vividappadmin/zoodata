<?php
/*
* SUSHI ADMIN CONFIGURATION
* - Add/Manage Sushi settings
*/

/* Sushi SEO Settings */
function add_sushi_theme_menu()
{
	if ( current_user_can( 'manage_options' ) )
		add_options_page( "DRG Theme Settings", "DRG Theme", 1, "sushi-theme", "sushi_theme_menu" );
}
function sushi_theme_menu()
{
	require_once( "sushi-options.php" );
}

/*
* END OF FILE
* sushi-admin.php
*/
?>