<?php if (!defined('APPPATH')) exit('No direct script access allowed');

interface Serializable {
	/**
	 * Serializes the entity into an array format, which in turn can
	 * be used by json_encode.
	 * @return array The serialized form of the entity
	 */
	public function serialize ();
}

?>