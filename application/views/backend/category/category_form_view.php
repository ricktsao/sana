<?php
showOutputBox("tinymce/tinymce_js_view", array('elements' => 'description'));
?>


<form action="<? echo bUrl("updateCategory")?>" method="post"  id="update_form" class="contentEditForm">
	<div id="option_bar">
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td >
					<button type="button" class='btn back' onclick="jUrl('<?php echo bUrl("categories")?>')"><?php echo $this->lang->line('common_return'); ?></button>
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
		<tr>
			<td class="left"><span class="require">* </span>代表圖： </td>
			<td>
				<?php 
            		$elements = array("no"=>1,"name"=>"img_filename");
            		showOutputBox("tools/pickup_img_view", array('elements'=>$elements)); 
            	?>
			</td>
		</tr>
	  	<tr>
			<td class="left"><span class="require">* </span>排序： </td>
			<td>
				<input  name="sort" type="text" class="inputs" value="<? echo tryGetData('sort',$edit_data)?>" /><?php echo form_error('sort');?>
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
				<button type="button" class='btn back' onclick="jUrl('<?php echo bUrl("categories")?>')"><?php echo $this->lang->line('common_cancel'); ?></button>        	
				<button type="submit" class='btn save'><?php echo $this->lang->line('common_save'); ?></button>
			</td>
		</tr>
    </table>
    
    <input type="hidden" name="sn" value="<? echo tryGetData('sn', $edit_data)?>" />
</form>        