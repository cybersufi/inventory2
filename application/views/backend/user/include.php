<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	$this->extloader->loadbase();
	
	$this->asset->stylesheet('administrator/user/user'); 
		
	$this->asset->javascript('administrator/user/config');
	$this->asset->javascript('administrator/user/user');
	$this->asset->javascript('administrator/user/userlist');
?>