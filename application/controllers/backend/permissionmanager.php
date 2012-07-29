<?php if ( ! defined('APPPATH')) exit('No direct script access allowed');

class permissionmanager extends CI_Controller {

	private $timingStart="";
	private $page_config = "";

	public function __construct() {
		parent::__construct();
		$this->CI =& get_Instance();

		$this->index = 'administrator/permission/index';
		$this->result = 'administrator/result';
		$this->timingStart = microtime(true);
		$this->config->load('app');
		$config = $this->config->item('backend');

		foreach($config['permmanager'] as $key => $value) {
			$this->page_config->$key = $value;
		}

		$this->load->library('admin');
	}

	public function index() {
		print_r($this->page_config->content_file['permlist']);
		return null;
	}

	public function permissionList(){
		//$issiteadmin = $this->session->userdata('issiteadmin');
		//if ($issiteadmin) {
			$limit = 50;
			$start = 0;
			$isFiltered = false;
			$isSorted = false;
			$sort = null;
			
			$this->load->model('administrator/permissionmodel','pm');

			$data['nav'] = array();
			$data['url'] = base_url('backend/permissionmanager/permissionlist/');
			$data['sorter'] = array('permname' => 'asc', 'permkey' => 'asc');

			$message = $this->session->flashdata('message');

			if (!empty($message)) {
				$data['message'] = $this->session->flashdata('message');
				$data['message'] = json_decode($data['message']);
			}

			$params = $this->parameterParser();

			$sort = $this->sortParser($params['sort']);

			if ($sort != null) {
				$data['sorter'][$sort['property']] = ($sort['direction'] == 'asc') ? 'desc' : 'asc';
			}

			$filters = $this->filterParser($params['filters']);

		    if ($filters != null) {
		      	$filters = $this->filterParser($filters);
		    }

		    if ($params['page'] != null) {
		    	$ps = ($params['page'] <= 1) ? 0 : ($params['page'] - 1);
		    	$start = $ps * $limit;
		    } 

			$collection = $this->pm->getPermissionList($start, $limit, $sort, $filters);
			$total = $this->pm->permissionCount($filters);
			
			$data['nav'] = $this->createLink($data, $sort, $filters, $start, $limit, $total);

			if ($collection) {
				$data['permlist'] = $collection->getPermissions();
			} else {
				$data['permlist'] = array();
			}

			$this->prepareTemplate('permlist', $data);

			$this->template->render();
	}

	public function newPermission() {
		$this->output->enable_profiler(TRUE);
		$message = $this->session->flashdata('message');
		if (!empty($message)) {
			$data['message'] = $this->session->flashdata('message');
			$data['message'] = json_decode($data['message']);
		}
		
		$act = strtolower($this->input->get_post('action'));

		switch ($act) {
			case 'save and new':
				$data['is_new'] = true;
			case 'save':

				$perm_name = $this->input->get_post('perm_name');
				$perm_key = $this->input->get_post('perm_key');

				$perm = new Permission(null, $perm_name, $perm_key);

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
					$data['perm'] = $perm;
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
			if (isset($data['message'])) {
				$data['message'] = json_decode($data['message']);
			}
			$this->prepareTemplate('permform', $data);
			$this->template->render();
		} else {
			if ($data['message']) {
				$this->session->set_flashdata('message', $data['message']);
			}
			redirect(base_url('administrator/permissionmanager/permissionlist'), 'location', 301);
		}
	}

