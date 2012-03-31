<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	$this->extloader->loadbase();
	$this->extloader->stylesheet('ux/css/checkheader');
	$this->extloader->javascript('ux/checkcolumn');
	$this->asset->stylesheet('administrator/menu/menu');
	$this->asset->javascript('administrator/menu');
	$this->asset->javascript('administrator/menu/config');
	$this->asset->javascript('administrator/menu/menulist');
	$this->asset->javascript('administrator/menu/menuitemlist');
	$this->asset->javascript('administrator/menu/menupanel');
	$this->asset->javascript('administrator/menu/menu');
?>