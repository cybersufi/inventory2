<?php
class ServerCredentialHistoryModel extends Model {

  private $histlist;
	private $userlist;
  
  
  function ServerCredentialHistoryModel() {
    parent::Model();
    $this->histlist = 'app_servercredentialhistory';
		$this->userlist = 'users';
  }
  
  function __call($name, $arguments) {
    switch ($name) {
	    case 'getHistoryList' : {
	      if (count($arguments) == 1) {
	        return $this->historyList1($arguments[0]);
	      } else if (count($arguments) ==  2) {
	        return $this->historyList2($arguments[0], $arguments[1]);
	      } else if (count($arguments) == 3) {
	        return $this->historyList3($arguments[0],$arguments[1], $arguments[2]);
	      } else {
	        trigger_error("Method <strong>$name</strong> with argument ". implode (',', $arguments)."doesn't exist", E_USER_ERROR);
	      }
	      break;
	    }
	    case 'getHistoryListFiltered' : {
	      if (count($arguments) == 2) {
	        return $this->historyList1($arguments[0], $arguments[1]);
	      } else if (count($arguments) == 3) {
	        return $this->historyList2($arguments[0], $arguments[1], $arguments[2]);
	      } else if (count($arguments) == 4) {
	        return $this->historyList3($arguments[0], $arguments[1], $arguments[2], $arguments[3]);
	      } else {
	        trigger_error("Method <strong>$name</strong> with argument ". implode (',', $arguments)."doesn't exist", E_USER_ERROR);
	      }
	      break;
	    }
			case 'getHistoryCount' : {
	      if (count($arguments) == 0) {
	        return $this->historyCount1();
	      } else if (count($arguments) == 1) {
	        return $this->historyCount1($arguments[0]);
	      } else {
	        trigger_error("Method <strong>$name</strong> with argument ". implode (',', $arguments)."doesn't exist", E_USER_ERROR);
	      }
	      break;
	    }
			case 'delByServerid' : {
				if (count($arguments) == 1) {
	        return $this->delHistory1($arguments[0]);
	      } else {
	        trigger_error("Method <strong>$name</strong> with argument ". implode (',', $arguments)."doesn't exist", E_USER_ERROR);
	      }
				break;
			}
	    case 'addHistory' : {
	      if (count($arguments) == 4) {
	        return $this->addHistory($arguments[0], $arguments[1], $arguments[2], $arguments[3]);
	      } else {
	        trigger_error("Method <strong>$name</strong> with argument ". implode (',', $arguments)."doesn't exist", E_USER_ERROR);
	      }
	      break;
	    }
    }  
  }
  
  private function addHistory1($userid, $serverid, $changedate, $changestatus) {
    $st = $this->histlist;
    $data = array(
      'userid' => $userid, 
      'serverid' => $serverid,
      'changedate' => $changedate,
      'changestatus' => $changestatus);
    $this->db->insert($st, $data);
    return $var = ($this->db->affected_rows() > 0) ? true : false;
  }
	
	private function delHistory1($serverid) {
    $st = $this->histlist;
    $this->db->delete($st, array('serverid' => $serverid));
    return $var = ($this->db->affected_rows() > 0) ? true : false;
  }
  
  private function historyList1($serverid, $filters=NULL) {    
    return $this->historyList2($serverid, 0,$filters);
  }
  
  private function historyList2($serverid, $l,$filters=NULL) {
    return $this->historyList3($serverid, 0, $l, $filters);
  }
  
  private function historyList3($serverid, $s, $l, $filters=NULL) {
    $st = $this->histlist;
		$su = $this->userlist;
    $this->db->select($st.'.historyid as id, '.
                      $st.'.changedate, '.
                      $st.'.changestatus, '.
											$su.'.username')
    ->from($st)
		->join($su, $su.'.id = '.$st.'.userid','left');
    
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
  
  private function historyCount1($serverid, $filters=NULL) {
    $st = $this->histlist;
    
    $this->db->select($st.'.historyid as id')
    ->from($st);
    
    if ($filters != NULL) {
    	$filters .= " and ".$st.".serverid = '".$serverid."'";
      $this->db->where($filters, NULL, FALSE);
    } else {
    	$this->db->where($st.'.serverid', $serverid);
    }
    
    return $this->db->count_all_results();
  }
}
?>