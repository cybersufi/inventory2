<?php
class ServerZoneModel extends Model {

  private $zonelist;
  
  
  function ServerZoneModel() {
    parent::Model();
    $this->zonelist = 'app_serverzone';
  }
  
  function __call($name, $arguments) {
    switch ($name) {
    case 'getZoneList' : {
        if (count($arguments) == 0) {
          return $this->zoneList1();
        } else if (count($arguments) ==  1) {
          return $this->zoneList2($arguments[0]);
        } else if (count($arguments) == 2) {
          return $this->zoneList3($arguments[0],$arguments[1]);
        } else {
          trigger_error("Method <strong>$name</strong> with argument ". implode (',', $arguments)."doesn't exist", E_USER_ERROR);
        }
        break;
      }
      case 'getZoneListFiltered' : {
        if (count($arguments) == 1) {
          return $this->zoneList1($arguments[0]);
        } else if (count($arguments) == 2) {
          return $this->zoneList2($arguments[0],$arguments[1]);
        } else if (count($arguments) == 3) {
          return $this->zoneList3($arguments[0],$arguments[1], $arguments[2]);
        } else {
          trigger_error("Method <strong>$name</strong> with argument ". implode (',', $arguments)."doesn't exist", E_USER_ERROR);
        }
        break;
      }
    case 'getZone': {
      if (count($arguments) == 1) {
        return $this->getZone1($arguments[0]);
      } else if ((count($arguments) == 2) && strstr($arguments[1], 'zonename')) {
        return $this->getZone2($arguments[0]);
      } else {
          trigger_error("Method <strong>$name</strong> with argument ". implode (',', $arguments)."doesn't exist", E_USER_ERROR);
      }
      break;
    }
    case 'getZoneCount' : {
        if (count($arguments) == 0) {
          return $this->zoneCount1();
        } else if (count($arguments) == 1) {
          return $this->zoneCount1($arguments[0]);
        } else {
          trigger_error("Method <strong>$name</strong> with argument ". implode (',', $arguments)."doesn't exist", E_USER_ERROR);
        }
        break;
      }
    case 'delZone' : {
      if (count($arguments) == 1) {
        return $this->delZone1($arguments[0]);
      } else {
        trigger_error("Method <strong>$name</strong> with argument ". implode (',', $arguments)."doesn't exist", E_USER_ERROR);
      }
      break;
    }
    case 'addZone' : {
      if (count($arguments) == 2) {
        return $this->addZone1($arguments[0], $arguments[1]);
      } else {
        trigger_error("Method <strong>$name</strong> with argument ". implode (',', $arguments)."doesn't exist", E_USER_ERROR);
      }
      break;
    }
    case 'editZone' : {
      if (count($arguments) == 3) {
        return $this->editZone1($arguments[0], $arguments[1], $arguments[2]);
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
  
  private function addZone1($zonename, $zonenote) {
    $zl = $this->zonelist;
    $data = array(
      'text' => $zonename,
      'note' => $zonenote);
    $this->db->insert($zl, $data);
    return $var = ($this->db->affected_rows() > 0) ? true : false;
  }
  
  private function editZone1($zid, $zonename, $zonenote) {
    $zl = $this->zonelist;
    $data = array(
      'text' => $zonename,
      'note' => $zonenote);
    $this->db->where('zoneid', $zid);
    $this->db->update($zl, $data);
    return $var = ($this->db->affected_rows() > 0) ? true : false;
  }
  
  private function delZone1($id) {
    $zl = $this->zonelist;
    $this->db->delete($zl, array('zoneid' => $id));
    return $var = ($this->db->affected_rows() > 0) ? true : false;
  }
  
  private function zoneList1($filters=NULL) {    
    return $this->zoneList2(0,$filters);
  }
  
  private function zoneList2($l,$filters=NULL) {
    return $this->zoneList3(0, $l, $filters);
  }
  
  private function zoneList3($s, $l, $filters=NULL) {
    $zl = $this->zonelist;
    $this->db->select($zl.'.zoneid as id, '.
                      $zl.'.text as zonename, '.
                      $zl.'.note as zonenote')
    ->from($zl);
    
    if ($filters != NULL) {
      $this->db->where($filters, NULL, FALSE);
    }
    
    if ($l > 0) {
      $this->db->limit($l,$s);
    }
    
    $res = $this->db->get();
    
    return ($res->num_rows() > 0) ? $res : false;
  }
  
  private function zoneCount1($filters=NULL) {
    $zl = $this->zonelist;
    
    $this->db->select($zl.'.zoneid as id')
    ->from($zl);
    
    if ($filters != NULL) {
      $this->db->where($filters, NULL, FALSE);
    }
    
    return $this->db->count_all_results();
  }
  
  private function getZone1($id) {
    $zl = $this->zonelist;
    $sql = $this->db->select($zl.'.zoneid as id, '.
                      $zl.'.text, '.
                      $zl.'.note')
           ->from($zl)
           ->where('zoneid',$id)
           ->get();
    return $var = ($sql->num_rows() > 0) ? $sql : false;
  }
  
  private function getZone2($zonename) {
    $zl = $this->zonelist;
    $sql = $this->db->select($zl.'.zoneid as id, '.
                      $zl.'.text, '.
                      $zl.'.note')
           ->from($zl)
           ->where('text',$zonename)
           ->get();
    return $var = ($sql->num_rows() > 0) ? $sql : false;
  }
}
?>