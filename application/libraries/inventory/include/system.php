<?php if ( ! defined('APPPATH')) exit('No direct script access allowed');

class system {
    	
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
	private $_
    private $_uptime = 0;
	
	private $_memory = array();
    private $_cpus = array();
    private $_nics = array();
    private $_fss = array();
    
    private $_swapDevices = array();
    
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
	
    public function getDistribution() {
        return $this->_distribution;
    }
    
    public function setDistribution($distribution) {
        $this->_distribution = $distribution;
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
	
    public function getUptime() {
        return $this->_uptime;
    }
    
    public function setUptime($uptime) {
        $this->_uptime = $uptime;
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
}
?>
