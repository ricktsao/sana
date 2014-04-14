<?php
//showOutputBox("tinymce/tinymce_js_view");

$attributes = array('class' => 'form-horizontal', 'id' => 'myform');//update_form
echo form_open(getBackendUrl('update/'.tryGetArrayValue( 'sn', $edit_data)), $attributes);
$data = array('sn'=>tryGetArrayValue( 'sn', $edit_data));
echo form_hidden($data);
?>
	
    <div class="contentForm">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td class="left"><span class="require">* </span>標題：</td>
            <td>
            <?php
			$str_field='title';
            $data = array('id'=>$str_field, 'name'=>$str_field, 'value'=>tryGetArrayValue( $str_field,$edit_data), 'class'=>'input-large');
            echo form_input($data);
			echo form_error($str_field);
            ?>
            </td>
          </tr>
		   <tr>
            <td class="left"><span class="require">* </span>圖片：</td>
            <td>
           <?php 
            		$elements = array("no"=>1,"name"=>"filename");
            		showOutputBox("tools/pickup_img_view", array('elements'=>$elements)); 
            	?>
            	請選擇355*250px的圖檔
            	<div class="message"><? echo  form_error('filename')  ?></div>
            </td>
          </tr>
		   <tr>
            <td class="left"><span class="require">* </span>連結：</td>
            <td>
            <?php
			$str_field='url';
            $data = array('id'=>$str_field, 'name'=>$str_field, 'value'=>tryGetArrayValue( $str_field,$edit_data), 'class'=>'input-large');
            echo form_input($data);
			echo form_error($str_field);
            ?>
            </td>
          </tr>
          <tr>
            <td class="left"><span class="require">* </span>內容：</td>
            <td>
            <?php
			$str_field='content';
            $data = array('id'=>$str_field, 'name'=>$str_field, 'value'=>tryGetArrayValue( $str_field,$edit_data), 'class'=>'input-large', 'rows'=>'10', 'cols'=>'100');
            echo form_textarea($data);
            ?><?php echo form_error($str_field);   ?>
            </td>
          </tr>
          <tr>
            <td class="left"><span class="require">* </span><?php echo $this->lang->line('common_sort');?>：</td>
            <td>
            <?php
			$str_field='sort';
            $data = array('id'=>$str_field, 'name'=>$str_field, 'value'=>tryGetArrayValue( $str_field, $edit_data), 'class'=>'input-tiny');
            echo form_input($data);
            ?><?php echo form_error($str_field);   ?>
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
