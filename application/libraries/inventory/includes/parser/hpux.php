<?php if ( ! defined('APPPATH')) exit('No direct script access allowed');

class hpux extends parser {
	
	private $manifest_file;
	private $machinfo_file;
	private $manifest;
	private $machinfo;
	private $isManifest = false;
	private $isMachinfo = false;
	
	function __construct() {
		parent::__construct();
		$this->manifest = '/opt/ignite/bin/print_manifest';
		$this->machinfo = '/usr/contrib/bin/machinfo';
		$this->manifest_file = '/tmp/manifest_file.txt';
		$this->machinfo_file = '/tmp/machinfo_file.txt';
		$this->sys->setType('hpux');
	}
	
	public function prepareConfig() {
		$str = 'test -f \''.$this->manifest.'\' && echo 1 || echo 0';
		$res = $this->ssh->ex($str);
		$this->isManifest = ($res == 1) ? true : false;
		
		$str = 'test -f \''.$this->machinfo.'\' && echo 1 || echo 0';
		$res = $this->ssh->ex($str);
		$this->isMachinfo = ($res == 1) ? true : false;
		
		if ($this->isMachinfo) {
			$str = $this->machinfo.' > '.$this->machinfo_file;
			$res1 = $this->ssh->ex($str);
		}

		if ($this->isManifest) {
			$str = $this->manifest.' > '.$this->manifest_file;
			$res2 = $this->ssh->ex($str);
		}
		
		return 0;
	}
	
	public function deleteConfig() {
		if ($this->isMachinfo) {
			$str = 'rm -f '.$this->machinfo_file;
			$rst = $this->ssh->ex($str);
		}
		
		if ($this->isManifest) {
			$str = 'rm -f '.$this->manifest_file;
			$rst = $this->ssh->ex($str);
		}
		return 0;
	}
	
	public function getHostname() {
		$str = "hostname";
		$rst = $this->ssh->ex($str);
		$this->sys->setHostname($rst);
		return $this->sys->getHostname();
	}
	
	public function getKernel() {
		$str = "uname -srvm";
		$rst = $this->ssh->ex($str);
		$this->sys->setKernel(trim($rst));
		return $this->sys->getKernel();
	}
	
	function getDistribution() {
		$this->sys->setDistribution('HP UX');
		return $this->sys->getDistribution();
	}
	
	public function getSystemModel() {
		
		if ($this->isMachinfo) {
			$str = 'cat '.$this->machinfo_file.' | egrep -i \'model|model string\'';
			$sysmodel = $this->ssh->ex($str);
		} else if ($this->isManifest) {
			$str = 'cat '.$this->manifest_file.' | grep \'Model\'';
			$sysmodel = $this->ssh->ex($str);
		} else {
			$sysmodel = null;
		}
		
		if ($sysmodel != null) {
			$temp = explode(":", $sysmodel);
			$temp = preg_replace("/(\s\s+|\t|\n)/", " ", trim($temp[1]));
			$temp = str_replace('"', '', $temp);
			$sysmodel = $temp;
		}
		$this->sys->setModel($sysmodel);
		return $this->sys->getModel();
	}
	
	function getMemory() {
		$str = 'swapinfo | grep memory';
		$res = $this->ssh->ex($str);
		
		$text = preg_replace("/(\s\s+|\t|\n)/", " ", trim($res));
		$tmp = explode(" ", $text);
		if (count($tmp) > 1) {
			$mem = new memory();
			$mem->setMemTotal($tmp[1]);
			$mem->setMemUsed($tmp[2]);
			$mem->setMemFree($tmp[2]);
			
			$this->sys->setMemory($mem);
		}
		
		return $this->sys->getMemory();
	}

	function getFirmware() {
		$firm = "";
		if ($this->isMachinfo) {
			$str = 'cat '.$this->machinfo_file.' | grep \'Firmware revision\'';
			$res = $this->ssh->ex($str);
			$res = explode(":", $res);
			$firm = trim($res[1]);
		}
		
		$this->sys->setFirmware($firm);
		return $this->sys->getFirmware();
	}
	
