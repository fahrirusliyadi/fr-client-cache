<?php
/**
 * Class ClientCacheEnabler
 *
 * @package FrBrowserCache
 */

/**
 * Client HTTP cache enabler test case.
 */
class ClientCacheEnabler extends WP_UnitTestCase {
	/**
	 * Cancel if Last-Modified header already exists.
	 */
	public function test_cancel_if_has_last_modified_header() {
		$headers = array(
			'Last-Modified' => 'Wed, 21 Oct 2015 07:28:00 GMT',
		);
		$request = new FrClientCache_HTTP_ServerRequest();
		$service = new FrClientCache_Frontend_ClientCacheEnabler( $request );

		$this->assertSame( $headers, $service->add_cache_headers( $headers ) );
	}

	/**
	 * Cancel if the current user is logged.
	 */
	public function test_cancel_if_logged_in() {
		// Create a post so we can get last modified date.
		$this->factory()->post->create();
		// Log user with ID 1 in.
		wp_set_current_user( 1 );

		$headers = array();
		$request = new FrClientCache_HTTP_ServerRequest();
		$service = new FrClientCache_Frontend_ClientCacheEnabler( $request );

		$this->assertSame( $headers, $service->add_cache_headers( $headers ) );
	}

	/**
	 * Cancel if has query parameters.
	 */
	public function test_cancel_if_has_query_params() {
		$headers = array();
		$request = new FrClientCache_HTTP_ServerRequest( array( 'fruit' => 'apple' ) );
		$service = new FrClientCache_Frontend_ClientCacheEnabler( $request );

		$this->assertSame( $headers, $service->add_cache_headers( $headers ) );
	}

	/**
	 * Cancel if has request parameters.
	 */
	public function test_cancel_if_has_request_params() {
		$headers = array();
		$request = new FrClientCache_HTTP_ServerRequest( array(), array( 'fruit' => 'apple' ) );
		$service = new FrClientCache_Frontend_ClientCacheEnabler( $request );

		$this->assertSame( $headers, $service->add_cache_headers( $headers ) );
	}

	/**
	 * Cancel if the blog does not have any posts.
	 */
	public function test_cancel_if_no_posts() {
		$request = new FrClientCache_HTTP_ServerRequest();
		$service = new FrClientCache_Frontend_ClientCacheEnabler( $request );
		$headers = $service->add_cache_headers( array() );

		$this->assertSame( array(), $headers );
	}

	/**
	 * Cache enabled test.
	 */
	public function test_cache_enabled() {
		// Create a post so we can get last modified date.
		$this->factory()->post->create();

		$request = new FrClientCache_HTTP_ServerRequest();
		$service = new FrClientCache_Frontend_ClientCacheEnabler( $request );
		$headers = $service->add_cache_headers( array() );

		$this->assertArrayHasKey( 'Last-Modified', $headers );
		$this->assertArrayHasKey( 'Cache-Control', $headers );
	}

	/**
	 * Cancel send 304 response if does not have Last-Modified on the response header.
	 */
	public function test_cancel_send_304_status_if_does_not_have_last_modified_header() {
		$request = new FrClientCache_HTTP_ServerRequest();
		$service = new FrClientCache_Frontend_ClientCacheEnabler( $request );

		$service->add_cache_headers( array() );
		$this->assertFalse( $service->send_304_status() );
	}

	/**
	 * Cancel send 304 response if client has expired cache.
	 *
	 * @runInSeparateProcess
	 */
	public function test_cancel_send_304_status_if_client_has_expired_cache() {
		$request = new FrClientCache_HTTP_ServerRequest();
		$service = new FrClientCache_Frontend_ClientCacheEnabler( $request );

		putenv( 'HTTP_IF_MODIFIED_SINCE=Wed, 21 Oct 2015 06:28:00 GMT' ); // phpcs:ignore WordPress.PHP.DiscouragedPHPFunctions.runtime_configuration_putenv
		$service->add_cache_headers( array( 'Last-Modified' => 'Wed, 21 Oct 2015 07:28:00 GMT' ) );
		$this->assertFalse( $service->send_304_status() );
	}

	/**
	 * Send 304 not modified response if the client has valid cache.
	 *
	 * @runInSeparateProcess
	 */
	public function test_send_304_status() {
		$request = new FrClientCache_HTTP_ServerRequest();
		$service = new FrClientCache_Frontend_ClientCacheEnabler( $request );

		add_filter( 'wp_die_handler', array( $this, 'get_return_null_callback' ), 11 );
		putenv( 'HTTP_IF_MODIFIED_SINCE=Wed, 21 Oct 2015 07:28:00 GMT' ); // phpcs:ignore WordPress.PHP.DiscouragedPHPFunctions.runtime_configuration_putenv
		$service->add_cache_headers( array( 'Last-Modified' => 'Wed, 21 Oct 2015 07:28:00 GMT' ) );
		$this->assertTrue( $service->send_304_status() );
	}

	/**
	 * Test get wp_die handler.
	 */
	public function test_get_die_handler() {
		$request = new FrClientCache_HTTP_ServerRequest();
		$service = new FrClientCache_Frontend_ClientCacheEnabler( $request );

		$this->assertSame( '_scalar_wp_die_handler', $service->get_die_handler() );
	}

	/**
	 * Returns `__return_null` callback.
	 */
	public function get_return_null_callback() {
		return '__return_null';
	}
}
