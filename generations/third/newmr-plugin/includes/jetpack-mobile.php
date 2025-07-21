<?php
/**
 * Jetpack mobile compatibility helpers.
 *
 * Provides a minimal replacement for the old `jetpack_check_mobile` function and
 * hooks to disable Jetpack's legacy mobile theme. Optionally swaps in a mobile
 * template from the active theme when Jetpack reports a mobile device.
 *
 * @package NewMR
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Determine if Jetpack thinks the current request is from a mobile device.
 *
 * Mirrors the behaviour of `jetpack_check_mobile()` from the Jetpack plugin.
 *
 * @return bool
 */
function newmr_jetpack_check_mobile() {
	if ( ( defined( 'XMLRPC_REQUEST' ) && XMLRPC_REQUEST ) || ( defined( 'APP_REQUEST' ) && APP_REQUEST ) ) {
		return false;
	}

	if ( ! isset( $_SERVER['HTTP_USER_AGENT'] ) || ( isset( $_COOKIE['akm_mobile'] ) && 'false' === $_COOKIE['akm_mobile'] ) ) {
		return false;
	}

	if ( newmr_jetpack_mobile_exclude() ) {
		return false;
	}

	if ( 1 === (int) get_option( 'wp_mobile_disable' ) ) {
		return false;
	}

	if ( isset( $_COOKIE['akm_mobile'] ) && 'true' === $_COOKIE['akm_mobile'] ) {
		return true;
	}

	$is_mobile = false;
	if ( function_exists( 'jetpack_is_mobile' ) ) {
		$is_mobile = jetpack_is_mobile();
	}

	return (bool) apply_filters( 'jetpack_check_mobile', $is_mobile );
}

/**
 * Whether the current request should be excluded from mobile mode.
 *
 * @return bool
 */
function newmr_jetpack_mobile_exclude() {
	$exclude          = false;
	$pages_to_exclude = array(
		'wp-admin',
		'wp-comments-post.php',
		'wp-mail.php',
		'wp-login.php',
		'wp-activate.php',
	);

	foreach ( $pages_to_exclude as $page ) {
		if ( isset( $_SERVER['REQUEST_URI'] ) && str_contains( strtolower( sanitize_text_field( wp_unslash( $_SERVER['REQUEST_URI'] ) ) ), $page ) ) {
			$exclude = true;
			break;
		}
	}

	if ( defined( 'DOING_AJAX' ) && true === DOING_AJAX ) {
		$exclude = false;
	}

	if ( isset( $GLOBALS['wp_customize'] ) ) {
		return true;
	}

	return (bool) apply_filters( 'jetpack_mobile_exclude', $exclude );
}

/**
 * Load a mobile template when available.
 *
 * @param string $template Current template path.
 * @return string
 */
function newmr_maybe_load_mobile_template( $template ) {
	if ( ! newmr_jetpack_check_mobile() ) {
		return $template;
	}

	$mobile_template = get_stylesheet_directory() . '/mobile.php';
	if ( file_exists( $mobile_template ) ) {
		return $mobile_template;
	}

	return $template;
}

/**
 * Setup Jetpack mobile integration.
 */
function newmr_setup_jetpack_mobile() {
	// Disable Jetpack's legacy mobile theme if the plugin is present.
	add_filter( 'jetpack_has_mobile_theme', '__return_false' );

	// Swap template when a mobile.php file exists in the active theme.
	add_filter( 'template_include', 'newmr_maybe_load_mobile_template' );
}
add_action( 'plugins_loaded', 'newmr_setup_jetpack_mobile' );
