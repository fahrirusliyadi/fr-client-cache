<?php
/**
 * Class FrClientCache_HTTP_ServerRequest.
 *
 * @package FrClientCache
 */

defined( 'ABSPATH' ) || die;

/**
 * Representation of an incoming, server-side HTTP request.
 *
 * @since 1.0.0
 * @author Fahri Rusliyadi <fahri.rusliyadi@gmail.com>
 */
class FrClientCache_HTTP_ServerRequest {
	/**
	 * Query string parameters ($_GET).
	 *
	 * @since 1.0.0
	 * @var FrClientCache_HTTP_ParameterBag
	 */
	public $query;

	/**
	 * Request body parameters ($_POST).
	 *
	 * @since 1.0.0
	 * @var FrClientCache_HTTP_ParameterBag
	 */
	public $request;

	/**
	 * Construct.
	 *
	 * @since 1.0.0
	 * @param array $query Query string parameters.
	 * @param array $request Request body parameters.
	 */
	public function __construct( $query = array(), $request = array() ) {
		$this->query   = new FrClientCache_HTTP_ParameterBag( $query );
		$this->request = new FrClientCache_HTTP_ParameterBag( $request );
	}
}
