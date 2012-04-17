<?php if ( ! defined('APPPATH')) exit('No direct script access allowed');

class linux extends parser {
	
	public function getHostname() {
		$str = "hostname";
		$rst = $this->ssh->ex($str);
		$this->sys->setHostname($rst);
		return $this->sys->getHostname();
	}
	
	public function getKernel() {
		$str = "cat /proc/version";
		$rst = $this->ssh->ex($str);
		
		if (preg_match('/version (.*?) /', $rst, $ar_buf)) {
            $result = $ar_buf[1];
            if (preg_match('/SMP/', $rst)) {
                $result .= ' (SMP)';
            }
            $this->sys->setKernel ($result);
        }
		return $this->sys->getKernel();
	}
	
	public function getSystemModel() {
		$str = 'dmidecode -t 1 | grep "Product Name"';
		$res = $this->ssh->ex($str);
		$temp = explode(":", $res);
		$sysmodel = trim($temp[1]);
		$this->sys->setModel($sysmodel);
		return $this->sys->getModel();
	}
	
	function getMemory() {
		$mem = new memory();
			
		$str = 'cat /proc/meminfo';
		$res = $this->ssh->ex($str);
		$bufe = preg_split("/\n/", $res, -1, PREG_SPLIT_NO_EMPTY);
        foreach ($bufe as $buf) {
            if (preg_match('/^MemTotal:\s+(.*)\s*kB/i', $buf, $ar_buf)) {
                $mem->setMemTotal($ar_buf[1] * 1024);
            } elseif (preg_match('/^MemFree:\s+(.*)\s*kB/i', $buf, $ar_buf)) {
                $mem->setMemFree($ar_buf[1] * 1024);
            } elseif (preg_match('/^Cached:\s+(.*)\s*kB/i', $buf, $ar_buf)) {
                $mem->setMemCache($ar_buf[1] * 1024);
            } elseif (preg_match('/^Buffers:\s+(.*)\s*kB/i', $buf, $ar_buf)) {
                $mem->setMemBuffer($ar_buf[1] * 1024);
            }
        }
		$mem->setMemUsed($mem->getMemTotal() -  $mem->getMemFree());
		
		$this->sys->setMemory($mem);
		return $this->sys->getMemory();
	}

	function getFirmware() {
		$str = 'dmidecode -t 0 | grep "Version"';
		$res = $this->ssh->ex($str);
		$tmp = explode(":", $res);
		$firm = trim($tmp[1]);
		$this->sys->setFirmware($firm);
		return $this->sys->getFirmware();
	}
	
	function getSerial() {
		$str = 'dmidecode -t 1 | grep "Serial Number"';
		$res = $this->ssh->ex($str);
		$temp = explode(":", $res);
		$serial = trim($temp[1]);
		$this->sys->setSerial($serial);
		return $this->sys->getSerial();
	}
	
	function getOsBit() {
		$str = 'getconf LONG_BIT';
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
		$str = 'cat /proc/cpuinfo';
		$res = $this->ssh->ex($str);
		$res = preg_split('/\s?\n\s?\n/', trim($res));
		$proc = array();
		foreach ($res as $buf) {
        	$details = preg_split("/\n/", $buf, -1, PREG_SPLIT_NO_EMPTY);
			$pid = 0;
			$cpu = array();
			foreach ($details as $detail) {
				$arrBuff = preg_split('/\s+:\s+/', trim($detail));
				if (count($arrBuff) == 2) {
					switch (strtolower($arrBuff[0])) {
						case 'physical id':
							$pid = $arrBuff[1];
						break;
                        case 'model name':
                        case 'cpu':
							$cpu['model'] = $arrBuff[1];
                        break;
                        case 'cpu mhz':
                        case 'clock':
							$cpu['speed'] = $arrBuff[1];
                        break;
                        case 'cycle frequency [hz]':
							$cpu['speed'] = $arrBuff[1] / 1000000;
                        break;
                        case 'cpu0clktck':
							$cpu['speed'] = hexdec($arrBuff[1]) / 1000000;
                        break;
						case 'cpu cores':
							$cpu['cpucore'] = $arrBuff[1];
						break;
                    }
				}
			}
			if (!array_key_exists($pid, $proc)) {
				$proc[$pid] = $cpu;
			}
        }
		
		if (count($proc) > 0) {
			foreach ($proc as $line) {
				$cpu = new cpu();
				$cpu->setModel($line['model']);
				$cpu->setCpuSpeed($line['speed']);
				$cpu->setCpuCores($line['cpucore']);
				$this->sys->setCpus($cpu);
			}
		}
		
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
		$str = 'cat /proc/swaps';
		$res = $this->ssh->ex($str);
		$res = explode("\n", $res);
		unset($res[0]);
		foreach ($res as $line) {
			$text = preg_replace("/(\s\s+|\t|\n)/", " ", trim($line));
			$tmp = explode(" ", $text);
			if (count($tmp) > 1) {
				$sw = new filesystem();
				$sw->setName($tmp[0]);
				$sw->setTotal($tmp[2]);
				$sw->setFree(($tmp[2] - $tmp[3]));
				$sw->setUsed($tmp[3]);
				
				$this->sys->setSwapDevices($sw);
			}
		}
		return $this->sys->getSwapDevices();
	}
	
