<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	$this->extloader->loadbase();
	$this->extloader->stylesheet('ux/css/checkheader');
	$this->extloader->javascript('ux/checkcolumn');
	$this->asset->stylesheet('siteadmin/menu');
	$this->asset->javascript('siteadmin/config');
	$this->asset->javascript('siteadmin/menu/config');
	$this->asset->javascript('siteadmin/menu/menulist');
	$this->asset->javascript('siteadmin/menu/menuitemlist');
	$this->asset->javascript('siteadmin/menu/menupanel');
	$this->asset->javascript('siteadmin/menu/menu');
?>