<?php
/**
 * Class PluginTest
 *
 * @package FrBrowserCache
 */

/**
 * Plugin test case.
 */
class PluginTest extends WP_UnitTestCase {
	/**
	 * Test run plugin.
	 */
	public function test_run() {
		$container = $this->create_container();
		$plugin    = new FrClientCache_Plugin( $container );
		$handler   = array( $container->get( 'FrClientCache_Frontend_ClientCacheEnabler' ), 'add_cache_headers' );

		$this->assertFalse( has_action( 'wp_headers', $handler ) );
		$plugin->run();
		$this->assertSame( 1000, has_action( 'wp_headers', $handler ) );
	}

	/**
	 * Create container.
	 *
	 * @return FrClientCache_DI_Container Container.
	 */
	private function create_container() {
		$definitions = require plugin_dir_path( __FILE__ ) . '../config/dependencies.php';
		$factory     = new FrClientCache_DI_ContainerFactory( $definitions );

		return $factory->create();
	}
}
