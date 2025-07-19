<?php
/**
 * PHPUnit bootstrap file
 */

require_once dirname( dirname( __DIR__ ) ) . '/vendor/autoload.php';

// Give access to tests_add_filter() function.
require_once getenv( 'WP_PHPUNIT__DIR' ) . '/includes/functions.php';

tests_add_filter( 'muplugins_loaded', function() {
    require dirname( dirname( __DIR__ ) ) . '/generations/third/newmr-plugin/newmr-plugin.php';
} );

// Start up the WP testing environment.
require getenv( 'WP_PHPUNIT__DIR' ) . '/includes/bootstrap.php';
