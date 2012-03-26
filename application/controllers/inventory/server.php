<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
class Server extends CI_Controller {
	
	private $CI;
	private $siteName;
	private $isadmin;
	private $isviewer;
	
	public function __construct() {
		parent::__construct();	
		$this->CI =& get_Instance();
		$this->siteName = $this->CI->config->item('site_name');
		$this->isadmin = $this->session->userdata('isadmin');
		$this->isviewer = $this->session->userdata('isviewer');
	}

	function Index() {
		
		//if ($this->isadmin || $this->isviewer) {
	  	$data['site_name'] = $this->siteName." - Server List";
			$this->load->view('inventory/server/serv_list_index', $data);
		/*} else {
			$data['heading'] = 'Access Forbidden';
			$data['message'] = 'You have no privilege to access this page';
			$this->load->view('error/error_403', $data);
		}*/
	}
  
  	function getServerList() {
  		$data['type'] = 'list';
    	$data['funcname'] = 'slist';
    	$data['res'] = null;
    	$data['total'] = 0;
			
		//if ($this->isadmin || $this->isviewer) {
	    	$start = $this->input->post('start');
	    	$limit = $this->input->post('limit');
	    	$filters = $this->input->post('filter');
	    	$isFiltered = false;
	    	$sl = "";
	    	$this->load->model('inventory/ServerModel','sm');
	    
	    	if (!empty($filters)) {
	      		$isFiltered = true;
	      		$filters = $this->filterParser($filters);
	    	}
	    
		    if (empty($start) && empty($limit)) {
		    	$sl = ($isFiltered) ? $this->sm->getServerListFiltered($filters) : $this->sm->getServerList();
		    } else if (empty($start)) {
		    	$sl = ($isFiltered) ? $this->sm->getServerListFiltered($filters) : $this->sm->getServerList($limit);
		    } else {
		    	$sl = ($isFiltered) ? $this->sm->getServerListFiltered($filters) : $this->sm->getServerList($start, $limit);
		    }
	    
	    	$data['type'] = 'list';
	    	$data['funcname'] = 'slist';
	    	$data['res'] = $sl->result();
	    	$data['total'] = ($isFiltered) ? $this->sm->getServerCount($filters) : $this->sm->getServerCount();
    	//}
    	$this->load->view('inventory/server/server_res', $data);
	}
	
  function addServer() {
    $data['type'] = 'form';
    $isSuccess = false;
    $data['success'] = $isSuccess;
    $data['msg'] = null;
    if ($this->isadmin) {
	    $rules['servername'] = "require";
	    $rules['serverfunc'] = "require";
	    $rules['servertype'] = "require";
	    $rules['prodip'] = "require";
	    $this->validation->set_rules($rules);
	    
	    $fields['servername'] = "servername";
	    $fields['serverfunc'] = "serverfunc";
	    $fields['servertype'] = "servertype";
	    $fields['prodip'] = "prodip";
	    $this->validation->set_fields($fields);
	    
	    if ($this->validation->run() == true) {
	      $sname = $this->input->post('servername');
	      $sfunction = $this->input->post('serverfunc');
	      $prodip = $this->input->post('prodip');
	      $stype = $this->input->post('servertype');
	      
	      $this->load->model('inventory/ServerModel','sm');
	      if (!$this->sm->getServer($sname, $prodip)) {
	        if ($this->sm->addServer($sname, $sfunction, $stype, $prodip)) {
	          $data['success'] = 'true';
	          $data['msg'] = 'Server successfully added to list';
	        } else {
	          $data['success'] = 'false';
	          $data['msg'] = 'Unknown error. Unable to add new server.<br> Please try again latter';
	        }
	      } else {
	        $data['success'] = 'false';
	        $data['msg'] = 'Server already there. Unable to add new server';
	      }
	      
	    } else {
	      $data['success'] = 'false';
	      $data['msg'] = 'Invalid data, Please try again';
	    }
    } else {
    	$data['success'] = 'false';
      $data['msg'] = 'Insufficient privilege. Please try again';
    } 
    $this->load->view('inventory/server/server_res', $data);
  }
  
  function delServer() {
    $data['type'] = 'form';
    $isSuccess = false;
    $data['success'] = false;
    $data['msg'] = null;
		if ($this->isadmin) {
	    $rules['ids'] = "require";
	    $this->validation->set_rules($rules);
	    $fields['ids'] = "ids";
	    $this->validation->set_fields($fields);
	    if ($this->validation->run() == true) {
	      $this->load->model('inventory/ServerModel', 'som');
	      $ids = $this->input->post('ids');
				$ids = explode(";", $ids);
	      foreach ($ids as $sid) {
	        if ($this->som->getServer($sid) && !empty($sid)) {
		      	$this->load->model('inventory/server/serveripmodel', 'ip');
						$this->ip->delByServerid($sid);
						$this->load->model('inventory/server/servermpmodel', 'mp');
						$this->mp->delByServerid($sid);
						$this->load->model('inventory/server/serverusermodel', 'usr');
						$this->usr->delByServerid($sid);
		        $isSuccess = $this->som->delServer($sid);
		      }
	      }
	        
	      if ($isSuccess) {
	        $data['success'] = 'true';
	        $data['msg'] = 'Server deleted from list';
	      } else {
	        $data['success'] = 'false';
	        $data['msg'] = 'Invalid data, Server not deleted from list';
	      }
	    }
	    else {
	      $data['success'] = 'false';
	      $data['msg'] = 'Invalid data, Please try again';
	    }
    } else {
    	$data['success'] = 'false';
      $data['msg'] = 'Insufficient privilege. Please try again';
    }
    $this->load->view('inventory/server/server_res', $data);
  }
  
