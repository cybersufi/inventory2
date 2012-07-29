<?php  if (!defined('APPPATH')) exit('No direct script access allowed');

	function __autoload($class_name) {
	    //$class_name = str_replace('-', '', $class_name);
	    $rdir = APPPATH.'/libraries/backend/';
	    $dirs = array('Include/','Include/Exception/',  
	    			  'Include/User/', 'Include/User/Exception/', 
	                  'Include/Permission/', 'Include/Permission/Exception/',
	                  'Include/Menu/', 'Include/Menu/Exception/',
	                  'Include/Role/');
	    
	    foreach ($dirs as $dir) {
	        if (file_exists($rdir.$dir.$class_name.'.php')) {
	            include_once $rdir.$dir.$class_name.'.php';
	            return;
	        }
	    }
	}


	class Backends {
		function __construct() {
			return null;
		}
	}
	
?>
