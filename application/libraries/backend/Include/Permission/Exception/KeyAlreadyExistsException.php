<?php if ( ! defined('APPPATH')) exit('No direct script access allowed');

/**
* Is thrown when the user already exists. This usually happens
* if someone tries to create a user with the same name of an existing
* user.
*/
class KeyAlreadyExistsException extends SerializableException {
	public function __construct ($key) {
		parent::__construct(
			sprintf("Failed to add permission. Key %s already exists.", $key));
	}
}