<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends CI_Controller {
	
	private $page_config = "";

	public function __construct() {
		parent::__construct();

		$this->CI =& get_Instance();
		
		$this->config->load('backend');
		$config = $this->config->item('backend');

		foreach($config['dashboard'] as $key => $value) {
			$this->page_config->$key = $value;
		}
	}
	
	public function index()
	{
		$data = array();
		$this->prepareTemplate(null, $data);
		$this->template->render();
	}
	
	private function prepareTemplate($func_name=null, $data=null) {
		$this->load->model('backend/template/sitetemplate', 'site_template');
		$data['links'] = $this->site_template->siteNavigation();
		$data['page_title'] = $this->page_config->page_title;
		$this->template->write_view('header', 'administrator/master/header_template', $data, TRUE);
		$this->template->write_view('secondary_bar', 'administrator/master/secondarybar_template', '',TRUE);
		$this->template->write_view('sidebar', 'administrator/master/sitelink_template', $data, TRUE);
		if ($func_name != null) {
			$this->template->write_view('content', $this->page_config->content_file[$func_name], $data, TRUE);
		}
	}
}

?>