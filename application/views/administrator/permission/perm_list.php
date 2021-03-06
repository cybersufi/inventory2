<?php if ( ! defined('APPPATH')) exit('No direct script access allowed'); ?>
<?php if (isset($message)): ?>
	<?php echo '<h4 class="alert_'.$message->type.'">'.$message->message.'</h4>'; ?>
<?php endif; ?>
<form action="<?php echo base_url('administrator/permissionmanager/deletepermission/batch'); ?>" method="post">
<article class="module width_full">
	<header><h3>Permission List</h3></header>
	<div class="tab_content">
		<table class="tablesorter" cellspacing="0"> 
			<thead> 
				<tr> 
					<th></th> 
					<th>Permission Name</th>
					<th>Permission Key</th>
					<th>Actions</th>
				</tr> 
			</thead> 
			<tbody> 
				<?php if (count($permlist) <= 0): ?>
					<tr>
						<td colspan="3">No data found. Please ask system administrator or try again in other time. :)</td>
					</tr>
				<?php else: ?>
					<?php foreach ($permlist as $perm): ?>
						<tr> 
							<td><input type="checkbox" name="ids[]" value="<?php echo $perm->getId(); ?>"></td> 
							<td><?php echo $perm->getName(); ?></td>
							<td><?php echo $perm->getKey(); ?></td>
							<td>
								<a href="<?php echo base_url('administrator/permissionmanager/editpermission/'.$perm->getId()); ?>">
									<input type="image" src="<?php echo base_url('assets/images/administrator'); ?>/icn_edit.png" title="Edit">
								</a>
								<a href="<?php echo base_url('administrator/permissionmanager/deletepermission/'.$perm->getId()); ?>">
									<input type="image" src="<?php echo base_url('assets/images/administrator'); ?>/icn_trash.png" title="Trash">
								</a>
							</td> 
						</tr>
					<?php endforeach; ?>
				<?php endif; ?> 
			</tbody> 
		</table>
	</div>
	<footer>
		<div class="submit_link">
			test
		</div>
		<div class="submit_delete">
			<input type="submit" name="action" value="Delete Selected" class="alt_btn">
		</div>
	</footer>
</article>
</form>
<div class="clear"></div>