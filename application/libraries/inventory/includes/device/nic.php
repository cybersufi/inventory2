<?php if ( ! defined('APPPATH')) exit('No direct script access allowed');

class nic implements idevice{
    
	private $nicid = "";	
    private $name = "";
    private $macaddr = "";
	private $ipaddr = "";
	private $type = "";
	private $txBytes = 0;
    private $rxBytes = 0;
    private $errors = 0;
    private $drops = 0;
	
	public function getId() {
		return $this->nicid;
	}
	
	public function setId($nicid) {
		$this->nicid = $nicid;
	}
	
    public function getDrops() {
        return $this->_drops;
    }
    
    public function setDrops($drops) {
        $this->_drops = $drops;
    }
    
    public function getErrors() {
        return $this->_errors;
    }
    
    public function setErrors($errors) {
        $this->_errors = $errors;
    }
    
    public function getName() {
        return $this->_name;
    }
    
    public function setName($name) {
        $this->_name = $name;
    }
    
	public function getMAC() {
        return $this->_macaddr;
    }
    
    public function setMAC($mac) {
        $this->_macaddr = $mac;
    }
	
	public function getIpAddress() {
        return $this->_ipaddr;
    }
    
    public function setIpAddress($ipaddr) {
        $this->_ipaddr = $ipaddr;
    }
	
	public function getType() {
        return $this->_type;
    }
    
    public function setType($type) {
        $this->_type = $type;
    }
	
    public function getRxBytes() {
        return $this->_rxBytes;
    }
    
    public function setRxBytes($rxBytes) {
        $this->_rxBytes = $rxBytes;
    }
    
    public function getTxBytes() {
        return $this->_txBytes;
    }
    
    public function setTxBytes($txBytes) {
        $this->_txBytes = $txBytes;
    }
	
	public function loadFromDatabase() {
		return null;
	}
	
	public function saveToDatabase() {
		return null;
	}
}
?>