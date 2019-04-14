<?php
/**
 * Class FrClientCache_Frontend_ClientCacheEnablerFactory
 *
 * @package FrClientCache
 */

defined( 'ABSPATH' ) || die;

/**
 * FrClientCache_Frontend_ClientCacheEnabler factory.
 *
 * @since 1.0.0
 * @author Fahri Rusliyadi <fahri.rusliyadi@gmail.com>
 */
class FrClientCache_Frontend_ClientCacheEnablerFactory implements FrClientCache_DI_FactoryInterface {
	/**
	 * {@inheritdoc}
	 *
	 * @since 1.0.0
	 * @param FrClientCache_DI_Container $container Dependency injection container.
	 * @return FrClientCache_Frontend_ClientCacheEnabler Client cache enabler.
	 */
	public function create( FrClientCache_DI_Container $container ) {
		$request = $container->get( 'FrClientCache_HTTP_ServerRequest' );

		return new FrClientCache_Frontend_ClientCacheEnabler( $request );
	}
}
