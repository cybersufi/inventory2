<?php if ( ! defined('APPPATH')) exit('No direct script access allowed'); ?>
<?php if (isset($message)): ?>
	<h4 class="alert_info"><?php echo $message; ?></h4>
<?php endif; ?>
<article class="module width_full">
	<header><h3>Permission List</h3></header>
	<div class="tab_content">
		<table class="tablesorter" cellspacing="0"> 
			<thead> 
				<tr> 
					<th></th> 
					<th>Permission Name</th> 
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
							<td><input type="checkbox"></td> 
							<td><?php echo $perm->getName(); ?></td>
							<td><input type="image" src="<?php echo base_url('assets/images/administrator'); ?>/icn_edit.png" title="Edit"><input type="image" src="<?php echo base_url('assets/images/administrator'); ?>/icn_trash.png" title="Trash"></td> 
						</tr>
					<?php endforeach; ?>
				<?php endif; ?> 
			</tbody> 
		</table>
	</div>
</article>
<div class="clear"></div>