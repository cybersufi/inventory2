<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<html lang="en">
<head>
	<meta http-equiv="pragma" content="no-cache">
	<meta http-equiv="cache-control" content="no-cache">
	<meta http-equiv="expires" content="-1">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title><?php echo $site_name; ?> - Site Administration</title>
    <?php
		$this->extloader->loadbase();
		$this->extloader->javascript('ux/SimpleIFrame');
		$this->asset->stylesheet('inventory/shared/prettify');
		$this->asset->stylesheet('inventory/mainpage/mainpage'); 
		$this->asset->javascript('inventory/siteadmin/config');
		$this->asset->javascript('inventory/siteadmin/mainpage/navigationtree');
		$this->asset->javascript('inventory/siteadmin/mainpage/mainpage');
	?>
</head>
<body>
	<div id="header" style="display:none;">
    	<a href="<?php echo $base_url; ?>" style="float:right;margin-right:10px;">
		<?php
			$this->asset->image('extjs.gif', 'extjs.com', array("style" => "width:83px;height:24px;margin-top:1px;"));
        	?>
      	</a>
		<div class="api-title"><?php echo $site_name; ?> - Site Administration</div>
  	</div>
    	<div style="display:none;">
	    	<div id="session-user">
			Welcome &nbsp;<b><?php echo ucfirst($username); ?></b>,&nbsp;Last login:&nbsp;<?php echo date('d/m/Y H:i', $lastlogin); ?>
			,&nbsp;From:&nbsp;<?php echo $ipaddress; ?>
	    	</div>
    	</div>
    	<script type="text/javascript">
		Ext.onReady(function(){
          	Ext.create('App.Inventory.SiteAdmin.Mainpage').init();
		});
    	</script>
    	<!--<iframe id="iframe-div" frameborder="0" scrolling="auto" src="" width="100%" height="100%"></iframe>-->
    	<script type="text/javascript">
		function change_parent_url() {
			document.location = site_url;
   		}		
    	</script>
</body>
<head>
	<meta http-equiv="pragma" content="no-cache">
	<meta http-equiv="cache-control" content="no-cache">
	<meta http-equiv="expires" content="-1">
</head>
</html>
