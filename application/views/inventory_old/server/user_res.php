<?php

switch($type) {
  case 'list' : {
    $data['total'] = $total;
    $data['data'] = array();
    if ($res != null) {
      switch($funcname) {
        case 'uslist' : {
          foreach ($res as $row) {
            $cur_row = array();
            $cur_row['userid'] = $row->id;
            $cur_row['accname'] = $row->accname;
            $cur_row['homedir'] = $row->homedir;
            $cur_row['comment'] = $row->comment;
            $cur_row['servername'] = $row->servername;
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
}
  
echo json_encode($data);

?>