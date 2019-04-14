<?php
/**
 * Class FrClientCache_Frontend_ClientCacheEnabler
 *
 * @package FrClientCache
 */

defined( 'ABSPATH' ) || die;

/**
 * Client side cache enabler.
 *
 * @since 1.0.0
 * @author Fahri Rusliyadi <fahri.rusliyadi@gmail.com>
 */
class FrClientCache_Frontend_ClientCacheEnabler {
	/**
	 * Incoming server-side HTTP request.
	 *
	 * @var FrClientCache_HTTP_ServerRequest
	 */
	private $server_request;

	/**
	 * Response headers.
	 *
	 * @var array
	 */
	private $headers;

	/**
	 * Construct.
	 *
	 * @since 1.0.0
	 * @param FrClientCache_HTTP_ServerRequest $server_request Incoming server-side HTTP request.
	 */
	public function __construct( $server_request ) {
		$this->server_request = $server_request;
	}

	/**
	 * Send Last-Modified and Cache-Control headers.
	 *
	 * If client has valid cached response, set response code to 304 and stop
	 * execution.
	 *
	 * @since 1.0.0
	 * @access private
	 * @param array $headers Response headers.
	 * @return array Modified response headers.
	 */
	public function add_cache_headers( $headers ) {
		$this->headers = &$headers;

		if ( isset( $headers['Last-Modified'] ) || is_user_logged_in() ) {
			return $headers;
		}

		if ( $this->server_request->query->count() || $this->server_request->request->count() ) {
			return $headers;
		}

		$last_modified = $this->get_last_modified();
		if ( $last_modified ) {
			$max_age                  = (int) $this->get_max_cache_age();
			$headers['Last-Modified'] = $last_modified;
			$headers['Cache-Control'] = "public, max-age=$max_age, must-revalidate";
		}

		return $headers;
	}

	/**
	 * Send 304 not modified status if client has valid cache and kill WordPress
	 * execution.
	 *
	 * @since 1.0.0
	 * @access private
	 * @return bool False if cancelled.
	 */
	public function send_304_status() {
		if ( ! isset( $this->headers['Last-Modified'] ) || false === $this->headers['Last-Modified'] || headers_sent() ) {
			return false;
		}

		$client_last_modified = getenv( 'HTTP_IF_MODIFIED_SINCE' );
		if ( $client_last_modified === $this->headers['Last-Modified'] ) {
			status_header( 304 );
			add_filter( 'wp_die_handler', array( $this, 'get_die_handler' ) );
			wp_die();

			return true;
		}

		return false;
	}

	/**
	 * Get the wp_die handler.
	 *
	 * @since 1.0.0
	 * @access private
	 * @return string Die handler.
	 */
	public function get_die_handler() {
		return '_scalar_wp_die_handler';
	}

	/**
	 * Get server last modified date.
	 *
	 * @return string|bool Server last content modified date or false on failure.
	 */
	private function get_last_modified() {
		$last_comment_modified   = get_lastcommentmodified( 'GMT' );
		$last_post_modified      = get_lastpostmodified( 'GMT' );
		$last_modified           = strtotime( $last_comment_modified ) > strtotime( $last_post_modified ) ? $last_comment_modified : $last_post_modified;
		$last_modified_formatted = mysql2date( 'D, d M Y H:i:s', $last_modified, false );

		if ( $last_modified_formatted ) {
			$last_modified_formatted .= ' GMT';
		}

		return $last_modified_formatted;
	}

	/**
	 * Get max cache age.
	 *
	 * @return string
	 */
	private function get_max_cache_age() {
		return defined( 'FRBROWSERCACHE_MAX_AGE' ) ? FRBROWSERCACHE_MAX_AGE : HOUR_IN_SECONDS;
	}
}
