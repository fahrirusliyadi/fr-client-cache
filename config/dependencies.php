<?php
/**
 * Dependency injection configuration.
 *
 * @since 1.0.0
 * @author Fahri Rusliyadi <fahri.rusliyadi@gmail.com>
 * @package FrClientCache
 */

defined( 'ABSPATH' ) || die;

return array(
	// Any class that may be instantiated without any constructor arguments.
	'invokables' => array(),
	// Map a service name to the factory capable of producing the instance. The
	// factory must implements FrClientCache_DI_FactoryInterface.
	'factories'  => array(
		'FrClientCache_Plugin'                      => 'FrClientCache_PluginFactory',
		'FrClientCache_HTTP_ServerRequest'          => 'FrClientCache_HTTP_ServerRequestFactory',
		'FrClientCache_Frontend_ClientCacheEnabler' => 'FrClientCache_Frontend_ClientCacheEnablerFactory',
	),
);
