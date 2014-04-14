<form action="<?php echo getFrontendUrl("updatePayment");?>" method="post" id="edit_form">
<input type="hidden" name="sn" value="<?php echo tryGetArrayValue("sn", $edit_data);?>" />
<table class='data_table' width="95%">
	<tr>
		<td class='first_row'>付款方式</td>
		<td><input type="text" name="title" value="<?php echo tryGetArrayValue("title", $edit_data);?>" /></td>
	</tr>
	<tr class='high_line'>
		<td class='first_row'>戶名</td>
		<td><input type="text" name="user_name" value="<?php echo tryGetArrayValue("user_name", $edit_data);?>" /></td>
	</tr>
	<tr>
		<td class='first_row'>銀行代號</td>
		<td><input type="text" name="bank_code" value="<?php echo tryGetArrayValue("bank_code", $edit_data);?>" /></td>
	</tr>
	<tr class='high_line'>
		<td class='first_row'>帳號</td>
		<td><input type="text" name="account" value="<?php echo tryGetArrayValue("account", $edit_data);?>" /></td>
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