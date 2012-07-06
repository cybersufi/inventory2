<?php if ( ! defined('APPPATH')) exit('No direct script access allowed');

class Permissionmodel extends CI_Model {

	private $perm_data = "";
	private $user_perm = "";

	function __construct() {
		parent::__construct();
		$this->perm_data = "acl_perm_data";
		$this->user_perm = "acl_user_perms";
	}

	public function permissionCount($filters=null) {
		$pt = $this->perm_data;
    
    	$this->db->select($pt.'.id')
		->from($pt);
    
    	if ($filters != null) {
      		$this->db->where($filters, NULL, FALSE);
    	}	
	    
		return $this->db->count_all_results();
  	}

  	public function getPermissionList($start=0, $limit=0, $sorter=NULL, $filters=NULL) {
    	$pt = $this->perm_data;
    
    	$this->db->select($pt.'.id, '.
					  $pt.'.permkey, '.
					  $pt.'.permname')
    	->from($pt);
    
	    if ($filters != NULL) {
	      	$this->db->where($filters, NULL, FALSE);
	    }
    	
		if ($sorter != NULL) {
			$this->db->order_by($sorter['property'], $sorter['direction']);
		}
		
	    if ($limit > 0) {
	      	$this->db->limit($limit,$start);
	    }
    
    	$res = $this->db->get();
    		
		if ($res->num_rows() > 0) {
			$coll = new PermissionCollection();
			foreach ($res->result() as $row) {
				$perm = new Permission();
				$perm->setId($row->id);
				$perm->setName($row->permname);
				$perm->SetKey($row->permkey);
				$coll->add($perm);
			}
			return $coll;
		} else {
			return null;
		}
  	}

  	public function addPermission($perm) {
  		$pt = $this->perm_data;
  		$data = array(
			'permkey' => $perm->getKey(),
			'permname' => $perm->getName(),
		);
  		$this->db->insert($pt, $data);
  		return ($this->db->affected_rows() == 1) ? true : false ;
  	}

  	public function getPermissionByName($perm_name) {
  		$pt = $this->perm_data;
    	$filter = array($pt.'.permname' => $perm_name);
    	return $this->getPermission($filter);
  	}

  	public function getPermissionById($perm_id) {
  		$pt = $this->perm_data;
    	$filter = array($pt.'.id' => $perm_id);
    	return $this->getPermission($filter);
  	}

  	public function getPermissionByKey($perm_key) {
  		$pt = $this->perm_data;
    	$filter = array($pt.'.permkey' => $perm_key);
    	return $this->getPermission($filter);
  	}

  	private function getPermission($filter) {
  		$pt = $this->perm_data;
    
    	$this->db->select($pt.'.id, '.
					  $pt.'.permkey, '.
					  $pt.'.permname')
    	->from($pt)
      	->where($filter)
      	->limit(1,0)
      	->get();
    
    	$res = $this->db->get();
    		
		if ($res->num_rows() > 0) {
			$row = $sql->row();
			$perm = new Permission();
			$perm->setId($row->id);
			$perm->setName($row->permname);
			$perm->SetKey($row->permkey);
			return $perm;
		} else {
			return null;
		}
  	}

  	public function deletePermission($permId) {
  		$pt = $this->perm_data;
  	}

}

?>