<?php if ( ! defined('APPPATH')) exit('No direct script access allowed');

class OsModel extends CI_Model {
	
	private $CI;
	private $inventory;
	
	private $list;
  	private $type;
	private $nic;
	
	function __construct() {
		$this->CI =& get_instance();
		$this->inventory = $this->CI->load->library('inventory');
		$this->nic = 'app_niclist';
    	$this->type = 'app_iptype';
	}
	
	public function loadById($nicid) {
		$filter = array($this->list.'.nicid' => $nicid);
		$res = $this->load($filter);
	}
	
	public function loadByIp($ipaddress) {
		$filter = array($this->list.'.ipaddress' => $ipaddress);
		$res = $this->load($filter);
		return $res;
	}
	
	public function loadByMac($macaddress) {
		$filter = array($this->list.'.macaddress' => $macaddress);
		$res = $this->load($filter);
		return $res;
	}
	
	private function load($filter) {
		$sql = $this->db->select($this->nic.'.*, '.$this->type.'.text' )
           		->from($this->nic)
				->join($this->type, $this->type.'.iptypeid = '.$this->nic.'.nictype','left')
           		->where($filter)
           		->limit(1,0)
           		->get();
    	$var = ($sql->num_rows() > 0) ? $sql->result() : false;
		
		if ($var != false) {
			$nic = $this->CI->inventory->createDevice('nic');
			foreach ($var as $row) {		
				$nic->setId($row->nicid);
				$nic->setName($row->nicname);
				$nic->setMac($row->macaddress);
				$nic->setIpAddress($row->ipaddress);
				$nic->setType($row->nictype);
			}
			return $nic;
		} else {
			return $var;
		}
	}
	
}

?>
	