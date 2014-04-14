<? showOutputBox("tinymce/tinymce_js_view");?>
<form action="<? echo bUrl("updateInfo")?>" method="post"  id="update_form" class="contentEditForm">

	<table width="100%" border="0" cellspacing="0" cellpadding="0" id='dataTable'>
    	<tr style="display:none">
			<td class="left"><span class="require">* </span>單元名稱： </td>
			<td>
				<input  name="title" type="text" class="inputs" value="<? echo tryGetData('title',$edit_data)?>" /><?php echo form_error('title');?>
			</td>
		</tr>
		<tr style="display:none">
			<td class="left"><span class="require">* </span>Page ID： </td>
			<td>
				<input name="page_id" type="text" class="inputs" value="<? echo tryGetData('page_id',$edit_data)?>" /><?php echo form_error('page_id');?>
			</td>
		</tr>		
		<tr>
			<td class="left">內容： </td>
			<td colspan="2" class='center'>
				<textarea name="content" id="content"><? echo tryGetData('content',$edit_data,"")?></textarea>				
			</td>				
		</tr>
		<tr>
			<td colspan="2" class='center'>
				    	
				<button type="submit" class='btn save'><?php echo $this->lang->line('common_save'); ?></button>
			</td>
		</tr>
    </table>
    
    <input type="hidden" name="sn" value="<? echo tryGetData('sn', $edit_data)?>" />
</form>