<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class SiteTemplate extends CI_Model {
	
	private $CI;
	private $base_url;
  	
  	function __construct() {
    	parent::__construct();
		$this->CI =& get_instance();
		$this->base_url = $this->CI->config->item('base_url');
  	}
	
	public function siteNavigation() {
		$res = array();
				
		$res[] = array(
			'text' => 'TT Manager',	
			'links' => array (
				array (
					'text' => 'Show All TT',
					'link' => base_url('ttocr/ttmanager/ttlist/wgroup/all'),
					'icon_cls' => 'icn_categories',
				),
				array (
					'text' => 'Show TT for UNIX',
					'link' => base_url('ttocr/ttmanager/ttlist/wgroup/unix'),
					'icon_cls' => 'icn_categories',
				),
				array (
					'text' => 'Show TT for Database',
					'link' => base_url('ttocr/ttmanager/ttlist/wgroup/database'),
					'icon_cls' => 'icn_categories',
				),
				array (
					'text' => 'Show TT for Backup',
					'link' => base_url('ttocr/ttmanager/ttlist/wgroup/backup'),
					'icon_cls' => 'icn_categories',
				),
			)
		);
		
		$res[] = array(
			'text' => 'OCR Manager',
			'links' => array (
				array (
					'text' => 'Show All OCR',
					'link' => base_url('ttocr/ocrmanager/ocrlist/wgroup/all'),
					'icon_cls' => 'icn_view_users',
				),
				array (
					'text' => 'Show OCR for UNIX',
					'link' => base_url('ttocr/ocrmanager/ocrlist/wgroup/unix'),
					'icon_cls' => 'icn_view_users',
				),
				array (
					'text' => 'Show OCR for Database',
					'link' => base_url('ttocr/ocrmanager/ocrlist/wgroup/database'),
					'icon_cls' => 'icn_view_users',
				),
				array (
					'text' => 'Show OCR for Backup',
					'link' => base_url('ttocr/ocrmanager/ocrlist/wgroup/backup'),
					'icon_cls' => 'icn_view_users',
				),
			)
		);
		
		return $res;
	}
}	
?>