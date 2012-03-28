<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Main extends CI_Controller {
		
	private $base_url;
	private $sitename;
	
	public function __construct() {
		parent::__construct();
		$this->CI =& get_Instance();
		$this->base_url = $this->CI->config->item('base_url');
		$this->sitename = $this->CI->config->item('site_name');
	}
	
	public function index()
	{
		//$data['base_url'] = $this->base_url;
		$data['base_url'] = base_url();
		$data['site_name'] = $this->sitename;
		$this->load->view('administrator/main2/main_index', $data);
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */