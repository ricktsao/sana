<? showOutputBox("tinymce/tinymce_js_view");?>
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
				<td class="left">標題</td>
				<td> <? $filed='title';
					if($debug){?>
					
				<input  name="<? echo $filed?>" type="text" class='middle'  value="<? echo tryGetArrayValue($filed,$edit_data,"")?>" />
				<?php echo form_error($filed); ?>
				<? 
					}else{
						echo tryGetArrayValue($filed,$edit_data,"");	
						echo "<input type='hidden' name='".$filed."' value='".tryGetArrayValue($filed,$edit_data,"")."'/>";
					}
				?></td>
			</tr>
			<tr>
				<td colspan="2" class='center'>內文</td>				
			</tr>
			<tr><? $filed='content'?>
				<td colspan="2" class='center'>
					<textarea  name="<? echo $filed ?>" id="<? echo $filed ?>"><? echo tryGetArrayValue($filed,$edit_data,"")?></textarea>
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
