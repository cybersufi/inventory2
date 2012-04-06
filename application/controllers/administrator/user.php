<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Controller {
		
	private $base_url;
	private $sitename;
	private $func_name;
	private $breadcumbs;
	
	private $index;
	private $result;
	
	public function __construct() {
		parent::__construct();
		$this->CI =& get_Instance();
		$this->base_url = $this->CI->config->item('base_url');
		$this->sitename = $this->CI->config->item('site_name');
		$this->func_name = 'User';
		$this->breadcumbs = array();
		
		$this->index = 'administrator/user/user_index';
		$this->result = 'administrator/user/user_result';
		$this->load->library('redux_auth');
		$this->load->model('administrator/user/usermodel','um');
		
	}
	
	public function index() {
		$this->loadExt();
		$this->prepareHeader();
		$this->prepareSecondaryBar();
		$this->prepareSiteNav();
		$this->loadContent();
		$this->template->render();
	}
	
	public function register() {
		$res = $this->redux_auth->check_username($this->input->post('username'));
		if ($res == false) {
			$gid = $this->session->userdata('gid');
			if ($gid == 0) {
				
				$config = array(
					array(
						'field'   => 'username', 
						'label'   => 'Username', 
						'rules'   => 'required'
					), array(
						'field'   => 'password', 
						'label'   => 'Password', 
						'rules'   => 'required'
					),  array(
						'field'   => 'password2', 
						'label'   => 'Repeat Password', 
						'rules'   => 'required'
					), array(
						'field'   => 'question', 
						'label'   => 'Secret Question', 
						'rules'   => 'required'
					), array(
						'field'   => 'answer', 
						'label'   => 'Secret Answer', 
						'rules'   => 'required'
					),
				);
						
				$this->form_validation->set_rules($config);
				
				if ($this->form_validation->run()) {
					$redux = $this->redux_auth->register (
						$this->input->post('username'),
						$this->input->post('password'),
						$this->input->post('email'),
						$this->input->post('question'),
						$this->input->post('answer')
					);
					
					switch($redux) {
						case 'REGISTRATION_SUCCESS' :
						case 'REGISTRATION_SUCCESS_EMAIL' :
							$data['success'] = 'true';
							$data['msg'] = 'User registered';
						break;
						case 'false' :
							$data['success'] = 'false';
							$data['msg'] = 'User Registration failed. Please try again';
						break;
						default :
							$data['success'] = 'false';
							$data['msg'] = 'Unknown Error. Please try again';
						break;
					}
				} else {
					$data['success'] = 'false';
					$data['msg'] = 'Invalid Data. Please try again';
				}
			} else {
				$data['success'] = 'false';
				$data['msg'] = 'You have no privilege to add user.';
			}
		} else {
			$data['success'] = 'false';
			$data['msg'] = 'Username already used.';
		}
		$data['type'] = 'form';
		$this->load->view($this->result, $data);
	}
	
	public function checkCredential() {
		$issiteadmin = $this->session->userdata('issiteadmin');
		if ($issiteadmin) {
			$username = $this->input->post('username');
			$userpass = $this->input->post('password');
			$res = $this->um->getUserCredential($username);
			if ($res) {
				$this->CI->config->load('redux_auth');
				$auth = $this->CI->config->item('auth');
				foreach($auth as $key => $value) {
					$this->$key = $value;
				}
				$pass = sha1(''.$res->hash.$userpass);
				if ($pass === $res->password) {
					$data['success'] = 'true';
					$data['msg'] = 'Credential valid';
				} else {
					$data['success'] = 'false';
					$data['msg'] = 'Username or password not valid;';
				}
			} else {
				$data['success'] = 'false';
				$data['msg'] = 'Credential not valid';
			}
		} else {
			$data['success'] = 'false';
    			$data['msg'] = 'Unsufficient privilege. Please try again';
		}
		$data['type'] = 'form';
		$this->load->view($this->result, $data);
	}
	
	public function deleteUser() {
		$issiteadmin = $this->session->userdata('issiteadmin');
		if ($issiteadmin) {
			
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
				foreach ($ids as $item) {
					$redux = $this->redux_auth->unregister ($item);
	      		}
				
				switch($redux) {
					case 'UNREGISTER_SUCCESS' :
						$data['success'] = 'true';
						$data['msg'] = 'User deleted';
					break;
					case 'UNREGISTER_FAILED' :
						$data['success'] = 'false';
						$data['msg'] = 'Failed to delete user';
					break;
					case 'false' :
						$data['success'] = 'false';
						$data['msg'] = 'Unknown Error. Please try again';
					break;
					default :
						$data['success'] = 'false';
						$data['msg'] = 'Unknown Error. Please try again';
					break;
				}
			} else {
				$data['success'] = 'false';
				$data['msg'] = 'Invalid Data. Please try again';
			}
		} else {
			$data['success'] = 'false';
			$data['msg'] = 'Unsufficient privilege. Please try again';
		}
		$data['type'] = 'form';
		$this->load->view($this->result, $data);
	}
	
	public function changeUserStat() {
		$issiteadmin = $this->session->userdata('issiteadmin');
		if ($issiteadmin) {
			$userid = $this->input->post('userid');
			$curstat = $this->input->post('userstat');
			$userstat = $this->input->post('stat-cmb');
			$banreason = $this->input->post('banreason');
			
			if ($curstat != $userstat) {
				switch($userstat) {
					case "Active" :
						$var = $this->redux_auth->activate($userid);
						if ($var) {
							$data['success'] = 'true';
							$data['msg'] = 'User status changed to active';	
						} else {
							$data['success'] = 'false';
							$data['msg'] = 'Unable to change user status';	
						}
					break;
					case "Inactive" :
						$var = $this->redux_auth->deactivate($userid);
						if ($var) {
							$data['success'] = 'true';
							$data['msg'] = 'User status changed to inactive';	
						} else {
							$data['success'] = 'false';
							$data['msg'] = 'Unable to change user status';	
						}
					break;
					case "Banned" :
						$var = $this->redux_auth->ban($userid,$banreason);
						if ($var) {
							$data['success'] = 'true';
							$data['msg'] = 'User status changed to banned';	
						} else {
							$data['success'] = 'false';
							$data['msg'] = 'Unable to change user status';	
						}
					break;
					case "Unbanned" :
						$var = $this->redux_auth->unban($userid);
						if ($var) {
							$data['success'] = 'true';
							$data['msg'] = 'User status changed to unbanned';	
						} else {
							$data['success'] = 'false';
							$data['msg'] = 'Unable to change user status';	
						}
					break;
					default :
						$data['success'] = 'false';
						$data['msg'] = 'Unsupported user status.';
					break;
				}
			} else {
				$data['success'] = 'false';
				$data['msg'] = 'No change to user status';
			}
		} else {
			$data['success'] = 'false';
			$data['msg'] = 'Unsufficient privilege. Please try again';
		}
		$data['type'] = 'form';
		$this->load->view($this->result, $data);
	}
	
	public function changeUserGroup(){
		$issiteadmin = $this->session->userdata('issiteadmin');
		if ($issiteadmin) {
			$userid = $this->input->post('grp_userid');
			$curgrp = $this->input->post('currusergroup');
			$newgrp = $this->input->post('grp-cmb');
			
			if ( $newgrp != $curgrp ) {
				$this->load->model('GroupModel','gm');
				$res = $this->gm->getGidByName($newgrp);
				$changeGrp = $this->um->changeUserGroup($userid, $res->id);
				if ($changeGrp) {
					$data['success'] = 'true';
					$data['msg'] ='User group changed';
				} else {
					$data['success'] = 'false';
					$data['msg'] ='Unable to change user group';
				}
			} else {
				$data['success'] = 'false';
				$data['msg'] ='No change to user group';
			}
		} else {
			$data['success'] = 'false';
			$data['msg'] ='Unsufficient privilege. Please try again';
		}
		$data['type'] = 'form';
		$this->load->view($this->result, $data);
	}
	
	public function resetUserPass() {
		$issiteadmin = $this->session->userdata('issiteadmin');
		if ($issiteadmin) {
			$username = $this->input->post('pass_username');
			$newpass1 = $this->input->post('password');
			$newpass2 = $this->input->post('password2');
			
			if ($newpass1 == $newpass2 ) {
				$var = $this->redux_auth->reset_password($username, $newpass1);
				if ($var) {
					$data['success'] = 'true';
					$data['msg'] ='User password changed.';
				} else {
					$data['success'] = 'false';
					$data['msg'] ='Unable to reset user password.';
				}
			} else {
				$data['success'] = 'false';
				$data['msg'] ='User password not same.';
			}
		} else {
			$data['success'] = 'false';
			$data['msg'] ='Unsufficient privilege. Please try again';
		}
		$data['type'] = 'form';
		$this->load->view($this->result, $data); 
	}
	
	public function getList() {
		$data['type'] = 'list';
		$data['funcname'] = 'ulist';
    	$data['res'] = null;
    	$data['total'] = 0;
		
		//$issiteadmin = $this->session->userdata('issiteadmin');
		//if ($issiteadmin) {
			$start = $this->input->post('start');
	    	$limit = $this->input->post('limit');
	    	$filters = $this->input->post('filter');
	    	$isFiltered = false;
	    	$sl = "";
	    
		    if (!empty($filters)) {
		      	$isFiltered = true;
		      	$filters = $this->filterParser($filters);
		    }
	    
		    if (empty($start) && empty($limit)) {
		      	$sl = ($isFiltered) ? $this->um->getUserListFiltered($filters) : $this->um->getUserList();
		    } else if (empty($start)) {
		      	$sl = ($isFiltered) ? $this->um->getUserListFiltered($filters) : $this->um->getUserList($limit);
		    } else {
		      	$sl = ($isFiltered) ? $this->um->getUserListFiltered($filters) : $this->um->getUserList($start, $limit);
		    }
			
	    	$data['type'] = 'list';
			$data['funcname'] = 'ulist';
	    	$data['res'] = $sl->result();
	    	$data['total'] = ($isFiltered) ? $this->um->getUserCount($filters) : $this->um->getUserCount();
		//}
    	$this->load->view($this->result, $data);
	}
	
	public function getUserDetail() {
		$this->load->view('user_detail');
	}
	
	public function getLoginHistory() {
		$this->load->view('user_log_hist');
	}
	
	public function getUserGid() {
		$data['type'] = 'form';
		$data['success'] = 'true';
		$data['msg'] = $this->session->userdata('gid');
		$this->load->view($this->result, $data);
	}
	
	public function getLoggedUserList() {
		$data['type'] = 'list';
		$data['funcname'] = 'llist';
    		$data['res'] = null;
    		$data['total'] = 0;
		
		$issiteadmin = $this->session->userdata('issiteadmin');
		if ($issiteadmin) {
			$sl = $this->um->getLoggedUser();
			$res = array();
			if ($sl) {
				foreach ($sl->result() as $row) {
					$userdata = $row->userdata;
					$curr_res = array();
					if (!empty($userdata)) {
						$curr_res['ipaddress'] = $row->ipaddress;
						$curr_res['lastactivity']  = date('d/m/Y H:i', $row->lastactivity);
						$userdata = substr($userdata, 5, -1);
						$userdata = explode(";", $userdata);
						$userid = null;
						for ($i = 0; $i < count($userdata); $i++) {
							if (strstr($userdata[$i], "id")) {
								$j = $i+1;
								$tmp = explode(":", $userdata[$j]);
								$userid = str_replace("\"", '', $tmp[2]);
								$curr_res['userid'] = $userid;
								break;
							}
						}
						
						$user = $this->um->getUser($userid, Usermodel::GET_DETAIL)->result();
						$curr_res['username'] = $user[0]->username;
						$curr_res['usergroup'] = $user[0]->groupname;
						$res[] = $curr_res;
					} else {
						continue;
					}
				}
			}
			//print_r($res);
	    		$data['type'] = 'list';
			$data['funcname'] = 'llist';
	    		$data['res'] = $res;
	    		$data['total'] = count($res);
		}
    		$this->load->view($this->result, $data);
	}
	
	public function getNewUserList() {
		$data['type'] = 'list';
		$data['funcname'] = 'nlist';
    		$data['res'] = null;
    		$data['total'] = 0;
		$issiteadmin = $this->session->userdata('issiteadmin');
		if ($issiteadmin) {
			$sl = $this->um->getNewUser();
	    		$data['type'] = 'list';
			$data['funcname'] = 'nlist';
	    		$data['res'] = $sl->result();
	    		$data['total'] = $sl->num_rows();
		}
    		$this->load->view($this->result, $data);
	}
	
	public function getTopUserLoggedin() {
		$data['type'] = 'list';
		$data['funcname'] = 'tlist';
    		$data['res'] = null;
    		$data['total'] = 0;
		
		$issiteadmin = $this->session->userdata('issiteadmin');
		if ($issiteadmin) {
			$sl = $this->um->getTopUser();
	    		$data['type'] = 'list';
			$data['funcname'] = 'tlist';
	    		$data['res'] = $sl->result();
	    		$data['total'] = $sl->num_rows();
		}
    		$this->load->view($this->result, $data);
	}
	
	public function getUserPrivilege() {
		$data['type'] = 'priv';
		$data['success'] = 'true';
		$data['msg'] = array(
			'issiteadmin' => ($this->session->userdata('issiteadmin') == 1) ? true : false,
			'isadmin' => ($this->session->userdata('isadmin') == 1) ? true : false,
			'isviewer' => ($this->session->userdata('isviewer') == 1) ? true : false);
		$this->load->view($this->result, $data);
	}
	
	public function getUserLoginHistory() {
		$data['type'] = 'list';
		$data['funcname'] = 'hlist';
    		$data['res'] = null;
    		$data['total'] = 0;
		
		$issiteadmin = $this->session->userdata('issiteadmin');
		if ($issiteadmin) {
			$userid = $this->input->post('userid');
			if (!empty($userid)) {
				$sl = $this->um->getLoginHistory($userid);
	    			$data['type'] = 'list';
				$data['funcname'] = 'hlist';
	    			$data['res'] = $sl->result();
	    			$data['total'] = $sl->num_rows();
    			}
		}
    		$this->load->view($this->result, $data);
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
	
	private function loadContent() {
		$data ['page_title'] = $this->func_name;
		$this->template->write_view('content', 'administrator/user/user_list_index', $data, TRUE);
	}
	
	private function loadExt() {
		$this->template->write_view('javascript', 'administrator/user/include', '', TRUE);
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