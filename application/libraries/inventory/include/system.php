<?php if ( ! defined('APPPATH')) exit('No direct script access allowed');

class system
{
    /**
     * name of the host
     *
     * @var String
     */
    private $_hostname = "localhost";
    
    /**
     * default ip of the host 
     *
     * @var String
     */
    private $_ip = "127.0.0.1";
    
    /**
     * detailed Information about the kernel
     *
     * @var String
     */
    private $_kernel = "Unknown";
    
    /**
     * name of the distribution
     *
     * @var String
     */
    private $_distribution = "Unknown";
    
    /**
     * icon of the distribution (must be available in phpSysInfo)
     *
     * @var String
     */
    private $_distributionIcon = "unknown.png";
    
    /**
     * time in sec how long the system is running
     *
     * @var Integer
     */
    private $_uptime = 0;
    
    /**
     * array with cpu devices
     *
     * @see cpu
     *
     * @var Array
     */
    private $_cpus = array();
    
    /**
     * array with network devices
     *
     * @see nic
     *
     * @var Array
     */
    private $_nics = array();
    
    /**
     * array with filesystems
     *
     * @see filesystem
     *
     * @var Array
     */
    private $_fss = array();
    
    /**
     * free memory in bytes
     *
     * @var Integer
     */
    private $_memFree = 0;
    
    /**
     * total memory in bytes
     *
     * @var Integer
     */
    private $_memTotal = 0;
    
    /**
     * used memory in bytes
     *
     * @var Integer
     */
    private $_memUsed = 0;
    
    /**
     * used memory for buffers in bytes
     *
     * @var Integer
     */
    private $_memBuffer = null;
    
    /**
     * used memory for cache in bytes
     *
     * @var Integer
     */
    private $_memCache = null;
    
    /**
     * array with swap devices
     *
     * @see DiskDevice
     *
     * @var Array
     */
    private $_swapDevices = array();
    
