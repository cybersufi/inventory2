<?php if ( ! defined('APPPATH')) exit('No direct script access allowed');

class memory {
	
	private $_memFree = 0;
    private $_memTotal = 0;
    private $_memUsed = 0;
    private $_memBuffer = null;
    private $_memCache = null;
	
	public function getMemFree() {
		return $this->_memFree;
	}
	
	public function setMemFree($memFree) {
		$this->_memFree = $memFree;
	}
	
	public function getMemUsed() {
		return $this->_memUsed;
	}
	
	public function setMemUsed($memUsed) {
		$this->_memUsed = $memUsed;
	}
	
	public function getMemTotal() {
		return $this->_memTotal;
	}
	
	public function setMemTotal($memTotal) {
		$this->_memTotal = $memTotal;
	}
	
	public function getMemBuffer() {
		return $this->_memBuffer;
	}
	
	public function setMemBuffer($memBuffer) {
		$this->_memBuffer = $memBuffer;
	}
	
	public function getMemCache() {
		return $this->_memCache;
	}
	
	public function setMemCache($memCache) {
		$this->_memCache = $memCache;
	}
	
	public function getMemPercentUsed() {
        if ($this->_memTotal > 0) {
            return ceil($this->_memUsed / $this->_memTotal * 100);
        } else {
            return 0;
        }
    }
    
    public function getMemPercentCache() {
        if ($this->_memCache !== null) {
            if ($this->_memCache > 0) {
                return ceil($this->_memCache / $this->_memTotal * 100);
            } else {
                return 0;
            }
        } else {
            return null;
        }
    }
    
    public function getMemPercentBuffer() {
        if ($this->_memBuffer !== null) {
            if ($this->_memBuffer > 0) {
                return ceil($this->_memBuffer / $this->_memTotal * 100);
            } else {
                return 0;
            }
        } else {
            return null;
        }
    }
	
}

?>