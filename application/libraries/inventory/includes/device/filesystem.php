<?php if ( ! defined('APPPATH')) exit('No direct script access allowed');

class filesystem {
    /**
     * name of the disk device
     *
     * @var String
     */
    private $name = "";
    
    /**
     * type of the filesystem on the disk device
     *
     * @var String
     */
    private $fsType = "";
    
    /**
     * diskspace that is free in bytes
     *
     * @var Integer
     */
    private $free = 0;
    
    /**
     * diskspace that is used in bytes
     *
     * @var Integer
     */
    private $used = 0;
    
    /**
     * total diskspace
     *
     * @var Integer
     */
    private $total = 0;
    
    /**
     * mount point of the disk device if available
     *
     * @var String
     */
    private $mountPoint = null;
    
    /**
     * additional options of the device, like mount options
     *
     * @var String
     */
    private $options = null;
    
    /**
     * inodes usage in percent if available
     *
     * @var
     */
    private $percentInodesUsed = null;
    
    /**
     * Returns PercentUsed calculated when function is called from internal values
     *
     * @see DiskDevice::$total
     * @see DiskDevice::$used
     *
     * @return Integer
     */
    public function getPercentUsed()
    {
        if ($this->total > 0) {
            return ceil($this->used / $this->total * 100);
        } else {
            return 0;
        }
    }

    
    /**
     * Returns $PercentInodesUsed.
     *
     * @see DiskDevice::$PercentInodesUsed
     *
     * @return Integer
     */
    public function getPercentInodesUsed()
    {
        return $this->percentInodesUsed;
    }
    
    /**
     * Sets $PercentInodesUsed.
     *
     * @param Integer $percentInodesUsed inodes percent
     *
     * @see DiskDevice::$PercentInodesUsed
     *
     * @return Void
     */
    public function setPercentInodesUsed($percentInodesUsed)
    {
        $this->percentInodesUsed = $percentInodesUsed;
    }
    
    /**
     * Returns $free.
     *
     * @see DiskDevice::$free
     *
     * @return Integer
     */
    public function getFree()
    {
        return $this->free;
    }
    
    /**
     * Sets $free.
     *
     * @param Integer $free free bytes
     *
     * @see DiskDevice::$free
     *
     * @return Void
     */
    public function setFree($free)
    {
        $this->free = $free;
    }
    
    /**
     * Returns $fsType.
     *
     * @see DiskDevice::$fsType
     *
     * @return String
     */
    public function getFsType()
    {
        return $this->fsType;
    }
    
    /**
     * Sets $fsType.
     *
     * @param String $fsType filesystemtype
     *
     * @see DiskDevice::$fsType
     *
     * @return Void
     */
    public function setFsType($fsType)
    {
        $this->fsType = $fsType;
    }
    
    /**
     * Returns $mountPoint.
     *
     * @see DiskDevice::$mountPoint
     *
     * @return String
     */
    public function getMountPoint()
    {
        return $this->mountPoint;
    }
    
    /**
     * Sets $mountPoint.
     *
     * @param String $mountPoint mountpoint
     *
     * @see DiskDevice::$mountPoint
     *
     * @return Void
     */
    public function setMountPoint($mountPoint)
    {
        $this->mountPoint = $mountPoint;
    }
    
    /**
     * Returns $name.
     *
     * @see DiskDevice::$name
     *
     * @return String
     */
    public function getName()
    {
        return $this->name;
    }
    
    /**
     * Sets $name.
     *
     * @param String $name device name
     *
     * @see DiskDevice::$name
     *
     * @return Void
     */
    public function setName($name)
    {
        $this->name = $name;
    }
    
    /**
     * Returns $options.
     *
     * @see DiskDevice::$options
     *
     * @return String
     */
    public function getOptions()
    {
        return $this->options;
    }
    
    /**
     * Sets $options.
     *
     * @param String $options additional options
     *
     * @see DiskDevice::$options
     *
     * @return Void
     */
    public function setOptions($options)
    {
        $this->options = $options;
    }
    
    /**
     * Returns $total.
     *
     * @see DiskDevice::$total
     *
     * @return Integer
     */
    public function getTotal()
    {
        return $this->total;
    }
    
    /**
     * Sets $total.
     *
     * @param Integer $total total bytes
     *
     * @see DiskDevice::$total
     *
     * @return Void
     */
    public function setTotal($total)
    {
        $this->total = $total;
    }
    
    /**
     * Returns $used.
     *
     * @see DiskDevice::$used
     *
     * @return Integer
     */
    public function getUsed()
    {
        return $this->used;
    }
    
    /**
     * Sets $used.
     *
     * @param Integer $used used bytes
     *
     * @see DiskDevice::$used
     *
     * @return Void
     */
    public function setUsed($used)
    {
        $this->used = $used;
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
