<?php if ( ! defined('APPPATH')) exit('No direct script access allowed');

/**
* Is thrown when the user already exists. This usually happens
* if someone tries to create a user with the same name of an existing
* user.
*/
class PermissionAlreadyExistsException extends SerializableException {
	public function __construct ($perm) {
		parent::__construct(
			sprintf("Failed to add permission. Permission %s already exists.", $perm));
	}
}