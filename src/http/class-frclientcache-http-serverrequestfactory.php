<?php
/**
 * Class FrClientCache_HTTP_ServerRequestFactory.
 *
 * @package FrClientCache
 */

defined( 'ABSPATH' ) || die;

/**
 * FrClientCache_HTTP_ServerRequest factory.
 *
 * @since 1.0.0
 * @author Fahri Rusliyadi <fahri.rusliyadi@gmail.com>
 */
class FrClientCache_HTTP_ServerRequestFactory implements FrClientCache_DI_FactoryInterface {
	/**
	 * {@inheritdoc}
	 *
	 * @since 1.0.0
	 * @param FrClientCache_DI_Container $container Dependency injection.
	 * @return FrClientCache_HTTP_ServerRequest Server request.
	 */
	public function create( FrClientCache_DI_Container $container ) {
		$query   = (array) filter_input_array( INPUT_GET );
		$request = (array) filter_input_array( INPUT_POST );

		return new FrClientCache_HTTP_ServerRequest( $query, $request );
	}

}
