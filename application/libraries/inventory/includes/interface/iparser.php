<?php if ( ! defined('APPPATH')) exit('No direct script access allowed');

interface iparser {
	
    function getHostname();
	function getKernel();
	function getSystemModel();
	function getTotalMemory();
	function getFirmware();
	function getSerial();
	function getOsBit();
	function getUptime();
	function getCpu();
	function getFilesystem();
	function getSwapdevice();
	function getNic();
	function run();
	function getSys();
	function setSsh($ssh);
}
?>
