<?php if ( ! defined('APPPATH')) exit('No direct script access allowed'); ?>
<?php if (isset($message)): ?>
	<?php echo '<h4 class="alert_'.$message->type.'">'.$message->message.'</h4>'; ?>
<?php endif; ?>

<article class="module width_full">
	<?php if (isset($is_new)): ?>
		<header><h3>New Permission</h3></header>
	<?php elseif (isset($is_edit)): ?>
		<header><h3>Edit Permission: ( <?php echo $perm->getName(); ?> )</h3></header>
	<?php endif; ?>
	<div class="module_content">

		<table border="0" cellpadding="0" cellspacing="0"  id="id-form">
			<tr >
				<th valign="top">Permission name:</th>
				<td><input type="text" class="inp-form" /></td>
				<td></td>
			</tr>
			<tr >
				<th valign="top">Permission key:</th>
				<td><input type="text" class="inp-form-error" /></td>
				<td>
				<div class="error-left">	</div>
				<div class="error-inner">This field is required.</div>
				</td>
			</tr>
			<tr>
				<th>&nbsp;</th>
				<td valign="top">
					<input type="button" value="" class="form-submit" />
					<input type="reset" value="" class="form-reset"  />
				</td>
				<td></td>
			</tr>
		</table>
	</div>
	<div class="clear"></div>
</article>
<div class="clear"></div>