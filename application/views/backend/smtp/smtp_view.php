<form action="<? echo $url['action']?>" method="post"  id="update_form" class="contentEditForm" >
		<div id="option_bar">
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td >
						
					</td>
				</tr>
			</table>
		</div>
		<table  border="0" cellspacing="0" cellpadding="0" id='dataTable'>
			<tr>
				<td class="left">Host</td>
				<td> <? $filed='host'?>
				<input  name="<? echo $filed?>" type="text" class='middle'  value="<? echo tryGetArrayValue($filed,$edit_data,"")?>" />
				<?php echo form_error($filed); ?></td>
			</tr>
				<tr>
				<td class="left">Port</td>
				<td> <? $filed='port'?>
				<input  name="<? echo $filed?>" type="text" class='middle'  value="<? echo tryGetArrayValue($filed,$edit_data,"")?>" />
				<?php echo form_error($filed); ?></td>
			</tr>
			<tr>
				<td class="left">Username</td>
				<td> <? $filed='username'?>
				<input  name="<? echo $filed?>" type="text" class='middle'  value="<? echo tryGetArrayValue($filed,$edit_data,"")?>" />
				<?php echo form_error($filed); ?></td>
			</tr>
				<tr>
				<td class="left">Password</td>
				<td> <? $filed='password'?>
				<input  name="<? echo $filed?>" type="text" class='middle'  value="<? echo tryGetArrayValue($filed,$edit_data,"")?>" />
				<?php echo form_error($filed); ?></td>
			</tr>
			<tr>				
				<td colspan="2" class='center'>				
				
				<button type="submit" class='btn save'>
					<?php echo $this -> lang -> line('common_save'); ?>
				</button>
				</td>
			</tr>
		</table>
	
	<input type="hidden" name="sn" value="<? echo tryGetArrayValue('sn', $edit_data)?>" />
</form>
