<?php
/*
Plugin Name: Live Vote
Plugin URI:  https://livevote.com
Description: Live Vote is a global sentiment platform that gathers consumer sentiment in an agile environment while bringing your content to life.
Version:     1.1
Author:      Live Vote
Author URI:  https://livevote.com
*/


if ( ! defined( 'ABSPATH' ) ) {
	die( 'Access denied.' );
}

define( 'LV_NAME',                 'Live Vote' );
define( 'LV_REQUIRED_PHP_VERSION', '5.3' );                          // because of get_called_class()
define( 'LV_REQUIRED_WP_VERSION',  '3.1' );                          // because of esc_textarea()
/**
 * Checks if the system requirements are met
 *
 * @return bool True if system requirements are met, false if not
 */
function lv_requirements_met() {
	global $wp_version;
	//require_once( ABSPATH . '/wp-admin/includes/plugin.php' );		// to get is_plugin_active() early
	if ( version_compare( PHP_VERSION, LV_REQUIRED_PHP_VERSION, '<' ) ) {
		return false;
	}
	if ( version_compare( $wp_version, LV_REQUIRED_WP_VERSION, '<' ) ) {
		return false;
	}

	return true;
}
/**
 * Prints an error that the system requirements weren't met.
 */
function lv_requirements_error() {
	global $wp_version;
	require_once( dirname( __FILE__ ) . '/views/requirements-error.php' );
}
/*
 * Check requirements and load main class
 * The main program needs to be in a separate file that only gets loaded if the plugin requirements are met. Otherwise older PHP installations could crash when trying to parse it.
 */
if ( lv_requirements_met() ) {
	require_once( __DIR__ . '/classes/lv-module.php' );
	require_once( __DIR__ . '/classes/lv-plugin.php' );
	require_once( __DIR__ . '/includes/admin-notice-helper/admin-notice-helper.php' );
	require_once( __DIR__ . '/classes/lv-widget.php' );
	require_once( __DIR__ . '/classes/lv-post.php' );
	require_once( __DIR__ . '/classes/lv-settings.php' );
	if ( class_exists( 'LV_Plugin' ) ) {
		$GLOBALS['lv'] = LV_Plugin::get_instance();
		register_activation_hook(   __FILE__, array( $GLOBALS['lv'], 'activate' ) );
		register_deactivation_hook( __FILE__, array( $GLOBALS['lv'], 'deactivate' ) );
	}
} else {
	add_action( 'admin_notices', 'lv_requirements_error' );
}
