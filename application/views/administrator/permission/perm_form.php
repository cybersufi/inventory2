<?php if ( ! defined('APPPATH')) exit('No direct script access allowed'); ?>
<?php if (isset($message)): ?>
	<h4 class="alert_info"><?php echo $message; ?></h4>
<?php endif; ?>
<form action="<?php echo base_url('administrator/permissionmanager/newpermission'); ?>" method="post">
<article class="module width_full">
	<?php if ($is_new): ?>
		<header><h3>New Permission</h3></header>
	<?php else: ?>
		<header><h3>Edit Permission: (<?php echo $perm_name;?>)</h3></header>
	<?php endif; ?>
	<div class="module_content">
		<fieldset>
			<label for="email">Permission Name:</label>
			<input type="text" name="perm_name" id="perm_name" size="54" />
		</fieldset>
		<fieldset>
			<label for="password">Permission Key:</label></dt>
			<input type="text" name="perm_key" id="perm_key" size="54" />
		</fieldset>
	</div>
	<div class="clear"></div>
	<footer>
		<div class="submit_link">
			<input type="submit" name="action" value="Save and New" class="alt_btn">
			<input type="submit" name="action" value="Save" class="alt_btn">
			<input type="submit" name="action" value="Cancel">
		</div>
	</footer>
</article>
</form>
<div class="clear"></div>