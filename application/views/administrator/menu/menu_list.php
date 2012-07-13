<?php if ( ! defined('APPPATH')) exit('No direct script access allowed'); ?>
<?php if (isset($message)): ?>
	<?php echo '<h4 class="alert_'.$message->type.'">'.$message->message.'</h4>'; ?>
<?php endif; ?>
<article class="module width_full">
	<header><h3>Menu List</h3></header>
	<div class="tab_content">
		<table class="tablesorter" cellspacing="0"> 
			<thead> 
				<tr> 
					<th></th> 
					<th>Menu Name</th>
					<th>Menu Alias</th>
					<th>Actions</th>
				</tr> 
			</thead> 
			<tbody> 
				<?php if (count($menulist) <= 0): ?>
					<tr>
						<td colspan="3">No data found. Please ask system administrator or try again in other time. :)</td>
					</tr>
				<?php else: ?>
					<?php foreach ($menulist as $menu): ?>
						<tr> 
							<td><input type="checkbox" name="ids[]" value="<?php echo $menu->getId(); ?>"></td> 
							<td><?php echo $menu->getMenuName(); ?></td>
							<td><?php echo $menu->getMenuAlias(); ?></td>
							<td>
								<a href="<?php echo base_url('administrator/menumanager/editmenu/'.$menu->getId()); ?>">
									<input type="image" src="<?php echo base_url('assets/images/administrator'); ?>/icn_edit.png" title="Edit">
								</a>
								<a href="<?php echo base_url('administrator/menumanager/deletemenu/'.$menu->getId()); ?>">
									<input type="image" src="<?php echo base_url('assets/images/administrator'); ?>/icn_trash.png" title="Trash">
								</a>
							</td> 
						</tr>
					<?php endforeach; ?>
				<?php endif; ?> 
			</tbody> 
		</table>
	</div>
</article>
<div class="clear"></div>