    /**
     * remove duplicate Entries and Count
     *
     * @param Array $arrDev list of HWDevices
     *
     * @see HWDevice
     *
     * @return Array
     */
    public static function removeDupsAndCount($arrDev)
    {
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
    
    /**
     * return percent of used memory
     *
     * @see System::_memUsed
     * @see System::_memTotal
     *
     * @return Integer
     */
    public function getMemPercentUsed()
    {
        if ($this->_memTotal > 0) {
            return ceil($this->_memUsed / $this->_memTotal * 100);
        } else {
            return 0;
        }
    }
    
    /**
     * return percent of used memory for cache
     *
     * @see System::_memCache
     * @see System::_memTotal
     *
     * @return Integer
     */
    public function getMemPercentCache()
    {
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
    
    /**
     * return percent of used memory for buffer
     *
     * @see System::_memBuffer
     * @see System::_memTotal
     *
     * @return Integer
     */
    public function getMemPercentBuffer()
    {
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
    
    /**
     * Returns total free swap space
     *
     * @see System::_swapDevices
     * @see DiskDevice::getFree()
     *
     * @return Integer
     */
    public function getSwapFree()
    {
        if (count($this->_swapDevices) > 0) {
            $free = 0;
            foreach ($this->_swapDevices as $dev) {
                $free += $dev->getFree();
            }
            return $free;
        }
        return null;
    }
    
    /**
     * Returns total swap space
     *
     * @see System::_swapDevices
     * @see DiskDevice::getTotal()
     *
     * @return Integer
     */
    public function getSwapTotal()
    {
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
    
    /**
     * Returns total used swap space
     *
     * @see System::_swapDevices
     * @see DiskDevice::getUsed()
     *
     * @return Integer
     */
    public function getSwapUsed()
    {
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
    
    /**
     * return percent of total swap space used
     *
     * @see System::getSwapUsed()
     * @see System::getSwapTotal()
     *
     * @return Integer
     */
    public function getSwapPercentUsed()
    {
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
    
    /**
     * Returns $_distribution.
     *
     * @see System::$_distribution
     *
     * @return String
     */
    public function getDistribution()
    {
        return $this->_distribution;
    }
    
    /**
     * Sets $_distribution.
     *
     * @param String $distribution distributionname
     *
     * @see System::$_distribution
     *
     * @return Void
     */
    public function setDistribution($distribution)
    {
        $this->_distribution = $distribution;
    }
    
    /**
     * Returns $_hostname.
     *
     * @see System::$_hostname
     *
     * @return String
     */
    public function getHostname()
    {
        return $this->_hostname;
    }
    
    /**
     * Sets $_hostname.
     *
     * @param String $hostname hostname
     *
     * @see System::$_hostname
     *
     * @return Void
     */
    public function setHostname($hostname)
    {
        $this->_hostname = $hostname;
    }
    
    /**
     * Returns $_ip.
     *
     * @see System::$_ip
     *
     * @return String
     */
    public function getIp()
    {
        return $this->_ip;
    }
    
    /**
     * Sets $_ip.
     *
     * @param String $ip IP
     *
     * @see System::$_ip
     *
     * @return Void
     */
    public function setIp($ip)
    {
        $this->_ip = $ip;
    }
    
    /**
     * Returns $_kernel.
     *
     * @see System::$_kernel
     *
     * @return String
     */
    public function getKernel()
    {
        return $this->_kernel;
    }
    
    /**
     * Sets $_kernel.
     *
     * @param String $kernel kernelname
     *
     * @see System::$_kernel
     *
     * @return Void
     */
    public function setKernel($kernel)
    {
        $this->_kernel = $kernel;
    }
	
    /**
     * Returns $_uptime.
     *
     * @see System::$_uptime
     *
     * @return Integer
     */
    public function getUptime()
    {
        return $this->_uptime;
    }
    
    /**
     * Sets $_uptime.
     *
     * @param Interger $uptime uptime
     *
     * @see System::$_uptime
     *
     * @return Void
     */
    public function setUptime($uptime)
    {
        $this->_uptime = $uptime;
    }
    
    /**
     * Returns $_cpus.
     *
     * @see System::$_cpus
     *
     * @return Array
     */
    public function getCpus()
    {
        return $this->_cpus;
    }
    
    /**
     * Sets $_cpus.
     *
     * @param Cpu $cpus cpu device
     *
     * @see System::$_cpus
     * @see CpuDevice
     *
     * @return Void
     */
    public function setCpus($cpus)
    {
        array_push($this->_cpus, $cpus);
    }
    
    /**
     * Returns $_nics.
     *
     * @see System::$_nics
     *
     * @return Array
     */
    public function getNics()
    {
        return $this->_nics;
    }
    
    /**
     * Sets $_nics.
     *
     * @param nic $nics network device
     *
     * @see System::$_nics
     * @see nic
     *
     * @return Void
     */
    public function setNics($nics)
    {
        array_push($this->_nics, $nics);
    }
    
    /**
     * Returns $_fss.
     *
     * @see System::$_fss
     *
     * @return Array
     */
    public function getFilesystems()
    {
        return $this->_fss;
    }
    
    /**
     * Sets $_fss.
     *
     * @param filesystem $fs disk device
     *
     * @see System::$_fss
     * @see filesystem
     *
     * @return void
     */
    public function setFilesystems($fs)
    {
        array_push($this->_fss, $fs);
    }
    
    /**
     * Returns $_memBuffer.
     *
     * @see System::$_memBuffer
     *
     * @return Integer
     */
    public function getMemBuffer()
    {
        return $this->_memBuffer;
    }
    
    /**
     * Sets $_memBuffer.
     *
     * @param Integer $memBuffer buffer memory
     *
     * @see System::$_memBuffer
     *
     * @return Void
     */
    public function setMemBuffer($memBuffer)
    {
        $this->_memBuffer = $memBuffer;
    }
    
    /**
     * Returns $_memCache.
     *
     * @see System::$_memCache
     *
     * @return Integer
     */
    public function getMemCache()
    {
        return $this->_memCache;
    }
    
    /**
     * Sets $_memCache.
     *
     * @param Integer $memCache cache memory
     *
     * @see System::$_memCache
     *
     * @return Void
     */
    public function setMemCache($memCache)
    {
        $this->_memCache = $memCache;
    }
    
    /**
     * Returns $_memFree.
     *
     * @see System::$_memFree
     *
     * @return Integer
     */
    public function getMemFree()
    {
        return $this->_memFree;
    }
    
    /**
     * Sets $_memFree.
     *
     * @param Integer $memFree free memory
     *
     * @see System::$_memFree
     *
     * @return Void
     */
    public function setMemFree($memFree)
    {
        $this->_memFree = $memFree;
    }
    
    /**
     * Returns $_memTotal.
     *
     * @see System::$_memTotal
     *
     * @return Integer
     */
    public function getMemTotal()
    {
        return $this->_memTotal;
    }
    
    /**
     * Sets $_memTotal.
     *
     * @param Integer $memTotal total memory
     *
     * @see System::$_memTotal
     *
     * @return Void
     */
    public function setMemTotal($memTotal)
    {
        $this->_memTotal = $memTotal;
    }
    
    /**
     * Returns $_memUsed.
     *
     * @see System::$_memUsed
     *
     * @return Integer
     */
    public function getMemUsed()
    {
        return $this->_memUsed;
    }
    
    /**
     * Sets $_memUsed.
     *
     * @param Integer $memUsed used memory
     *
     * @see System::$_memUsed
     *
     * @return Void
     */
    public function setMemUsed($memUsed)
    {
        $this->_memUsed = $memUsed;
    }
    
    /**
     * Returns $_swapDevices.
     *
     * @see System::$_swapDevices
     *
     * @return Array
     */
    public function getSwapDevices()
    {
        return $this->_swapDevices;
    }
    
    /**
     * Sets $_swapDevices.
     *
     * @param DiskDevice $swapDevices swap devices
     *
     * @see System::$_swapDevices
     * @see DiskDevice
     *
     * @return Void
     */
    public function setSwapDevices($swapDevices)
    {
        array_push($this->_swapDevices, $swapDevices);
    }
}
?>
