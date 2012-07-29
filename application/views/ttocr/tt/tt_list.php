<?php if ( ! defined('APPPATH')) exit('No direct script access allowed'); ?>
<?php if (isset($message)): ?>
	<?php echo '<h4 class="alert_'.$message->type.'">'.$message->message.'</h4>'; ?>
<?php endif; ?>

<?php foreach ($wgroup as $group): ?>
	<article class="module width_full">
		<header><h3>TT List: <?php echo ucfirst($group['name']); ?></h3></header>
		<div class="module_content">
			<div id="table-content">	 
				<!--  start table ..................................................................................... -->
				<table border="0" width="100%" cellpadding="0" cellspacing="0" id="product-table">
					<tr>
						<th class="table-header-repeat line-left" width="10%"><a href="">TT Status</a></th>
						<th class="table-header-repeat line-left" width="7%"><a href="">Priority</a></th>
						<th class="table-header-repeat line-left" width="10%"><a href="">Caler Name</a></th>
						<th class="table-header-repeat line-left" width="13%"><a href="">Assigned Group</a></th>
						<th class="table-header-repeat line-left" width="10%"><a href="">Actual Start</a></th>
						<th class="table-header-repeat line-left" width="10%"><a href="">Dead Line</a></th>
						<th class="table-header-repeat line-left" width="10%"><a href="">TT Number</a></th>
						<th class="table-header-repeat line-left"><a href="">Description</a></th>
					</tr>
					<?php if (($group['total'] <= 0) || ($group['data'] == null)): ?>
					<tr>
						<td colspan="8">No data found. Please ask system administrator or try again in other time. :)</td>
					</tr>
					<?php else: ?>
						<?php $count = 0; ?>
						<?php foreach ($group['data'] as $tt): ?>
							<tr <?php echo (($count % 2) == 1) ? 'class="alternate-row"' : ''?>> 
								<td><?php echo $tt->getStatus(); ?></t>
								<td><?php echo $tt->getPriority(); ?></t>
								<td><?php echo $tt->getCallerName(); ?></t>
								<td><?php echo $tt->getWorkgroupName(); ?></t>
								<td><?php echo $tt->getActualStart(); ?></t>
								<td><?php echo $tt->getDeadline(); ?></t>
								<td><?php echo $tt->getID(); ?></t>
								<td><?php echo $tt->getDescription(); ?></t>
							</tr>
							<?php $count++; ?>
						<?php endforeach; ?>
					<?php endif; ?>
				</table>
				<!--  end table................................... -->
			</div>
			<!--  end content-table  -->
		</div>
	</article>
	<div class="clear"></div>
<?php endforeach; ?>