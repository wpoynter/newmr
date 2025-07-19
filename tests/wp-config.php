<?php

/* Path to the WordPress codebase you'd like to test. Add a forward slash in the end. */
define( 'ABSPATH', dirname( dirname( __FILE__ ) ) . '/wordpress/' );

/*
 * Path to the theme to test with.
 * The 'default' theme is symlinked from the tests directory into
 * the themes directory of the WordPress installation defined above.
 */
define( 'WP_DEFAULT_THEME', 'default' );

// Test with WordPress debug mode (default).
define( 'WP_DEBUG', true );

// ** MySQL settings ** //
// This configuration file will be used by the copy of WordPress being tested.
// WARNING: These tests will DROP ALL TABLES in the database with the prefix named below.

define( 'DB_NAME', getenv( 'WP_DB_NAME' ) ?: 'wp_phpunit_tests' );
define( 'DB_USER', getenv( 'WP_DB_USER' ) ?: 'root' );
define( 'DB_PASSWORD', getenv( 'WP_DB_PASS' ) ?: '' );
define( 'DB_HOST', getenv( 'WP_DB_HOST' ) ?: 'localhost' );
define( 'DB_CHARSET', 'utf8' );
define( 'DB_COLLATE', '' );

$table_prefix = 'tests_';

define( 'WP_TESTS_DOMAIN', 'example.org' );
define( 'WP_TESTS_EMAIL', 'admin@example.org' );
define( 'WP_TESTS_TITLE', 'Test Blog' );

define( 'WP_PHP_BINARY', 'php' );

define( 'WPLANG', '' );
