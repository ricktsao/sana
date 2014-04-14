
<form action="<? echo $url['action']?>" method="post"  id="update_form" class="contentEditForm"  enctype="multipart/form-data" >
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
				<td class="left"><span class="require">* </span>標題</td>
				<td> <? $filed='title'?>
				<input  name="<? echo $filed?>" type="text" class='small'  value="<? echo tryGetArrayValue($filed,$edit_data,"")?>" />
				<?php echo form_error($filed); ?></td>
			</tr>
		
			<tr>
				<td class="left">附件</td>
				<td> <? $filed='file1'?>
					<input type="file" name="<? echo $filed?>"/><br />
					<?php
						$file=tryGetArrayValue($filed,$edit_data,"");					
					
						if($file!=''){
							echo "<div class='sicon document'></div><a href='".base_url()."/".$file_path."/".$file."' target='_blank'>目前檔案</a>&nbsp&nbsp&nbsp&nbsp";
							echo "<label><div class='sicon del'></div>刪除檔案<input type='checkbox' name='del1' value='1' /></label>";
							echo "<input type='hidden' name='".$filed."' value='".$file."'/>";					
						}
					?>
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
</form>
