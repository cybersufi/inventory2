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
					'text' => 'New Link',
					'link' => '#',
					'icon_cls' => 'default',
				),
				array (
					'text' => 'Show Link',
					'link' => '#',
					'icon_cls' => 'default',
				),
			)
		);
		
		$res[] = array(
			'text' => 'User',
			'links' => array (
				array (
					'text' => 'New User',
					'link' => '#',
					'icon_cls' => 'default',
				),
				array (
					'text' => 'Show User',
					'link' => '#',
					'icon_cls' => 'default',
				),
				array (
					'text' => 'Your Account',
					'link' => '#',
					'icon_cls' => 'default',
				),
			)
		);
		
		return $res;
	}
	
	public function breadcrumbs() {
		
	}
}	
?>