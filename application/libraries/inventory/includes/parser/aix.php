<?php if ( ! defined('APPPATH')) exit('No direct script access allowed');

class aix extends parser {
	
	private $configFile;
	
	function __construct() {
		$this->sys->setType('aix');
		$this->configFile = '/tmp/webprtconf.txt';
	}
	
	public function prepareConfig() {
		$str = 'prtconf > '.$this->configFile;
		$rst = $this->ssh->ex($str);
		return $rst;
	}
	
	public function deleteConfig() {
		$str = 'rm -f '.$this->configFile;
		$rst = $this->ssh->ex($str);
		return $rst;
	}
	
	public function getHostname() {
		$str = "hostname";
		$rst = $this->ssh->ex($str);
		$this->sys->setHostname($rst);
		return $this->sys->getHostname();
	}
	
	public function getKernel() {
		$str1 = "oslevel";
		$str2 = "oslevel -s";
		$rst1 = $this->ssh->ex($str1);
		$rst2 = $this->ssh->ex($str2);
		$rst = $rst1.' ('.$rst2.')';
		$this->sys->setKernel($rst);
		return $this->sys->getKernel();
	}
	
	public function getSystemModel() {
		$str = 'cat '.$this->configFile.' | grep \'System Model\'';
		$sysmodel = $this->ssh->ex($str);
		$this->sys->setModel($sysmodel);
	}
	
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
	
    
}


?>