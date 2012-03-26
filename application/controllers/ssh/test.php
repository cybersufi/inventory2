<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Test extends CI_Controller {

	private $CI;
	private $sitename;
	private $base_url;

	public function __construct() {
		parent::__construct();
		$this->CI =& get_Instance();
		$this->sitename = $this->CI->config->item('site_name');
		$this->base_url = $this->CI->config->item('base_url');
		$this->load->library('ssh');
	}
	
	function index() {
		echo 'index';
	}
	
	function testCon() {
		$this->ssh->setServer('10.9.13.10','root','kamina123');
		$cmd = 'sh ~/get_nic.sh';
		echo $this->ssh->ex($cmd);
	}
}

?>