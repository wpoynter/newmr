<?php
/**
 * PHPUnit bootstrap file
 */

$root_dir      = dirname( dirname( __DIR__ ) );
$tests_wp_dir  = $root_dir . '/tests/wordpress';
$install_script = $root_dir . '/tests/bin/install-wp-tests.sh';

// Always start with a fresh WordPress test environment.
if ( file_exists( $tests_wp_dir ) ) {
    exec( 'rm -rf ' . escapeshellarg( $tests_wp_dir ) );
}

if ( is_readable( $install_script ) ) {
    passthru( escapeshellcmd( $install_script ), $retval );
    if ( 0 !== $retval ) {
        fwrite( STDERR, "Failed installing WordPress test environment\n" );
        exit( 1 );
    }
}

require_once $root_dir . '/vendor/autoload.php';

// Give access to tests_add_filter() function.
require_once getenv( 'WP_PHPUNIT__DIR' ) . '/includes/functions.php';

tests_add_filter( 'muplugins_loaded', function() {
    require dirname( dirname( __DIR__ ) ) . '/generations/third/newmr-plugin/newmr-plugin.php';
} );

// Start up the WP testing environment.
require getenv( 'WP_PHPUNIT__DIR' ) . '/includes/bootstrap.php';
