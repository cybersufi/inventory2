<?php if ( ! defined('APPPATH')) exit('No direct script access allowed');

class nic {
    
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
        return $this->drops;
    }
    
    public function setDrops($drops) {
        $this->drops = $drops;
    }
    
    public function getErrors() {
        return $this->errors;
    }
    
    public function setErrors($errors) {
        $this->errors = $errors;
    }
    
    public function getName() {
        return $this->name;
    }
    
    public function setName($name) {
        $this->name = $name;
    }
    
	public function getMAC() {
        return $this->macaddr;
    }
    
    public function setMAC($mac) {
        $this->macaddr = $mac;
    }
	
	public function getIpAddress() {
        return $this->ipaddr;
    }
    
    public function setIpAddress($ipaddr) {
        $this->ipaddr = $ipaddr;
    }
	
	public function getType() {
        return $this->type;
    }
    
    public function setType($type) {
        $this->type = $type;
    }
	
    public function getRxBytes() {
        return $this->rxBytes;
    }
    
    public function setRxBytes($rxBytes) {
        $this->rxBytes = $rxBytes;
    }
    
    public function getTxBytes() {
        return $this->txBytes;
    }
    
    public function setTxBytes($txBytes) {
        $this->txBytes = $txBytes;
    }
	
	public final function toArray() {
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
