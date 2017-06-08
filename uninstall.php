<?php

// This is checking to make sure the plugin is being uninstalled by a Wordpress // Admin. This variable only contains a value if an Admin is activating the
// uninstall script from inside Wordpress.

if( !defined( 'WP_UNINSTALL_PLUGIN' ) )
	exit(); // End the script if accessed by a non-admin

delete_option( 'sc_defaults', 'sc_title');

?>
