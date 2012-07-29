<?php if ( ! defined('APPPATH')) exit('No direct script access allowed'); ?>

<?php	$this->asset->stylesheet('ttocr/master/table', 'screen'); ?>

<!--  checkbox styling script -->
<?php
	
	$this->asset->javascript('backend/jquery/ui.core');
	$this->asset->javascript('backend/jquery/ui.checkbox');
	$this->asset->javascript('backend/jquery/jquery.bind');

?>
<script type="text/javascript">
$(function(){
	$('input').checkBox();
	$('#toggle-all').click(function(){
 	$('#toggle-all').toggleClass('toggle-checked');
	$('#mainform input[type=checkbox]').checkBox('toggle');
	return false;
	});
});
</script>  

<![if !IE 7]>

<!--  styled select box script version 1 -->
<?php $this->asset->javascript('backend/jquery/jquery.selectbox-0.5'); ?>
<script type="text/javascript">
$(document).ready(function() {
	$('.styledselect').selectbox({ inputClass: "selectbox_styled" });
});
</script>
 
<![endif]>

<!--  styled select box script version 2 -->
<?php $this->asset->javascript('backend/jquery/jquery.selectbox-0.5_style_2'); ?>
<script type="text/javascript">
$(document).ready(function() {
	$('.styledselect_form_1').selectbox({ inputClass: "styledselect_form_1" });
	$('.styledselect_form_2').selectbox({ inputClass: "styledselect_form_2" });
});
</script>

<!--  styled select box script version 3 -->
<?php $this->asset->javascript('backend/jquery/jquery.selectbox-0.5_style_2'); ?>
<script type="text/javascript">
$(document).ready(function() {
	$('.styledselect_pages').selectbox({ inputClass: "styledselect_pages" });
});
</script>

<!-- Custom jquery scripts -->
<?php $this->asset->javascript('backend/jquery/custom_jquery'); ?>
 
<!-- Tooltips -->
<?php $this->asset->javascript('backend/jquery/jquery.tooltip'); ?>
<?php $this->asset->javascript('backend/jquery/jquery.dimensions'); ?>
<script type="text/javascript">
$(function() {
	$('a.info-tooltip ').tooltip({
		track: true,
		delay: 0,
		fixPNG: true, 
		showURL: false,
		showBody: " - ",
		top: -35,
		left: 5
	});
});
</script> 