	function getNic() {
		$nic_stat = array();
		$str = 'cat /proc/net/dev';
		$res = $this->ssh->ex($str);
		$res = preg_split("/\n/", $res, -1, PREG_SPLIT_NO_EMPTY);	
		foreach ($res as $buf) {
            if (preg_match('/:/', $buf)) {
                list($dev_name, $stats_list) = preg_split('/:/', $buf, 2);
                $stats = preg_split('/\s+/', trim($stats_list));
                $nic_stat[trim($dev_name)] = array (
                	"rx" => $stats[0],
                	"tx" => $stats[8],
                	"error" => ($stats[2] + $stats[10]),
                	"drop" => ($stats[3] + $stats[11])
				);
            }
        }
		
		$str = 'ifconfig -a | grep -A1 "Link encap"';
		$res = $this->ssh->ex($str);
		$res = preg_split("/\n/", $res, -1, PREG_SPLIT_NO_EMPTY);
		
		for ($i=0; $i < count($res); $i+=3) { 
			$text1 = preg_replace("/(\s\s+|\t|\n)/", " ", trim($res[$i]));
			$tmp = explode(" ", $text1);
			if ((strstr($tmp[0], 'lo') === false) && (strstr($tmp[0], 'sit') === false)) {
				$text2 = preg_replace("/(\s\s+|\t|\n)/", " ", trim($res[$i+1]));
				$tmp2 = explode(" ", $text2);
				$nic = new nic();
				$nic->setName($tmp[0]);
				$nic->setMAC($tmp[4]);
				
				$addr = explode(":", $tmp2[1]);
				if (strcmp($addr[0], 'addr') == 0) {
					$nic->setIpAddress($addr[1]);
				}
				
				$nicname = explode(":", $tmp[0]);
				$stat = $nic_stat[$nicname[0]];
				
				$nic->setRxBytes($stat["rx"]);
				$nic->setTxBytes($stat["tx"]);
				$nic->setErrors($stat["error"]);
				$nic->setDrops($stat["drop"]);
				$this->sys->setNics($nic);
			}
		}
		
		return $this->sys->getNics();
	}

	function getDist() {
		$list = @parse_ini_file(APPPATH.'/libraries/inventory/data.ini', true);
		$str = 'lsb_release -a 2> /dev/null';
		$res = $this->ssh->ex($str);
		if ($res) {
			$distro_tmp = preg_split("/\n/", $res, -1, PREG_SPLIT_NO_EMPTY);
            foreach ($distro_tmp as $info) {
                $info_tmp = preg_split('/:/', $info, 2);
                $distro[$info_tmp[0]] = trim($info_tmp[1]);
				if (isset($distro['Description'])) {
                    $this->sys->setDistribution($distro['Description']);
                }
            }
		} else {
			foreach ($list as $section=>$distribution) {
                if (!isset($distribution["Files"])) {
                    continue;
                } else {
                    foreach (preg_split("/;/", $distribution["Files"], -1, PREG_SPLIT_NO_EMPTY) as $filename) {
                    	$str = 'test -f \''.$filename.'\' && echo 1 || echo 0';
						$res = $this->ssh->ex($str);
						$res = trim($res);
						if ($res == 1) {
							$str1 = 'cat '.$filename;
							$res1 = $this->ssh->ex($str1);
							if (isset($distribution["Name"])) {
                                if ($distribution["Name"] == 'Synology') {
                                    $this->sys->setDistribution($distribution["Name"]);
                                } else {
                                    $this->sys->setDistribution($distribution["Name"]." ".trim($res1));
                                }
                            } else {
                                $this->sys->setDistribution(trim($res1));
                            }
							return;
						}
                    }
                }
            }
		}
	}
	
	function run() {
		$this->ssh->connect();
		$this->getHostname();
		$this->getKernel();
		$this->getSystemModel();
		$this->getMemory();
		$this->getFirmware();
		$this->getSerial();
		$this->getOsBit();
		$this->getUptime();
		$this->getDist();
		$this->getFilesystem();
		$this->getSwapdevice();
		$this->getNic();
		$this->getCpu();
		$this->ssh->disconnect();
	}
}


?>