<?php

class ServerModel extends CI_Model {
  
  	private $list;
  	private $type;
  	private $nic;
	private $mp;
  
  	function __construct() {
    	parent::__construct();
    	$this->list = 'app_serverlist';
    	$this->type = 'app_servertype';
    	$this->nic = 'app_serverniclist';
  	}
  
  	public function getServerByName($servername) {
    	$param = array($this->list.'.servername' => $sname);
    	$sql = $this->db->select($this->list.'.*')
           		->from($this->list)
				->join($this->type, $this->type.'.servertypeid = '.$this->list.'.servertype','left')
           		->where($param)
           		->limit(1,0)
           		->get();
    	return $var = ($sql->num_rows() > 0) ? $sql->result() : false;
  	}
}

?>