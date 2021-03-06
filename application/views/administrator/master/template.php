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
		$this->asset->stylesheet('administrator/main/layout', 'screen');
		$this->asset->javascript('administrator/main/jquery-1.5.2.min');
		$this->asset->javascript('administrator/main/hideshow');
		$this->asset->javascript('administrator/main/jquery.tablesorter.min');
		$this->asset->javascript('administrator/main/jquery.equalHeight');
		
		echo $javascript;
	?>
	<!--[if lt IE 9]>
	<?php $this->asset->stylesheet('administrator/main/ie', 'screen'); ?>
	<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	<script type="text/javascript">
		$(document).ready(function() { 
			$(".tablesorter").tablesorter(); 
	   	});
		$(document).ready(function() {
			//When page loads...
			$(".tab_content").hide(); //Hide all content
			$("ul.tabs li:first").addClass("active").show(); //Activate first tab
			$(".tab_content:first").show(); //Show first tab content

			//On Click Event
			$("ul.tabs li").click(function() {

				$("ul.tabs li").removeClass("active"); //Remove any "active" class
				$(this).addClass("active"); //Add "active" class to selected tab
				$(".tab_content").hide(); //Hide all tab content

				var activeTab = $(this).find("a").attr("href"); //Find the href attribute value to identify the active tab + content
				$(activeTab).fadeIn(); //Fade in the active ID content
				return false;
			});

		});
    </script>
    <script type="text/javascript">
	    $(function(){
	        $('.column').equalHeight();
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
	
	<aside id="sidebar" class="column" style="height: 100%">
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