<?php
	$data['total'] = $total;
	$data['data'] = array();
	
	foreach ($res as $row) {
		$cur_row = array();
		$cur_row['id'] = $row->id;
		$cur_row['servername'] = $row->servername;
		$cur_row['serverfunction'] = $row->serverfunction;
		$cur_row['servertype'] = $row->serveros;
		$cur_row['prodip'] = '0';
    $cur_row['monip'] = '0';
    $cur_row['backip'] = '0';
		array_push($data['data'],$cur_row);
	}
	
	echo json_encode($data);
?>