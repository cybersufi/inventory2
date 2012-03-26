<?php

switch($type) {
  case 'list' : {
    $data['total'] = $total;
    $data['data'] = array();
    if ($res != null) {
      switch($funcname) {
        case 'slist' : {
          foreach ($res as $row) {
            $cur_row = array();
            $cur_row['id'] = $row->id;
            $cur_row['servername'] = $row->servername;
            $cur_row['serverfunc'] = $row->serverfunction;
            $cur_row['servertype'] = $row->serveros;
            $cur_row['defaultip'] = $row->defaultip;
            array_push($data['data'], $cur_row);
          }
          break;
        }
      }
    }
    break;
  }
  case 'sdetail': {
  	$data['success'] = $success;
		$data['msg'] = $msg;
    $data['total'] = $total;
    $data['data'] = array();
    foreach ($res as $row) {
      $cur_row = array();
      $cur_row['servername'] = $row->servername;
      $cur_row['sfunction'] = $row->serverfunction;
      $cur_row['ostype'] = $row->servertype;
      $cur_row['uptime'] = 0;
      $cur_row['osversion'] = $row->osversion;
      $cur_row['firmware'] = $row->firmwareversion;
      $cur_row['osbit'] = $row->osbit;
      $cur_row['totmem'] = $row->totalmemory;
      $cur_row['serversn'] = $row->serialnumber;
      $cur_row['makenmodel'] = $row->makemodel;
      $cur_row['szone'] = $row->serverzone;
      $cur_row['sowner'] = $row->systemowner;
      $cur_row['slocation'] = $row->location;
      $cur_row['rackinfo'] = $row->rackinfo;
      $cur_row['note'] = $row->note;
      $cur_row['defaultip'] = $row->defaultip;
      array_push($data['data'], $cur_row);
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