	public function editPermission($permId) {
		$this->load->model('administrator/permissionmodel', 'pm');
		$data['is_edit'] =  true;
		try {
			$perm = $this->pm->getPermissionById($permId);
			$data['perm'] = $perm;
		} catch (SerializableException $e) {
			$this->session->set_flashdata('message', $e->getMessage());
			redirect(base_url('administrator/permissionmanager/permissionlist'), 'location', 301);
		}

		$act = strtolower($this->input->get_post('action'));
		switch ($act) {
			case 'save and exit':
				$data['is_edit'] = false;
			case 'save':

				$perm_name = $this->input->get_post('perm_name');
				$perm_key = $this->input->get_post('perm_key');
				if ((strcmp($perm->getName(), $perm_name) != 0) || (strcmp($perm->getKey(), $perm_key) != 0)) {
					$p = new Permission($perm->getId(), $perm_name, $perm_key);
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
						$alert['type'] = 'error';
						$alert['message'] = $e->getMessage();
						$data['message'] = json_encode($alert);
					}
				} else {
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

		if ($data['is_edit']) {
			if (isset($data['message'])) {
				$data['message'] = json_decode($data['message']);
			}
			$this->prepareTemplate('permform', $data);
			$this->template->render();
		} else {
			if ($data['message']) {
				$this->session->set_flashdata('message', $data['message']);
			}
			redirect(base_url('administrator/permissionmanager/permissionlist'), 'location', 301);
		}


	}

	public function deletePermission($permId) {
		$is_delete = false;
		$data['is_batch'] = false;
		$coll = new PermissionCollection();
		$this->load->model('administrator/permissionmodel','pm');

		if (strlen($permId) > 0) {

			$data['is_batch'] = (strcmp($permId, "batch") == 0) ? true : false;

			if ($data['is_batch'] == true) {
				$ids = $this->input->get_post('ids');
				if (!empty($ids)) {
					foreach ($ids as $id) {
						$p = $this->pm->getPermissionById($id);
						if ($p) {
							$coll->add($p);
						}
					}
				}
			}
			

			$act = strtolower($this->input->get_post('action'));

			switch ($act) {
				case 'yes':

					if ($data['is_batch'] == true) {
						foreach ($ids as $id) {
							try {
								$res = $this->pm->deletePermission($id);
								if ($res) {
									$alert['type'] = 'success';
									$alert['message'] = 'Permissions successfuly deleted';
									$data['message'] = json_encode($alert);
								}
							} catch (SerializableException $e) {
								$alert['type'] = 'error';
								$alert['message'] = $e->getMessage();
								$data['message'] = json_encode($alert);
							}
						}
					} else {
						try {
							$res = $this->pm->deletePermission($permId);
							if ($res) {
								$alert['type'] = 'success';
								$alert['message'] = 'Permission successfuly deleted';
								$data['message'] = json_encode($alert);
							}
						} catch (SerializableException $e) {
							$alert['type'] = 'error';
							$alert['message'] = $e->getMessage();
							$data['message'] = json_encode($alert);
						}
					}
					$is_delete = false;
					break;
				case 'no':
					$is_delete = false;
					break;
				default:
					$is_delete = true;

					if ($data['is_batch'] == true) {
						if (!empty($ids)) {
							$data['permilist'] = $coll;
						} else {
							$is_delete = false;
						}
					} else {
						try {
							$perm = $this->pm->getPermissionById($permId);
							if ($perm) {
								$data['perm'] = $perm;
							}					
						} catch (SerializableException $e) {
							$alert['type'] = 'error';
							$alert['message'] = $e->getMessage();
							$data['message'] = json_encode($alert);
							$is_delete = false;
						}
					}
					break;
			}
		}

		if ($is_delete) {
			if (isset($data['message'])) {
				$data['message'] = json_decode($data['message']);
			}
			$this->prepareTemplate('permconfirm', $data);
			$this->template->render();
		} else {
			if ($data['message']) {
				$this->session->set_flashdata('message', $data['message']);
			}
			redirect(base_url('administrator/permissionmanager/permissionlist'), 'location', 301);
		}
	}

	private function parameterParser() {
		$default = array('act','page','sort','filters');
		$params = $this->uri->uri_to_assoc(4, $default);
		return $params;
	}

	private function sortParser($sort) {
		if ($sort != null) {
			$sort = explode(':', $sort);
			$param  = array('property' => $sort[0], 'direction' => $sort[1]);
			return $param;
		} else {
			return null;
		}
		
	}
	
	private function filterParser($filters) {
   		return null;
	}

	private function createLink($data, $sort=null, $filters=null, $start=0, $limit=0, $total_record=0) {

		$sortLink = ($sort != null) ? 'sort/'.$sort['property'].':'.$sort['direction'].'/' : '';
		$filterLink = ($filters != null) ? 'filters/'.json_encode($filters).'/' : '';


		$pages = ceil(($total_record / $limit));
		$total_pages = ($pages == 0) ? 1 : $pages;
		$curr_page = ($start/$limit) + 1;

		$prev = ($curr_page <= 1) ? 0 : ($curr_page - 1);
		$next = (($pages > 1) && ($curr_page <= $pages)) ? ($curr_page + 1) : 0;
		$first = ($pages > 1) ? 1 : 0;
		$last = ($pages > 1) ? $pages : 0;

		$nav['total_pages'] = $total_pages;
		$nav['curr_page'] = "$curr_page";
		$nav['prev'] = ($prev != 0) ? $data['url'].'page/'.$prev.'/'.$sortLink.$filterLink : '';
		$nav['next'] = ($next != 0) ? $data['url'].'page/'.$next.'/'.$sortLink.$filterLink : '';
		$nav['first'] = ($first != 0) ? $data['url'].'page/'.$first.'/'.$sortLink.$filterLink : '';
		$nav['last'] = ($last != 0) ? $data['url'].'page/'.$last.'/'.$sortLink.$filterLink : '';

		$navLink = 'page/'.$curr_page.'/';

		$sortParam = 'permname:'.$data['sorter']['permname'];
		$nav['permname'] = $data['url'].'sort/'.$sortParam.'/'.$filterLink;

		$sortParam = 'permkey:'.$data['sorter']['permkey'];
		$nav['permkey'] = $data['url'].'sort/'.$sortParam.'/'.$filterLink;

		return $nav;
	}

	private function prepareTemplate($func_name, $data) {
		$this->load->model('backend/template/sitetemplate', 'site_template');
		$data['links'] = $this->site_template->siteNavigation();
		$data['page_title'] = $this->page_config->page_title;
		$this->template->write_view('javascript', $this->page_config->include_file[$func_name], '', TRUE);
		$this->template->write_view('header', 'backend/master/header_template', $data, TRUE);
		$this->template->write_view('secondary_bar', 'backend/master/secondarybar_template', '',TRUE);
		$this->template->write_view('sidebar', 'backend/master/sitelink_template', $data, TRUE);
		$this->template->write_view('content', $this->page_config->content_file[$func_name], $data, TRUE);
	}

}

?>