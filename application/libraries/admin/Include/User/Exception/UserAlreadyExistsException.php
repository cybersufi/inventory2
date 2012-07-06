<?php if ( ! defined('APPPATH')) exit('No direct script access allowed');

/**
* Is thrown when the user already exists. This usually happens
* if someone tries to create a user with the same name of an existing
* user.
*/
class UserAlreadyExistsException extends SerializableException {
	public function __construct ($username) {
		parent::__construct(
			sprintf("User %s already exists.", $username));
	}
}