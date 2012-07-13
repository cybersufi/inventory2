<?php if ( ! defined('APPPATH')) exit('No direct script access allowed'); ?>

<?php if (isset($message)): ?>
	<?php echo '<h4 class="alert_'.$message->type.'">'.$message->message.'</h4>'; ?>
<?php endif; ?>

<?php if ($is_batch): ?>
	<form action="<?php echo base_url('administrator/permissionmanager/deletepermission/batch'); ?>" method="post">
<?php else: ?>
	<form action="<?php echo base_url('administrator/permissionmanager/deletepermission/'.$perm->getId()); ?>" method="post">
<?php endif; ?>

<article class="module width_full">
	<header><h3>Delete Confirmation</h3></header>
	<div class="module_content">
		<h3>Do you really want to delete below permission(s):</h3>
		<ul>
		<?php if ($is_batch): ?>
			<?php foreach ($permilist as $perm): ?>
				<li><b>Permission Name:</b> <?php echo $perm->getName(); ?> <b> ( Key: </b><?php echo $perm->getKey(); ?> <b>)</b></li>
				<input type="hidden" value="<?php echo $perm->getId(); ?>" name="ids[]" />
			<?php endforeach; ?>
		<?php elseif (isset($perm)): ?>
			<li><b>Permission Name:</b> <?php echo $perm->getName(); ?> <b> ( Key: </b><?php echo $perm->getKey(); ?> <b>)</b></li>
		<?php endif; ?>
		</ul>
	</div>
	<div class="clear"></div>
	<footer>
		<div class="submit_link">
			<input type="submit" name="action" value="Yes" class="alt_btn">
			<input type="submit" name="action" value="No">
		</div>
	</footer>
</article>
</form>
<div class="clear"></div>