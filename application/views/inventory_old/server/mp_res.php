<?php

switch($type) {
  case 'list' : {
    $data['total'] = $total;
    $data['data'] = array();
    if ($res != null) {
      switch($funcname) {
        case 'mplist' : {
          foreach ($res as $row) {
            $cur_row = array();
            $cur_row['mpid'] = $row->id;
            $cur_row['filesystem'] = $row->filesystem;
            $cur_row['totalsize'] = $row->totalsize;
            $cur_row['usedsize'] = $row->usedsize;
            $cur_row['available'] = $row->available;
            $cur_row['mountedon'] = $row->mountedon;
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