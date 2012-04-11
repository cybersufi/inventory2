<?php if ( ! defined('APPPATH')) exit('No direct script access allowed');

class nic {
    /**
     * name of the device
     *
     * @var String
     */
    private $_name = "";
    
	/**
     * MAC adrress of the device
     *
     * @var String
     */
    private $_macaddr = "";
	
	/**
     * IP address of the device
     *
     * @var String
     */
    private $_ipaddr = "";
	
	/**
     * type of the device
     *
     * @var String
     */
    private $_type = "";
	
    /**
     * transmitted bytes
     *
     * @var Integer
     */
    private $_txBytes = 0;
    
    /**
     * received bytes
     *
     * @var Integer
     */
    private $_rxBytes = 0;
    
    /**
     * counted error packages
     *
     * @var Integer
     */
    private $_errors = 0;
    
    /**
     * counted droped packages
     *
     * @var Integer
     */
    private $_drops = 0;
    
    /**
     * Returns $_drops.
     *
     * @see nic::$_drops
     *
     * @return Integer
     */
    public function getDrops()
    {
        return $this->_drops;
    }
    
    /**
     * Sets $_drops.
     *
     * @param Integer $drops dropped packages
     *
     * @see nic::$_drops
     *
     * @return Void
     */
    public function setDrops($drops)
    {
        $this->_drops = $drops;
    }
    
    /**
     * Returns $_errors.
     *
     * @see nic::$_errors
     *
     * @return Integer
     */
    public function getErrors()
    {
        return $this->_errors;
    }
    
    /**
     * Sets $_errors.
     *
     * @param Integer $errors error packages
     *
     * @see nic::$_errors
     *
     * @return Void
     */
    public function setErrors($errors)
    {
        $this->_errors = $errors;
    }
    
    /**
     * Returns $_name.
     *
     * @see nic::$_name
     *
     * @return String
     */
    public function getName()
    {
        return $this->_name;
    }
    
    /**
     * Sets $_name.
     *
     * @param String $name device name
     *
     * @see nic::$_name
     *
     * @return Void
     */
    public function setName($name)
    {
        $this->_name = $name;
    }
    
	/**
     * Returns $_macaddr.
     *
     * @see nic::$_macaddr
     *
     * @return String
     */
    public function getMAC()
    {
        return $this->_macaddr;
    }
    
    /**
     * Sets $_macaddr.
     *
     * @param String $mac nic MAC address
     *
     * @see nic::$_macaddr
     *
     * @return Void
     */
    public function setMAC($mac)
    {
        $this->_macaddr = $mac;
    }
	
	/**
     * Returns $_ipaddr.
     *
     * @see nic::$_ipaddr
     *
     * @return String
     */
    public function getIpAddress()
    {
        return $this->_ipaddr;
    }
    
    /**
     * Sets $_ipaddr.
     *
     * @param String $ipaddr nic IP address
     *
     * @see nic::$_ipaddr
     *
     * @return Void
     */
    public function setIpAddress($ipaddr)
    {
        $this->_ipaddr = $ipaddr;
    }
	
	/**
     * Returns $_type.
     *
     * @see nic::$_type
     *
     * @return String
     */
    public function getType()
    {
        return $this->_type;
    }
    
    /**
     * Sets $_type.
     *
     * @param String $type nic type
     *
     * @see nic::$_type
     *
     * @return Void
     */
    public function setType($type)
    {
        $this->_type = $type;
    }
	
    /**
     * Returns $_rxBytes.
     *
     * @see nic::$_rxBytes
     *
     * @return Integer
     */
    public function getRxBytes()
    {
        return $this->_rxBytes;
    }
    
    /**
     * Sets $_rxBytes.
     *
     * @param Integer $rxBytes received bytes
     *
     * @see nic::$_rxBytes
     *
     * @return Void
     */
    public function setRxBytes($rxBytes)
    {
        $this->_rxBytes = $rxBytes;
    }
    
    /**
     * Returns $_txBytes.
     *
     * @see nic::$_txBytes
     *
     * @return Integer
     */
    public function getTxBytes()
    {
        return $this->_txBytes;
    }
    
    /**
     * Sets $_txBytes.
     *
     * @param Integer $txBytes transmitted bytes
     *
     * @see nic::$_txBytes
     *
     * @return Void
     */
    public function setTxBytes($txBytes)
    {
        $this->_txBytes = $txBytes;
    }
}
?>
