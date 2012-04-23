<?php

switch($type) {
  case 'list' : {
    $data['total'] = $total;
    $data['data'] = array();
    if ($res != null) {
      switch($funcname) {
        case 'iplist' : {
          foreach ($res as $row) {
            $cur_row = array();
            $cur_row['nicid'] = $row->id;
            $cur_row['ipaddress'] = $row->ipaddress;
            $cur_row['macaddress'] = $row->macaddress;
            $cur_row['nicname'] = $row->nicname;
            $cur_row['nictype'] = $row->nictype;
            $cur_row['servername'] = $row->servername;
            $cur_row['note'] = $row->note;
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