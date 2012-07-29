<?php if ( ! defined('APPPATH')) exit('No direct script access allowed');

/**
* Is thrown when the user doesn't exist.
*/
class PermissionDoesNotExistException extends SerializableException {
	public function __construct () {
		parent::__construct(
			sprintf("Permission doesn't exist. Maybe it was deleted."));
	}
}