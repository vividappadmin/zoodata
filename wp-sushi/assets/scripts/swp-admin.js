/*
* SUSHI WORDPRESS ADMIN SCRIPTS
*
* @version: 1.0
* @since: Sashimi 3.1
*/

jQuery( function($) {	

	/* Package Activation / Deactivation */
	$( '.button.activate-package' ).on( 'click', function(e) {		
		if ( ! confirm( "Activating this package will enable its features and may change the way the Dashboard behaves. This package would also create its own database tables if necessary.\n\nUpon activation, the current active package would be deactivated. If you need to clean up, you may do it through its configuration menu.\n\nAre you sure you want to proceed?" ) ) {
			e.preventDefault();
		}
	});
	
	$( '.button.deactivate-package' ).on( 'click', function(e) {		
		if ( ! confirm( "Deactivating this package will uninstall its features and activate the default package. To clean up, such as deleting the tables it created, you may do so through its configuration menu. You may wish to backup though.\n\nAre you sure you want to proceed?" ) ) {
			e.preventDefault();
		}
	});
	
	// Disable click event
	$( '.button.default-package[disabled="disabled"]' ).off( 'click' );
	
});

function swp_redirect( url ) {
	document.location.href = url;
}