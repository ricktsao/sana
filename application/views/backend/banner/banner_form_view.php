<form action="<? echo bUrl("updateBanner")?>" method="post"  id="update_form" enctype="multipart/form-data" class="contentEditForm">
	<div id="option_bar">
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td >
					<button type="button" class='btn back' onclick="jUrl('<?php echo bUrl("banners")?>')"><?php echo $this->lang->line('common_return'); ?></button>
				</td>
			</tr>
		</table>
	</div>
	<table width="100%" border="0" cellspacing="0" cellpadding="0" id='dataTable'>
    	<tr>
			<td class="left"><span class="require">* </span>名稱： </td>
			<td>
				<input  name="title" type="text" class="inputs" value="<? echo tryGetData('title',$edit_data)?>" /><?php echo form_error('title');?>
			</td>
		</tr>
		<tr style="display:none">
			<td class="left"><span class="require">* </span>Banner ID： </td>
			<td>
				<input name="banner_id" type="text" class="inputs" value="<? echo tryGetData('banner_id',$edit_data)?>" /><?php echo form_error('banner_id');?>
			</td>
		</tr>		
	  	<tr>
			<td class="left"><span class="require">* </span>排序： </td>
			<td>
				<input  name="sort" type="text" class="inputs" value="<? echo tryGetData('sort',$edit_data)?>" /><?php echo form_error('sort');?>
			</td>
		</tr>
		

		<tr>
			<td class="left"><span class="require">* </span>Image： </td>
			<td>
				<input type="file" name="filename" size="20" /><br /><br />
				<input type="hidden" name="orig_filename" value="<?php echo tryGetData('orig_filename',$edit_data)?>"  />
				<?php if(isNotNull(tryGetData('filename',$edit_data))){ ?>
				<img  border="0" src="<?php echo tryGetData('filename',$edit_data); ?>"><br />		
				刪除<input type="checkbox" name="del_filename"	value="1" />
            	<?php } ?>
				<div>建議尺寸:1920*287</div>
			</td>
		</tr>
		
		<tr>
            <td class="left">
                <?php echo $this->lang->line("field_launch");?>：
            </td>
            <td>
                <input name="launch" id="launch" value="1" type="checkbox" <? echo tryGetData('launch',$edit_data)=='1'?"checked":"" ?> >
            </td>
        </tr>  
		<tr>
			<td colspan="2" class='center'>
				<button type="button" class='btn back' onclick="jUrl('<?php echo bUrl("banners")?>')"><?php echo $this->lang->line('common_cancel'); ?></button>        	
				<button type="submit" class='btn save'><?php echo $this->lang->line('common_save'); ?></button>
			</td>
		</tr>
    </table>
    
    <input type="hidden" name="sn" value="<? echo tryGetData('sn', $edit_data)?>" />
</form>