<?php
/**
 * Class FrClientCache_DI_ContainerFactory
 *
 * @package FrClientCache
 */

defined( 'ABSPATH' ) || die;

/**
 * Dependency injection container factory.
 *
 * @since 1.0.0
 * @author Fahri Rusliyadi <fahri.rusliyadi@gmail.com>
 */
class FrClientCache_DI_ContainerFactory {
	/**
	 * Container definitions.
	 *
	 * @since 1.0.0
	 * @var array
	 */
	private $definitions;

	/**
	 * Construct.
	 *
	 * @since 1.0.0
	 * @param array $definitions Container definitions.
	 */
	public function __construct( $definitions = array() ) {
		$this->definitions = $definitions;
	}

	/**
	 * Create the container.
	 *
	 * @since 1.0.0
	 * @return FrClientCache_DI_Container
	 */
	public function create() {
		$container  = new FrClientCache_DI_Container();
		$factories  = isset( $this->definitions['factories'] ) ? $this->definitions['factories'] : array();
		$invokables = isset( $this->definitions['invokables'] ) ? $this->definitions['invokables'] : array();

		foreach ( $factories as $id => $factory ) {
			$container->set_factory( $id, $factory );
		}

		foreach ( $invokables as $id => $class ) {
			$container->set_invokable( $id, $class );
		}

		return $container;
	}
}
