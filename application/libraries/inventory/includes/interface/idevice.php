<?php if ( ! defined('APPPATH')) exit('No direct script access allowed');

interface idevice {
	
	/**
     * build the os information from database
     *
     * @return void
     */
    function loadFromDatabase();
	
	/**
     * save the os information to database
     *
     * @return void
     */
    function saveToDatabase();
}
?>
