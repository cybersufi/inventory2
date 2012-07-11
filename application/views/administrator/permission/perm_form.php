<?php if ( ! defined('APPPATH')) exit('No direct script access allowed'); ?>
<?php if (isset($message)): ?>
	<?php echo '<h4 class="alert_'.$message->type.'">'.$message->message.'</h4>'; ?>
<?php endif; ?>

<?php if (isset($is_new)): ?>
	<form action="<?php echo base_url('administrator/permissionmanager/newpermission'); ?>" method="post">
<?php elseif (isset($is_edit)): ?>
	<form action="<?php echo base_url('administrator/permissionmanager/editpermission/'.$perm->getId()); ?>" method="post">
<?php endif; ?>

<article class="module width_full">
	<?php if (isset($is_new)): ?>
		<header><h3>New Permission</h3></header>
	<?php elseif (isset($is_edit)): ?>
		<header><h3>Edit Permission: ( <?php echo $perm->getName(); ?> )</h3></header>
	<?php endif; ?>
	<div class="module_content">
		<fieldset>
			<label for="email">Permission Name:</label>
			<input type="text" name="perm_name" id="perm_name" size="54" value="<?php echo (isset($perm))? $perm->getName() : ""; ?>" />
		</fieldset>
		<fieldset>
			<label for="password">Permission Key:</label></dt>
			<input type="text" name="perm_key" id="perm_key" size="54" value="<?php echo (isset($perm))? $perm->getKey() : ""; ?>" />
		</fieldset>
	</div>
	<div class="clear"></div>
	<footer>
		<div class="submit_link">
			<?php if (isset($is_new)): ?>
				<input type="submit" name="action" value="Save and New" class="alt_btn">
			<?php elseif (isset($is_edit)): ?>
				<input type="submit" name="action" value="Save and Exit" class="alt_btn">
			<?php endif; ?>
			<input type="submit" name="action" value="Save" class="alt_btn">

			<?php if (isset($is_new)): ?>
				<input type="submit" name="action" value="Cancel">
			<?php elseif (isset($is_edit)): ?>	
				<input type="submit" name="action" value="Exit">
			<?php endif; ?>
		</div>
	</footer>
</article>
</form>
<div class="clear"></div>