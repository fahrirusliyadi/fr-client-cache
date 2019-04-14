<?php
/**
 * Class ServerRequestFactoryTest
 *
 * @package FrBrowserCache
 */

/**
 * Server HTTP request factory test case.
 */
class ServerRequestFactoryTest extends WP_UnitTestCase {
	/**
	 * Create server HTTP request instance.
	 */
	public function test_create() {
		$factory = new FrClientCache_HTTP_ServerRequestFactory();

		$this->assertInstanceOf( 'FrClientCache_HTTP_ServerRequest', $factory->create( new FrClientCache_DI_Container() ) );
	}
}
