<?php
class ServerOwnerModel extends Model {

  private $ownerlist;
  
  function ServerOwnerModel() {
    parent::Model();
    $this->ownerlist = 'app_serverowner';
  }
  
  function __call($name, $arguments) {
    switch ($name) {
    case 'getOwnerList' : {
        if (count($arguments) == 0) {
          return $this->ownerList1();
        } else if (count($arguments) ==  1) {
          return $this->ownerList2($arguments[0]);
        } else if (count($arguments) == 2) {
          return $this->ownerList3($arguments[0],$arguments[1]);
        } else {
          trigger_error("Method <strong>$name</strong> with argument ". implode (',', $arguments)."doesn't exist", E_USER_ERROR);
        }
        break;
      }
      case 'getOwnerListFiltered' : {
        if (count($arguments) == 1) {
          return $this->ownerList1($arguments[0]);
        } else if (count($arguments) == 2) {
          return $this->ownerList2($arguments[0],$arguments[1]);
        } else if (count($arguments) == 3) {
          return $this->ownerList3($arguments[0],$arguments[1], $arguments[2]);
        } else {
          trigger_error("Method <strong>$name</strong> with argument ". implode (',', $arguments)."doesn't exist", E_USER_ERROR);
        }
        break;
      }
    case 'getOwner': {
      if (count($arguments) == 1) {
        return $this->getOwner1($arguments[0]);
      } else if (count($arguments) == 2 && strstr($arguments[1],"ownername")) {
        return $this->getOwner2($arguments[0]);
      } else {
          trigger_error("Method <strong>$name</strong> with argument ". implode (',', $arguments)."doesn't exist", E_USER_ERROR);
      }
      break;
    }
    case 'getOwnerCount' : {
        if (count($arguments) == 0) {
          return $this->ownerCount1();
        } else if (count($arguments) == 1) {
          return $this->ownerCount1($arguments[0]);
        } else {
          trigger_error("Method <strong>$name</strong> with argument ". implode (',', $arguments)."doesn't exist", E_USER_ERROR);
        }
        break;
      }
    case 'delOwner' : {
      if (count($arguments) == 1) {
        return $this->delOwner1($arguments[0]);
      } else {
        trigger_error("Method <strong>$name</strong> with argument ". implode (',', $arguments)."doesn't exist", E_USER_ERROR);
      }
      break;
    }
    case 'addOwner' : {
      if (count($arguments) == 3) {
        return $this->addOwner1($arguments[0], $arguments[1], $arguments[2]);
      } else {
        trigger_error("Method <strong>$name</strong> with argument ". implode (',', $arguments)."doesn't exist", E_USER_ERROR);
      }
      break;
    }
    case 'editOwner' : {
      if (count($arguments) == 4) {
        return $this->editOwner1($arguments[0], $arguments[1], $arguments[2], $arguments[3]);
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
  
  private function addOwner1($ownername, $email, $phone) {
    $ol = $this->ownerlist;
    $data = array(
      'ownername' => $ownername, 
      'email' => $email,
      'phone' => $phone);
    $this->db->insert($ol, $data);
    return $var = ($this->db->affected_rows() > 0) ? true : false;
  }
  
  private function editOwner1($id, $ownername, $email, $phone) {
    $ol = $this->ownerlist;
    $data = array(
      'ownername' => $ownername, 
      'email' => $email,
      'phone' => $phone);
    $this->db->where('idowner', $id);
    $this->db->update($ol, $data);
    return $var = ($this->db->affected_rows() > 0) ? true : false;
  }
  
  private function delOwner1($id) {
    $ol = $this->ownerlist;
    $this->db->delete($ol, array('idowner' => $id));
    return $var = ($this->db->affected_rows() > 0) ? true : false;
  }
  
  private function ownerList1($filters=NULL) {    
    return $this->ownerList2(0,$filters);
  }
  
  private function ownerList2($l,$filters=NULL) {
    return $this->ownerList3(0, $l, $filters);
  }
  
  private function ownerList3($s, $l, $filters=NULL) {
    $ol = $this->ownerlist;
    $this->db->select($ol.'.idowner as id, '.
                      $ol.'.ownername, '.
                      $ol.'.email, '.
                      $ol.'.phone')
    ->from($ol);
    
    if ($filters != NULL) {
      $this->db->where($filters, NULL, FALSE);
    }
    
    if ($l > 0) {
      $this->db->limit($l,$s);
    }
    
    $res = $this->db->get();
    
    return ($res->num_rows() > 0) ? $res : false;
  }
  
  private function ownerCount1($filters=NULL) {
    $ol = $this->ownerlist;
    
    $this->db->select($ol.'.idowner as id')
    ->from($ol);
    
    if ($filters != NULL) {
      $this->db->where($filters, NULL, FALSE);
    }
    
    return $this->db->count_all_results();
  }
  
  private function getOwner1($id) {
    $ol = $this->ownerlist;
    $sql = $this->db->select($ol.'.idowner as id, '.
                      $ol.'.ownername, '.
                      $ol.'.email, '.
                      $ol.'.phone')
           ->from($ol)
           ->where('idowner',$id)
           ->get();
    return $var = ($sql->num_rows() > 0) ? $sql : false;
  }
  
  private function getOwner2($ownername) {
    $ol = $this->ownerlist;
    $sql = $this->db->select($ol.'.idowner as id, '.
                      $ol.'.ownername, '.
                      $ol.'.email, '.
                      $ol.'.phone')
           ->from($ol)
           ->where('ownername',$ownername)
           ->get();
    return $var = ($sql->num_rows() > 0) ? $sql : false;
  }
}
?>