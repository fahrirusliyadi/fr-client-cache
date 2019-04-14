<?php
/**
 * Class FrClientCache_HTTP_ParameterBag.
 *
 * @package FrClientCache
 */

defined( 'ABSPATH' ) || die;

/**
 * HTTP parameter bag.
 *
 * @since 1.0.0
 */
class FrClientCache_HTTP_ParameterBag extends ArrayIterator {
	/**
	 * {@inheritdoc}
	 *
	 * @since 1.0.0
	 * @param mixed $index The offset to get the value from.
	 * @return mixed|null The value at offset `index` or null if the index does not
	 * exist.
	 */
	public function offsetGet( $index ) {
		if ( $this->offsetExists( $index ) ) {
			return parent::offsetGet( $index );
		}
	}
}
