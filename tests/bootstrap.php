<?php
/**
 * PHPUnit bootstrap file
 *
 * @package Fr_Browser_Cache
 */

$_frclientcache_test_dir = getenv( 'WP_TESTS_DIR' );

if ( ! $_frclientcache_test_dir ) {
	$_frclientcache_test_dir = rtrim( sys_get_temp_dir(), '/\\' ) . '/wordpress-tests-lib';
}

if ( ! file_exists( $_frclientcache_test_dir . '/includes/functions.php' ) ) {
	echo "Could not find $_frclientcache_test_dir/includes/functions.php, have you run bin/install-wp-tests.sh ?" . PHP_EOL; // phpcs:ignore WordPress.Security.EscapeOutput
	exit( 1 );
}

// Give access to tests_add_filter() function.
require_once $_frclientcache_test_dir . '/includes/functions.php';

/**
 * Manually load the plugin being tested.
 */
function _frclientcache_manually_load_plugin() {
	require dirname( dirname( __FILE__ ) ) . '/fr-client-cache.php';
}
tests_add_filter( 'muplugins_loaded', '_frclientcache_manually_load_plugin' );

// Start up the WP testing environment.
require $_frclientcache_test_dir . '/includes/bootstrap.php';
