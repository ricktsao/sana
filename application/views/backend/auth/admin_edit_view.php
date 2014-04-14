<?php
	//showOutputBox("tinymce/tinymce_js_view");

	$group_html = '';	
	$group_row = '';
	for($i =0;$i<count($group_list);$i++)
	{
		$option_checked = '';
		if(array_key_exists("sys_admin_group",$edit_data)  &&  in_array($group_list[$i]["sn"], $edit_data["sys_admin_group"]))
		{
			$option_checked = 'checked';
		}
		
		$group_row .=
		'<td><input id="sys_admin_group" type="checkbox"  value="'.$group_list[$i]["sn"].'" '.$option_checked.' name="sys_admin_group[]">'.$group_list[$i]["name"].'</td>';
		if(($i+1)%3==0)
		{
			$group_html .='<tr>'.$group_row.'</tr>';
			$group_row = '';
		}
	}
	if(isNotNull($group_row))
	{
		$group_html .='<tr>'.$group_row.'</tr>';
	}
	
	$group_html = '<table style="border-collapse:collapse; width:480px;">'.$group_html.'</table>';
?>

<form action="<? echo bUrl("updateAdmin")?>" method="post"  id="update_form" class="contentEditForm">
   		<div id="option_bar">
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td >
						<button type="button" class='btn back' onclick="history.back()">	<?php echo $this -> lang -> line('common_return'); ?></button>	
						
					</td>
				</tr>
			</table>
		</div>
        <table width="100%" border="0" cellspacing="0" cellpadding="0" id='dataTable'>
          <tr>
            <td class="left"><span class="require">* </span><?php echo $this->lang->line("field_account");?>： </td>
            <td>
				<? if(tryGetArrayValue( 'sn',$edit_data)== ''){ ?>
				<input  name="id" type="text" class="inputs" value="<? echo tryGetArrayValue('id',$edit_data)?>" /><?php echo form_error('id');?>
				<? }else{ ?>
				<? echo tryGetArrayValue('id',$edit_data)?>
				<input type="hidden" name="id" value="<? echo tryGetArrayValue( 'id',$edit_data)?>" />
				<? } ?>
			</td>
          </tr>
		  <? if(tryGetArrayValue('sn', $edit_data)== ''){ ?>
          <tr>
            <td class="left"><span class="require">* </span><?php echo $this->lang->line("field_password");?>： </td>
            <td><input id="password" name="password" type="password" class="inputs" value="<? echo tryGetArrayValue('password',$edit_data)?>" /><? echo  form_error('password');   ?></td>
          </tr>
		  <? } ?>
		  
		  <tr style="display:none">
            <td class="left"><span class="require">* </span><?php echo $this->lang->line("field_email");?>：</td>
            <td><input id="email" name="email" type="text" class="inputs" value="<? echo tryGetArrayValue('email',$edit_data)?>" /><?php echo form_error('email');?></td>
          </tr>
          <tr style="display:none">
			<input type="hidden" name="sys_admin_group[]" value="2"  />
            <td class="left"><?php echo $this->lang->line("field_admin_belong_group");?>：</td>
            <td><? echo $group_html?><div class="message"><? echo  form_error('sys_admin_group')  ?></div></td>
          </tr>
          <tr>
            <td class="left">
                <span class="require">* </span><?php echo $this->lang->line("field_start_date");?>：
            </td>
            <td>            	
                <input name="start_date" type="text" class="inputs2" value="<? echo  showDateFormat(tryGetArrayValue( 'start_date',$edit_data))?>" onclick="WdatePicker()" />
                <div class="message"><? echo  form_error('start_date')  ?></div>
            </td>
          </tr>
		    <tr>
		        <td class="left">
		            <span class="require">* </span><?php echo $this->lang->line("field_end_date");?>：
		        </td>
		        <td>
		            <input name="end_date" type="text" class="inputs2" value="<? echo tryGetArrayValue('end_date',$edit_data)?>" onclick="WdatePicker()" />                    
		            <input name="forever" id="forever" value="1" type="checkbox"  <? echo tryGetArrayValue('forever',$edit_data)=='1'?"checked":"" ?>  />
		            <label for="forever" ><? echo $this->lang->line("field_forever");?></label>
		            <div class="message"><? echo  form_error('end_date');   ?></div>
		        </td>
		    </tr>
            <tr>
                <td class="left">
                    <?php echo $this->lang->line("field_launch");?>：
                </td>
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
</form>        
