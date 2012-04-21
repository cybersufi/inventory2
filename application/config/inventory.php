<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

$site_config['active_template'] = 'admin';

/*
|--------------------------------------------------------------------------
| Administrator Template Configuration
|--------------------------------------------------------------------------
*/
$site_config['default']['template'] = 'template';
$site_config['default']['regions'] = array(
   'header',
   'content',
   'footer',
);
$site_config['default']['parser'] = 'parser';
$site_config['default']['parser_method'] = 'parse';
$site_config['default']['parse_template'] = FALSE;


/*
|--------------------------------------------------------------------------
| Administrator Template Configuration
|--------------------------------------------------------------------------
*/
$site_config['admin']['template'] = 'administrator/master/template';
$site_config['admin']['regions'] = array ('javascript', 'header', 'secondary_bar', 'sidebar', 'messages', 'content');
$site_config['admin']['parser'] = 'parser';
$site_config['admin']['parser_method'] = 'parse';
$site_config['admin']['parse_template'] = FALSE;

/* End of file template.php */
/* Location: ./system/application/config/template.php */

?>