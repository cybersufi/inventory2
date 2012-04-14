<?php if ( ! defined('APPPATH')) exit('No direct script access allowed');

class OsModel extends CI_Model {
    
	private $CI;
	private $inventory;
	
	private $list;
  	private $type;
	
	function __construct() {
		$this->CI =& get_instance();
		$this->inventory = $this->CI->load->library('inventory');
		$this->list = 'app_system';
    	$this->type = 'app_servertype';
    	$this->servernic = 'app_serverniclist';
	}
	
    public function loadById($serverid) {
		$filter = array($this->list.'.serverid' => $serverid);
		$res = $this->load($filter);
	}
	
	public function loadByName($servername) {
		$filter = array($this->list.'.servername' => $servername);
		$res = $this->load($filter);
		return $res;
	}
	
	private function load($filter) {
		$sql = $this->db->select($this->list.'.*, '.$this->type.'.text' )
           		->from($this->list)
				->join($this->type, $this->type.'.servertypeid = '.$this->list.'.servertype','left')
           		->where($filter)
           		->limit(1,0)
           		->get();
    	$var = ($sql->num_rows() > 0) ? $sql->result() : false;
		
		if ($var != false) {
			$system = $this->CI->inventory->createGenericOs();
			foreach ($var as $row) {		
				$system->getSys()->setServerid($row->serverid);
				$system->getSys()->setHostname($row->servername);
				$system->getSys()->setIp($row->defaultip);
				$system->getSys()->setType($row->text);
				$system->getSys()->setFunction($row->serverfunction);
				$system->getSys()->setKernel($row->kernel);
				$system->getSys()->setFirmware($row->firmwareversion);
				$system->getSys()->setDistribution($row->distribution);
				$system->getSys()->setSerial($row->serialnumber);
				$system->getSys()->setModel($row->makemodel);
				$system->getSys()->setOsbit($row->osbit);
				$system->getSys()->setStatus($row->serverstatus);
				$system->getSys()->setUptime($row->uptime);
				
				$system->getSys()->setZone($row->serverzone);
				$system->getSys()->setLocation($row->location);
				$system->getSys()->setRackInfo($row->rackinfo);
			}
			return $system;
		} else {
			return $var;
		}
	}	
}
?>
