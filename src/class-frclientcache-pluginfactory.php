<?php
/**
 * Class FrClientCache_PluginFactory
 *
 * @package FrClientCache
 */

defined( 'ABSPATH' ) || die;

/**
 * Plugin factory.
 *
 * @since 1.0.0
 * @author Fahri Rusliyadi <fahri.rusliyadi@gmail.com>
 */
class FrClientCache_PluginFactory implements FrClientCache_DI_FactoryInterface {
	/**
	 * {@inheritdoc}
	 *
	 * @since 1.0.0
	 * @param FrClientCache_DI_Container $container Container instance.
	 * @return FrClientCache_Plugin
	 */
	public function create( FrClientCache_DI_Container $container ) {
		return new FrClientCache_Plugin( $container );
	}
}
