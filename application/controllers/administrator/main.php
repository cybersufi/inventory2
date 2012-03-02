<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Main extends CI_Controller {
	private $base_url;
	
	public function __construct() {
		parent::__construct();
		$this->CI =& get_Instance();
		$this->base_url = $this->CI->config->item('base_url');
	}
	
	public function index()
	{
		$data['base_url'] = $this->base_url; 
		$this->load->view('administrator/login/login_index', $data);
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */