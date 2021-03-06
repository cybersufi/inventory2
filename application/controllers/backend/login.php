<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {

	private $CI;
	private $sitename;
	private $base_url;

	public function __construct() {
		parent::__construct();
		$this->CI =& get_Instance();
		$this->sitename = $this->CI->config->item('site_name');
		$this->base_url = $this->CI->config->item('base_url');
		$this->load->library('redux_auth');
	}
	
	public function index() {
		$data['site_name'] = $this->sitename;
		$data['username'] = $this->session->userdata('uname');
		$data['lastlogin'] = $this->session->userdata('lastlogin');
		$data['ipaddress'] = $this->session->userdata('ipaddress');
		
		if (!empty($data['username'])) {
			redirect(base_url('administrator/main'), 'refresh');
		}
		else {
			$this->load->view('administrator/login/login_index', $data);
		}
	}
	
	function doLogin() {
		$sess_id = $this->session->userdata('id');
		$data['base_url'] = $this->base_url;
		if (empty($sess_id)) {
			$config = array(
				array(
					'field'   => 'username', 
					'label'   => 'Username', 
					'rules'   => 'required'
				), array(
					'field'   => 'password', 
					'label'   => 'Password', 
					'rules'   => 'required'
				)
			);
			
			$this->form_validation->set_rules($config);
			
			if ($this->form_validation->run()) {
				$redux = $this->redux_auth->login (
					$this->input->post('username'),
					$this->input->post('password')
				);
				
				switch($redux){
					case 'NOT_ACTIVATED': 
						$data['success'] = 'false';
						$data['msg'] = 'Access Denied. Your account is not activated. Please contact the administrator';
						break;
					
					case 'BANNED': 
						$data['success'] = 'false';
						$data['msg'] = 'Access Denied. '.$this->session->flashdata('login');
						break;
					
					case 'false': 
						$data['success'] = 'false';
						$data['msg'] = 'Access Denied. Wrong Username or Password';
						break;
					
					case 'true': 
						$data['success'] = 'true';
						$data['msg'] = 'Access Granted. Welcome "'.strtoupper($this->input->post('username')).'".';
						break;
					
					default: 
						$data['success'] = 'false';
						$data['msg'] = 'Access Denied.';
				}
				$this->session->set_flashdata($data);
				redirect(base_url('administrator/login'), 'location	');
			} else {
				$data['success'] = 'false';
				$data['msg'] = 'Invalid data, Please try again';
				$this->session->set_flashdata($data);
				redirect(base_url('administrator/login'), 'refresh');
			}
		} else {
			redirect(base_url('administrator/main'), 'refresh');
		}
	}
	
	function doLogout() {
		$this->redux_auth->logout();
		$data['site_name'] = $this->sitename;
		redirect(base_url('administrator/login'), 'refresh');
	}
}

?>