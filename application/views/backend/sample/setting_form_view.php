<?php
showOutputBox("tinymce/tinymce_js_view", array('elements' => 'form_submit_message,form_header'));
?>
<form action="<? echo bUrl("updateSetting")?>" method="post"  id="update_form" class="contentEditForm">

	<table width="100%" border="0" cellspacing="0" cellpadding="0" id='dataTable'>
    	<tr>
			<td class="left"><span class="require">* </span>信件標題： </td>
			<td>
				<input  name="mail_title" type="text" class="inputs" value="<? echo tryGetData('mail_title',$edit_data)?>" />
			</td>
		</tr>				
		<tr>
			<td class="left">收件者Email： </td>
			<td colspan="2" class='center'>
				<textarea name="mail_list" id="mail_list"><? echo tryGetData('mail_list',$edit_data,"")?></textarea>		
				<div>若填多筆請以逗號(,)隔開</div>
			</td>				
		</tr>
		<tr>
			<td class="left">表單上方區塊： </td>
			<td colspan="2" class='center'>
				<textarea name="form_header" id="form_header"><? echo tryGetData('form_header',$edit_data,"")?></textarea>				
			</td>				
		</tr>
		<tr>
			<td class="left">表單提交後訊息： </td>
			<td colspan="2" class='center'>
				<textarea name="form_submit_message" id="form_submit_message"><? echo tryGetData('form_submit_message',$edit_data,"")?></textarea>				
			</td>				
		</tr>
		<tr>
			<td colspan="2" class='center'>				       	
				<button type="submit" class='btn save'><?php echo $this->lang->line('common_save'); ?></button>
			</td>
		</tr>
    </table>   

</form>        