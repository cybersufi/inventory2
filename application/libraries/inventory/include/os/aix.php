<?php if ( ! defined('APPPATH')) exit('No direct script access allowed');

class aix extends os {

    private $myprtconf = array();

    /**
     * Virtual Host Name
     * @return void
     */
    private function _hostname()
    {
        /*   if (PSI_USE_VHOST === true) {
               $this->sys->setHostname(getenv('SERVER_NAME'));
           } else {
               if (CommonFunctions::executeProgram('hostname', '', $ret)) {
                   $this->sys->setHostname($ret);
               }
           } */
        $this->sys->setHostname(getenv('SERVER_NAME'));

    }

    /**
     * IP of the Virtual Host Name
     *  @return void
     */
    private function _ip()
    {
        if (PSI_USE_VHOST === true)
        {
            $this->sys->setIp(gethostbyname($this->_hostname()));
        }
        else
        {
            if (!($result = getenv('SERVER_ADDR')))
            {
                $this->sys->setIp(gethostbyname($this->_hostname()));
            }
            else
            {
                $this->sys->setIp($result);
            }
        }
    }

    /**
     * IBM AIX Version
     * @return void
     */
    private function _kernel()
    {
        if (CommonFunctions::executeProgram('oslevel', '', $ret1) && CommonFunctions::executeProgram('oslevel', '-s', $ret2))
        {
            $this->sys->setKernel($ret1 . '   (' . $ret2 . ')');
        }
    }

    /**
     * UpTime
     * time the system is running
     * @return void
     */
    private function _uptime()
    {
        if (CommonFunctions::executeProgram('uptime', '', $buf))
        {
            if (preg_match("/up (\d+) days,\s*(\d+):(\d+),/", $buf, $ar_buf) || preg_match("/up (\d+) day,\s*(\d+):(\d+),/", $buf, $ar_buf))
            {
                $min = $ar_buf[3];
                $hours = $ar_buf[2];
                $days = $ar_buf[1];
                $this->sys->setUptime($days * 86400 + $hours * 3600 + $min * 60);
            }
        }
    }

    /**
     * Number of Users
     * @return void
     */
    private function _users()
    {
        if (CommonFunctions::executeProgram('who', '| wc -l', $buf, PSI_DEBUG))
        {
            $this->sys->setUsers($buf);
        }
    }

    /**
     * Processor Load
     * optionally create a loadbar
     * @return void
     */
    private function _loadavg()
    {
        if (CommonFunctions::executeProgram('uptime', '', $buf))
        {
            if (preg_match("/average: (.*), (.*), (.*)$/", $buf, $ar_buf))
            {
                $this->sys->setLoad($ar_buf[1].' '.$ar_buf[2].' '.$ar_buf[3]);
            }
        }
    }

    /**
     * CPU information
     * All of the tags here are highly architecture dependant
     * @return void
     */
    private function _cpuinfo()
    {
        $dev = new CpuDevice();
        CommonFunctions::executeProgram('cat', '/tmp/webprtconf.txt |grep Type', $cpudev);
        $dev->setModel($cpudev);
        CommonFunctions::executeProgram('cat', '/tmp/webprtconf.txt | grep Speed | awk \'{print $4}\'', $cpuspeed);
        $dev->setCpuSpeed($cpuspeed);
        //$dev->setCache('512000'); //-don't know howto guess cache size
        $this->sys->setCpus($dev);
    }

    /**
     * Network devices
     * includes also rx/tx bytes
     * @return void
     */
    private function _network()
    {
        if (CommonFunctions::executeProgram('netstat', '-ni | tail -n +2', $netstat))
        {
            $lines = preg_split("/\n/", $netstat, -1, PREG_SPLIT_NO_EMPTY);
            foreach ($lines as $line)
            {
                $ar_buf = preg_split("/\s+/", $line);
                if (! empty($ar_buf[0]) && ! empty($ar_buf[3]))
                {
                    $dev = new NetDevice();
                    $dev->setName($ar_buf[0]);
                    $dev->setRxBytes($ar_buf[4]);
                    $dev->setTxBytes($ar_buf[6]);
                    $dev->setErrors($ar_buf[5] + $ar_buf[7]);
                    //$dev->setDrops($ar_buf[8]);
                    $this->sys->setNetDevices($dev);
                }
            }
        }
    }

    /**
     * Physical memory information and Swap Space information
     * @return void
     */
    private function _memory()
    {
        CommonFunctions::executeProgram('cat', '/tmp/webprtconf.txt |grep Good|awk \'{print $4}\'', $mems);
        $this->sys->setMemTotal($mems*1024*1024);
        //FIXME
        $mems = 0;
        $this->sys->setMemUsed($mems);
        $this->sys->setMemFree($mems);
        $this->sys->setMemApplication($mems);
        $this->sys->setMemBuffer($mems);
        $this->sys->setMemCache($mems);
    }

    /**
     * filesystem information
     *
     * @return void
     */
    private function _filesystems()
    {
        if (CommonFunctions::executeProgram('df', '-kP', $df, PSI_DEBUG))
        {
            $mounts = preg_split("/\n/", $df, -1, PREG_SPLIT_NO_EMPTY);
            if (CommonFunctions::executeProgram('mount', '-v', $s, PSI_DEBUG))
            {
                $lines = preg_split("/\n/", $s, -1, PREG_SPLIT_NO_EMPTY);
                while (list(, $line) = each($lines))
                {
                    $a = preg_split('/ /', $line, -1, PREG_SPLIT_NO_EMPTY);
                    $fsdev[$a[0]] = $a[4];
                }
            }
            foreach ($mounts as $mount)
            {
                $ar_buf = preg_split("/\s+/", $mount, 6);
                $dev = new DiskDevice();
                $dev->setName($ar_buf[0]);
                $dev->setTotal($ar_buf[1] * 1024);
                $dev->setUsed($ar_buf[2] * 1024);
                $dev->setFree($ar_buf[3] * 1024);
                $dev->setMountPoint($ar_buf[5]);
                if (isset($fsdev[$ar_buf[0]]))
                {
                    $dev->setFsType($fsdev[$ar_buf[0]]);
                }
                $this->sys->setDiskDevices($dev);
            }
        }
    }

    /**
     * Distribution
     *
     * @return void
     */
    private function _distro()
    {
        $this->sys->setDistribution(' IBM AIX ');
        $this->sys->setDistributionIcon('AIX.png');
    }


    /**
     * IBM AIX INFORMATIONs by K.PAZ
     * @return void
     */
    private function _myaixdata()
    {
        CommonFunctions::executeProgram('prtconf', '> /tmp/webprtconf.txt', $confret);
        CommonFunctions::rfts('/tmp/webprtconf.txt', $bufr);
        $this->myprtconf = preg_split("/\n/", $bufr, -1, PREG_SPLIT_NO_EMPTY);
    }



    /**
     * get the information
     *
     * @see PSI_Interface_OS::build()
     *
     * @return Void
     */
    function build()
    {
        $this->_myaixdata();
        $this->_distro();
        $this->_ip();
        $this->_hostname();
        $this->_kernel();
        $this->_uptime();
        $this->_users();
        $this->_loadavg();
        $this->_cpuinfo();
        $this->_pci();
        $this->_ide();
        $this->_scsi();
        $this->_usb();
        $this->_network();
        $this->_memory();
        $this->_filesystems();
    }
}
?>
