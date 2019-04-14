<?php
/**
 * Class PluginFactoryTest
 *
 * @package FrBrowserCache
 */

/**
 * Plugin factory test case.
 */
class PluginFactoryTest extends WP_UnitTestCase {
	/**
	 * Test create plugin instance.
	 */
	public function test_create() {
		$container = $this->create_container();
		$factory   = new FrClientCache_PluginFactory();
		$plugin    = $factory->create( $container );

		$this->assertInstanceOf( 'FrClientCache_Plugin', $plugin );
	}

	/**
	 * Create container.
	 *
	 * @return FrClientCache_DI_Container Container.
	 */
	private function create_container() {
		$factory = new FrClientCache_DI_ContainerFactory();

		return $factory->create();
	}
}
