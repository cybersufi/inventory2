<?php

class Usermodel extends CI_Model {
	
	private $user_tbl;
	private $group_tbl;
	private $banned_tbl;
	private $session_tbl;
	private $user_history;
	
	const GET_DETAIL = 1;
	const BY_USERNAME = 2;
	
	public function __construct() {
		parent::__construct();
		$this->user_tbl = 'users';
		$this->group_tbl = 'groups';
		$this->banned_tbl = 'banned';
		$this->session_tbl = 'sessions';
		$this->user_history = 'users_history';
	}
	
	public function __call($name, $arguments) {
		switch ($name) {
      		case 'getUserList' :
        		if (count($arguments) == 1) {
					return $this->userList1($arguments[0]);
        		} else if (count($arguments) ==  2) {
          			return $this->userList2($arguments[0], $arguments[1]);
        		} else if (count($arguments) == 3) {
          			return $this->userList3($arguments[0],$arguments[1], $arguments[2]);
        		} else {
          			trigger_error("Method <strong>$name</strong> with argument ". implode (',', $arguments)."doesn't exist", E_USER_ERROR);
        		}
        	break;
      		case 'getUserListFiltered' :
        			if (count($arguments) == 2) {
		          	return $this->userList1($arguments[0], $arguments[1]);
		        	} else if (count($arguments) == 3) {
		          	return $this->userList2($arguments[0],$arguments[1], $arguments[2]);
		        	} else if (count($arguments) == 4) {
		          	return $this->userList3($arguments[0],$arguments[1], $arguments[2], $arguments[3]);
		        	} else {
		          	trigger_error("Method <strong>$name</strong> with argument ". implode (',', $arguments)."doesn't exist", E_USER_ERROR);
		        	}
	        break;
	      	case 'getUserCount' :
		        	if (count($arguments) == 0) {
		          	return $this->userCount1();
		        	} else if (count($arguments) == 1) {
		          	return $this->userCount1($arguments[0]);
		        	} else {
					trigger_error("Method <strong>$name</strong> with argument ". implode (',', $arguments)."doesn't exist", E_USER_ERROR);
		        	}
	        	break;
	      	case 'getUser' :
		        	if (count($arguments) == 1) {
	          		return $this->getUser1($arguments[0]);
		        	} else if (count($arguments) == 2) {
		        		switch($arguments[1]) {
						case UserModel::GET_DETAIL :
							return $this->getUser3($arguments[0]);
						break;
						case UserModel::BY_USERNAME :
							return $this->getUser2($arguments[0]);
						break;
						default :
							trigger_error("Method <strong>$name</strong> with argument ". implode (',', $arguments)."doesn't exist", E_USER_ERROR);
						break;
		        		}
		        	} else {
		          	trigger_error("Method <strong>$name</strong> with argument ". implode (',', $arguments)."doesn't exist", E_USER_ERROR);
		        	}
	        break;
	      	case 'addUser' :
		        	if (count($arguments) == 6) {
		          	return $this->addGroup1($arguments[0], $arguments[1], $arguments[2], $arguments[3], $arguments[4], $arguments[5]);
		        	} else {
		          	trigger_error("Method <strong>$name</strong> with argument ". implode (',', $arguments)."doesn't exist", E_USER_ERROR);
		        	}
	       	break;
	      	case 'delUser' :
		        	if (count($arguments) == 1) {
		          	return $this->delGroup1($arguments[0]);
		        	} else {
		          	trigger_error("Method <strong>$name</strong> with argument ". implode (',', $arguments)."doesn't exist", E_USER_ERROR);
		        	}
			break;
	      	case 'editUser':
		        	if (count($arguments) == 7) {
		          	return $this->editGroup1($arguments[0], $arguments[1], $arguments[2], $arguments[3], $arguments[4], $arguments[5], $arguments[6]);
		        	} else {
		          	trigger_error("Method <strong>$name</strong> with argument ". implode (',', $arguments)."doesn't exist", E_USER_ERROR);
		        	}
	       	break;
			case 'getUserCredential':
				if (count($arguments) == 1) {
					return $this->getUserCredential1($arguments[0]);
				} else {
          			trigger_error("Method <strong>$name</strong> with argument ". implode (',', $arguments)."doesn't exist", E_USER_ERROR);
        			}
			break;
			case 'changeUserGroup':
				if (count($arguments) == 2) {
					return $this->changeUserGroup1($arguments[0], $arguments[1]);
				} else {
          			trigger_error("Method <strong>$name</strong> with argument ". implode (',', $arguments)."doesn't exist", E_USER_ERROR);
        			}
			break;
			case 'getLoggedUser': 
				if (count($arguments) == 0) {
					return $this->getLoggedUser1();
				} else {
          			trigger_error("Method <strong>$name</strong> with argument ". implode (',', $arguments)."doesn't exist", E_USER_ERROR);
        			}
			break;
			case 'getNewUser': 
				if (count($arguments) == 0) {
					return $this->getNewUser1();
				} else {
          			trigger_error("Method <strong>$name</strong> with argument ". implode (',', $arguments)."doesn't exist", E_USER_ERROR);
        			}
			break;
			case 'getTopUser': 
				if (count($arguments) == 0) {
					return $this->getTopUser1();
				} else {
          			trigger_error("Method <strong>$name</strong> with argument ". implode (',', $arguments)."doesn't exist", E_USER_ERROR);
        			}
			break;
			case 'getLoginHistory':
				if (count($arguments) == 1) {
					return $this->getLoginHistory1($arguments[0]);
				} else {
          			trigger_error("Method <strong>$name</strong> with argument ". implode (',', $arguments)."doesn't exist", E_USER_ERROR);
        			}
			break;
      		default:
        			trigger_error("Method <strong>$name</strong> doesn't exist", E_USER_ERROR);
			break;
    		}
	}
	
