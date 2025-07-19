<?php
/**
 * Plugin Name: NewMR Plugin
 * Plugin URI: https://example.com/
 * Description: Skeleton plugin for the third generation of NewMR.
 * Version: 0.1.0
 * Author: NewMR Team
 * Author URI: https://example.com/
 * License: GPL2
 *
 * @package NewMR
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Initialize the plugin.
 */
function newmr_plugin_init() {
	register_post_type(
		'newmr_item',
		array(
			'public' => true,
			'label'  => 'NewMR Item',
		)
	);
}
add_action( 'init', 'newmr_plugin_init' );

/**
 * Placeholder for plugin activation hook.
 */
function newmr_plugin_activate() {
	// TODO: add activation code.
}
register_activation_hook( __FILE__, 'newmr_plugin_activate' );

/**
 * Placeholder for plugin deactivation hook.
 */
function newmr_plugin_deactivate() {
	// TODO: add deactivation code.
}
register_deactivation_hook( __FILE__, 'newmr_plugin_deactivate' );