	function getSerial() {
		
			
		if ($this->isMachinfo) {
			$str = 'cat '.$this->machinfo_file.' | grep \'Machine serial number\'';
			$res = $this->ssh->ex($str);
		} else if ($this->isManifest) {
			$str = 'cat '.$this->manifest_file.' | grep \'Serial number\'';
			$res = $this->ssh->ex($str);
		} else {
			$res = "";
		}
		
		$res = explode(":", $res);
		$tmp = preg_replace('~\s{2,}~', ' ', trim($res[1]));
		$this->sys->setSerial($tmp);
		return $this->sys->getSerial();
	}
	
	function getOsBit() {
		$str = 'getconf KERNEL_BITS';
		$res = $this->ssh->ex($str);
		$osbit = trim($res);
		$this->sys->setOsbit($osbit);
		return $this->sys->getOsbit();
	}
	
	function getUptime() {
		$str = "uptime"; 
		$res = $this->ssh->ex($str);
		$uptime = parserhelper::getUptime($res);
		$this->sys->setUptime($uptime);
		return $this->sys->getUptime();
	}
	
	function getCpu() {
		return null;
	}
	
	function getFilesystem() {
		$str = 'bdf';
		$res = $this->ssh->ex($str);
		$fs = parserhelper::bdf($res);
		foreach ($fs as $fs_line) {
			$dev = new filesystem();
			$dev->setName($fs_line[0]);
			$dev->setTotal($fs_line[1]);
			$dev->setUsed($fs_line[2]);
			$dev->setFree($fs_line[3]);
			$dev->setMountPoint($fs_line[5]);
			$this->sys->setFilesystems($dev);
		}
		return $this->sys->getFilesystems();
	}
	
	function getSwapdevice() {
		$str = 'swapinfo | grep dev';
		$res = $this->ssh->ex($str);
		$res = explode("\n", $res);
		foreach ($res as $line) {
			$text = preg_replace("/(\s\s+|\t|\n)/", " ", trim($line));
			$tmp = explode(" ", $text);
			if (count($tmp) > 1) {
				$sw = new filesystem();
				$sw->setName($tmp[8]);
				$sw->setTotal($tmp[1]);
				$sw->setFree($tmp[3]);
				$sw->setUsed($tmp[2]);
				
				$this->sys->setSwapDevices($sw);
			}
		}
		return $this->sys->getSwapDevices();
	}
	
	function getNic() {
		$str = 'lanscan | tail -n +3';
		$res = $this->ssh->ex($str);
		$nic = preg_split("/\n/", $res, -1, PREG_SPLIT_NO_EMPTY);
		$macs = array();
		foreach ($nic as $line) {
			$text = preg_replace("/(\s\s+|\t|\n)/", " ", trim($line));
			$text = explode(' ', $text);
			$mac = explode('x', $text[1]);
			$macs[$text[4]] = $mac[1];
		}
		
		$str = 'netstat -in | tail -n +2';
		$res = $this->ssh->ex($str);
		$res = preg_split("/\n/", $res, -1, PREG_SPLIT_NO_EMPTY);
		
		foreach ($res as $line) {
			$text = preg_replace("/(\s\s+|\t|\n)/", " ", trim($line));
			$tmp = preg_split("/\s+/", $text);
			if (! empty($tmp[0]) && ! empty($tmp[3]) && !strstr($tmp[0], 'lo')) {
				
				$name = explode(':', $tmp[0]);
				$mac = $macs[$name[0]];
				
				$dev = new nic();
                $dev->setName($tmp[0]);
				$dev->setIpAddress($tmp[3]);
				$dev->setMAC($mac);
                $dev->setRxBytes($tmp[4]);
                $dev->setTxBytes($tmp[6]);
                $dev->setErrors($tmp[5] + $tmp[7]);
                $dev->setDrops($tmp[8]);
                $this->sys->setNics($dev);
			}
		}
		
		return $this->sys->getNics();
	}
	
	function run() {
		$this->ssh->connect();
		$this->prepareConfig();
		$this->getHostname();
		$this->getKernel();
		$this->getSystemModel();
		$this->getDistribution();
		$this->getFirmware();
		$this->getSerial();
		$this->getOsBit();
		$this->getUptime();
		
		$this->getFilesystem();
		$this->getSwapdevice();
		$this->getMemory();
		$this->getNic();
		
		
		
		$this->getCpu();
		
		
		
		$this->deleteConfig();
		$this->ssh->disconnect();
	}
}


?>