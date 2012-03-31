<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MenuModel extends CI_Model {
	
	private $users_tbl;
	private $group_tbl;
	private $banned_tbl;
	private $group_count_tbl;
	
	const GET_DETAIL = 1;
	const BY_GROUPNAME = 2;
	
	public function __construct() {
		parent::__construct();
		$this->users_tbl = 'users';
		$this->group_tbl = 'groups';
		$this->banned_tbl = 'banned';
		$this->group_count_tbl = 'group_count';
	}
}

?>