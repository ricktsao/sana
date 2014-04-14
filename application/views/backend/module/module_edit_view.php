<form action="<? echo $url['action']?>" method="post"  id="update_form" class="contentEditForm" >
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
				<td class="left"><span class="require">* </span>module名稱</td>
				<td> <? $filed='title'?>
				<input  name="<? echo $filed?>" type="text" class="inputs" value="<? echo tryGetArrayValue($filed,$edit_data,"")?>" />
				<?php echo form_error($filed); ?></td>
			</tr>
			<tr>
				<td class="left"><span class="require">* </span>module別名</td>
				<td> <? $filed='id'?>
				<input  name="<? echo $filed?>" type="text" class="inputs" value="<? echo tryGetArrayValue($filed,$edit_data)?>" />
				<?php echo form_error($filed); ?></td>
			</tr>
			<tr>
				<td class="left"><span class="require">* </span>module 群組</td>
				<td> <? $filed='module_category'?>
				<select  name="<? echo $filed?>" >
					<? dprint(tryGetArrayValue($filed,$edit_data))?>
					<? foreach($module_category as $key=>$value){
							
						
						
						echo "<option value='".$value['sn']."' ".inputCheck($value['sn'],tryGetArrayValue("module_category_sn",$edit_data)).">".$value['title']."</option>";
					}?>
				</select>
				<?php echo form_error($filed); ?></td>
			</tr>
			<tr>
				<td class="left"><span class="require">* </span>排序</td>
				<td> <? $filed='sort'?>
				<input  name="<? echo $filed?>" type="text" class="inputs" value="<? echo tryGetArrayValue($filed,$edit_data)?>" />
				<?php echo form_error($filed); ?></td>
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
		
	<input type="hidden" name="sn" value="<? if($copy=='0'){ echo tryGetArrayValue('sn', $edit_data);}?>" />
</form>
