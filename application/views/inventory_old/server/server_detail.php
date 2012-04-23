<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="pragma" content="no-cache">
	<meta http-equiv="cache-control" content="no-cache">
	<meta http-equiv="expires" content="-1">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title><?php echo $site_name; ?></title>
<?php
	$this->asset->stylesheet('ext-all');
	$this->asset->stylesheet('inventory/serv-index');
  $this->asset->stylesheet('ux/css/RowEditor');
	
	$this->asset->javascript('adapter/ext/ext-base');
	$this->asset->javascript('ext-all');
	
	$this->asset->javascript('ux/statusbar/StatusBar');
	$this->asset->javascript('ux/statusbar/ValidationStatus');
	$this->asset->javascript('ux/RowEditor');
	$this->asset->javascript('ux/paging/pPageSize');
  
  
	$this->asset->javascript('public/config');
	$this->asset->javascript('inventory/sd/iplist');
	$this->asset->javascript('inventory/sd/mplist');
	$this->asset->javascript('inventory/sd/userlist');
  $this->asset->javascript('inventory/sd/serverdetail');
	$this->asset->javascript('inventory/serverdetail');
?>
    
</head>
<body>
  <div id="serverid" sytyle="display:none;visibility:hidden"><?php echo $serverid ?></div>
	<div id="loading-mask" style=""></div>
	<div id="loading">
    	<div class="loading-indicator">
        	<?php
            	$this->asset->image('login/extanim32.gif', 'Loading Anim', array("width" => "32", "height" => "32", "style" => "margin-right:8px", "align" => "absmiddle"));
            ?>
            Loading...
		</div>
	</div>
	<div id="sdform"></div>
</body>
<head>
	<meta http-equiv="pragma" content="no-cache">
	<meta http-equiv="cache-control" content="no-cache">
	<meta http-equiv="expires" content="-1">
</head>
</html>