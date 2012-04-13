<?php if ( ! defined('APPPATH')) exit('No direct script access allowed');

class System extends CI_Model {
    	
    private $_serverid = "0";
    private $_hostname = "localhost";
	private $_type = "unknown";
    private $_ip = "127.0.0.1";
    private $_kernel = "Unknown";
    private $_distribution = "Unknown";
	private $_firmware = "Unknown";
	private $_function = "Unknown";
	private $_osbit = "Unknown";
	private $_serialnumber = "Unknown";
	private $_model = "Unknown";
	private $_status = "Unknown";
    private $_uptime = 0;
	
	private $_zone = "Unknown";
	private $_location = "Unknown";
	private $_rackinfo = "Unknown";
	private $_owner = "Unknown";
	
	
	private $_memory = array();
    private $_cpus = array();
    private $_nics = array();
    private $_fss = array();
    private $_swapDevices = array();
	
	private $list;
  	private $type;
  	private $nic;
	private $mp;
    
	function __construct() {
    	parent::__construct();
		$this->list = 'app_serverlist';
    	$this->type = 'app_servertype';
    	$this->nic = 'app_serverniclist';
  	}
	
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
    
    public function getServerid() {
        return $this->_serverid;
    }
	
    public function setServerid($serverid) {
        $this->_serverid = $serverid;
    }
	
    public function getHostname() {
        return $this->_hostname;
    }
    
    public function setHostname($hostname) {
        $this->_hostname = $hostname;
    }
    
    public function getType() {
        return $this->_type;
    }
    
    public function setType($type) {
        $this->_type = $type;
    }
    
    public function getIp() {
        return $this->_ip;
    }
    
    public function setIp($ip) {
        $this->_ip = $ip;
    }
    
    public function getKernel() {
        return $this->_kernel;
    }
    
    public function setKernel($kernel) {
        $this->_kernel = $kernel;
    }
    
    public function getDistribution() {
        return $this->_distribution;
    }
    
    public function setDistribution($distribution) {
        $this->_distribution = $distribution;
    }
	
	public function getFirmware() {
		return $this->_firmware;
	}
	
	public function setFirmware($firmware) {
		$this->firmware = $firmware;
	}
	
	public function getFunction() {
		return $this->_function;
	}
	
	public function setFunction($function) {
		$this->_function = $function;
	}
	
	public function getOsbit() {
		return $this->_osbit;
	}
	
	public function setOsbit($bit) {
		$this->_osbit = $bit;
	}
	
	public function getSerial() {
		return $this->_serialnumber;
	}
	
	public function setSerial($serial) {
		$this->_serialnumber = $serial;
	}
	
	public function getModel() {
		return $this->_model;
	}
	
	public function setModel($model) {
		$this->_model = $model;
	}
	
	public function getStatus() {
		return $this->_status;
	}
	
	public function setStatus($status) {
		$this->_status = $status;
	}
	
	public function getUptime() {
        return $this->_uptime;
    }
    
    public function setUptime($uptime) {
        $this->_uptime = $uptime;
    }
    
	public function getZone() {
		return $this->_zone;
	}
	
	public function setZone($zone) {
		$this->_zone = $zone;
	}
	
	public function getLocation() {
		return $this->_location;
	}
	
	public function setLocation($location) {
		$this->_location = $location;
	}
	
	public function getRackInfo() {
		return $this->_rackinfo;
	}
	
	public function setRackInfo($rackInfo) {
		$this->_rackinfo = $rackInfo;
	}
	
	public function getOwner() {
		return $this->_owner;
	}
	
	public function setOwner($owner) {
		$this->_owner = $owner;
	}
	
	public function getMemory() {
		return $this->_memory;
	}
	
	public function setMemory($memory) {
		$this->_memory = $memory;
	}
	
    public function getCpus() {
        return $this->_cpus;
    }
    
    public function setCpus($cpus) {
        array_push($this->_cpus, $cpus);
    }
    
    public function getNics() {
        return $this->_nics;
    }
    
    public function setNics($nics) {
        array_push($this->_nics, $nics);
    }
    
    public function getFilesystems() {
        return $this->_fss;
    }
    
    public function setFilesystems($fs) {
        array_push($this->_fss, $fs);
    }

    public function getSwapDevices() {
        return $this->_swapDevices;
    }
    
    public function setSwapDevices($swapDevices) {
        array_push($this->_swapDevices, $swapDevices);
    }
	
	public function loadById($serverid) {
		$filter = array($this->list.'.serverid' => $serverid);
		$res = $this->load($filter);
	}
	
	public function loadByName($servername) {
		$filter = array($this->list.'.servername' => $servername);
		$res = $this->load($filter);
	}
	
	private function load($filter) {
		$sql = $this->db->select($this->list.'.*')
           		->from($this->list)
				->join($this->type, $this->type.'.servertypeid = '.$this->list.'.servertype','left')
           		->where($param)
           		->limit(1,0)
           		->get();
    	return $var = ($sql->num_rows() > 0) ? $sql->result() : false;
	}
	
}
?>
