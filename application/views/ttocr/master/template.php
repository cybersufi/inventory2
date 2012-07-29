<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<html lang="en">
<head>
	<meta http-equiv="pragma" content="no-cache">
	<meta http-equiv="cache-control" content="no-cache">
	<meta http-equiv="expires" content="-1">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title><?php echo $this->CI->config->item('site_name'); ?> - Admin Panel</title>
	<script type="text/javascript">
		var site_url = '<?php echo $this->config->base_url().'administrator/'; ?>';
		var sitename = '<?php echo $this->CI->config->item('site_name'); ?>';
	</script>
	<?php
		$this->asset->stylesheet('ttocr/master/layout', 'screen');
		$this->asset->javascript('backend/master/jquery-1.5.2.min');
		$this->asset->javascript('backend/master/hideshow');
		
		echo $javascript;
	?>
	<!--[if lt IE 9]>
	<?php $this->asset->stylesheet('backend/template/ie', 'screen'); ?>
	<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	
	<!-- MUST BE THE LAST SCRIPT IN <HEAD></HEAD></HEAD> png fix -->
	<?php $this->asset->javascript('backend/jquery/jquery.pngFix.pack'); ?>
	<script type="text/javascript">
		$(document).ready(function(){
			$(document).pngFix( );
		});
	</script>
</head>
<body>
	<header id="header">
		<?php echo $header; ?>
	</header> <!-- end of header bar -->
	
	<section id="secondary_bar">
		<?php echo $secondary_bar; ?>
	</section><!-- end of secondary bar -->
	
	<aside id="sidebar" class="column">
		<hr />
		<?php echo $sidebar; ?>
		<footer>
			<hr />
			<p><strong>Copyright &copy; 2012 UNIX Team</strong></p>
			<p>Theme by <a href="http://www.medialoot.com">MediaLoot</a></p>
		</footer>
	</aside><!-- end of sidebar -->
	
	<section id="main" class="column">
		<?php echo $content; ?>
		<div class="spacer"></div>
	</section>
	
</body>
</html>