<? showOutputBox("tinymce/tinymce_js_view");?>
<form action="<? echo bUrl("updateSetting")?>" method="post"  id="update_form" class="contentEditForm">

	<table width="100%" border="0" cellspacing="0" cellpadding="0" id='dataTable'>
    	<tr>
			<td class="left"><span class="require">* </span>網站名稱： </td>
			<td>
				<input  name="website_title" type="text" class="inputs" value="<? echo tryGetData('website_title',$edit_data)?>" />
			</td>
		</tr>				
		<tr>
			<td class="left">SEO Keywords： </td>
			<td colspan="2" class='center'>
				<textarea name="meta_keyword" id="meta_keyword"><? echo tryGetData('meta_keyword',$edit_data,"")?></textarea>				
			</td>				
		</tr>
		<tr>
			<td class="left">SEO Description： </td>
			<td colspan="2" class='center'>
				<textarea name="meta_description" id="meta_description"><? echo tryGetData('meta_description',$edit_data,"")?></textarea>				
			</td>				
		</tr>
		<tr>
			<td class="left">網站頁腳內容： </td>
			<td colspan="2" class='center'>
				<textarea name="footer" id="content"><? echo tryGetData('footer',$edit_data,"")?></textarea>				
			</td>				
		</tr>
		<tr>
			<td colspan="2" class='center'>				       	
				<button type="submit" class='btn save'><?php echo $this->lang->line('common_save'); ?></button>
			</td>
		</tr>
    </table>   

</form>        