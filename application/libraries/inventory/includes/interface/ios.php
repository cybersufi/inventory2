<?php if ( ! defined('APPPATH')) exit('No direct script access allowed');

interface ios
{
    /**
     * get a special encoding from os where phpsysinfo is running
     *
     * @return string
     */
    function getEncoding();
    
    /**
     * build the os information
     *
     * @return void
     */
    function build();
    
    /**
     * get the filled or unfilled (with default values) system object
     *
     * @return System
     */
    function getSys();
}
?>
