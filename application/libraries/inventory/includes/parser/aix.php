<?php if ( ! defined('APPPATH')) exit('No direct script access allowed');

class aix extends parser {
	
	private $configFile;
	
	public function prepareConfig() {
		$this->sys->setType('aix');
		$this->configFile = '/tmp/webprtconf.txt';
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
		$rst = trim($rst1).' ( '.trim($rst2).' )';
		$this->sys->setKernel($rst);
		return $this->sys->getKernel();
	}
	
	public function getSystemModel() {
		$str = 'cat '.$this->configFile.' | grep \'System Model\'';
		$res = $this->ssh->ex($str);
		$temp = explode(":", $res);
		$temp = explode(",", $temp[1]);
		$sysmodel = $temp[1];
		$this->sys->setModel($sysmodel);
		return $this->sys->getModel();
	}
	
	function getMemory() {
		$mem = new memory();
			
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
		return $this->sys->getMemory();
	}

	function getFirmware() {
		$str = 'cat '.$this->configFile.' | grep \'Firmware Version\'';
		$res = $this->ssh->ex($str);
		$res = explode(":", $res);
		$tmp = explode(",", $res[1]);
		$this->sys->setFirmware($tmp[1]);
		return $this->sys->getFirmware();
	}
	
	function getSerial() {
		$str = 'cat '.$this->configFile.' | grep \'Machine Serial Number\'';
		$res = $this->ssh->ex($str);
		$res = explode(":", $res);
		$tmp = preg_replace('~\s{2,}~', ' ', $res[1]);
		$this->sys->setSerial($tmp);
		return $this->sys->getSerial();
	}
	
	function getOsBit() {
		$str = 'cat '.$this->configFile.' | grep \'Kernel Type\'';
		$res = $this->ssh->ex($str);
		$res = explode(":", $res);
		$temp = explode("-", $res[1]);
		$osbit = trim($temp[0]);
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
		$str = 'df -kP';
		$res = $this->ssh->ex($str);
		$fs = parserhelper::df($res);
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
		
		return null;
	}
	
	function run() {
		$this->ssh->connect();
		$this->prepareConfig();
		$this->getHostname();
		$this->getKernel();
		$this->getSystemModel();
		$this->getMemory();
		$this->getFirmware();
		$this->getSerial();
		$this->getOsBit();
		$this->getUptime();
		$this->getCpu();
		$this->getFilesystem();
		$this->getSwapdevice();
		$this->getNic();
		$this->deleteConfig();
		$this->ssh->disconnect();
	}
}


?>