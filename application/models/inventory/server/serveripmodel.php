<?php
class ServerIpModel extends Model {

  private $iplist;
  private $iptype;
  private $slist;
  
  
  function ServerIpModel() {
    parent::Model();
    $this->iplist = 'app_serverniclist';
    $this->iptype = 'app_serveriptype';
    $this->slist = 'app_serverlist';
  }
  
  function __call($name, $arguments) {
    switch ($name) {
    case 'getIpList' : {
      if (count($arguments) == 0) {
        return $this->ipList1();
      } else if (count($arguments) ==  1) {
        return $this->ipList2($arguments[0]);
      } else if (count($arguments) == 2) {
        return $this->ipList3($arguments[0],$arguments[1]);
      } else {
        trigger_error("Method <strong>$name</strong> with argument ". implode (',', $arguments)."doesn't exist", E_USER_ERROR);
      }
      break;
    }
    case 'getIpListFiltered' : {
      if (count($arguments) == 1) {
        return $this->ipList1($arguments[0]);
      } else if (count($arguments) == 2) {
        return $this->ipList2($arguments[0],$arguments[1]);
      } else if (count($arguments) == 3) {
        return $this->ipList3($arguments[0],$arguments[1], $arguments[2]);
      } else {
        trigger_error("Method <strong>$name</strong> with argument ". implode (',', $arguments)."doesn't exist", E_USER_ERROR);
      }
      break;
    }
		case 'getIpsForDetail' : {
			if (count($arguments) == 1) {
        return $this->ipList4($arguments[0],0,0,NULL);
      } else if (count($arguments) ==  2) {
        return $this->ipList4($arguments[0],0,$arguments[1],NULL);
      } else if (count($arguments) == 3) {
        return $this->ipList4($arguments[0],$arguments[1], $arguments[2], NULL);
      } else {
        trigger_error("Method <strong>$name</strong> with argument ". implode (',', $arguments)."doesn't exist", E_USER_ERROR);
      }
			break;
		}
		case 'getIpsForDetailFiltered' : {
			if (count($arguments) == 2) {
        return $this->ipList4($arguments[0],0,0,$arguments[1]);
      } else if (count($arguments) ==  3) {
        return $this->ipList4($arguments[0],0,$arguments[1],$arguments[2]);
      } else if (count($arguments) == 4) {
        return $this->ipList4($arguments[0],$arguments[1], $arguments[2], $arguments[3]);
      } else {
        trigger_error("Method <strong>$name</strong> with argument ". implode (',', $arguments)."doesn't exist", E_USER_ERROR);
      }
			break;
		}
    case 'getIp': {
      if (count($arguments) == 1) {
        return $this->getIp1($arguments[0]);
      } else if ((count($arguments) == 2)) {
        return $this->getIp2($arguments[0], $arguments[1]);
      } else if ((count($arguments) == 4)) {
        return $this->getIp3($arguments[0], $arguments[1], $arguments[2], $arguments[3]);
      } else {
          trigger_error("Method <strong>$name</strong> with argument ". implode (',', $arguments)."doesn't exist", E_USER_ERROR);
      }
      break;
    }
    case 'getIpCount' : {
      if (count($arguments) == 0) {
        return $this->ipCount1();
      } else if (count($arguments) == 1) {
        return $this->ipCount1($arguments[0]);
      } else {
        trigger_error("Method <strong>$name</strong> with argument ". implode (',', $arguments)."doesn't exist", E_USER_ERROR);
      }
      break;
    }
		case 'getIpCountForDetail' : {
      if (count($arguments) == 1) {
        return $this->ipCount2($arguments[0]);
      } else if (count($arguments) == 2) {
        return $this->ipCount2($arguments[0], $arguments[1]);
      } else {
        trigger_error("Method <strong>$name</strong> with argument ". implode (',', $arguments)."doesn't exist", E_USER_ERROR);
      }
      break;
    }
    case 'delIp' : {
      if (count($arguments) == 1) {
        return $this->delIp1($arguments[0]);
      } else {
        trigger_error("Method <strong>$name</strong> with argument ". implode (',', $arguments)."doesn't exist", E_USER_ERROR);
      }
      break;
    }
		case 'delByServerid' : {
			if (count($arguments) == 1) {
        return $this->delIp2($arguments[0]);
      } else {
        trigger_error("Method <strong>$name</strong> with argument ". implode (',', $arguments)."doesn't exist", E_USER_ERROR);
      }
			break;
		}
    case 'addIp' : {
      if (count($arguments) == 6) {
        return $this->addIp1($arguments[0], $arguments[1], $arguments[2], $arguments[3], $arguments[4], $arguments[5]);
      } else {
        trigger_error("Method <strong>$name</strong> with argument ". implode (',', $arguments)."doesn't exist", E_USER_ERROR);
      }
      break;
    }
    case 'editIp' : {
      if (count($arguments) == 6) {
        return $this->editIp1($arguments[0], $arguments[1], $arguments[2], $arguments[3], $arguments[4], $arguments[5]);
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
  
  private function addIp1($ipaddr, $macaddr, $nicname, $nictype, $serverid, $note) {
    $st = $this->iplist;
    $data = array(
      'ipaddress' => $ipaddr, 
      'macaddress' => $macaddr,
      'nicname' => $nicname,
      'nictype' => $nictype,
      'serverid' => $serverid,
      'note' => $note,
      'lastupdate' => date('Y-m-d h:i:s'));
    $this->db->insert($st, $data);
    return $var = ($this->db->affected_rows() > 0) ? true : false;
  }
  
  private function editIp1($id, $ipaddr, $macaddr, $nicname, $nictype, $note) {
    $st = $this->iplist;
    $data = array(
      'ipaddress' => $ipaddr, 
      'macaddress' => $macaddr,
      'nicname' => $nicname,
      'nictype' => $nictype,
      'note' => $note,
      'lastupdate' => date('Y-m-d h:i:s'));
    $this->db->where('nicid', $id);
    $this->db->update($st, $data);
    return $var = ($this->db->affected_rows() > 0) ? true : false;
  }
  
  private function delIp1($id) {
    $st = $this->iplist;
    $this->db->delete($st, array('nicid' => $id));
    return $var = ($this->db->affected_rows() > 0) ? true : false;
  }
	
	private function delIp2($serverid) {
    $st = $this->iplist;
    $this->db->delete($st, array('serverid' => $serverid));
    return $var = ($this->db->affected_rows() > 0) ? true : false;
  }
  
  private function ipList1($filters=NULL) {    
    return $this->ipList2(0,$filters);
  }
  
  private function ipList2($l,$filters=NULL) {
    return $this->ipList3(0, $l, $filters);
  }
  
  private function ipList3($s, $l, $filters=NULL) {
    $st = $this->iplist;
    $ipt = $this->iptype;
    $sl = $this->slist;
    $this->db->select($st.'.nicid as id, '.
                      $st.'.ipaddress, '.
                      $st.'.macaddress, '.
                      $st.'.nicname, '.
                      $ipt.'.text as nictype, '.
                      $st.'.note, '.
                      $sl.'.servername')
    ->from($st)
    ->join($ipt, $ipt.'.iptypeid = '.$st.'.nictype','left')
    ->join($sl, $sl.'.serverid = '.$st.'.serverid','left');
    
    if ($filters != NULL) {
      $this->db->where($filters, NULL, FALSE);
    }
    
    if ($l > 0) {
      $this->db->limit($l,$s);
    }
    
    $res = $this->db->get();
    
    return ($res->num_rows() > 0) ? $res : false;
  }
	
	private function ipList4($serverid, $s, $l, $filters=NULL) {
		$st = $this->iplist;
    $ipt = $this->iptype;
    $sl = $this->slist;
    $this->db->select($st.'.nicid as id, '.
                      $st.'.ipaddress, '.
                      $st.'.macaddress, '.
                      $st.'.nicname, '.
                      $ipt.'.text as nictype, '.
                      $st.'.note, '.
                      $sl.'.servername')
    ->from($st)
    ->join($ipt, $ipt.'.iptypeid = '.$st.'.nictype','left')
    ->join($sl, $sl.'.serverid = '.$st.'.serverid','left');
    
    if ($filters != NULL) {
    	$filters .= " and ".$st.".serverid = '".$serverid."'";
      $this->db->where($filters, NULL, FALSE);
    } else {
    	$this->db->where($st.'.serverid', $serverid);
    }
    
    if ($l > 0) {
      $this->db->limit($l,$s);
    }
    
    $res = $this->db->get();
    
    return ($res->num_rows() > 0) ? $res : false;
	}
  
  private function ipCount1($filters=NULL) {
    $st = $this->iplist;
    $ipt = $this->iptype;
    $sl = $this->slist;
    
    $this->db->select($st.'.nicid as id')
    ->from($st)
    ->join($ipt, $ipt.'.iptypeid = '.$st.'.nictype','left')
    ->join($sl, $sl.'.serverid = '.$st.'.serverid','left');
    
    if ($filters != NULL) {
      $this->db->where($filters, NULL, FALSE);
    }
    
    return $this->db->count_all_results();
  }
	
	private function ipCount2($serverid, $filters=NULL) {
    $st = $this->iplist;
    $ipt = $this->iptype;
    $sl = $this->slist;
    
    $this->db->select($st.'.nicid as id')
    ->from($st)
    ->join($ipt, $ipt.'.iptypeid = '.$st.'.nictype','left')
    ->join($sl, $sl.'.serverid = '.$st.'.serverid','left');
    
    if ($filters != NULL) {
    	$filters .= " and ".$st.".serverid = '".$serverid."'";
      $this->db->where($filters, NULL, FALSE);
    } else {
    	$this->db->where($st.'.serverid', $serverid);
    }
    
    return $this->db->count_all_results();
  }
  
  private function getIp1($id) {
    $st = $this->iplist;
    $ipt = $this->iptype;
    $sl = $this->slist;
    $sql = $this->db->select($st.'.nicid as id, '.
                      $st.'.ipaddress, '.
                      $st.'.macaddress, '.
                      $st.'.nicname, '.
                      $ipt.'.text as nictype, '.
                      $st.'.note, '.
                      $sl.'.servername')
           ->from($st)
           ->join($ipt, $ipt.'.iptypeid = '.$st.'.nictype','left')
           ->join($sl, $sl.'.serverid = '.$st.'.serverid','left')
           ->where('nicid',$id)
           ->get();
    return $var = ($sql->num_rows() > 0) ? $sql : false;
  }
  
  private function getIp2($serverid, $ipaddr) {
    $st = $this->iplist;
    $ipt = $this->iptype;
    $sl = $this->slist;
    $sql = $this->db->select($st.'.nicid as id, '.
                      $st.'.ipaddress, '.
                      $st.'.macaddress, '.
                      $st.'.nicname, '.
                      $ipt.'.text as nictype, '.
                      $st.'.note, '.
                      $sl.'.servername')
           ->from($st)
           ->join($ipt, $ipt.'.iptypeid = '.$st.'.nictype','left')
           ->join($sl, $sl.'.serverid = '.$st.'.serverid','left')
           ->where('ipaddress',$ipaddr)
           ->where($st.'.serverid',$serverid)
           ->get();
    return $var = ($sql->num_rows() > 0) ? $sql : false;
  }
  
  private function getIp3($serverid, $nicname, $ipaddress, $macaddress) {
    $st = $this->iplist;
    $ipt = $this->iptype;
    $sl = $this->slist;
    $sql = $this->db->select($st.'.nicid as id, '.
                      $st.'.ipaddress, '.
                      $st.'.macaddress, '.
                      $st.'.nicname, '.
                      $ipt.'.text as nictype, '.
                      $st.'.note, '.
                      $sl.'.servername')
           ->from($st)
           ->join($ipt, $ipt.'.iptypeid = '.$st.'.nictype','left')
           ->join($sl, $sl.'.serverid = '.$st.'.serverid','left')
           ->where('ipaddress', $ipaddress)
           ->where('nicname', $nicname)
           ->where('macaddress', $macaddress)
           ->where($st.'.serverid', $serverid)
           ->get();
    return $var = ($sql->num_rows() > 0) ? $sql : false;
  }
}
?>