	function showServerDetail($sid) {
		if ($this->isadmin) {
			$data['site_name'] = $this->siteName." - Server Detail";
		  $data['serverid'] = $sid;
			$this->load->view('inventory/server_detail', $data);
		}
	}
  
  function getServerDetail($sid) {
  	if ($this->isadmin || $this->isviewer) {
	    $this->load->model('inventory/ServerModel','som');
	    $res = $this->som->getServer($sid,'ServerDetail');
	    $data['type'] = 'sdetail';
	    if ($res) {
	    	$data['success'] = 'true';
				$data['msg'] = 'Form loaded..';
	    	$data['res'] = $res->result();
	    	$data['total'] = $res->num_rows();
			} else {
				$data['success'] = 'false';
				$data['msg'] = 'Data not found..';
				$data['res'] = null;
	    	$data['total'] = 0;
			}
		}
    $this->load->view('inventory/server/server_res', $data);
  }
  
  function submitDetail($sid) {
    $data = array();
    $data['type'] = 'form';
    $data['success'] = false;
    $data['msg'] = null;
    if ($this->isadmin) {
	    $rec = array();
	    $rec['servername'] = $this->input->post('servername');
	    $rec['serverfunction'] = $this->input->post('sfunction');
	    $rec['defaultip'] = $this->input->post('defaultip');
	    $rec['servertype'] = $this->input->post('ostype');
	    $rec['firmwareversion'] = $this->input->post('firmware');
	    $rec['makemodel'] = $this->input->post('makenmodel');
	    $rec['note'] = $this->input->post('note');
	    $rec['osbit'] = $this->input->post('osbit');
	    $rec['osversion'] = $this->input->post('osversion');
	    $rec['rackinfo']  = $this->input->post('rackinfo');
	    $rec['serialnumber']  = $this->input->post('serversn');
	    $rec['location'] = $this->input->post('slocation');
	    $rec['systemowner'] = $this->input->post('sowner');
	    $rec['serverzone'] = $this->input->post('szone');
	    $rec['totalmemory']  = $this->input->post('totmem');
	    
	    $this->load->model('inventory/ServerModel', 'som');
	    if ($this->som->getServer($sid)) {
	      $isSuccess = $this->som->editDetail($sid, $rec);
	      
	      if ($isSuccess) {
	        $data['success'] = 'true';
	        $data['msg'] = 'Detail updated';
	      } else {
	        $data['success'] = 'false';
	        $data['msg'] = 'Invalid data, Detail not updated';
	      }
	    } else {
	      $data['success'] = 'false';
	      $data['msg'] = 'Invalid data, Please try again';
	    }
    } else {
    	$data['success'] = 'false';
      $data['msg'] = 'Insufficient privilege. Please try again';
    }
    $this->load->view('inventory/server/server_res', $data);
  }
  
  private function filterParser($filters) {
      
    $filters = json_decode($filters);
    $where = ' "0" = "0" ';
    $qs = '';
    
    // loop through filters sent by client
    if (is_array($filters)) {
        for ($i=0;$i<count($filters);$i++){
            $filter = $filters[$i];
            
            $field = '';
            
            switch ($filter->field) {
              case 'servertype' : {
                $field = 'text';
                break;
              }
              default : {
                $field = $filter->field;
              }
            }
            
            //$field = $filter->field;
            $value = $filter->value;
            $compare = isset($filter->comparison) ? $filter->comparison : null;
            $filterType = $filter->type;
    
            switch($filterType){
                case 'string' : $qs .= " AND ".$field." LIKE '%".$value."%'"; Break;
                case 'list' :
                    if (strstr($value,',')){
                        $fi = explode(',',$value);
                        for ($q=0;$q<count($fi);$q++){
                            $fi[$q] = "'".$fi[$q]."'";
                        }
                        $value = implode(',',$fi);
                        $qs .= " AND ".$field." IN (".$value.")";
                    }else{
                        $qs .= " AND ".$field." = '".$value."'";
                    }
                Break;
                case 'boolean' : $qs .= " AND ".$field." = ".($value); Break;
                case 'numeric' :
                    switch ($compare) {
                        case 'eq' : $qs .= " AND ".$field." = ".$value; Break;
                        case 'lt' : $qs .= " AND ".$field." < ".$value; Break;
                        case 'gt' : $qs .= " AND ".$field." > ".$value; Break;
                    }
                Break;
                case 'date' :
                    switch ($compare) {
                        case 'eq' : $qs .= " AND ".$field." = '".date('Y-m-d',strtotime($value))."'"; Break;
                        case 'lt' : $qs .= " AND ".$field." < '".date('Y-m-d',strtotime($value))."'"; Break;
                        case 'gt' : $qs .= " AND ".$field." > '".date('Y-m-d',strtotime($value))."'"; Break;
                    }
                Break;
            }
        }
        $where .= $qs;
    }
    
    return $where;
  }
  
	
}

?>