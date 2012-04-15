<?php if ( ! defined('APPPATH')) exit('No direct script access allowed');

class memory {
	
	private $memFree = 0;
    private $memTotal = 0;
    private $memUsed = 0;
    private $memBuffer = null;
    private $memCache = null;
	
	public function getMemFree() {
		return $this->memFree;
	}
	
	public function setMemFree($memFree) {
		$this->memFree = $memFree;
	}
	
	public function getMemUsed() {
		return $this->memUsed;
	}
	
	public function setMemUsed($memUsed) {
		$this->memUsed = $memUsed;
	}
	
	public function getMemTotal() {
		return $this->memTotal;
	}
	
	public function setMemTotal($memTotal) {
		$this->memTotal = $memTotal;
	}
	
	public function getMemBuffer() {
		return $this->memBuffer;
	}
	
	public function setMemBuffer($memBuffer) {
		$this->memBuffer = $memBuffer;
	}
	
	public function getMemCache() {
		return $this->memCache;
	}
	
	public function setMemCache($memCache) {
		$this->memCache = $memCache;
	}
	
	public function getMemPercentUsed() {
        if ($this->memTotal > 0) {
            return ceil($this->memUsed / $this->memTotal * 100);
        } else {
            return 0;
        }
    }
    
    public function getMemPercentCache() {
        if ($this->memCache !== null) {
            if ($this->memCache > 0) {
                return ceil($this->memCache / $this->memTotal * 100);
            } else {
                return 0;
            }
        } else {
            return null;
        }
    }
    
    public function getMemPercentBuffer() {
        if ($this->memBuffer !== null) {
            if ($this->memBuffer > 0) {
                return ceil($this->memBuffer / $this->memTotal * 100);
            } else {
                return 0;
            }
        } else {
            return null;
        }
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