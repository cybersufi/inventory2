<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

$config = array(
	'permissionmanager/newPermission' => array(
		array(
			'field' => 'perm_name',
			'label' => 'Permission Name',
			'rules' => 'required'
		),
		array(
			'field' => 'perm_key',
			'label' => 'Permission Key',
			'rules' => 'required'
		)
	)
);