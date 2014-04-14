<form action="<?php echo getFrontendUrl("updateShipping");?>" method="post" id="edit_form">
<input type="hidden" name="sn" value="<?php echo tryGetArrayValue("sn", $edit_data);?>" />
<table class='data_table' width="95%">
	<tr class='first_row'>
		<td>出貨方式</td>
		<td><input type="text" name="title" value="<?php echo tryGetArrayValue("title", $edit_data);?>" /></td>
	</tr>
	<tr class='high_line'>
		<td class='first_row'>運費</td>
		<td><input type="text" name="shipping" value="<?php echo tryGetArrayValue("shipping", $edit_data);?>" /></td>
	</tr>
	<tr>
		<td class='first_row'>備註</td>
		<td><textarea name="memo"><?php echo tryGetArrayValue("memo", $edit_data);?></textarea></td>
	</tr>
	<tr>
		<td colspan="2">
			<input type="submit" id="submit_edit" value="送出" />
		</td>
	</tr>
</table>
</form>