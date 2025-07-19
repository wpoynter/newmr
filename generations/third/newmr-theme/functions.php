<?php
/**
 * Theme bootstrap file.
 *
 * @package NewMR
 */

/**
 * Theme functions and definitions
 */
function newmr_theme_setup() {
	add_theme_support( 'wp-block-styles' );
}
add_action( 'after_setup_theme', 'newmr_theme_setup' );
