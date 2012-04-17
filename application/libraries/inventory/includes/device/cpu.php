<?php if ( ! defined('APPPATH')) exit('No direct script access allowed');

class cpu {
    	
    private $model = "";
    
    private $cpuSpeed = 0;
    
    private $cache = null;

    private $virt = null;    
    
    private $busSpeed = null;
    
    private $temp = null;
    
    private $bogomips = null;
    
    private $load = null;
	
	private $cpucore = 0;
    
    public function getBogomips() {
        return $this->bogomips;
    }
    
    public function setBogomips($bogomips) {
        $this->bogomips = $bogomips;
    }
    
    public function getBusSpeed() {
        return $this->busSpeed;
    }
    
    public function setBusSpeed($busSpeed) {
        $this->busSpeed = $busSpeed;
    }
    
    public function getCache() {
        return $this->cache;
    }
    
    public function setCache($cache) {
        $this->cache = $cache;
    }
    
    public function getVirt() {
        return $this->virt;
    }
    
    public function setVirt($virt) {
        $this->virt = $virt;
    }    
    
    public function getCpuSpeed() {
        return $this->cpuSpeed;
    }
    
    public function setCpuSpeed($cpuSpeed) {
        $this->cpuSpeed = $cpuSpeed;
    }
    
    public function getModel() {
        return $this->model;
    }
    
    public function setModel($model) {
        $this->model = $model;
    }
    
    public function getTemp() {
        return $this->temp;
    }
    
    public function setTemp($temp) {
        $this->temp = $temp;
    }
    
    public function getLoad() {
        return $this->load;
    }
    
    public function setLoad($load) {
        $this->load = $load;
    }
	
	public function getCpuCores() {
		return $this->cpucore;
	}
	
	public function setCpuCores($cores) {
		$this->cpucore = $cores;
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
