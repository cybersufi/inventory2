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

	public function menu$message = $this->session->flashdata('message');
		if (!empty($message)) {
			$data['message'] = $this->session->flashdata('message');
			$data['message'] = json_decode($data['message']);
		}

		$start = $this->input->get_post('start');
    	$limit = $this->input->get_post('limit');
    	$filters = $this->input->get_post('filter');
		$sort = $this->input->get_post('sort');
    	$isFiltered = false;
		$isSorted = false;
    	$collection = "";
    	
	    if (!empty($filters)) {
	      	$isFiltered = true;
	      	$filters = $this->filterParser($filters);
	    }
		
		if (!empty($sort)) {
			$isSorted = true;
			$sort = $this->sortParser($sort);
		} else {
			$sort = NULL;
		}
    	
		$start = empty($start) ? 0 : $start;
		$limit = empty($limit) ? 0 : $limit;
		$filters = ($isFiltered) ? $filters : NULL;
		$sort = ($isSorted) ? $sort : NULL;
		
		$this->load->model('administrator/permissionmodel','pm');
		$collection = $this->pm->getPermissionList($start, $limit, $sort, $filters);
		
		if ($collection) {
			$data['menulist'] = $collection->getPermissions();
		} else {
			$data['menulist'] = array();
		}

		$this->prepareTemplate();
		$this->loadContent('menulist', $data);
		$this->template->render();
	}

	private function loadContent($func_name, $data) {
		$this->template->write_view('content', $this->link_config->content_file[$func_name], $data, TRUE);
	}
	
	private function prepareTemplate() {
		$this->load->model('administrator/template/sitetemplate', 'site_template');
		$data['links'] = $this->site_template->siteNavigation();
		$data['page_title'] = $this->link_config->page_title;
		$this->template->write_view('header', 'administrator/master/header_template', $data, TRUE);
		$this->template->write_view('secondary_bar', 'administrator/master/secondarybar_template', '',TRUE);
		$this->template->write_view('sidebar', 'administrator/master/sitelink_template', $data, TRUE);
	}
}

?>