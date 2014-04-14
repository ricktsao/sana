<?php showOutputBox("tinymce/tinymce_js_view", array('elements' => 'instruction, experience'));

$attributes = array('class' => 'form-horizontal', 'id' => 'myform');
//update_form
echo form_open(getBackendUrl('updateTeacher/' . tryGetArrayValue('sn', $edit_data)), $attributes);
$data = array('sn' => tryGetArrayValue('sn', $edit_data));
echo form_hidden($data);
?>
	
    <div class="contentForm">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
        	
          <tr>
            <td class="left"><span class="require">* </span><?php echo $this -> lang -> line('field_teacher_email'); ?>：</td>
            <td>
            <?php $data = array('id' => 'teacher_email', 'name' => 'teacher_email', 'value' => tryGetArrayValue('teacher_email', $edit_data), 'class' => 'input-small');
			echo form_input($data);
			echo form_error("teacher_email");
            ?>
            </td>
          </tr>
          
          <tr>
            <td class="left"><span class="require">* </span><?php echo $this -> lang -> line('field_teacher_english_name'); ?>：</td>
            <td>
            <?php $data = array('id' => 'teacher_english_name', 'name' => 'teacher_english_name', 'value' => tryGetArrayValue('teacher_english_name', $edit_data), 'class' => 'input-small');
			echo form_input($data);
			echo form_error("teacher_english_name");
            ?>
            </td>
          </tr>
          <tr>
            <td class="left"><?php echo $this -> lang -> line('field_teacher_chinese_name'); ?>：</td>
            <td>
            <?php $data = array('id' => 'teacher_chinese_name', 'name' => 'teacher_chinese_name', 'value' => tryGetArrayValue('teacher_chinese_name', $edit_data), 'class' => 'input-small');
			echo form_input($data);
			echo form_error("teacher_chinese_name");
            ?>
            </td>
          </tr>
          
          <tr>
            <td class="left"><?php echo $this -> lang -> line('field_teacher_password'); ?>：</td>
            <td>
            <?php $data = array('id' => 'teacher_password', 'name' => 'teacher_password', 'value' => "", 'class' => 'input-small');
			echo form_input($data);
			echo form_error("teacher_password");
            ?>
            </td>
          </tr>
          <tr>
            <td class="left"><?php echo $this -> lang -> line('field_teacher_passconf'); ?>：</td>
            <td>
            <?php $data = array('id' => 'teacher_passconf', 'name' => 'teacher_passconf', 'value' => "", 'class' => 'input-small');
			echo form_input($data);
			echo form_error("teacher_passconf");
            ?>
            </td>
          </tr>
          
          <tr>
            <td class="left"><?php echo $this -> lang -> line('field_teacher_picture'); ?>：</td>
            <td>
            	<?php 
            	$elements = array("no"=>1, "name"=>"teacher_picture");
            	showOutputBox("tools/pickup_img_view", array('elements'=>$elements)); 
            	?>
            </td>
          </tr>
          

          <tr>
            <td class="left"><?php echo $this -> lang -> line('field_gender'); ?>：</td>
            <td>
            <?php echo gender_radio('teacher_gender', (int) tryGetArrayValue('teacher_gender', $edit_data)); ?><?php //echo form_error('teacher_picture'); ?>
            </td>
          </tr>

          <tr>
            <td class="left"><?php echo $this -> lang -> line('field_teacher_sign'); ?>：</td>
            <td>
            <?php echo sign_dropdown('teacher_sign', tryGetArrayValue('teacher_sign', $edit_data)); ?>
            </td>
          </tr>
          
          
          <tr>
            <td class="left"><?php echo $this -> lang -> line('field_teacher_nationality'); ?>：</td>
            <td>
            <?php echo country_dropdown('teacher_nationality', array('TW', 'US', 'CA', 'GB', 'DE', 'BR', 'IT', 'ES', 'AU', 'NZ', 'HK'), tryGetArrayValue('teacher_nationality', $edit_data)); ?><?php echo form_error("teacher_nationality"); ?>
            </td>
          </tr>
          <tr>
            <td class="left"><?php echo $this -> lang -> line('field_teacher_instruction'); ?>：</td>
            <td>
            <?php $data = array('id' => 'instruction', 'name' => 'teacher_instruction', 'value' => tryGetArrayValue('teacher_instruction', $edit_data), 'rows' => '10', 'cols' => '100');
			echo form_textarea($data);
            ?><?php echo form_error('teacher_instruction'); ?>
            </td>
          </tr>
          <tr>
            <td class="left"><?php echo $this -> lang -> line('field_teacher_experience'); ?>：</td>
            <td>
            <?php $data = array('id' => 'experience', 'name' => 'teacher_experience', 'value' => tryGetArrayValue('teacher_experience', $edit_data), 'rows' => '10', 'cols' => '100');
			echo form_textarea($data);
            ?><?php echo form_error('teacher_experience'); ?>
            </td>
          </tr>


          <tr>
            <td class="left">
                <span class="require">* </span><?php echo $this -> lang -> line('field_start_date'); ?>：
            </td>
            <td>            	
                <input name="start_date" type="text" class="inputs2" value="<? echo showDateFormat(tryGetArrayValue( 'start_date', $edit_data))?>" onclick="WdatePicker()" />
                <div class="message"><? echo  form_error('start_date')  ?></div>
            </td>
          </tr>
		    <tr>
		        <td class="left">
		            <span class="require">* </span><?php echo $this -> lang -> line('field_end_date'); ?>：
		        </td>
		        <td>
		            <input name="end_date" type="text" class="inputs2" value="<? echo tryGetArrayValue('end_date', $edit_data)?>" onclick="WdatePicker()" />                    
		            <input name="forever" id="forever" value="1" type="checkbox" class="middle" <? echo tryGetArrayValue('forever',$edit_data)=='1'?"checked":"" ?>  /><label for="forever" class="middle">永久發佈</label>
		            <div class="message"><? echo form_error('end_date'); ?></div>		            
		        </td>
		    </tr>
            <tr>
                <td class="left">
                    <?php echo $this -> lang -> line('common_launch'); ?>：
                </td>
                <td>
                    <input name="launch" id="launch" value="1" type="checkbox" <? echo tryGetArrayValue('launch', $edit_data)=='1'?"checked":"" ?> />                    
                </td>
            </tr>   

          <tr>
            <td class="left">
                <span class="require">* </span><?php echo $this -> lang -> line('common_sort'); ?>：
            </td>
            <td>            	
                <input name="sort" type="text" class="inputs2" value="<? echo tryGetArrayValue( 'sort', $edit_data)?>" /><?php echo $this -> lang -> line('common_sort_note'); ?>
                <div class="message"><? echo  form_error('sort')  ?></div>
            </td>
          </tr>
          
          <tr>
            <td class="left">&nbsp;</td>
            <td>
            <input type="reset" class="btn" id="reset" value="<?php echo $this -> lang -> line('common_reset'); ?>">
            <input type="submit" class="btn" id="submit" value="<?php echo $this -> lang -> line('common_submit'); ?>">
            	</td>
          </tr>
    </table>
	</div>
    </form>

	<p class="footer">Page rendered in <strong>{elapsed_time}</strong> seconds</p>
