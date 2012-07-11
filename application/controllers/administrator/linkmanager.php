<?php if ( ! defined('APPPATH')) exit('No direct script access allowed');

class linkmanager extends CI_Controller {

	private $link_config = "";

	public function __construct() {
		parent::__construct();
		$this->CI =& get_Instance();

		$this->index = 'administrator/link/index';
		$this->result = 'administrator/result';
		$this->timingStart = microtime(true);
		$this->config->load('administrator');
		$config = $this->config->item('administrator');

		foreach($config['linkmanager'] as $key => $value) {
			$this->link_config->$key = $value;
		}

		$this->load->library('admin');
	}

}

?>