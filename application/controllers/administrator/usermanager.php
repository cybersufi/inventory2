<?php if ( ! defined('APPPATH')) exit('No direct script access allowed');

class usermanager extends CI_Controller {
	
	private $result = "";
	private $timingStart = "";
	private $user_config = "";
	
	public function __construct() {
		parent::__construct();
		$this->CI =& get_Instance();
		$this->sitename = $this->CI->config->item('site_name');

		$this->config->load('administrator');
		$user_config = $this->config->item('administrator');

		foreach($user_config['usermanager'] as $key => $value)
		{
			$this->user_config->$key = $value;
		}

		$this->load->library('admin');
		$this->load->model('administrator/usermodel', 'um');
		$this->index = 'administrator/user/index';
		$this->result = 'administrator/user/result';
		$this->timingStart = microtime(true);
	}
	
	public function index() {
		//$this->load->view('administrator/main');
		print_r($this->user_config->usermanager['userlist']);
		return null;
	}
	
	public function userList() {
		$data['timingStart'] = $this->timingStart;
		
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
		
		$this->load->model('administrator/usermodel','um');
		$collection = $this->um->getUserList($start, $limit, $sort, $filters);
		
		if ($collection) {
			$data['userdata'] = $collection->getUsers();
		} else {
			$data['userdata'] = array();
		}

		$this->prepareTemplate();
		$this->loadContent('userlist', $data);

		$this->template->render();
	}
	
	public function addUser() {
		$data['timingStart'] = $this->timingStart;
		$username = $this->input->post('username');
		$res = $this->um->checkUserByName($username);
		if ($res == false) {

			$email = $this->input->post('email');
			$groupid = $this->input->post('groupid');
			$userstatus = $this->input->post('userstatus');

			$user = new User();
			$user->setUsername($username);
			$user->setGroupId($groupid);
			$user->setEmail($email);
			$user->setStatus($userstatus);
			$user->getCredential()->setBlankPassword("default");

			$res = $this->um->addUser($user);

			if ($res) {
				$data['status'] = 'ok';
				$data['success'] = true;
				$data['result'] = array();

			} else {
				$e = new UserAddFailedException();
				$data['status'] = 'ok';
				$data['success'] = false;
				$data['result'] = $e->serialize();
			}
		} else {
			$e = new UserAlreadyExistsException($username);
			$data['status'] = 'ok';
			$data['success'] = false;
			$data['result'] = $e->serialize();
		}
		$this->load->view($this->result, $data);
	}

	public function deleteUser() {
		$config = array(
			array (
				'field'   => 'ids', 
				'label'   => 'ids', 
				'rules'   => 'required'
			)
		);
				
		$this->form_validation->set_rules($config);
		
		if ($this->form_validation->run()) {
			$ids = $this->input->post('ids');
			$ids = explode(";", $ids);

	  		try {
				foreach ($ids as $id) {
					$res = $this->um->deleteUserById($id);
		  		}
				
				$data['status'] = 'ok';
				$data['success'] = true;
				$data['result'] = $res;
				
			} catch (SerializableException $e) {
				$data['status'] = 'ok';
				$data['success'] = false;
				$data['result'] = $e->serialize();
				
			}
		} else {
			$e = new InvalidDataException();
			$data['status'] = 'ok';
			$data['success'] = false;
			$data['result'] = $e->serialize();
		}
		$this->load->view($this->result, $data);
	}

	public function changeUserGroup() {
		$data['timingStart'] = $this->timingStart;
		$username = $this->input->post('username');
		$nguid = $this->input->post('nguid');

		
		
	}

	private function sortParser($sorter) {
		$sorter = json_decode($sorter);
		$sort = NULL;
		for ($i=0; $i < count($sorter); $i++) { 
			$sortitem = $sorter[$i];
			switch ($sortitem->property) {
				case 'id':
					$sort['property'] = 'uid';
				break;
				case 'usergroup':
					$sort['property'] = 'groupname';
				break;
				case 'status' :
					$sort['property'] = 'activation_code';
				break;
				default :
					$sort['property'] = $sortitem->property;
			}
			$sort['direction'] = $sortitem->direction;
		}
		return $sort;
	}
	
	private function filterParser($filters) {
		$filters = json_decode($filters);
		$where = ' "0" = "0" ';
		$qs = '';
		
		if (is_array($filters)) {
   			for ($i=0;$i<count($filters);$i++){
            		$filter = $filters[$i]; 
            		$field = '';
  
  				switch ($filter->field) {
    					case 'usergroup' : {
 						$field = 'title';
				      	break;
				    	}
					case 'status' : {
						$field = 'activation_code';
				      	break;
				    	}
    					default : {
      					$field = $filter->field;
    					}
				}
  
  				if ($filter->type == 'boolean') {
					$value = (strstr($filter->value, "yes")) ? 1 : 0;
            		} else {
            			$value = $filter->value;
				}
						
           		$compare = isset($filter->comparison) ? $filter->comparison : null;
            		$filterType = $filter->type;
    
            		switch($filterType){
                		case 'string' : $qs .= " AND ".$field." LIKE '%".$value."%'"; break;
 					case 'list' :
						if (strstr($value,',')){
	    						$fi = explode(',',$value);
						    	for ($q=0;$q<count($fi);$q++) {
						        	$fi[$q] = "'".$fi[$q]."'";
					    		}
    							$value = implode(',',$fi);
   							$qs .= " AND ".$field." IN (".$value.")";
						} else {
    							$qs .= " AND ".$field." = '".$value."'";
					     }
				 	break;
				 	case 'boolean' : $qs .= " AND ".$field." = ".($value); break;
				 	case 'numeric' :
						switch ($compare) {
						    	case 'eq' : $qs .= " AND ".$field." = ".$value; break;
						   	case 'lt' : $qs .= " AND ".$field." < ".$value; break;
						    	case 'gt' : $qs .= " AND ".$field." > ".$value; break;
				     	}
				 	break;
					case 'date' :
						switch ($compare) {
							case 'eq' : $qs .= " AND ".$field." = '".date('Y-m-d',strtotime($value))."'"; break;
							case 'lt' : $qs .= " AND ".$field." < '".date('Y-m-d',strtotime($value))."'"; break;
							case 'gt' : $qs .= " AND ".$field." > '".date('Y-m-d',strtotime($value))."'"; break;
						}
					break;
				}
   			}
   			$where .= $qs;
		}
    
		return $where;
	}

	private function loadContent($func_name, $data) {
		//$data ['userdata'] = array();
		$this->template->write_view('content', $this->user_config->content_file[$func_name], $data, TRUE);
	}
	
	private function prepareTemplate() {
		$this->load->model('administrator/template/sitetemplate', 'site_template');
		$data['links'] = $this->site_template->siteNavigation();
		$data['page_title'] = "bababa";
		$this->template->write_view('header', 'administrator/master/header_template', $data, TRUE);
		$this->template->write_view('secondary_bar', 'administrator/master/secondarybar_template', '',TRUE);
		$this->template->write_view('sidebar', 'administrator/master/sitelink_template', $data, TRUE);
	}
}

?>