<?php if ( ! defined('APPPATH')) exit('No direct script access allowed');

class Ocrmodel extends CI_Model {

	private $ocr_table;
	private $ocr_database;

	public function __construct() {
		parent::__construct();
		$this->ocr_database = $this->load->database('ttocr', true);
		$this->ocr_table = 'servicedesk_nts_prd.v_tm_servicecall_v5';
	}

	public function ocrCount($wgroup) {
		$ocr = $this->ocr_table;
    
    	$this->ocr_database->select('id' , FALSE)
		->from($ocr)
		->where("Id > 11390 
				 and STATUS IN ('In Progress','Pending') 
    			 and (CLASSIFICATION = 'OCR')
   				 and (assworkgroup_name like '%".strtoupper($wgroup)."')");
	    
		return $this->ocr_database->count_all_results();
  	}

  	public function getOCRList($wgroup) {
    	$ocr = $this->ocr_table;

		$this->ocr_database->select(	'ID, '.	
					    	'ASSWORKGROUP_NAME, '.
					    	'ASSIGNEEPERSON_NAME, '.
					    	'DESCRIPTION, '.
					    	'to_char(ACTUALSTART, \'yyyy/mm/dd hh:mm\') ACTUALSTART, '.
					    	'to_char(DEADLINE, \'yyyy/mm/dd hh:mm\') DEADLINE, '.
					    	'PRIORITY, '.
					    	'STATUS, '.
					    	'CALLER_NAME, '.
					    	'CLASSIFICATION' , FALSE)
    	->from($ocr)
    	->where("Id > 11390 
    			 and STATUS IN ('In Progress','Pending') 
    			 and (CLASSIFICATION = 'OCR')
   				 and (assworkgroup_name like '%".strtoupper($wgroup)."')")
    	->order_by('ACTUALSTART', 'asc');
    
    	$res = $this->ocr_database->get();
    		
		if ($res->num_rows() > 0) {
			$coll = new OCRCollection();
			foreach ($res->result() as $row) {
				$ocr = new OCR();

				$ocr->setID($row->ID);
				$ocr->setWorkgroupName($row->ASSWORKGROUP_NAME);
				$ocr->setAssignePersonName($row->ASSIGNEEPERSON_NAME);
				$ocr->setDescription($row->DESCRIPTION);
				$ocr->setActualStart($row->ACTUALSTART);
				$ocr->setDeadline($row->DEADLINE);
				$ocr->setPriority($row->PRIORITY);
				$ocr->setStatus($row->STATUS);
				$ocr->setCallerName($row->CALLER_NAME);
				$ocr->setClassification($row->CLASSIFICATION);

				$coll->add($ocr);
			}
			return $coll;
		} else {
			return null;
		}
  	}


}

?>