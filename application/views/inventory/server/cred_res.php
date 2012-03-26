<?php

switch($type) {
  case 'list' : {
    $data['total'] = $total;
    $data['data'] = array();
    if ($res != null) {
      switch($funcname) {
        case 'historylist' : {
          foreach ($res as $row) {
            $cur_row = array();
            $cur_row['changeid'] = $row->id;
            $cur_row['changeby'] = $row->username;
            $cur_row['changedate'] = $row->changedate;
            $cur_row['changestatus'] = ($row->changestatus == 1) ? "success" : "failed";
            array_push($data['data'], $cur_row);
          }  
          break;
        }
      }
    }
    break;
  }
  case 'form' : {
    $data['success'] = $success;
    $data['msg'] = $msg;
    break;
  }
	case 'credForm' : {
		$data['success'] = $success;
		$data['data'] = $res;
	}
}
  
echo json_encode($data);

?>