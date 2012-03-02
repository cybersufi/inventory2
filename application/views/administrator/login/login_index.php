<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-gb" lang="en-gb" dir="ltr" >
<head>
  	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
  	<meta name="generator" content="Joomla! - Open Source Content Management" />
  	<title>Inventory - Administration</title>
  	<?php
  		$this->asset->stylesheet('administrator/system');
		$this->asset->stylesheet('administrator/template');
  	?>
  	<style type="text/css">
		html { display:none }
  	</style>
  	<script src="/website/joomla/media/system/js/mootools-core.js" type="text/javascript"></script>
  	<script src="/website/joomla/media/system/js/core.js" type="text/javascript"></script>
	<script type="text/javascript">
		window.addEvent('domready', function () {
			if (top == self) {
				document.documentElement.style.display = 'block'; 
			} else {
				top.location = self.location; 
			}
		});
  	</script>


<!--[if IE 7]>
<link href="templates/bluestork/css/ie7.css" rel="stylesheet" type="text/css" />
<![endif]-->

	<script type="text/javascript">
		window.addEvent('domready', function () {
			document.getElementById('form-login').username.select();
			document.getElementById('form-login').username.focus();
		});
	</script>
</head>
<body>
	<div id="border-top" class="h_blue">
		<span class="title"><a href="index.php">Administration</a></span>
	</div>
	<div id="content-box">
		<div id="element-box" class="login">
			<div class="m wbg">
				<h1>Administration Login</h1>	
				<div id="system-message-container">
					<dl id="system-message">
						<dt class="error">Error</dt>
						<dd class="error message">
							<ul>
								<li>Username and password do not match or you do not have an account yet.</li>
							</ul>
						</dd>
						<dt class="warning">Warning</dt>
						<dd class="warning message">
							<ul>
								<li>Username and password do not match or you do not have an account yet.</li>
							</ul>
						</dd>
						<dt class="notice">Notice</dt>
						<dd class="notice message">
							<ul>
								<li>Username and password do not match or you do not have an account yet.</li>
							</ul>
						</dd>
					</dl>
				</div>
				<div id="section-box">
					<div class="m">
						<form action="<?php echo $base_url; ?>login/doLogin" method="post" id="form-login">
							<fieldset class="loginform">
								<label id="mod-login-username-lbl" for="mod-login-username">User Name</label>
								<input name="username" id="mod-login-username" type="text" class="inputbox" size="15" />

								<label id="mod-login-password-lbl" for="mod-login-password">Password</label>
								<input name="password" id="mod-login-password" type="password" class="inputbox" size="15" />

								<div class="button-holder">
									<div class="button1">
										<div class="next">
											<a href="#" onclick="document.getElementById('form-login').submit();">
												Log in
											</a>
										</div>
									</div>
								</div>

								<div class="clr"></div>
								<input type="submit" class="hidebtn" value="Log in" />
								<input type="hidden" name="option" value="com_login" />
								<input type="hidden" name="task" value="login" />
								<input type="hidden" name="return" value="aW5kZXgucGhw" />
								<input type="hidden" name="86c327aaabd5ae2d1dbc601384ff15b4" value="1" />	</fieldset>
						</form>
						<div class="clr"></div>
					</div>
				</div>
	
				<p>Use a valid username and password to gain access to the administrator backend.</p>
				<p><a href="http://localhost/website/joomla/">Go to site home page.</a></p>
				<div id="lock"></div>
			</div>
		</div>
		<noscript>
				Warning! JavaScript must be enabled for proper operation of the Administrator backend.			
		</noscript>
	</div>
	<div id="footer">
		<p class="copyright">
			<a href="http://www.joomla.org">Joomla!&#174;</a> is free software released under the <a href="http://www.gnu.org/licenses/gpl-2.0.html">GNU General Public License</a>.		
		</p>
	</div>
</body>
</html>