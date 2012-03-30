<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Controller {
		
	private $base_url;
	private $sitename;
	private $func_name;
	private $breadcumbs;
	
	public function __construct() {
		parent::__construct();
		$this->CI =& get_Instance();
		$this->base_url = $this->CI->config->item('base_url');
		$this->sitename = $this->CI->config->item('site_name');
		$this->func_name = 'User';
		$this->breadcumbs = array();
	}
	
	public function index()
	{
		//$data['base_url'] = $this->base_url;
		//$data['base_url'] = base_url();
		//$data['site_name'] = $this->sitename;
		//$this->load->view('administrator/main2/main_index', $data);
		$this->prepareHeader();
		$this->prepareSecondaryBar();
		$this->prepareSiteNav();
		$this->loadContent();
		$this->template->render();
	}
	
	private function loadContent() {
		$data ['page_title'] = $this->func_name;
		$this->template->write_view('content', 'administrator/user/user_list', $data, TRUE);
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