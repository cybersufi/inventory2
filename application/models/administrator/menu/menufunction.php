<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MenuFunction extends CI_Model {
	
	public function __construct() {
		parent::__construct();
		$this->users_tbl = 'users';
		$this->group_tbl = 'groups';
		$this->banned_tbl = 'banned';
		$this->group_count_tbl = 'group_count';
	}
}

?>