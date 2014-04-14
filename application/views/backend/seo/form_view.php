<?php
$attributes = array('class' => 'form-horizontal', 'id' => 'myform');//update_form
echo form_open(getBackendUrl('update/'.tryGetArrayValue( 'sn', $edit_data)), $attributes);
$data = array('sn'=>tryGetArrayValue( 'sn', $edit_data));
echo form_hidden($data);
?>
	
    <div class="contentForm">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
          	<td class="left">SEO類別：</td>
            <td><?php echo $edit_data['class_name']; ?></td>
          </tr>
          <tr>
            <td class="left"><span class="require">* </span>標題(title)：</td>
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
            <td class="left"><span class="require">* </span>關鍵字(keyword)：</td>
            <td>
            <?php
			$str_field='keywords';
            $data = array('id'=>$str_field, 'name'=>$str_field, 'value'=>tryGetArrayValue( $str_field,$edit_data), 'class'=>'input-large', 'rows'=>'10', 'cols'=>'100');
            echo form_input($data);
            ?><?php echo form_error($str_field);   ?>
            </td>
          </tr>
          
          <tr>
            <td class="left"><span class="require">* </span>內文描述(description)：</td>
            <td>
            <?php
			$str_field='description';
            $data = array('id'=>$str_field, 'name'=>$str_field, 'value'=>tryGetArrayValue( $str_field,$edit_data), 'class'=>'input-large', 'rows'=>'10', 'cols'=>'100');
            echo form_input($data);
            ?><?php echo form_error($str_field);   ?>
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
