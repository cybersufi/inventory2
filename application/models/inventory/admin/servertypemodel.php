<?php
class ServerTypeModel extends Model {

  private $stype;
  private $stcount;
  
  function ServerTypeModel() {
    parent::Model();
    $this->stype = 'app_servertype';
    $this->stcount = 'app_servertypecount';
  }
  
  function __call($name, $arguments) {
    switch ($name) {
    case 'getTypeList' : {
        if (count($arguments) == 0) {
          return $this->typeList1();
        } else if (count($arguments) ==  1) {
          return $this->typeList2($arguments[0]);
        } else if (count($arguments) == 2) {
          return $this->typeList3($arguments[0],$arguments[1]);
        } else {
          trigger_error("Method <strong>$name</strong> with argument ". implode (',', $arguments)."doesn't exist", E_USER_ERROR);
        }
        break;
      }
      case 'getTypeListFiltered' : {
        if (count($arguments) == 1) {
          return $this->typeList1($arguments[0]);
        } else if (count($arguments) == 2) {
          return $this->typeList2($arguments[0],$arguments[1]);
        } else if (count($arguments) == 3) {
          return $this->typeList3($arguments[0],$arguments[1], $arguments[2]);
        } else {
          trigger_error("Method <strong>$name</strong> with argument ". implode (',', $arguments)."doesn't exist", E_USER_ERROR);
        }
        break;
      }
    case 'getType': {
      if (count($arguments) == 1) {
        return $this->getType1($arguments[0]);
      } else if ((count($arguments) == 2) && (strstr($arguments[1], "byname"))) {
        return $this->getType2($arguments[0]);
      } else {
          trigger_error("Method <strong>$name</strong> with argument ". implode (',', $arguments)."doesn't exist", E_USER_ERROR);
      }
      break;
    }
    case 'getTypeCount' : {
        if (count($arguments) == 0) {
          return $this->typeCount1();
        } else if (count($arguments) == 1) {
          return $this->typeCount1($arguments[0]);
        } else {
          trigger_error("Method <strong>$name</strong> with argument ". implode (',', $arguments)."doesn't exist", E_USER_ERROR);
        }
        break;
      }
    case 'delType' : {
      if (count($arguments) == 1) {
        return $this->delType1($arguments[0]);
      } else {
        trigger_error("Method <strong>$name</strong> with argument ". implode (',', $arguments)."doesn't exist", E_USER_ERROR);
      }
      break;
    }
    case 'addType' : {
      if (count($arguments) == 1) {
        return $this->addType1($arguments[0]);
      } else {
        trigger_error("Method <strong>$name</strong> with argument ". implode (',', $arguments)."doesn't exist", E_USER_ERROR);
      }
      break;
    }
    case 'editType' : {
      if (count($arguments) == 2) {
        return $this->editType1($arguments[0],$arguments[1]);
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
  
  private function addType1($typename) {
    $st = $this->stype;
    $data = array('text' => $typename);
    $this->db->insert($st, $data);
    return $var = ($this->db->affected_rows() > 0) ? true : false;
  }
  
  private function editType1($id, $typename) {
    $st = $this->stype;
    $data = array('text' => $typename);
    $this->db->where('servertypeid', $id);
    $this->db->update($st, $data);
    return $var = ($this->db->affected_rows() > 0) ? true : false;
  }
  
  private function delType1($id) {
    $st = $this->stype;
    $this->db->delete($st, array('servertypeid' => $id));
    return $var = ($this->db->affected_rows() > 0) ? true : false;
  }
  
  private function typeList1($filters=NULL) {    
    return $this->typeList2(0,$filters);
  }
  
  private function typeList2($l,$filters=NULL) {
    return $this->typeList3(0, $l, $filters);
  }
  
  private function typeList3($s, $l, $filters=NULL) {
    $st = $this->stype;
    $sc = $this->stcount;
    $this->db->select($st.'.servertypeid as id, '.
                      $st.'.text as typename, '.
                      $sc.'.sum as typesum')
    ->from($st)
  ->join($sc, $sc.'.servertype = '.$st.'.servertypeid', 'left');
    
    if ($filters != NULL) {
      $this->db->where($filters, NULL, FALSE);
    }
    
    if ($l > 0) {
      $this->db->limit($l,$s);
    }
    
    $res = $this->db->get();
    
    return ($res->num_rows() > 0) ? $res : false;
  }
  
  private function typeCount1($filters=NULL) {
    $st = $this->stype;
    $sc = $this->stcount;
    
    $this->db->select($st.'.servertypeid as id, '.
                      $st.'.text as typename, '.
                      $sc.'.sum as typesum')
    ->from($st)
    ->join($sc, $sc.'.servertype = '.$st.'.servertypeid', 'left');
    
    if ($filters != NULL) {
      $this->db->where($filters, NULL, FALSE);
    }
    
    return $this->db->count_all_results();
  }
  
  private function getType1($id) {
    $st = $this->stype;
    $sql = $this->db->select($st.'.servertypeid')
           ->from($st)
           ->where('servertypeid',$id)
           ->get();
    return $var = ($sql->num_rows() > 0) ? true : false;
  }
  
  private function getType2($typename) {
    $st = $this->stype;
    $sql = $this->db->select($st.'.servertypeid')
           ->from($st)
           ->where('text',$typename)
           ->get();
    return $var = ($sql->num_rows() > 0) ? true : false;
  }
}
?>