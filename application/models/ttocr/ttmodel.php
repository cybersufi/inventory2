<?php if ( ! defined('APPPATH')) exit('No direct script access allowed');

class Ttmodel extends CI_Model {

	private $tt_table;
	private $tt_database;

	public function __construct() {
		parent::__construct();
		$this->tt_database = $this->load->database('ttocr', true);
		$this->tt_table = 'servicedesk_nts_prd.v_tm_servicecall_v5';
	}

	public function ttCount($wgroup) {
		$tt = $this->tt_table;
    
    	$this->tt_database->select('id' , FALSE)
		->from($tt)
		->where("Id > 11390 and STATUS IN ('In Progress','Pending') 
    			 and (CLASSIFICATION = 'Service Request' or CLASSIFICATION = 'Trouble Ticket' or CLASSIFICATION is null) 
   				 and not (caller_name like 'SIEBEL') 
   				 and (assworkgroup_name like '%".strtoupper($wgroup)."')");	
	    
		return $this->tt_database->count_all_results();
  	}

  	public function getTTList($wgroup) {
    	$tt = $this->tt_table;

		$this->tt_database->select(	'ID, '.	
					    	'ASSWORKGROUP_NAME, '.
					    	'ASSIGNEEPERSON_NAME, '.
					    	'DESCRIPTION, '.
					    	'to_char(ACTUALSTART, \'yyyy/mm/dd hh:mm\') ACTUALSTART, '.
					    	'DEADLINE, '.
					    	'PRIORITY, '.
					    	'STATUS, '.
					    	'CALLER_NAME, '.
					    	'CLASSIFICATION' , FALSE)
    	->from($tt)
    	->where("Id > 11390 and STATUS IN ('In Progress','Pending') 
    			 and (CLASSIFICATION = 'Service Request' or CLASSIFICATION = 'Trouble Ticket' or CLASSIFICATION is null) 
   				 and not (caller_name like 'SIEBEL') 
   				 and (assworkgroup_name like '%".strtoupper($wgroup)."')")
    	->order_by('ACTUALSTART', 'asc');
    
    	$res = $this->tt_database->get();
    		
		if ($res->num_rows() > 0) {
			$coll = new TTCollection();
			foreach ($res->result() as $row) {
				$tt = new TT();

				$tt->setID($row->ID);
				$tt->setWorkgroupName($row->ASSWORKGROUP_NAME);
				$tt->setAssignePersonName($row->ASSIGNEEPERSON_NAME);
				$tt->setDescription($row->DESCRIPTION);
				$tt->setActualStart($row->ACTUALSTART);
				$tt->setDeadline($row->DEADLINE);
				$tt->setPriority($row->PRIORITY);
				$tt->setStatus($row->STATUS);
				$tt->setCallerName($row->CALLER_NAME);
				$tt->setClassification($row->CLASSIFICATION);

				$coll->add($tt);
			}
			return $coll;
		} else {
			return null;
		}
  	}


}

?>