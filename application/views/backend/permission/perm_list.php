<?php if ( ! defined('APPPATH')) exit('No direct script access allowed'); ?>
<?php if (isset($message)): ?>
	<?php echo '<h4 class="alert_'.$message->type.'">'.$message->message.'</h4>'; ?>
<?php endif; ?>
<article class="module width_full">
	<header><h3>Permission List</h3></header>
	<div class="module_content">
		<div id="table-content">	 
			<!--  start product-table ..................................................................................... -->
			<form id="mainform" action="<?php echo base_url('administrator/permissionmanager/deletepermission/batch'); ?>" method="post">
				<table border="0" width="100%" cellpadding="0" cellspacing="0" id="product-table">
					<tr>
						<th class="table-header-check"><a id="toggle-all" ></a></th>
						<th class="<?php echo ($sorter['permname'] == 'asc') ? 'table-header-repeat_d' : 'table-header-repeat_a'; ?> line-left minwidth-1"><a href="<?php echo $nav['permname']; ?>">Permission Name</a></th>
						<th class="<?php echo ($sorter['permkey'] == 'asc') ? 'table-header-repeat_d' : 'table-header-repeat_a'; ?> line-left"><a href="<?php echo $nav['permkey']; ?>">Permission Key</a></th>
						<th class="table-header-options line-left"><a href="#">Actions</a></th>
					</tr>

					<?php if (count($permlist) <= 0): ?>
					<tr>
						<td colspan="4">No data found. Please ask system administrator or try again in other time. :)</td>
					</tr>
					<?php else: ?>
						<?php $count = 0; ?>
						<?php foreach ($permlist as $perm): ?>
							<tr <?php echo (($count % 2) == 1) ? 'class="alternate-row"' : ''?>> 
								<td><input type="checkbox" name="ids[]" value="<?php echo $perm->getId(); ?>"></td> 
								<td><?php echo $perm->getName(); ?></td>
								<td><?php echo $perm->getKey(); ?></td>
								<td class="options-width">
									<?php echo anchor(base_url('administrator/permissionmanager/editpermission/'.$perm->getId()), ' ', array('title'=> 'Edit', 'class' => 'icon-1 info-tooltip')); ?>
									<?php echo anchor(base_url('administrator/permissionmanager/deletepermission/'.$perm->getId()), ' ', array('title'=> 'Delete', 'class' => 'icon-2 info-tooltip')); ?>
								</td>
							</tr>
							<?php $count++; ?>
						<?php endforeach; ?>
					<?php endif; ?>
				</table>
			<!--  end product-table................................... --> 
			</form>
		</div>
		<!--  end content-table  -->
	
		<!--  start actions-box ............................................... -->
		<div id="actions-box">
			<a href="" class="action-slider"></a>
			<div id="actions-box-slider">
				<a href="<?php echo $url.'sort/property/permname/direction/'.$sorter['permname']; ?>" class="action-delete">Delete</a>
			</div>
			<div class="clear"></div>
		</div>
		<!-- end actions-box........... -->
		
		<!--  start paging..................................................... -->
		<table border="0" cellpadding="0" cellspacing="0" id="paging-table">
			<tr>
				<td>
					<a href="<?php echo $nav['first']; ?>" class="page-far-left"></a>
					<a href="<?php echo $nav['prev']; ?>" class="page-left"></a>
					<div id="page-info">Page <strong><?php echo $nav['curr_page']; ?></strong> / <?php echo $nav['total_pages']; ?></div>
					<a href="<?php echo $nav['next']; ?>" class="page-right"></a>
					<a href="<?php echo $nav['last']; ?>" class="page-far-right"></a>
				</td>
			</tr>
		</table>
	</div>
	<div class="clear" style="height: 20px"></div>
</article>
<div class="clear"></div>