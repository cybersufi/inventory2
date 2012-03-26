<?php
class ServerMpModel extends Model {

  private $mplist;
  private $slist;
  
  function ServerMpModel() {
    parent::Model();
    $this->mplist = 'app_servermountpoint';
    $this->slist = 'app_serverlist';
  }
  
  function __call($name, $arguments) {
    switch ($name) {
    case 'getMpList' : {
        if (count($arguments) == 1) {
          return $this->mpList1($arguments[0]);
        } else if (count($arguments) ==  2) {
          return $this->mpList2($arguments[0], $arguments[1]);
        } else if (count($arguments) == 3) {
          return $this->mpList3($arguments[0],$arguments[1], $arguments[2]);
        } else {
          trigger_error("Method <strong>$name</strong> with argument ". implode (',', $arguments)."doesn't exist", E_USER_ERROR);
        }
        break;
      }
      case 'getMpListFiltered' : {
        if (count($arguments) == 2) {
          return $this->mpList1($arguments[0], $arguments[1]);
        } else if (count($arguments) == 3) {
          return $this->mpList2($arguments[0],$arguments[1], $arguments[2]);
        } else if (count($arguments) == 4) {
          return $this->mpList3($arguments[0],$arguments[1], $arguments[2], $arguments[3]);
        } else {
          trigger_error("Method <strong>$name</strong> with argument ". implode (',', $arguments)."doesn't exist", E_USER_ERROR);
        }
        break;
      }
    case 'getMp': {
      if (count($arguments) == 1) {
        return $this->getMp1($arguments[0]);
      } else if ((count($arguments) == 2)) {
        return $this->getMp2($arguments[0], $arguments[1]);
      } else {
          trigger_error("Method <strong>$name</strong> with argument ". implode (',', $arguments)."doesn't exist", E_USER_ERROR);
      }
      break;
    }
    case 'getMpCount' : {
        if (count($arguments) == 1) {
          return $this->mpCount1($arguments[0]);
        } else if (count($arguments) == 2) {
          return $this->mpCount1($arguments[0], $arguments[1]);
        } else {
          trigger_error("Method <strong>$name</strong> with argument ". implode (',', $arguments)."doesn't exist", E_USER_ERROR);
        }
        break;
      }
    case 'delMp' : {
      if (count($arguments) == 1) {
        return $this->delMp1($arguments[0]);
      } else {
        trigger_error("Method <strong>$name</strong> with argument ". implode (',', $arguments)."doesn't exist", E_USER_ERROR);
      }
      break;
    }
		case 'delByServerid' : {
			if (count($arguments) == 1) {
        return $this->delMp2($arguments[0]);
      } else {
        trigger_error("Method <strong>$name</strong> with argument ". implode (',', $arguments)."doesn't exist", E_USER_ERROR);
      }
			break;
		}
    case 'addMp' : {
      if (count($arguments) == 6) {
        return $this->addMp1($arguments[0], $arguments[1], $arguments[2], $arguments[3], $arguments[4], $arguments[5]);
      } else {
        trigger_error("Method <strong>$name</strong> with argument ". implode (',', $arguments)."doesn't exist", E_USER_ERROR);
      }
      break;
    }
    case 'editMp' : {
      if (count($arguments) == 6) {
        return $this->editMp1($arguments[0], $arguments[1], $arguments[2], $arguments[3], $arguments[4], $arguments[5]);
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
  
  private function addMp1($serverid, $filesystem, $totalsize, $usedsize, $available, $mountedon) {
    $st = $this->mplist;
    $data = array(
      'serverid' => $serverid, 
      'filesystem' => $filesystem,
      'totalsize' => $totalsize,
      'usedsize' => $usedsize,
      'available' => $available,
      'mountedon' => $mountedon,
      'lastupdate' => date('Y-m-d h:i:s'));
    $this->db->insert($st, $data);
    return $var = ($this->db->affected_rows() > 0) ? true : false;
  }
  
  private function editMp1($id, $filesystem, $totalsize, $usedsize, $available, $mountedon) {
    $st = $this->mplist;
    $data = array(
      'filesystem' => $filesystem, 
      'totalsize' => $totalsize,
      'usedsize' => $usedsize,
      'available' => $available,
      'mountedon' => $mountedon,
      'lastupdate' => date('Y-m-d h:i:s'));
    $this->db->where('mpid', $id);
    $this->db->update($st, $data);
    return $var = ($this->db->affected_rows() > 0) ? true : false;
  }
  
  private function delMp1($id) {
    $st = $this->mplist;
    $this->db->delete($st, array('mpid' => $id));
    return $var = ($this->db->affected_rows() > 0) ? true : false;
  }

	private function delMp2($serverid) {
    $st = $this->mplist;
    $this->db->delete($st, array('serverid' => $serverid));
    return $var = ($this->db->affected_rows() > 0) ? true : false;
  }
  
  private function mpList1($serverid, $filters=NULL) {    
    return $this->mpList2($serverid, 0, $filters);
  }
  
  private function mpList2($serverid, $l, $filters=NULL) {
    return $this->mpList3($serverid, 0, $l, $filters);
  }
  
  private function mpList3($serverid, $s, $l, $filters=NULL) {
    $st = $this->mplist;
    $sl = $this->slist;
    $this->db->select($st.'.mpid as id, '.
                      $st.'.filesystem, '.
                      $st.'.totalsize, '.
                      $st.'.usedsize, '.
                      $st.'.available, '.
                      $st.'.mountedon, '.
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
  
  private function mpCount1($serverid, $filters=NULL) {
    $st = $this->mplist;
    $sl = $this->slist;
    
    $this->db->select($st.'.mpid as id')
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
  
  private function getMp1($id) {
    $st = $this->mplist;
    $sl = $this->slist;
    $sql = $this->db->select($st.'.mpid as id, '.
                      $st.'.filesystem, '.
                      $st.'.totalsize, '.
                      $st.'.usedsize, '.
                      $st.'.available, '.
                      $st.'.mountedon, '.
                      $sl.'.servername')
           ->from($st)
           ->join($sl, $sl.'.serverid = '.$st.'.serverid','left')
           ->where('mpid',$id)
           ->get();
    return $var = ($sql->num_rows() > 0) ? $sql : false;
  }
  
  private function getMp2($serverid, $filesystem) {
    $st = $this->mplist;
    $sl = $this->slist;
    $sql = $this->db->select($st.'.mpid as id, '.
                      $st.'.filesystem, '.
                      $st.'.totalsize, '.
                      $st.'.usedsize, '.
                      $st.'.available, '.
                      $st.'.mountedon, '.
                      $sl.'.servername')
           ->from($st)
           ->join($sl, $sl.'.serverid = '.$st.'.serverid','left')
           ->where('filesystem', $filesystem)
           ->where($st.'.serverid', $serverid)
           ->get();
    return $var = ($sql->num_rows() > 0) ? $sql : false;
  }
}
?>