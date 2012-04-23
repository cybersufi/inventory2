<?php if ( ! defined('APPPATH')) exit('No direct script access allowed'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Site Administration</title>
	<script type="text/javascript">
		var base_url = "<?php echo $this->config->base_url(); ?>";
	</script>
	<?php
  		$this->asset->stylesheet('administrator/login/style');
		$this->asset->stylesheet('administrator/login/niceforms-default');
		$this->asset->javascript('administrator/login/jquery.min');
		$this->asset->javascript('administrator/login/jconfirmaction.jquery');
		$this->asset->javascript('administrator/login/niceforms');
  	?>
	<script type="text/javascript">
		
		$(document).ready(function() {
			$('.ask').jConfirmAction();
		});
		
	</script>
</head>
<body>
	<div id="main_container">
		<div class="header_login">
    		<div class="logo"><a href="#">
    			<?php
					$this->asset->image('administrator/login/logo.gif');
				?>
    		</a></div>
		</div>
		
     	<div class="login_form">
        	<h3>Administrator Login</h3>
        	<?php
				if ($this->session->flashdata('success') == 'false') {
			?>
				<div class="error_box">
			        <?php 
			        	//echo $msg 
			        	echo 'baka';
			        	echo $this->session->flashdata('msg');
						//$this->session->unset_userdata('success');
						//$this->session->unset_userdata('msg');
			        ?>
			    </div>
			<?php		
				}
			?>
         	<!--<a href="#" class="forgot_pass">Forgot password</a>-->
         	<form action="<?php echo $this->config->base_url().'administrator/login/dologin' ?>" method="post" class="niceform">
	         	<fieldset>
	            	<dl>
						<dt><label for="email">Username:</label></dt>
	                	<dd><input type="text" name="" id="" size="54" /></dd>
	                </dl>
	                <dl>
	                    <dt><label for="password">Password:</label></dt>
	                    <dd><input type="text" name="" id="" size="54" /></dd>
	                </dl>
					<dl>
	                    <dt><label></label></dt>
	                    <dd></dd>
	                </dl>        
					<dl class="submit">
	                	<input type="submit" name="submit" id="submit" value="Enter" />
					</dl> 
	            </fieldset>    
         	</form>
     	</div>
     	
		<div class="footer_login">
    		<div class="left_footer_login">Maintained by UNIX team | Powered by <a href="http://indeziner.com">INDEZINER</a></div>
    		<div class="right_footer_login"><a href="http://indeziner.com">
    				<?php
						$this->asset->image('administrator/login/indeziner_logo.gif');
					?>
    		</a></div>
		</div>
	</div>		
</body>
</html>