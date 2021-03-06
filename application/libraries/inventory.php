<?php  if ( ! defined('APPPATH')) exit('No direct script access allowed');

require_once APPPATH.'/libraries/inventory/autoloader.php';

class Inventory {
	
	public function createSystem() {
		$blah = new sys();
		return $blah;
	}
	
	public function createGenericOs() {
		$blah = new generic();	
		return $blah;
	}
	
	public function createDevice($deviceType) {
		$deviceType = strtolower($deviceType);	
		switch ($deviceType) {
			case 'cpu' :
				return new cpu();
			break;
			case 'filesystem' :
				return new filesystem();
			break;
			case 'memory' :
				return new memory();
			break;
			case 'nic' :
				return new nic();
			break;
			case 'swap' :
				return new swapdevice();
			break;
			default:
				return false;
		}
	}
	
	public function createParser($deviceType) {
		$deviceType = strtolower($deviceType);
		switch ($deviceType) {
			case 'aix' :
				return new aix();
			break;
			case 'linux' :
				return new linux();
			break;
			case 'hpux' :
				return new hpux();
			break;
			default:
				return false;
		}
	}
	
}


?>