<?php if ( ! defined('APPPATH')) exit('No direct script access allowed');

abstract class device implements idevice {
    /**
     * load data from database and filled to system object
     *
     * @see ios::loadFromDatabase()
     *
     * @return void
     */
	public final function loadFromDatabase() {
		$CI =& get_instance();	
	}
	
	public final function saveToDatabase() {
		return null;
	}
}
?>
