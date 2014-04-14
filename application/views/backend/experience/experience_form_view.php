<?php
showOutputBox("tinymce/tinymce_js_view");

$attributes = array('class' => 'form-horizontal', 'id' => 'myform');//update_form
echo form_open(getBackendUrl('updateExperience/'.tryGetArrayValue( 'sn', $edit_data)), $attributes);
$data = array('sn'=>tryGetArrayValue( 'sn', $edit_data));
echo form_hidden($data);
?>
	
    <div class="contentForm">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td class="left"><span class="require">* </span><?php echo $this->lang->line('field_user_name');?>：</td>
            <td>
            <?php
            $data = array('id'=>'user_name', 'name'=>'user_name', 'value'=>tryGetArrayValue( 'user_name',$edit_data), 'class'=>'input-large');
            echo form_input($data);
			echo form_error("user_name");
            ?>
            </td>
          </tr>
          <tr>
            <td class="left"><span class="require">* </span><?php echo $this->lang->line('field_content');?>：</td>
            <td>
            <?php
            $data = array('id'=>'content', 'name'=>'content', 'value'=>tryGetArrayValue( 'content', $edit_data), 'class'=>'input-large', 'rows'=>'10', 'cols'=>'100');
            echo form_textarea($data);
            ?><?php echo form_error('content');   ?>
            </td>
          </tr>
          <tr>
            <td class="left"><span class="require">* </span><?php echo $this->lang->line('common_sort');?>：</td>
            <td>
            <?php
            $data = array('id'=>'sort', 'name'=>'sort', 'value'=>tryGetArrayValue( 'sort', $edit_data), 'class'=>'input-tiny');
            echo form_input($data);
            ?><?php echo form_error('sort');   ?>
            </td>
          </tr>

          <tr>
            <td class="left">
                <span class="require">* </span><?php echo $this->lang->line('field_start_date');?>：
            </td>
            <td>            	
                <input name="start_date" type="text" class="inputs2" value="<? echo showDateFormat(tryGetArrayValue( 'start_date', $edit_data))?>" onclick="WdatePicker()" />
                <div class="message"><? echo  form_error('start_date')  ?></div>
            </td>
          </tr>
		    <tr>
		        <td class="left">
		            <span class="require">* </span><?php echo $this->lang->line('field_end_date');?>：
		        </td>
		        <td>
		            <input name="end_date" type="text" class="inputs2" value="<? echo tryGetArrayValue('end_date', $edit_data)?>" onclick="WdatePicker()" />                    
		            <input name="forever" id="forever" value="1" type="checkbox" class="middle" <? echo tryGetArrayValue('forever',$edit_data)=='1'?"checked":"" ?>  /><label for="forever" class="middle">永久發佈</label>
		            <div class="message"><? echo form_error('end_date');   ?></div>		            
		        </td>
		    </tr>
            <tr>
                <td class="left">
                    <?php echo $this->lang->line('common_launch');?>：
                </td>
                <td>
                    <input name="launch" id="launch" value="1" type="checkbox" <? echo tryGetArrayValue('launch', $edit_data)=='1'?"checked":"" ?> />                    
                </td>
            </tr>   
          <tr>
            <td class="left">&nbsp;</td>
            <td>
            <input type="reset" class="btn" id="reset" value="<?php echo $this->lang->line('common_reset');?>">
            <input type="submit" class="btn" id="submit" value="<?php echo $this->lang->line('common_submit');?>">
            	</td>
          </tr>
    </table>
	</div>
    </form>

	<p class="footer">Page rendered in <strong>{elapsed_time}</strong> seconds</p>
