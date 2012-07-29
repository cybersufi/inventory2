<?php if ( ! defined('APPPATH')) exit('No direct script access allowed'); ?>

<article class="module width_full">
	<header><h3>User List</h3></header>
	<div class="tab_container">
		<div id="tab1" class="tab_content" style="display: block;">
			<table class="tablesorter" cellspacing="0"> 
				<thead> 
					<tr> 
						<th></th> 
						<th>User Name</th> 
						<th>User Group</th> 
						<th>Creation Date</th>
						<th>User Status</th>
						<th>Actions</th>
					</tr> 
				</thead> 
				<tbody> 
					<?php if (count($userdata) <= 0): ?>
						<tr>
							<td colspan="6">No data found. Please ask system administrator or try again in other time. :)</td>
						</tr>
					<?php else: ?>
						<?php foreach ($userdata as $user): ?>
							<tr> 
								<td><input type="checkbox"></td> 
								<td><?php echo $user->getUsername(); ?></td> 
								<td><?php echo $user->getGroupname(); ?></td> 
								<td><?php echo $user->getCreationDate(); ?></td>
								<td><?php echo $user->getStatus(); ?></td>
								<td><input type="image" src="<?php echo base_url('assets/images/administrator'); ?>/icn_edit.png" title="Edit"><input type="image" src="<?php echo base_url('assets/images/administrator'); ?>/icn_trash.png" title="Trash"></td> 
							</tr>
						<?php endforeach; ?>
					<?php endif; ?> 
				</tbody> 
			</table>
		</div>
	</div>
</article>
<div class="clear"></div>