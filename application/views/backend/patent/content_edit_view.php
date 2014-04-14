<? showOutputBox("tinymce/tinymce_js_view");?>
<form action="<? echo $url['action']?>" method="post"  id="update_form" class="contentEditForm" enctype="multipart/form-data">
		<div id="option_bar">
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td >
						<button type="button" class='btn back' onclick="history.back()">	<?php echo $this -> lang -> line('common_return'); ?></button>	
						
					</td>
				</tr>
			</table>
		</div>
		<table  border="0" cellspacing="0" cellpadding="0" id='dataTable'>
			<tr>
				<td class="left"><span class="require">* </span>主題</td>
				<td> <? $filed='title'?>
				<input  name="<? echo $filed?>" type="text" class='middle'  value="<? echo tryGetArrayValue($filed,$edit_data,"")?>" />
				<?php echo form_error($filed); ?></td>
			</tr>
		
		
			<tr>
				<td colspan="2" class='center'>內文</td>				
			</tr>
			<tr><? $filed='content'?>
				<td colspan="2" class='center'>
					<textarea name="<? echo $filed ?>" id="<? echo $filed ?>"><? echo tryGetArrayValue($filed,$edit_data,"")?></textarea>
					<?php echo form_error($filed); ?>
				</td>				
			</tr>			
			<tr>
				<td class="left"> 啟用 </td>
				<td>
				<input name="launch" id="launch" value="1" type="checkbox" <? echo tryGetArrayValue('launch',$edit_data)=='1'?"checked":"" ?> >
				</td>
			</tr>
			<tr>
				
				<td colspan="2" class='center'>				
					<button class='btn back' type="button"  onclick="history.back()">
						<?php echo $this -> lang -> line('common_cancel'); ?>
					</button>
					<button type="submit" class='btn save'>
						<?php echo $this -> lang -> line('common_save'); ?>
					</button>
				</td>
			</tr>
		</table>
	
	<input type="hidden" name="sn" value="<? echo tryGetArrayValue('sn', $edit_data)?>" />
	<input type="hidden" name="type_sn" value="<? echo tryGetArrayValue('type_sn', $edit_data)?>" />
</form>
