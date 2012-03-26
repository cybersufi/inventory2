<?php
class ServerUserModel extends Model {

  private $uslist;
  private $slist;
  
  function ServerUserModel() {
    parent::Model();
    $this->uslist = 'app_serveruser';
    $this->slist = 'app_serverlist';
  }
  
  function __call($name, $arguments) {
    switch ($name) {
    case 'getUserList' : {
        if (count($arguments) == 1) {
          return $this->userList1($arguments[0]);
        } else if (count($arguments) ==  2) {
          return $this->userList2($arguments[0], $arguments[1]);
        } else if (count($arguments) == 3) {
          return $this->userList3($arguments[0],$arguments[1], $arguments[2]);
        } else {
          trigger_error("Method <strong>$name</strong> with argument ". implode (',', $arguments)."doesn't exist", E_USER_ERROR);
        }
        break;
      }
      case 'getUserListFiltered' : {
        if (count($arguments) == 2) {
          return $this->userList1($arguments[0], $arguments[1]);
        } else if (count($arguments) == 3) {
          return $this->userList2($arguments[0],$arguments[1], $arguments[2]);
        } else if (count($arguments) == 4) {
          return $this->userList3($arguments[0],$arguments[1], $arguments[2], $arguments[3]);
        } else {
          trigger_error("Method <strong>$name</strong> with argument ". implode (',', $arguments)."doesn't exist", E_USER_ERROR);
        }
        break;
      }
    case 'getUser': {
      if (count($arguments) == 1) {
        return $this->getUser1($arguments[0]);
      } else if ((count($arguments) == 2)) {
        return $this->getUser2($arguments[0], $arguments[1]);
      } else {
          trigger_error("Method <strong>$name</strong> with argument ". implode (',', $arguments)."doesn't exist", E_USER_ERROR);
      }
      break;
    }
    case 'getUserCount' : {
        if (count($arguments) == 1) {
          return $this->userCount1($arguments[0]);
        } else if (count($arguments) == 2) {
          return $this->userCount1($arguments[0], $arguments[1]);
        } else {
          trigger_error("Method <strong>$name</strong> with argument ". implode (',', $arguments)."doesn't exist", E_USER_ERROR);
        }
        break;
      }
    case 'delUser' : {
      if (count($arguments) == 1) {
        return $this->delUser1($arguments[0]);
      } else {
        trigger_error("Method <strong>$name</strong> with argument ". implode (',', $arguments)."doesn't exist", E_USER_ERROR);
      }
      break;
    }
		case 'delByServerid' : {
			if (count($arguments) == 1) {
        return $this->delUser2($arguments[0]);
      } else {
        trigger_error("Method <strong>$name</strong> with argument ". implode (',', $arguments)."doesn't exist", E_USER_ERROR);
      }
			break;
		}
    case 'addUser' : {
      if (count($arguments) == 4) {
        return $this->addUser1($arguments[0], $arguments[1], $arguments[2], $arguments[3]);
      } else {
        trigger_error("Method <strong>$name</strong> with argument ". implode (',', $arguments)."doesn't exist", E_USER_ERROR);
      }
      break;
    }
    case 'editUser' : {
      if (count($arguments) == 4) {
        return $this->editUser1($arguments[0], $arguments[1], $arguments[2], $arguments[3]);
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
  
  private function addUser1($serverid, $accname, $homedir, $comment) {
    $st = $this->uslist;
    $data = array(
      'serverid' => $serverid, 
      'accname' => $accname,
      'homedir' => $homedir,
      'comment' => $comment,
      'lastupdate' => date('Y-m-d h:i:s'));
    $this->db->insert($st, $data);
    return $var = ($this->db->affected_rows() > 0) ? true : false;
  }
  
  private function editUser1($id, $accname, $homedir, $comment) {
    $st = $this->uslist;
    $data = array(
      'accname' => $accname,
      'homedir' => $homedir,
      'comment' => $comment,
      'lastupdate' => date('Y-m-d h:i:s'));
    $this->db->where('userid', $id);
    $this->db->update($st, $data);
    return $var = ($this->db->affected_rows() > 0) ? true : false;
  }
  
  private function delUser1($id) {
    $st = $this->uslist;
    $this->db->delete($st, array('userid' => $id));
    return $var = ($this->db->affected_rows() > 0) ? true : false;
  }
	
	private function delUser2($serverid) {
    $st = $this->uslist;
    $this->db->delete($st, array('serverid' => $serverid));
    return $var = ($this->db->affected_rows() > 0) ? true : false;
  }
  
  private function userList1($serverid, $filters=NULL) {    
    return $this->userList2($serverid, 0,$filters);
  }
  
  private function userList2($serverid, $l, $filters=NULL) {
    return $this->userList3($serverid, 0, $l, $filters);
  }
  
  private function userList3($serverid, $s, $l, $filters=NULL) {
    $st = $this->uslist;
    $sl = $this->slist;
    $this->db->select($st.'.userid as id, '.
                      $st.'.accname, '.
                      $st.'.homedir, '.
                      $st.'.comment, '.
                      $sl.'.servername')
    ->from($st)
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
  
  private function userCount1($serverid, $filters=NULL) {
    $st = $this->uslist;
    $sl = $this->slist;
    
    $this->db->select($st.'.userid as id')
    ->from($st)
    ->join($sl, $sl.'.serverid = '.$st.'.serverid','left');
    
    if ($filters != NULL) {
    	$filters .= " and ".$st.".serverid = '".$serverid."'";
      $this->db->where($filters, NULL, FALSE);
    } else {
    	$this->db->where($st.'.serverid', $serverid);
    }
    
    return $this->db->count_all_results();
  }
  
  private function getUser1($id) {
    $st = $this->uslist;
    $sl = $this->slist;
    $sql = $this->db->select($st.'.userid as id, '.
                      $st.'.accname, '.
                      $st.'.homedir, '.
                      $st.'.comment, '.
                      $sl.'.servername')
           ->from($st)
           ->join($sl, $sl.'.serverid = '.$st.'.serverid','left')
           ->where('userid',$id)
           ->get();
    return $var = ($sql->num_rows() > 0) ? $sql : false;
  }
  
  private function getUser2($serverid, $accname) {
    $st = $this->uslist;
    $sl = $this->slist;
    $sql = $this->db->select($st.'.userid as id, '.
                      $st.'.accname, '.
                      $st.'.homedir, '.
                      $st.'.comment, '.
                      $sl.'.servername')
           ->from($st)
           ->join($sl, $sl.'.serverid = '.$st.'.serverid','left')
           ->where('accname', $accname)
           ->where($st.'.serverid', $serverid)
           ->get();
    return $var = ($sql->num_rows() > 0) ? $sql : false;
  }
}
?>