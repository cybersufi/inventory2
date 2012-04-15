<?php if ( ! defined('APPPATH')) exit('No direct script access allowed');

class sys {
    	
    private $serverid = "0";
    private $hostname = "localhost";
	private $type = "unknown";
    private $ip = "127.0.0.1";
    private $kernel = "Unknown";
    private $distribution = "Unknown";
	private $firmware = "Unknown";
	private $function = "Unknown";
	private $osbit = "Unknown";
	private $serialnumber = "Unknown";
	private $model = "Unknown";
	private $status = "Unknown";
    private $uptime = 0;
	
	private $zone = "Unknown";
	private $location = "Unknown";
	private $rackinfo = "Unknown";
	private $owner = "Unknown";
	
	
	private $memory = array();
    private $cpus = array();
    private $nics = array();
    private $fss = array();
    private $swapDevices = array();
    
    public static function removeDupsAndCount($arrDev) {
        $result = array();
        foreach ($arrDev as $dev) {
            if (count($result) === 0) {
                array_push($result, $dev);
            } else {
                $found = false;
                foreach ($result as $tmp) {
                    if ($dev->equals($tmp)) {
                        $tmp->setCount($tmp->getCount() + 1);
                        $found = true;
                        break;
                    }
                }
                if (!$found) {
                    array_push($result, $dev);
                }
            }
        }
        return $result;
    }
	
	public function getSwapFree() {
        if (count($this->swapDevices) > 0) {
            $free = 0;
            foreach ($this->swapDevices as $dev) {
                $free += $dev->getFree();
            }
            return $free;
        }
        return null;
    }
    
    public function getSwapTotal() {
        if (count($this->swapDevices) > 0) {
            $total = 0;
            foreach ($this->swapDevices as $dev) {
                $total += $dev->getTotal();
            }
            return $total;
        } else {
            return null;
        }
    }
    
    public function getSwapUsed() {
        if (count($this->swapDevices) > 0) {
            $used = 0;
            foreach ($this->swapDevices as $dev) {
                $used += $dev->getUsed();
            }
            return $used;
        } else {
            return null;
        }
    }
    
    public function getSwapPercentUsed() {
        if ($this->getSwapTotal() !== null) {
            if ($this->getSwapTotal() > 0) {
                return ceil($this->getSwapUsed() / $this->getSwapTotal() * 100);
            } else {
                return 0;
            }
        } else {
            return null;
        }
    }
    
    public function getServerid() {
        return $this->serverid;
    }
	
    public function setServerid($serverid) {
        $this->serverid = $serverid;
    }
	
    public function getHostname() {
        return $this->hostname;
    }
    
    public function setHostname($hostname) {
        $this->hostname = $hostname;
    }
    
    public function getType() {
        return $this->type;
    }
    
    public function setType($type) {
        $this->type = $type;
    }
    
    public function getIp() {
        return $this->ip;
    }
    
    public function setIp($ip) {
        $this->ip = $ip;
    }
    
    public function getKernel() {
        return $this->kernel;
    }
    
    public function setKernel($kernel) {
        $this->kernel = $kernel;
    }
    
    public function getDistribution() {
        return $this->distribution;
    }
    
    public function setDistribution($distribution) {
        $this->distribution = $distribution;
    }
	
	public function getFirmware() {
		return $this->firmware;
	}
	
	public function setFirmware($firmware) {
		$this->firmware = $firmware;
	}
	
	public function getFunction() {
		return $this->function;
	}
	
	public function setFunction($function) {
		$this->function = $function;
	}
	
	public function getOsbit() {
		return $this->osbit;
	}
	
	public function setOsbit($bit) {
		$this->osbit = $bit;
	}
	
	public function getSerial() {
		return $this->serialnumber;
	}
	
	public function setSerial($serial) {
		$this->serialnumber = $serial;
	}
	
	public function getModel() {
		return $this->model;
	}
	
	public function setModel($model) {
		$this->model = $model;
	}
	
	public function getStatus() {
		return $this->status;
	}
	
	public function setStatus($status) {
		$this->status = $status;
	}
	
	public function getUptime() {
        return $this->uptime;
    }
    
    public function setUptime($uptime) {
        $this->uptime = $uptime;
    }
    
	public function getZone() {
		return $this->zone;
	}
	
	public function setZone($zone) {
		$this->zone = $zone;
	}
	
	public function getLocation() {
		return $this->location;
	}
	
	public function setLocation($location) {
		$this->location = $location;
	}
	
	public function getRackInfo() {
		return $this->rackinfo;
	}
	
	public function setRackInfo($rackInfo) {
		$this->rackinfo = $rackInfo;
	}
	
	public function getOwner() {
		return $this->owner;
	}
	
	public function setOwner($owner) {
		$this->owner = $owner;
	}
	
	public function getMemory() {
		return $this->memory;
	}
	
	public function setMemory($memory) {
		$this->memory = $memory;
	}
	
    public function getCpus() {
        return $this->cpus;
    }
    
    public function setCpus($cpus) {
        array_push($this->cpus, $cpus);
    }
    
    public function getNics() {
        return $this->nics;
    }
    
    public function setNics($nics) {
        array_push($this->nics, $nics);
    }
    
    public function getFilesystems() {
        return $this->fss;
    }
    
    public function setFilesystems($fs) {
        array_push($this->fss, $fs);
    }

    public function getSwapDevices() {
        return $this->swapDevices;
    }
    
    public function setSwapDevices($swapDevices) {
        array_push($this->swapDevices, $swapDevices);
    }
	
	public function toArray(){
	    $array = get_object_vars($this);
	    unset($array['_parent'], $array['_index']);
	    array_walk_recursive($array, function(&$property, $key){
	        if(is_object($property)
	        && method_exists($property, 'toArray')){
	            $property = $property->toArray();
	        }
	    });
    	return $array;
	}
}
?>
