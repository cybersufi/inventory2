<?php if ( ! defined('APPPATH')) exit('No direct script access allowed');

class ocrmanager extends CI_Controller {

	private $timingStart="";
	private $page_config = "";

	public function __construct() {
		parent::__construct();
		$this->CI =& get_Instance();

		$this->timingStart = microtime(true);
		$this->config->load('app');
		$config = $this->config->item('ttocr');

		foreach($config['global'] as $key => $value) {
			$this->page_config->$key = $value;
		}

		foreach($config['ocrmanager'] as $key => $value) {
			$this->page_config->$key = $value;
		}

		foreach($config['template'] as $key => $value) {
			$this->page_config->$key = $value;
		}

		$this->load->library('ttocr');
		$this->template->set_template('ttocr');
	}

	public function index() {
		//print_r($this->page_config->content_file['permlist']);
		echo 'baka';
		return null;
	}

	public function ocrlist() {

		$this->output->enable_profiler(false);

		$message = $this->session->flashdata('message');

		if (!empty($message)) {
			$data['message'] = $this->session->flashdata('message');
			$data['message'] = json_decode($data['message']);
		}

		$params = $this->parameterParser();

		if ($params['wgroup'] == null) {
			$params['wgroup'] = 'all';
		}

		$this->load->model('ttocr/ocrmodel','om');

		if ($params['wgroup'] == 'all') {
			foreach ($this->page_config->workgroup as $group) {
				$data['wgroup'][$group]['name'] = $group;
				$data['wgroup'][$group]['data'] = $this->om->getOCRList($group);
				$data['wgroup'][$group]['total'] = $this->om->ocrCount($group);
			}
		} else {
			if (in_array($params['wgroup'], $this->page_config->workgroup)) {
				$data['wgroup'][$params['wgroup']]['name'] = $params['wgroup'];
				$data['wgroup'][$params['wgroup']]['data'] = $this->om->getOCRList($params['wgroup']);
				$data['wgroup'][$params['wgroup']]['total'] = $this->om->ocrCount($params['wgroup']);
			} else {
				$data['wgroup'] = null;
			}
		}

		$this->prepareTemplate('ocrlist', $data);

		$this->template->render();
	}

	private function parameterParser() {
		$default = array('wgroup');
		$params = $this->uri->uri_to_assoc(4, $default);
		return $params;
	}

	private function prepareTemplate($func_name, $data) {
		$this->load->model('ttocr/template/sitetemplate', 'site_template');
		$data['links'] = $this->site_template->siteNavigation();
		$data['page_title'] = $this->page_config->page_title;
		$this->template->write_view('javascript', $this->page_config->include_file[$func_name], '', TRUE);
		$this->template->write_view('header', $this->page_config->header, $data, TRUE);
		$this->template->write_view('secondary_bar', $this->page_config->secondary_bar, '',TRUE);
		$this->template->write_view('sidebar', $this->page_config->sidebar, $data, TRUE);
		$this->template->write_view('content', $this->page_config->content_file[$func_name], $data, TRUE);
	}

}

?>