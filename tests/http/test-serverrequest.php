<?php
/**
 * Class ServerRequestTest
 *
 * @package FrBrowserCache
 */

/**
 * Server HTTP request test case.
 */
class ServerRequestTest extends WP_UnitTestCase {
	/**
	 * Set query string parameter via constructor.
	 */
	public function test_get_query_param() {
		$request = new FrClientCache_HTTP_ServerRequest( array( 'fruit' => 'apple' ) );

		$this->assertSame( 'apple', $request->query['fruit'] );
	}

	/**
	 * Set query string parameter directly to parameter bag.
	 */
	public function test_set_query_param() {
		$request = new FrClientCache_HTTP_ServerRequest();

		$this->assertNull( $request->query['fruit'] );
		$request->query['fruit'] = 'apple';
		$this->assertSame( 'apple', $request->query['fruit'] );
	}

	/**
	 * Set request parameter via constructor.
	 */
	public function test_get_request_param() {
		$request = new FrClientCache_HTTP_ServerRequest( array(), array( 'fruit' => 'apple' ) );

		$this->assertSame( 'apple', $request->request['fruit'] );
	}

	/**
	 * Set request parameter directly to parameter bag.
	 */
	public function test_set_request_param() {
		$request = new FrClientCache_HTTP_ServerRequest();

		$this->assertNull( $request->request['fruit'] );
		$request->request['fruit'] = 'apple';
		$this->assertSame( 'apple', $request->request['fruit'] );
	}
}
