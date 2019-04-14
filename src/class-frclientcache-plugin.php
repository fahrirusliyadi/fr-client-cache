<?php
/**
 * Class FrClientCache_Plugin
 *
 * @package FrClientCache
 */

defined( 'ABSPATH' ) || die;

/**
 * Plugin.
 *
 * @since 1.0.0
 * @author Fahri Rusliyadi <fahri.rusliyadi@gmail.com>
 */
class FrClientCache_Plugin {
	/**
	 * Container instance.
	 *
	 * @var FrClientCache_DI_Container
	 */
	private $container;

	/**
	 * Construct.
	 *
	 * @since 1.0.0
	 * @param FrClientCache_DI_Container $container Container instance.
	 */
	public function __construct( FrClientCache_DI_Container $container ) {
		$this->container = $container;
	}

	/**
	 * Hooks into WordPress.
	 *
	 * @since 1.0.0
	 */
	public function run() {
		if ( ! is_admin() ) {
			$enable_client_cache = $this->container->get( 'FrClientCache_Frontend_ClientCacheEnabler' );

			add_filter( 'wp_headers', array( $enable_client_cache, 'add_cache_headers' ), 1000 );
			add_action( 'send_headers', array( $enable_client_cache, 'send_304_status' ) );
		}
	}
}
