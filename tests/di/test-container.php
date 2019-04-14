<?php
/**
 * Class ContainerTest
 *
 * @package FrBrowserCache
 */

/**
 * Dependency injection container test case.
 */
class ContainerTest extends WP_UnitTestCase {
	/**
	 * Raw entry value test.
	 */
	public function test_raw() {
		$container = new FrClientCache_DI_Container();

		$this->assertFalse( $container->has( 'fruit' ) );
		$container->set( 'fruit', 'apple' );
		$this->assertTrue( $container->has( 'fruit' ) );
		$this->assertSame( 'apple', $container->get( 'fruit' ) );
	}

	/**
	 * Entry does not exist test.
	 */
	public function test_entry_not_found() {
		$container = new FrClientCache_DI_Container();

		$this->assertFalse( $container->has( 'not_exist' ) );

		$this->expectException( 'FrClientCache_DI_NotFoundException' );
		$container->get( 'not_exist' );
	}

	/**
	 * Invalid factory class test.
	 */
	public function test_invalid_factory() {
		$container       = new FrClientCache_DI_Container();
		$invalid_factory = $this->prophesize();
		$invalid         = $invalid_factory->reveal();
		$invalid_class   = get_class( $invalid );

		$this->assertFalse( $container->has( 'invalid' ) );
		$container->set_factory( 'invalid', $invalid_class );
		$this->assertTrue( $container->has( 'invalid' ) );

		$this->expectException( 'FrClientCache_DI_InvalidFactoryException' );
		$container->get( 'invalid' );
	}

	/**
	 * Invokable definition test.
	 */
	public function test_invokable() {
		$container       = new FrClientCache_DI_Container();
		$invokable       = $this->prophesize()->reveal();
		$invokable_class = get_class( $invokable );

		$this->assertFalse( $container->has( 'invokeable' ) );
		$container->set_invokable( 'invokable', $invokable_class );
		$this->assertTrue( $container->has( 'invokable' ) );
		$this->assertInstanceOf( $invokable_class, $container->get( 'invokable' ) );
	}
}
