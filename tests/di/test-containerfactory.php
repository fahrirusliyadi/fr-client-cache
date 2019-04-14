<?php
/**
 * Class ContainerFactoryTest
 *
 * @package FrBrowserCache
 */

/**
 * Dependency injection container factory test case.
 */
class ContainerFactoryTest extends WP_UnitTestCase {
	/**
	 * Create container test.
	 */
	public function test_create() {
		$factory = new FrClientCache_DI_ContainerFactory();

		$this->assertInstanceOf( 'FrClientCache_DI_Container', $factory->create() );
	}

	/**
	 * Factory definition test.
	 */
	public function test_factory_definition() {
		$entry_class = 'DIContainerFactoryTest\test_factory_definition\entry_factory';
		$entry       = Mockery::mock( "overload:$entry_class", 'FrClientCache_DI_FactoryInterface' );
		$entry->shouldReceive( 'create' )->with( Mockery::type( 'FrClientCache_DI_Container' ) )->andReturn( 'product' );

		$definition = array(
			'factories' => array(
				'factory' => $entry_class,
			),
		);
		$factory    = new FrClientCache_DI_ContainerFactory( $definition );
		$container  = $factory->create();

		$this->assertTrue( $container->has( 'factory' ) );
		$this->assertSame( 'product', $container->get( 'factory' ) );
	}

	/**
	 * Invokable definition test.
	 */
	public function test_invokable_definition() {
		$entry       = Mockery::mock();
		$entry_class = get_class( $entry );

		$definition = array(
			'invokables' => array(
				$entry_class => $entry_class,
			),
		);
		$factory    = new FrClientCache_DI_ContainerFactory( $definition );
		$container  = $factory->create();

		$this->assertTrue( $container->has( $entry_class ) );
		$this->assertInstanceOf( $entry_class, $container->get( $entry_class ) );
	}
}
