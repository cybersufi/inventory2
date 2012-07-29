<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

	$modul_name[0] = 'backend';
	
	$config[$modul_name[0]]['dashboard']['page_title'] = "Dashboard";

	$config[$modul_name[0]]['usermanager']['page_title'] = "Permission Manager";
	$config[$modul_name[0]]['usermanager']['content_file']['userlist'] = 'administrator/user/user_list';

	$config[$modul_name[0]]['permmanager']['page_title'] = "Permission Manager";
	$config[$modul_name[0]]['permmanager']['content_file']['permlist'] = 'backend/permission/perm_list';
	$config[$modul_name[0]]['permmanager']['include_file']['permlist'] = 'backend/permission/perm_list_inc';
	$config[$modul_name[0]]['permmanager']['content_file']['permform'] = 'backend/permission/perm_form';
	$config[$modul_name[0]]['permmanager']['include_file']['permform'] = 'backend/permission/perm_form_inc';
	$config[$modul_name[0]]['permmanager']['content_file']['permconfirm'] = 'administrator/permission/perm_confirm';

	$config[$modul_name[0]]['menumanager']['page_title'] = "Menu Manager";
	$config[$modul_name[0]]['menumanager']['content_file']['menulist'] = 'administrator/menu/menu_list';
	$config[$modul_name[0]]['menumanager']['content_file']['menuform'] = 'administrator/menu/menu_form';


	$modul_name[1] = 'ttocr';

	$config[$modul_name[1]]['global']['workgroup'] = array ('backup','database','unix');

	$config[$modul_name[1]]['template']['header'] = 'ttocr/master/header_template';
	$config[$modul_name[1]]['template']['secondary_bar'] = 'ttocr/master/secondarybar_template';
	$config[$modul_name[1]]['template']['sidebar'] = 'ttocr/master/sitelink_template';

	$config[$modul_name[1]]['ttmanager']['page_title'] = "UDB Trouble Ticket Dashboard";
	$config[$modul_name[1]]['ttmanager']['content_file']['ttlist'] = 'ttocr/tt/tt_list';
	$config[$modul_name[1]]['ttmanager']['include_file']['ttlist'] = 'ttocr/tt/tt_list_inc';

	$config[$modul_name[1]]['ocrmanager']['page_title'] = "UDB OCR Dashboard";
	$config[$modul_name[1]]['ocrmanager']['content_file']['ocrlist'] = 'ttocr/ocr/ocr_list';
	$config[$modul_name[1]]['ocrmanager']['include_file']['ocrlist'] = 'ttocr/ocr/ocr_list_inc';

?>