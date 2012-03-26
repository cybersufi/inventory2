<?php

class ServerModel extends CI_Model {
  
  	private $serverlist;
  	private $servertype;
  	private $servernic;
	
	const GET_DETAIL = 1;
	const GET_BY_NAME = 2;
  
  	function __construct() {
    	parent::__construct();
    	$this->serverlist = 'app_serverlist';
    	$this->servertype = 'app_servertype';
    	$this->servernic = 'app_serverniclist';
  	}
  
  	public function __call($name, $arguments) {
    	switch ($name) {
      		case 'getServerList' : {
        		if (count($arguments) == 0) {
          			return $this->serverList1();
        		} else if (count($arguments) ==  1) {
          			return $this->serverList2($arguments[0]);
        		} else if (count($arguments) == 2) {
          			return $this->serverList3($arguments[0],$arguments[1]);
        		} else {
          			trigger_error("Method <strong>$name</strong> with argument ". implode (',', $arguments)."doesn't exist", E_USER_ERROR);
        		}
    			break;
      		}
	      	case 'getServerListFiltered' : {
	        	if (count($arguments) == 1) {
	          		return $this->serverList1($arguments[0]);
	        	} else if (count($arguments) == 2) {
	          		return $this->serverList2($arguments[0],$arguments[1]);
	        	} else if (count($arguments) == 3) {
	          		return $this->serverList3($arguments[0],$arguments[1], $arguments[2]);
	        	} else {
	          		trigger_error("Method <strong>$name</strong> with argument ". implode (',', $arguments)."doesn't exist", E_USER_ERROR);
	        	}
	        	break;
	      	}
	      	case 'getServerCount' : {
	        	if (count($arguments) == 0) {
	          		return $this->serverCount1();
	        	} else if (count($arguments) == 1) {
	          		return $this->serverCount1($arguments[0]);
	        	} else {
	          		trigger_error("Method <strong>$name</strong> with argument ". implode (',', $arguments)."doesn't exist", E_USER_ERROR);
	        	}
	        	break;
	      	}
	      	case 'getServer' : {
	        	if (count($arguments) == 1) {
	          		return $this->getServer1($arguments[0]);
	    		} else if (count($arguments) == 2) {
	          		if (strstr($arguments[1], "ServerDetail")) {
	            		return $this->getServer3($arguments[0]);
	          		} else if ($arguments[1] == servermodel::GET_BY_NAME) {
	          			return $this->getServer4($arguments[0]);
	          		} else {
	            		return $this->getServer2($arguments[0], $arguments[1]);
	          		}
	        	} else {
	          		trigger_error("Method <strong>$name</strong> with argument ". implode (',', $arguments)."doesn't exist", E_USER_ERROR);
	        	}
	        	break;  
	      	}
	      	case 'addServer' : {
	        	if (count($arguments) == 4) {
	          		return $this->addServer1($arguments[0], $arguments[1], $arguments[2], $arguments[3]);
	        	} else {
	          		trigger_error("Method <strong>$name</strong> with argument ". implode (',', $arguments)."doesn't exist", E_USER_ERROR);
	        	}
	        	break;
	      	}
	      	case 'delServer' : {
	        	if (count($arguments) == 1) {
	          		return $this->delServer1($arguments[0]);
	        	} else {
	          		trigger_error("Method <strong>$name</strong> with argument ". implode (',', $arguments)."doesn't exist", E_USER_ERROR);
	        	}
	        	break;
	      	}
	      	case 'editDetail': {
	        	if (count($arguments) == 2) {
	          		return $this->editDetail1($arguments[0], $arguments[1]);
	        	} else {
	          		trigger_error("Method <strong>$name</strong> with argument ". implode (',', $arguments)."doesn't exist", E_USER_ERROR);
	        	}
	        	break;
	      	}
	      	default: {
	        	trigger_error("Method <strong>$name</strong> doesn't exist", E_USER_ERROR);
	  		}
		}
  	}
  
