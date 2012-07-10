<?php if ( ! defined('APPPATH')) exit('No direct script access allowed');

/**
* Is thrown when the user already exists. This usually happens
* if someone tries to create a user with the same name of an existing
* user.
*/
class PermissionUpdateFailedException extends SerializableException {
	public function __construct ($perm_name) {
		parent::__construct(
			sprintf("Update data for permission %s failed. Please try again.", $perm_name));
	}
}