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
				<td class="left"><span class="require">* </span>標題</td>
				<td> <? $filed='title'?>
				<input  name="<? echo $filed?>" type="text" class='middle'  value="<? echo tryGetArrayValue($filed,$edit_data,"")?>" />
				<?php echo form_error($filed); ?></td>
			</tr>
			<tr>
				<td colspan="2" class='center'>關鍵字</td>				
			</tr>
			<tr><? $filed='keyword'?>
				<td colspan="2" class='center'>
					<textarea name="<? echo $filed ?>" id="<? echo $filed ?>"><? echo tryGetArrayValue($filed,$edit_data,"")?></textarea>
					<?php echo form_error($filed); ?>
				</td>				
			</tr>
			<tr>
				<td colspan="2" class='center'>描述</td>				
			</tr>
			<tr><? $filed='description'?>
				<td colspan="2" class='center'>
					<textarea name="<? echo $filed ?>" id="<? echo $filed ?>"><? echo tryGetArrayValue($filed,$edit_data,"")?></textarea>
					<?php echo form_error($filed); ?>
				</td>				
			</tr>
			<tr>
				<td colspan="2" class='center'>google</td>				
			</tr>
			<tr><? $filed='google'?>
				<td colspan="2" class='center'>
					<textarea name="<? echo $filed ?>" id="<? echo $filed ?>"><? echo tryGetArrayValue($filed,$edit_data,"")?></textarea>
					<?php echo form_error($filed); ?>
				</td>				
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