  	private function serverCount1($filters=null) {
    	$sl = $this->serverlist;
    	$st = $this->servertype;
    
    	$this->db->select($sl.'.serverid, '.
                             $sl.'.servername, '.
                             $sl.'.serverfunction, '.
                             $st.'.text as serveros')
    	->from($sl)
    	->join($st, $st.'.servertypeid = '.$sl.'.servertype','left');
    
    	if ($filters != null) {
      		$this->db->where($filters, NULL, FALSE);
    	}
    
    	return $this->db->count_all_results();
  	}
  
  	private function serverCount2($filters) {
    	return null;
  	}
  
  	private function serverList1($filters=NULL) {    
    	return $this->serverList2(0,$filters);
  	}
  
  	private function serverList2($l,$filters=NULL) {
    	return $this->serverList3(0, $l, $filters);
  	}
  
  	private function serverList3($s, $l, $filters=NULL) {
  		$sl = $this->serverlist;
    	$st = $this->servertype;
    	$sn = $this->servernic;
    
    	$this->db->select($sl.'.serverid as id, '.
                             $sl.'.servername, '.
                             $sl.'.serverfunction, '.
                             $sl.'.defaultip, '.
                             $st.'.text as serveros')
    	->from($sl)
    	->join($st, $st.'.servertypeid = '.$sl.'.servertype','left');
    
    	if ($filters != NULL) {
      		$this->db->where($filters, NULL, FALSE);
    	}
    
    	if ($l > 0) {
      		$this->db->limit($l,$s);
    	}
    
    	$res = $this->db->get();
    
    	return ($res->num_rows() > 0) ? $res : false;
  	}
  
  	private function getServer1($id) {
    	$sl = $this->serverlist;
    	$sql = $this->db->select($sl.'.serverid')
       	->from($sl)
       	->where('serverid',$id)
       	->limit(1,0)
       	->get();
    	return $var = ($sql->num_rows() > 0) ? true : false;
  	}
  
  	private function getServer2($sname, $ipaddr) {
    	$sl = $this->serverlist;
    	$param = array('servername' => $sname);
    	$param2 = array('defaultip' => $ipaddr);
    	$sql = $this->db->select($sl.'.serverid')
           		->from($sl)
           		->where($param)
           		->where($param2)
           		->limit(1,0)
           		->get();
    	return $var = ($sql->num_rows() > 0) ? true : false;
  	}
	
  	private function getServer3($id) {
    	$sl = $this->serverlist;
    	$sql = $this->db->select($sl.'.*')
           		->from($sl)
           		->where('serverid',$id)
           		->limit(1,0)
           		->get();
    	return $var = ($sql->num_rows() > 0) ? $sql : false;
  	}
	
	private function getServer4($sname) {
    	$sl = $this->serverlist;
    	$param = array($sl.'.servername' => $sname);
    	$sql = $this->db->select($sl.'.serverid')
           		->from($sl)
           		->where($param)
           		->limit(1,0)
           		->get();
    	return $var = ($sql->num_rows() > 0) ? $sql->result() : false;
  	}
  
  	private function addServer1($sname, $sfunc, $stype, $ip) {
    	$sl = $this->serverlist;
    	$data = array();
    	$data['servername'] = $sname;
    	$data['serverfunction'] = $sfunc;
    	$data['servertype'] = $stype;
    	$data['defaultip'] = $ip;
    	$this->db->insert($sl, $data);
    	return $var = ($this->db->affected_rows() > 0) ? true : false;
  	}
  
  	private function delServer1($id) {
    	$sl = $this->serverlist;
    	$this->db->delete($sl, array('serverid' => $id));
    	return $var = ($this->db->affected_rows() > 0) ? true : false;
  	}
  
  	private function editDetail1($sid, $record) {
    	$sl = $this->serverlist;
    	$this->db->where('serverid', $sid);
    	$this->db->update($sl, $record);
    	return $var = ($this->db->affected_rows() > 0) ? true : false;
  	}
}

?>