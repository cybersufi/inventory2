<?php
class ServerCredentialModel extends Model {

  private $credlist;
  private $slist;
  
	const USE_SERVERID = 1;
  
  function ServerCredentialModel() {
    parent::Model();
    $this->credlist = 'app_servercredential';
    $this->slist = 'app_serverlist';
		$this->load->model('inventory/server/servercredentialhistorymodel','history_model');
  }
  
  function __call($name, $arguments) {
    switch ($name) {
	    case 'getCredentialList' : {
	      if (count($arguments) == 0) {
	        return $this->credList1();
	      } else if (count($arguments) ==  1) {
	        return $this->credList2($arguments[0]);
	      } else if (count($arguments) == 2) {
	        return $this->credList3($arguments[0],$arguments[1]);
	      } else {
	        trigger_error("Method <strong>$name</strong> with argument ". implode (',', $arguments)."doesn't exist", E_USER_ERROR);
	      }
	      break;
	    }
	    case 'getCredentialListFiltered' : {
	      if (count($arguments) == 1) {
	        return $this->credList1($arguments[0]);
	      } else if (count($arguments) ==  2) {
	        return $this->credList2($arguments[0], $arguments[1]);
	      } else if (count($arguments) == 3) {
	        return $this->credList3($arguments[0], $arguments[1], $arguments[2]);
	      } else {
	        trigger_error("Method <strong>$name</strong> with argument ". implode (',', $arguments)."doesn't exist", E_USER_ERROR);
	      }
	      break;
	    }
			case 'getCredentialCount' : {
	      if (count($arguments) == 0) {
	        return $this->credCount1();
	      } else if (count($arguments) == 1) {
	        return $this->credCount1($arguments[0]);
	      } else {
	        trigger_error("Method <strong>$name</strong> with argument ". implode (',', $arguments)."doesn't exist", E_USER_ERROR);
	      }
	      break;
	    }
	    case 'getCredential': {
	      if (count($arguments) == 1) {
	        return $this->getCredential1($arguments[0]);
	      } else if ((count($arguments) == 2) && ($arguments[1] == ServerCredentialModel::USE_SERVERID)) {
	        return $this->getCredential2($arguments[0]);
	      } else {
	          trigger_error("Method <strong>$name</strong> with argument ". implode (',', $arguments)."doesn't exist", E_USER_ERROR);
	      }
	      break;
	    }
			case 'getPasswd' : {
				if (count($arguments) == 1) {
	        return $this->getPasswd1($arguments[0]);
	      } else {
	          trigger_error("Method <strong>$name</strong> with argument ". implode (',', $arguments)."doesn't exist", E_USER_ERROR);
	      }
				break;
			}
			case 'getMasterPassword' : {
				if (count($arguments) == 0) {
	        return $this->getMasterPassword1();
	      } else {
	          trigger_error("Method <strong>$name</strong> with argument ". implode (',', $arguments)."doesn't exist", E_USER_ERROR);
	      }
				break;
			}
	    case 'delCredential' : {
	      if (count($arguments) == 1) {
	        return $this->delCredential1($arguments[0]);
	      } else {
	        trigger_error("Method <strong>$name</strong> with argument ". implode (',', $arguments)."doesn't exist", E_USER_ERROR);
	      }
	      break;
	    }
			case 'delByServerid' : {
				if (count($arguments) == 1) {
	        return $this->delCredential2($arguments[0]);
	      } else {
	        trigger_error("Method <strong>$name</strong> with argument ". implode (',', $arguments)."doesn't exist", E_USER_ERROR);
	      }
				break;
			}
	    case 'addCredential' : {
	      if (count($arguments) == 3) {
	        return $this->addCredential1($arguments[0], $arguments[1], $arguments[2]);
	      } else {
	        trigger_error("Method <strong>$name</strong> with argument ". implode (',', $arguments)."doesn't exist", E_USER_ERROR);
	      }
	      break;
	    }
	    case 'editCredential' : {
	      if (count($arguments) == 3) {
	        return $this->editCredential1($arguments[0], $arguments[1], $arguments[2]);
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
  
  private function addCredential1($serverid, $passwd, $userid) {
    $st = $this->credlist;
    $date = date('Y-m-d H:i:s');
    $data = array(
      'serverid' => $serverid, 
      'passwd' => $passwd,
      'changeby' => $userid,
      'lastupdate' => $date);
    $this->db->insert($st, $data);
		
		$var = ($this->db->affected_rows() > 0) ? true : false;
		
		$this->history_model->addHistory($userid, $serverid, $date, $var);
		
    return $var;
  }
  
  private function editCredential1($id, $passwd, $userid) {
    $st = $this->credlist;
		$date = date('Y-m-d H:i:s');
    $data = array(
      'passwd' => $passwd,
      'changeby' => $userid,
      'lastupdate' => $date);
    $this->db->where('credid', $id);
    $this->db->update($st, $data);
		
		$var = ($this->db->affected_rows() > 0) ? true : false;
		
		//echo $var;
		
		//$this->history_model->addHistory($userid, $serverid, $date, $var);
		
    return $var;
  }
  
  private function delCredential1($id) {
    $st = $this->credlist;
    $this->db->delete($st, array('credid' => $id));
    return $var = ($this->db->affected_rows() > 0) ? true : false;
  }
	
	private function delCredential2($serverid) {
    $st = $this->credlist;
    $this->db->delete($st, array('serverid' => $serverid));
    return $var = ($this->db->affected_rows() > 0) ? true : false;
  }
  
  private function credentialList1($filters=NULL) {    
    return $this->credentialList2(0,$filters);
  }
  
  private function credentialList2($l,$filters=NULL) {
    return $this->credentialList3(0, $l, $filters);
  }
  
  private function credentialList3($s, $l, $filters=NULL) {
    $st = $this->credlist;
    $sl = $this->slist;
    $this->db->select($st.'.credid as id, '.
                      $st.'.passwd, '.
                      $st.'.changeby, '.
                      $st.'.lastupdate, '.
                      $sl.'.servername')
    ->from($st)
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
  
  private function credentialCount1($filters=NULL) {
    $st = $this->credlist;
    $sl = $this->slist;
    
    $this->db->select($st.'.credid as id')
    ->from($st)
    ->join($sl, $sl.'.serverid = '.$st.'.serverid','left');
    
    if ($filters != NULL) {
      $this->db->where($filters, NULL, FALSE);
    }
    
    return $this->db->count_all_results();
  }
  
  private function getCredential1($id) {
    $st = $this->credlist;
    $sl = $this->slist;
    $sql = $this->db->select($st.'.credid as id, '.
                      $st.'.passwd, '.
                      $st.'.changeby, '.
                      $st.'.lastupdate, '.
                      $sl.'.servername')
           ->from($st)
           ->join($sl, $sl.'.serverid = '.$st.'.serverid','left')
           ->where('credid',$id)
           ->get();
    return $var = ($sql->num_rows() > 0) ? $sql : false;
  }
  
  private function getCredential2($serverid) {
    $st = $this->credlist;
    $sl = $this->slist;
    $sql = $this->db->select($st.'.credid as id, '.
                      $st.'.passwd, '.
                      $st.'.changeby, '.
                      $st.'.lastupdate, '.
                      $sl.'.servername')
           ->from($st)
           ->join($sl, $sl.'.serverid = '.$st.'.serverid','left')
           ->where($st.'.serverid',$serverid)
					 ->limit(1)
           ->get();
    return $var = ($sql->num_rows() > 0) ? $sql : false;
  }
	
	private function getPassword1($serverid) {
		$st = $this->credlist;
    $sql = $this->db->select($st.'.passwd')
           ->from($st)
           ->where($st.'.serverid',$serverid)
					 ->limit(1)
           ->get(); 
		return $var = ($sql->num_rows() > 0) ? $sql->result() : false;
	}
	
	private function getMasterPassword1() {
		$st = $this->credlist;
    $sql = $this->db->select($st.'.passwd')
           ->from($st)
           ->where($st.'.credid',"0")
           ->get(); 
		return $var = ($sql->num_rows() > 0) ? $sql->result() : false;
	}
}
?>