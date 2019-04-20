<?php
/**
 * Plugin Name:     Fr Client Cache
 * Plugin URI:
 * Description:     Enable client side browser page cache.
 * Author:          Fahri Rusliyadi
 * Author URI:      https://profiles.wordpress.org/fahrirusliyadi/
 * Text Domain:     fr-client-cache
 * Domain Path:     /languages
 * Version:         0.0.0
 *
 * @package FrClientCache
 */

/**
 * Load plugin class.
 *
 * @since 1.0.0
 * @access private
 * @param string $class Class name.
 */
function frclientcache_autoload( $class ) {
	$prefix   = 'FrClientCache_';
	$base_dir = plugin_dir_path( __FILE__ ) . 'src/';

	// Does the class use the prefix?
	$prefix_len = strlen( $prefix );
	if ( strncmp( $prefix, $class, $prefix_len ) !== 0 ) {
		// No, move to the next registered autoloader.
		return;
	}

	$lower_class = strtolower( $class );
	// Get the relative class name.
	$relative_path = substr( $lower_class, 0, strrpos( $lower_class, '_' ) + 1 );
	$relative_path = substr( $relative_path, $prefix_len );
	// Replace the prefix with the base directory, replace separators with directory
	// separators in the relative path.
	$path = path_join( $base_dir, str_replace( '_', '/', $relative_path ) );
	$file = path_join( $path, 'class-' . str_replace( '_', '-', $lower_class ) . '.php' );

	if ( file_exists( $file ) ) {
		require $file;
	}
}
spl_autoload_register( 'frclientcache_autoload' );

/**
 * Run plugin.
 *
 * @since 1.0.0
 * @access private
 */
function frclientcache_run() {
	$dir = plugin_dir_path( __FILE__ );

	// Load constants.
	require $dir . 'config/constants.php';

	$container_config  = require $dir . 'config/dependencies.php';
	$container_factory = new FrClientCache_DI_ContainerFactory( $container_config );
	$container         = $container_factory->create();

	$plugin = $container->get( 'FrClientCache_Plugin' );
	$plugin->run();
}
add_action( 'plugins_loaded', 'frclientcache_run' );
// Run the plugin on activation so if there is an error, the plugin will not be
// activated.
register_activation_hook( __FILE__, 'frclientcache_run' );
