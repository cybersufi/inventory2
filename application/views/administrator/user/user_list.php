<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

<article class="module width_full">
	<header><h3>User List</h3></header>
	<div class="tab_content">
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
					<tr> 
						<td><input type="checkbox"></td> 
						<td>Lorem Ipsum Dolor Sit Amet</td> 
						<td>Articles</td> 
						<td>5th April 2011</td>
						<td>Active</td>
						<td><input type="image" src="<?php echo base_url('assets/images/administrator'); ?>/icn_edit.png" title="Edit"><input type="image" src="<?php echo base_url('assets/images/administrator'); ?>/icn_trash.png" title="Trash"></td> 
					</tr>
				<?php endif; ?> 
			</tbody> 
		</table>
	</div>
</article>
<div class="clear"></div>