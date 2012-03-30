<?php

class SiteTemplate extends CI_Model {
  
  	function __construct() {
    	parent::__construct();
    	$this->serverlist = 'app_serverlist';
    	$this->servertype = 'app_servertype';
    	$this->servernic = 'app_serverniclist';
  	}
	
	public function siteNavigation() {
		$res = array();
				
		$res[] = array(
			'text' => 'Content',
			'links' => array (
				array (
					'text' => 'Show Link',
					'link' => '#',
					'icon_cls' => 'icn_categories',
				),
				array (
					'text' => 'New Link',
					'link' => '#',
					'icon_cls' => 'icn_new_article',
				),
			)
		);
		
		$res[] = array(
			'text' => 'User',
			'links' => array (
				array (
					'text' => 'Show User',
					'link' => 'user',
					'icon_cls' => 'icn_view_users',
				),
				array (
					'text' => 'New User',
					'link' => '#',
					'icon_cls' => 'icn_add_user',
				),
				array (
					'text' => 'Your Account',
					'link' => '#',
					'icon_cls' => 'icn_profile',
				),
			)
		);
		
		$res[] = array(
			'text' => 'Group',
			'links' => array (
				array (
					'text' => 'Show Group',
					'link' => '#',
					'icon_cls' => 'icn_view_users',
				),
				array (
					'text' => 'New Group',
					'link' => '#',
					'icon_cls' => 'icn_add_user',
				),
			)
		);
		
		$res[] = array(
			'text' => 'Admin',
			'links' => array (
				array (
					'text' => 'Logout',
					'link' => '#',
					'icon_cls' => 'icn_jump_back',
				),
			)
		);
		
		return $res;
	}
	
	public function breadcrumbs() {
		
	}
}	
?>