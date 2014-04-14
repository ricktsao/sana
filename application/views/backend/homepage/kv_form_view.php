<form action="<? echo getBackendUrl("updateKv")?>" method="post"  id="update_form" >
    <div class="contentForm">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">

          <tr>
            <td class="left"><span class="require">* </span><?php echo $this->lang->line('field_kv_img');?>：</td>
            <td>
            	<?php 
            		$elements = array("no"=>1,"name"=>"filename");
            		showOutputBox("tools/pickup_img_view", array('elements'=>$elements)); 
            	?>
            	請選擇1196*890px的圖檔
            	<div class="message"><? echo  form_error('filename')  ?></div>
            </td> 
            <?php
            /*           
            <tr>
			    <td class="left">
			        <?php echo $this->lang->line('common_url');?>：
			    </td>
			    <td>
			        <input id="url" name="url" type="text" class="inputs" value="<? echo tryGetArrayValue('url',$edit_data)?>" />                   
			    </td>
			</tr>
          	<tr>
			    <td class="left">
			        <?php echo $this->lang->line('common_target_type');?>：
			    </td>
			    <td>
			        <?php echo link_target_radio("target",tryGetArrayValue('target',$edit_data,0));?>                    
			    </td>
			</tr>
         	*/
         	?>
			<tr>
            <td class="left">
                <span class="require">* </span><?php echo $this->lang->line('field_start_date');?>：
            </td>
            <td>            	
                <input name="start_date" type="text" class="inputs2" value="<? echo  showDateFormat(tryGetArrayValue( 'start_date',$edit_data))?>" onclick="WdatePicker()" />
                <div class="message"><? echo  form_error('start_date')  ?></div>
            </td>
          </tr>
		    <tr>
		        <td class="left">
		            <span class="require">* </span><?php echo $this->lang->line('field_end_date');?>：
		        </td>
		        <td>
		            <input name="end_date" type="text" class="inputs2" value="<? echo tryGetArrayValue('end_date',$edit_data)?>" onclick="WdatePicker()" />                    
		            <input name="forever" id="forever" value="1" type="checkbox" class="middle" <? echo tryGetArrayValue('forever',$edit_data)=='1'?"checked":"" ?>  /><label for="forever" class="middle">永久啟用</label>
		            <div class="message"><? echo  form_error('end_date');   ?></div>		            
		        </td>
		    </tr>
            <tr>
                <td class="left">
                    <?php echo $this->lang->line('common_launch');?>：
                </td>
                <td>
                    <input name="launch" id="launch" value="1" type="checkbox" <? echo tryGetArrayValue('launch',$edit_data)=='1'?"checked":"" ?> />勾選啟用
                </td>
            </tr>   
          <tr>
			

          <tr>
            <td class="left"><span class="require">* </span><?php echo $this->lang->line('common_sort');?>：</td>
            <td>
            <?php
            $data = array('id'=>'sort', 'name'=>'sort', 'value'=>tryGetArrayValue('sort', $edit_data), 'class'=>'input-tiny');
            echo form_input($data);
            ?><?php echo form_error('sort');   ?>
            </td>
          </tr>
			 
          <tr>
            <td class="left">&nbsp;</td>
            <td>
            	<input value="<?php echo $this->lang->line('common_save');?>"   type="submit" class="btn" />
            	<input value="<?php echo $this->lang->line('common_cancel');?>" type="button" class="btn" onclick="window.location='<? echo getBackendUrl("kvs") ?>'" />
            </td>
          </tr>
        </table>
    </div>
    <input type="hidden" name="sn" value="<? echo tryGetArrayValue( 'sn',$edit_data)?>" />
</form>        
   