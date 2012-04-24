<?php if ( ! defined('APPPATH')) exit('No direct script access allowed'); 

	$data = array (
		'success' => $success,
		'msg' => $msg
	);
	
	//$this->session->set_userdata($data);
	//$this->session->keep_flashdata('success');
	//$this->session->keep_flashdata('msg');
	redirect(base_url('administrator/login'), 'location', 301);

?>
