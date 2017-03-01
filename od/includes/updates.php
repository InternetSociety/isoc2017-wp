<?php

if( get_option( 'occhio_auto_update' ) || get_option( 'occhio_auto_update' ) === false ) {

	// auto-update everything that is auto-updatable (client does not have a OpenSource servicecontract)
	add_filter( 'allow_minor_auto_core_updates', '__return_true' ); // maintenance and security (are default ON)
	add_filter( 'allow_major_auto_core_updates', '__return_true' );
	add_filter( 'auto_update_plugin', '__return_true' ); // be aware that some plugins do not auto-update
	add_filter( 'auto_update_theme', '__return_true' ); // be aware that some themes do not auto-update
	add_filter( 'auto_update_translation', '__return_true' );
	add_filter( 'automatic_updates_is_vcs_checkout', '__return_false', 1 );
	add_filter( 'auto_core_update_send_email', '__return_true' ); // sends email
	add_filter( 'automatic_updates_send_debug_email', '__return_true', 1 ); // sends debugging email for each automatic background update.

}

// ----  dashboard widget ----
if ( !function_exists('occhio_wp_updates_dashboard_widget_function') ) {
    function occhio_wp_updates_dashboard_widget_function() {

    	if( isset( $_GET['od_wp_update_setting'] ) ) {
    		update_option( 'occhio_auto_update', $_GET['od_wp_update_setting'] );
    	}

    	if( get_option( 'occhio_auto_update' ) || get_option( 'occhio_auto_update' ) === false ) {
			echo <<<EOHTML
	<p>
		<span class="dashicons dashicons-yes" style="color: green; float: right;"></span>
		Deze website heeft automatische updates aan staan.<br>
		Zet de automatische updates <a href="./?od_wp_update_setting=0">uit</a>.
	</p>
EOHTML;

    	} else {
			echo <<<EOHTML
	<p>
		<span class="dashicons dashicons-warning" style="color: red; float: right;"></span>
		Deze website wordt momenteel niet automatisch geupdate.<br>
		Zet deze automatische updates <a href="./?od_wp_update_setting=1">aan</a> wanneer er geen open-source serviceovereenkomst is.
	</p>
EOHTML;
    	}
    }
}
// Function used in the action hook
function add_occhio_wp_updates_dashboard_widgets() {

	// only show if user is superadmin
	if( !is_super_admin() ) {
		return;
	}
	wp_add_dashboard_widget( 'add_occhio_wp_updates_dashboard_widgets', 'Occhio updates', 'occhio_wp_updates_dashboard_widget_function' );
}

// Register the new dashboard widget with the 'wp_dashboard_setup' action
add_action( 'wp_dashboard_setup', 'add_occhio_wp_updates_dashboard_widgets' );
