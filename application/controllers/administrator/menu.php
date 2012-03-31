<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Menu extends CI_Controller {
		
	private $base_url;
	private $sitename;
	private $func_name;
	private $breadcumbs;
	
	public function __construct() {
		parent::__construct();
		$this->CI =& get_Instance();
		$this->base_url = $this->CI->config->item('base_url');
		$this->sitename = $this->CI->config->item('site_name');
		$this->func_name = 'Menu Manager';
		$this->breadcumbs = array();
	}
	
	public function index() {
		$this->loadExt();
		$this->prepareHeader();
		$this->prepareSecondaryBar();
		$this->prepareSiteNav();
		$this->loadContent();
		$this->template->render();
	}
	
	public function showUser() {
		
	}
	
	private function loadContent() {
		$data ['page_title'] = $this->func_name;
		$this->template->write_view('content', 'administrator/menumanager/menulist_index', $data, TRUE);
	}
	
	private function loadExt() {
		$this->template->write_view('javascript', 'administrator/menumanager/include', '', TRUE);
	}
	
	private function prepareHeader() {
		$data ['page_title'] = $this->func_name;
		$this->template->write_view('header', 'administrator/master/header_template', $data, TRUE);
	}
	
	private function prepareSecondaryBar() {
		$this->template->write_view('secondary_bar', 'administrator/master/secondarybar_template', '',TRUE);
	}
	
	private function prepareSiteNav() {
		$this->load->model('administrator/template/sitetemplate', 'site_template');
		$data['links'] = $this->site_template->siteNavigation();
		$this->template->write_view('sidebar', 'administrator/master/sitelink_template', $data, TRUE);
	}
}

?>