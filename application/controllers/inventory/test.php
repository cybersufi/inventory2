<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Test extends CI_Controller {
	
	public function __construct() {
		parent::__construct();	
		$this->CI =& get_Instance();
		$this->load->library('inventory');
		$this->load->model('inventory/osmodel', 'osmodel');
	}

	function Index() {
		
		$server = $this->osmodel->loadByName('ca22codp');
		echo json_encode($server->toArray());
	}
	
}

?>