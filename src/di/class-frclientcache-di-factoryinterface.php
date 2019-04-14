<?php
/**
 * Class FrClientCache_DI_FactoryInterface
 *
 * @package FrClientCache
 */

defined( 'ABSPATH' ) || die;

/**
 * Dependency injection entry factory.
 *
 * @since 1.0.0
 * @author Fahri Rusliyadi <fahri.rusliyadi@gmail.com>
 */
interface FrClientCache_DI_FactoryInterface {
	/**
	 * Create the entry instance.
	 *
	 * @since 1.0.0
	 * @param FrClientCache_DI_Container $container Container instance.
	 */
	public function create( FrClientCache_DI_Container $container);
}
