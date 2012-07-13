<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Menumodel extends CI_Model {
	
	private $menu_data = "";

	public function __construct() {
		parent::__construct();
		$this->menu_data = "acl_menu_data";
	}

	public function menuCount($filters=null) {
		$md = $this->menu_data;

		$this->db->select($md,'.id')
		->from($md);

		if ($filters != null) {
			$this->db->where($filters, NULL, FALSE);
		}

		return $this->db->count_all_result();
	}

	public function getMenuList($start=0, $limit=0, $sorter=null, $filter=null) {
		$md = $this->menu_data;

		$this->db->select($md.'.menuid, '.
						  $md.'.menuname, '.
						  $md.'.menualias, '.
						  $md.'.parent')
		->from($md);

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
			$coll = new MenuCollection();
			foreach ($res->result() as $row) {
				$menu = new Menu($row->id, $row->menuname, $row->menulink, $row->parent);
				$coll->add($menu);
			}
			return $coll;
		} else {
			return null;
		}

	}
}

?>