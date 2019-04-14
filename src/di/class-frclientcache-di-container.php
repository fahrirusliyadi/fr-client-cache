<?php
/**
 * Class FrClientCache_DI_Container
 *
 * @package FrClientCache
 */

defined( 'ABSPATH' ) || die;

/**
 * Dependency injection container.
 *
 * @since 1.0.0
 * @author Fahri Rusliyadi <fahri.rusliyadi@gmail.com>
 */
class FrClientCache_DI_Container {
	/**
	 * Factory definitions.
	 *
	 * @var array [
	 *      (string) entry identifier => (FrClientCache_DI_EntryFactoryInterface|string)
	 *          factory object or class.
	 *  ]
	 */
	private $factories = array();

	/**
	 * Invokables definitions.
	 *
	 * @var type
	 */
	private $invokables = array();

	/**
	 * Resolved entries.
	 *
	 * @var array
	 */
	private $entries = array();

	/**
	 * Set an entry value.
	 *
	 * @since 1.0.0
	 * @param string $id Entry identifier.
	 * @param mixed  $entry Entry value.
	 */
	public function set( $id, $entry ) {
		$this->entries[ $id ] = $entry;
	}

	/**
	 * Set factory definition.
	 *
	 * @since 1.0.0
	 * @param string $id Entry identifier.
	 * @param string $factory Factory class that implements FrClientCache_DI_EntryFactoryInterface.
	 */
	public function set_factory( $id, $factory ) {
		$this->factories[ $id ] = $factory;
	}

	/**
	 * Set entry invokable definition.
	 *
	 * @since 1.0.0
	 * @param string $id Entry identifier.
	 * @param string $class Class name.
	 */
	public function set_invokable( $id, $class ) {
		$this->invokables[ $id ] = $class;
	}

	/**
	 * Finds an entry of the container by its identifier and returns it.
	 *
	 * @since 1.0.0
	 * @param string $id Identifier of the entry to look for.
	 * @return mixed Entry value.
	 * @throws FrClientCache_DI_NotFoundException If no entry was found.
	 */
	public function get( $id ) {
		if ( array_key_exists( $id, $this->entries ) ) {
			return $this->entries[ $id ];
		}

		if ( isset( $this->factories[ $id ] ) ) {
			$entry = $this->resolve_from_factory( $id );
			$this->set( $id, $entry );

			return $entry;
		}

		if ( isset( $this->invokables[ $id ] ) ) {
			$entry = $this->resolve_from_invokable( $id );
			$this->set( $id, $entry );

			return $entry;
		}

		throw new FrClientCache_DI_NotFoundException( "No entry was found for \"$id\" identitier." );
	}

	/**
	 * Returns true if the container can return an entry for the given identifier.
	 * Returns false otherwise.
	 *
	 * `has($id)` returning true does not mean that `get($id)` will not throw an
	 * exception. It does however mean that `get($id)` will not throw a
	 * `FrClientCache_DI_NotFoundException`.
	 *
	 * @param string $id Identifier of the entry to look for.
	 * @return bool
	 */
	public function has( $id ) {
		if ( array_key_exists( $id, $this->entries ) ) {
			return true;
		}

		if ( array_key_exists( $id, $this->factories ) ) {
			return true;
		}

		if ( array_key_exists( $id, $this->invokables ) ) {
			return true;
		}

		return false;
	}

	/**
	 * Resolve an entry from factory definition.
	 *
	 * @param string $id Identifier of the entry.
	 * @return mixed Entry value.
	 * @throws FrClientCache_DI_InvalidFactoryException If the factory is invalid.
	 */
	private function resolve_from_factory( $id ) {
		/* @var $factory FrClientCache_DI_InvalidFactoryException */ // phpcs:ignore Squiz.PHP.CommentedOutCode.Found
		$factory = new $this->factories[ $id ]();

		if ( ! $factory instanceof FrClientCache_DI_FactoryInterface ) {
			throw new FrClientCache_DI_InvalidFactoryException( "\"$id\" must implements FrClientCache_DI_FactoryInterface." );
		}

		return $factory->create( $this );
	}

	/**
	 * Resolve an entry from invokable definition.
	 *
	 * @param string $id Identifier of the entry.
	 * @return mixed Entry value.
	 */
	private function resolve_from_invokable( $id ) {
		$class = $this->invokables[ $id ];
		return new $class();
	}
}
