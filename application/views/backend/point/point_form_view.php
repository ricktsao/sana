<form action="<? echo getBackendUrl("updatePoint")?>" method="post"  id="update_form" >
    <div class="contentForm">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
		  <tr>
		  	
            <td class="left"><span class="require">* </span><?php echo $this->lang->line('field_point_id');?>：</td>
            <td>
            	<? if(tryGetArrayValue( 'sn',$edit_data)== ''){ ?>
            	<input id="point_id" name="point_id" type="text" class="inputs" value="<? echo tryGetArrayValue('point_id',$edit_data)?>" /><?php echo form_error('point_id');?>
            	<? }else{ ?>
				<? echo tryGetArrayValue('point_id',$edit_data)?>
				<input type="hidden" name="point_id" value="<? echo tryGetArrayValue('point_id',$edit_data)?>" />
				<? } ?>
            </td>
          </tr>
          <tr>
            <td class="left"><span class="require">* </span><?php echo $this->lang->line('field_point_title');?>：</td>
            <td><input id="title" name="title" type="text" class="inputs" value="<? echo tryGetArrayValue('title',$edit_data)?>" /><?php echo form_error('title');?></td>
          </tr>          
          <tr>
            <td class="left"><span class="require">* </span><?php echo $this->lang->line('field_point_value');?>：</td>
            <td><input id="point_value" name="point_value" type="text" class="inputs" value="<? echo tryGetArrayValue('point_value',$edit_data)?>" /><?php echo form_error('point_value');?></td>
          </tr>          
          <tr>
            <td class="left"><?php echo $this->lang->line('field_point_description');?>：</td>
            <td><textarea name="description" class="textarea"></textarea><?php echo form_error('description');?></td>
          </tr>          
			<tr>
			    <td class="left">
			        <?php echo $this->lang->line('common_launch');?>：
			    </td>
			    <td>
			        <input name="launch" id="launch" value="1" type="checkbox" <? echo tryGetArrayValue('launch',$edit_data)=='1'?"checked":"" ?> />                    
			    </td>
			</tr>   
          <tr>
            <td class="left">&nbsp;</td>
            <td>
            	<input value="<?php echo $this->lang->line('common_save');?>"   type="submit" class="btn" />
            	<input value="<?php echo $this->lang->line('common_cancel');?>" type="button" class="btn" onclick="window.location='<? echo getBackendUrl("points") ?>'" />
            </td>
          </tr>
        </table>
    </div>
    <input type="hidden" name="sn" value="<? echo tryGetArrayValue( 'sn',$edit_data)?>" />
</form>        
   