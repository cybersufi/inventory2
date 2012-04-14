<?php if ( ! defined('APPPATH')) exit('No direct script access allowed');

class swapdevice extends filesystem {
    
	public function getSwapFree() {
        if (count($this->_swapDevices) > 0) {
            $free = 0;
            foreach ($this->_swapDevices as $dev) {
                $free += $dev->getFree();
            }
            return $free;
        }
        return null;
    }
    
    public function getSwapTotal() {
        if (count($this->_swapDevices) > 0) {
            $total = 0;
            foreach ($this->_swapDevices as $dev) {
                $total += $dev->getTotal();
            }
            return $total;
        } else {
            return null;
        }
    }
    
    public function getSwapUsed() {
        if (count($this->_swapDevices) > 0) {
            $used = 0;
            foreach ($this->_swapDevices as $dev) {
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
	
}
?>
