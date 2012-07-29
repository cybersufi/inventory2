<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<div class="user">
	<?php 
		
		$username = ucfirst($this->session->userdata('uname'));
		echo '<p>'.$username.' (<a href="#">3 Messages</a>)</p>';
		
		$link = base_url('administrator/login/dologout');
		echo anchor($link, 'Logout', 'class="logout_user" title="Logout"');
	?>
	
</div>
<div class="breadcrumbs_container">
	<article class="breadcrumbs"><?php echo anchor(base_url('administrator/main'), 'Website Admin', ''); ?> <div class="breadcrumb_divider"></div>  <a class="current">Dashboard</a></article>
</div>