<?php if ( ! defined('APPPATH')) exit('No direct script access allowed');

abstract class os implements ios {
    /**
     * @var System
     */
    protected $sys;
    
    /**
     * build the global Error object
     */
    public function __construct()
    {
        $this->sys = new system();
    }
    
    /**
     * get os specific encoding
     *
     * @see ios::getEncoding()
     *
     * @return string
     */
    public function getEncoding()
    {
        return null;
    }
    
    /**
     * get the filled or unfilled (with default values) System object
     *
     * @see ios::getSys()
     *
     * @return system
     */
    public final function getSys()
    {
        $this->build();
        return $this->sys;
    }
	
	/**
     * load data from database and filled to system object
     *
     * @see ios::loadFromDatabase()
     *
     * @return void
     */
	public final function loadFromDatabase() {
		$CI =& get_instance();
		$CI->load->model('inventory/servermodel_new','servermodel');
		$hostname = $this->sys->getHostname();
		$res = $CI->servermodel->getServerByName($hostname);
		if ($res != false) {
			foreach ($$res as $row) {
				$this->sys->setServerid($row->serverid);
				$this->sys->setIp($row->defaultip);
				$this->sys->setType($row->text);
				$this->sys->setFunction($row->serverfunction);
				$this->sys->setKernel($row->kernel);
				$this->sys->setFirmware($row->firmwareversion);
				$this->sys->setDistribution($row->distribution);
				$this->sys->setSerial($row->serialnumber);
				$this->sys->setModel($row->makemodel);
				$this->sys->setOsbit($row->osbit);
				$this->sys->setStatus($row->serverstatus);
				$this->sys->setUptime($row->uptime);
				
				$this->sys->setZone($row->serverzone);
				$this->sys->setLocation($row->location);
				$this->sys->setRackInfo($row->rackinfo);
			}
		}
	}
}
?>