	private function userCount1($filters=null) {
		$ul = $this->user_tbl;
	    	$gl = $this->group_tbl;
	    
	    	$this->db->select($ul.'.id')
	    			->from($ul)
	    			->join($gl, $gl.'.id = '.$ul.'.group_id','left');
	    
	    	if ($filters != null) {
	      	$this->db->where($filters, NULL, FALSE);
	    	}	
	    
	    	return $this->db->count_all_results();
  	}
  
  	private function userList1($sorter=NULL, $filters=NULL) {    
    		return $this->userList2(0, $sorter, $filters);
  	}
  
  	private function userList2($l, $sorter=NULL, $filters=NULL) {
    		return $this->userList3(0, $l, $sorter, $filters);
  	}
  
  	private function userList3($s, $l, $sorter=NULL, $filters=NULL) {
    	$ul = $this->user_tbl;
		$gl = $this->group_tbl;
		$bl = $this->banned_tbl;
    
    	$this->db->select($ul.'.id as uid, '.
					  $ul.'.username, '.
					  $ul.'.activation_code, '.
					  $ul.'.email, '.
					  $ul.'.lastlogin, '.
					  $ul.'.ipaddress, '.
					  $gl.'.title as groupname, '.
					  $bl.'.reason')
    	->from($ul)
    	->join($gl, $gl.'.id = '.$ul.'.group_id','left')
		->join($bl, $bl.'.id = '.$ul.'.banned_id','left');
    
	    if ($filters != NULL) {
	      	$this->db->where($filters, NULL, FALSE);
	    }
    	
		if ($sorter != NULL) {
			$this->db->order_by($sorter['property'], $sorter['direction']);
		}
		
	    if ($l > 0) {
	      	$this->db->limit($l,$s);
	    }
    
    	$res = $this->db->get();
    
    	return ($res->num_rows() > 0) ? $res : false;
  	}
	
