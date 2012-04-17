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
		/*$mem = new memory();
			
		$str = 'cat '.$this->configFile.' | grep \'Good Memory Size\'';
		$res = $this->ssh->ex($str);
		$res = explode(":", $res);
		$res1 = explode(" ", $res[1]);
		$tm = trim($res1[1]);
		$mem->setMemTotal($tm);
		
		$str = 'svmon -G | head -2|tail -1| awk {\'print $3\'}';
		$res = $this->ssh->ex($str);
		$um = intval(intval($res) / 256);
		$mem->setMemUsed($um);
		
		$fm = $tm - $um;
		$mem->setMemFree($fm);
		
		$this->sys->setMemory($mem);
		return $this->sys->getMemory();*/
		return null;
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
		$str = 'swap -l | grep -v "device"';
		$res = $this->ssh->ex($str);
		$res = explode("\n", $res);
		foreach ($res as $line) {
			$text = preg_replace("/(\s\s+|\t|\n)/", " ", trim($line));
			$tmp = explode(" ", $text);
			if (count($tmp) > 1) {
				$tl = strlen($tmp[3]);
				$st = substr($tmp[3], -2);
				$ts = substr($tmp[3], 0, ($tl-2));
				$ts = parserhelper::toKilo($ts, $st);
				
				$tl = strlen($tmp[4]);
				$st = substr($tmp[4], -2);
				$fs = substr($tmp[4], 0, ($tl-2));
				$fs = parserhelper::toKilo($fs, $st);
				
				$sw = new filesystem();
				$sw->setName($tmp[0]);
				$sw->setTotal($ts);
				$sw->setFree($fs);
				$sw->setUsed(($ts - $fs));
				
				$this->sys->setSwapDevices($sw);
			}
		}
		return $this->sys->getSwapDevices();
	}
	
	function getNic() {
		$str = 'netstat -in';
		$res = $this->ssh->ex($str);
		$res = explode("\n", $res);
		
		$state = false;
    	$temp = null;
    	$mac = null;
		foreach ($res as $line) {
			$text = preg_replace("/(\s\s+|\t|\n)/", " ", trim($line));
			$tmp = explode(" ", $text);
			if (count($tmp) > 1) {
				if (is_numeric($tmp[1])) {
					if (strstr($tmp[2], "link#")) {
					  $mac = $tmp[3];
					} else {
						if (!strstr($tmp[0], "lo")){
							$nic = new nic();
							$nic->setIpAddress($tmp[3]);
							$nic->setMAC($mac);
							$nic->setName($tmp[0]);
							$nic->setRxBytes($tmp[5]);
							$nic->setTxBytes($tmp[7]);
							$nic->setErrors($tmp[6] + $tmp[8]);
							$this->sys->setNics($nic);
						}
					}
				}
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
		/*$this->getMemory();
		
		
		
		
		$this->getCpu();
		
		$this->getSwapdevice();
		$this->getNic();*/
		$this->deleteConfig();
		$this->ssh->disconnect();
	}
}


?>