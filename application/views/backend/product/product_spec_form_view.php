<?php
showOutputBox("tinymce/tinymce_js_view", array('elements' => 'description'));
?>

<form action="<? echo bUrl("updateSpec")?>" method="post"  id="update_form" enctype="multipart/form-data" class="contentEditForm">
	<div id="option_bar">
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td >
					<button type="button" class='btn back' onclick="jUrl('<?php echo bUrl("productList",true,array('product_sn'))?>')"><?php echo $this->lang->line('common_return'); ?></button>
				</td>
			</tr>
		</table>
	</div>
	<table width="100%" border="0" cellspacing="0" cellpadding="0" id='dataTable'>
	<?php foreach ($spec_list as $key => $item){?>
	    <tr style="display:">
			<td class="left"><span class="require">* </span><?php echo tryGetData('title',$item)?>： </td>
			<td>
				<input type="hidden" name="spec_name_<?php echo tryGetData('sn',$item)?>" value="<?php echo tryGetData('title',$item)?>" />
				<textarea name="spec_value_<?php echo tryGetData('sn',$item)?>" style="width:500px"><? echo $spec_info[$item["sn"]]["spec_value"]?></textarea>
				啟用 : <input type="checkbox" name="spec_launch_<? echo tryGetData('sn',$item)?>" value="1" <? echo $spec_info[$item["sn"]]["spec_launch"]==1?"checked":""; ?>  />
			</td>
		</tr>
	<? } ?>
	
		<tr>
			<td colspan="2" class='center'>
    	
				<button type="button" class='btn back' onclick="jUrl('<?php echo bUrl("productList",true,array('product_sn'))?>')"><?php echo $this->lang->line('common_cancel'); ?></button>
				<button type="submit" class='btn save'><?php echo $this->lang->line('common_save'); ?></button>
			</td>
		</tr>
    </table>
    <input type="hidden" name="product_sn" value="<? echo $product_sn?>" />
</form>        