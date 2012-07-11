<?php if ( ! defined('APPPATH')) exit('No direct script access allowed');

class permissionmanager extends CI_Controller {

	private $timingStart="";
	private $perm_config = "";

	public function __construct() {
		parent::__construct();
		$this->CI =& get_Instance();

		$this->index = 'administrator/permission/index';
		$this->result = 'administrator/result';
		$this->timingStart = microtime(true);
		$this->config->load('administrator');
		$config = $this->config->item('administrator');

		foreach($config['permmanager'] as $key => $value) {
			$this->perm_config->$key = $value;
		}
		print_r($this->perm_config);
		$this->load->library('admin');
	}

	public function index() {
		print_r($this->perm_config->content_file['permlist']);
		return null;
	}

	public function permissionList(){
		//$issiteadmin = $this->session->userdata('issiteadmin');
		//if ($issiteadmin) {
			$message = $this->session->flashdata('message');
			if (!empty($message)) {
				$data['message'] = $this->session->flashdata('message');
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
				$data['permlist'] = $collection->getPermissions();
			} else {
				$data['permlist'] = array();
			}

			$this->prepareTemplate();
			$this->loadContent('permlist', $data);

			$this->template->render();
	}

	public function newPermission() {
		$message = $this->session->flashdata('message');
		if (!empty($message)) {
			$data['message'] = $this->session->flashdata('message');
		}
		
		$perm_name = $this->input->get_post('perm_name');
		$perm_key = $this->input->get_post('perm_key');
		$act = strtolower($this->input->get_post('action'));

		switch ($act) {
			case 'save and new':
				$data['is_new'] = true;
			case 'save':
				$perm = new Permission();
				$perm->setName($perm_name);
				$perm->SetKey($perm_key);
				$this->load->model('administrator/permissionmodel','pm');

				try {
					$res = $this->pm->addPermission($perm);
					if ($res) {
						$alert['type'] = 'success';
						$alert['message'] = 'Permission successfuly added';
						$data['message'] = json_encode($alert);
					}
				} catch (SerializableException $e) {
					$alert['type'] = 'error';
					$alert['message'] = $e->getMessage();
					$data['message'] = json_encode($alert);
				}

			break;
			case 'cancel':
				$data['is_new'] = false;
				$alert['type'] = 'info';
				$alert['message'] = "Adding action canceled. No permission added to database";
				$data['message'] = json_encode($alert);
			break;
			default:
				$data['is_new'] = true;
			break;
		}

		if ($data['is_new']) {
			$this->prepareTemplate();
			$this->loadContent('permform', $data);
			$this->template->render();
		} else {
			if ($data['message']) {
				$this->session->set_flashdata('message', $data['message']);
			}
			redirect(base_url('administrator/permissionmanager/permissionlist'), 'location', 301);
		}
	}

	public function editPermission($permId) {
		$this->output->enable_profiler(TRUE);
		$this->load->model('administrator/permissionmodel', 'pm');
		$data['is_edit'] =  true;
		try {
			$perm = $this->pm->getPermissionById($permId);
			$data['perm'] = $perm;
			echo 'baka<br>';
		} catch (SerializableException $e) {
			$this->session->set_flashdata('message', $e->getMessage());
			redirect(base_url('administrator/permissionmanager/permissionlist'), 'location', 301);
		}

		$act = strtolower($this->input->get_post('action'));
		echo "biki<br>";
		switch ($act) {
			case 'save and exit':
				$data['is_edit'] = false;
			case 'save':

				$perm_name = $this->input->get_post('perm_name');
				$perm_key = $this->input->get_post('perm_key');
				echo $perm_name."<br>";
				echo $perm_key."<br>";
				print_r($perm);
				echo "buku<br>";
				if ((strcmp($perm->getName(), $perm_name) != 0) || (strcmp($perm->getKey(), $perm_key) != 0)) {
					echo "beke<br>";
					$p = new Permission($perm->getId(), $perm_name, $perm_key);
					print_r($p);
					echo "boko<br>";
					$this->load->model('administrator/permissionmodel','pm');

					try {
						$res = $this->pm->updatePermission($p);
						if ($res) {
							$alert['type'] = 'success';
							$alert['message'] = 'Permission successfuly updated';
							$data['message'] = json_encode($alert);
							$data['perm'] = $p;
						}
					} catch (SerializableException $e) {
						$data['message'] = $e->getMessage();
					}
				} else {
					echo "acho<br>";
					$alert['type'] = 'info';
					$alert['message'] = 'Permission not updated. Nothing to change.';
					$data['message'] = json_encode($alert);
				}
			break;
			case 'exit':
				$data['is_edit'] = false;
			break;
			default:
				$data['is_edit'] = true;
			break;
		}

		echo "achi<br>";
		if ($data['is_edit']) {
			echo "achu<br>";
			if (isset($data['message'])) {
				$data['message'] = json_decode($data['message']);
			}
			echo "baba<br>";
			$this->prepareTemplate();
			echo "bibi<br>";
			$this->loadContent('permform', $data);
			echo "bubu<br>";
			$this->template->render();
			echo "ache<br>";
		} else {
			if ($data['message']) {
				$this->session->set_flashdata('message', $data['message']);
			}
			redirect(base_url('administrator/permissionmanager/permissionlist'), 'location', 301);
		}


	}

	public function deletePermission($permId) {
		$this->load->model('administrator/permissionmodel','pm');
		$res = $this->pm->deletePermission($permId);
		if ($res) {
			$data['message'] = 'Permission successfuly deleted';
		} else {
			$data['message'] = 'Unable to delete permission. Please try again latter';
		}

		if ($data['message']) {
			$this->session->set_flashdata('message', $data['message']);
		}
		redirect(base_url('administrator/permissionmanager/permissionlist'), 'location', 301);
	}

	private function loadContent($func_name, $data) {
		//$data ['userdata'] = array();
		$this->template->write_view('content', $this->perm_config->content_file[$func_name], $data, TRUE);
	}
	
	private function prepareTemplate() {
		$this->load->model('administrator/template/sitetemplate', 'site_template');
		$data['links'] = $this->site_template->siteNavigation();
		$data['page_title'] = "";
		$this->template->write_view('header', 'administrator/master/header_template', $data, TRUE);
		$this->template->write_view('secondary_bar', 'administrator/master/secondarybar_template', '',TRUE);
		$this->template->write_view('sidebar', 'administrator/master/sitelink_template', $data, TRUE);
	}

}

?>