	function getUserCredential1($username) {
		$res = $this->db->select($this->user_tbl.'.password, '.
								 $this->user_tbl.'.hash')
		->from($this->user_tbl)
		->where($this->user_tbl.'.username', $username)
		->limit(1)
		->get();

		return $var = ($res->num_rows() > 0) ? $res->row() : false;
	}
	
	private function getUser1($id) {
    		$ul = $this->user_tbl;
    		$sql = $this->db->select($ul.'.id as uid')
	           	->from($ul)
	           	->where('id',$id)
	           	->limit(1,0)
				->get();
    		return $var = ($sql->num_rows() > 0) ? true : false;
  	}
  
  	private function getUser2($uname) {
    		$ul = $this->user_tbl;
    		$sql = $this->db->select($ul.'.id')
	           	->from($gl)
	           	->where('username', $uname)
	           	->limit(1,0)
	           	->get();
    		return $var = ($sql->num_rows() > 0) ? true : false;
  	}
  
  	private function getUser3($id) {
    		$ul = $this->user_tbl;
		$gl = $this->group_tbl;
		$bl = $this->banned_tbl;

    		$sql = $this->db->select($ul.'.id as uid, '.
							 $ul.'.username, '.
							 $ul.'.email, '.
							 $ul.'.activation_code, '.
							 $gl.'.title as groupname, '.
							 $bl.'.reason')
 		->from($ul)
	 	->join($gl, $gl.'.id = '.$ul.'.group_id','left')
	 	->join($bl, $bl.'.id = '.$ul.'.banned_id','left')
      	->where($ul.'.id',$id)
      	->limit(1,0)
      	->get();
    		return $var = ($sql->num_rows() > 0) ? $sql : false;
  	}
	
	private function getLoggedUser1() {
		$ul = $this->user_tbl;
		$gl = $this->group_tbl;
		$st = $this->session_tbl;

    		$sql = $this->db->select($st.'.ip_address as ipaddress, '.
							 $st.'.last_activity as lastactivity, '.
							 $st.'.user_data as userdata')
 		->from($st)
	 	->get();
    		return $var = ($sql->num_rows() > 0) ? $sql : false;
	}
	
	private function getNewUser1() {
		$ul = $this->user_tbl;

    		$sql = $this->db->select($ul.'.id as userid, '.
	 						$ul.'.username, '.
							$ul.'.email, '.
							$ul.'.activation_code')
 		->from($ul)
		->where($ul.".lastlogin", "0")
	 	->get();
    		return $var = ($sql->num_rows() > 0) ? $sql : false;
	}
	
	private function getTopUser1() {
		$uh = $this->user_history;
		$gl = $this->group_tbl;
		$ul = $this->user_tbl;

    		$sql = $this->db->select($uh.'.userid, '.
							 $ul.'.username, '.
							 $gl.'.title as usergroup, count(*) as total')
 		->from($uh)
		->join($ul, $ul.'.id = '.$uh.'.userid','left')
		->join($gl, $gl.'.id = '.$ul.'.group_id','left')
		->group_by($uh.".userid")
	 	->get();
    		return $var = ($sql->num_rows() > 0) ? $sql : false;
	}
	
	private function getLoginHistory1($userid) {
		$uh = $this->user_history;

    		$sql = $this->db->select($uh.'.datetime, '.
							 $uh.'.ipaddress ')
 		->from($uh)
		->where($uh.".userid", $userid)
		->order_by($uh.".datetime", "DESC")
	 	->get();
    		return $var = ($sql->num_rows() > 0) ? $sql : false;
	}
	
	private function changeUserGroup1($user_id, $group_id) {
		$this->db->where($this->user_tbl.'.id',$user_id)->update($this->user_tbl, array ($this->user_tbl.'.group_id' => $group_id));
		return $var = ($this->db->affected_rows() > 0) ? true : false;
	}
	
	private function runQuery($sql_query){
		$query = $this->db->query($sql_query);
		return $query;
	}
	
}

?>