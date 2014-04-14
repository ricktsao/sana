    <script language="JavaScript" type="text/javascript" src="<?php echo base_url();?>template/js/jquery.chainedSelects.js"></script>
    <script language="JavaScript" type="text/javascript">
	$(function()
	{
	    $('select[name=location_county_sn]').chainSelect('select[name=location_area_sn]',"<?=base_url()?>member/country_state_chained_selection",
	    { 
	        before:function (target) //before request hide the target combobox and display the loading message
	        { 
	            $("#loading").css("display","block");
	            $(target).css("display","none");
	        },
	        after:function (target) //after request show the target combobox and hide the loading message
	        { 
	            $("#loading").css("display","none");
	            $(target).css("display","inline");
	        }
	    });
		
		$('select[name=location_area_sn]').change(function()
		{
			$.ajax({
				'method':'get',
				'url':'<?=base_url()?>member/location_area_selection',
				'data':'sn='+$(this).val(),
				'success':function(data){
					if(data!=''){
						$("input[name=zip_code]").val(data);
					}
					else
					{
						$("input[name=zip_code]").val('郵遞區號');
					}
				}
			});
		}).trigger('change');
	});
    </script>

	<style type="text/css">
	#loading
	{
		position:absolute;
		top:0px;
		right:0px;
		background:#ff0000;
		color:#fff;
		font-size:14px;
		font-familly: Arial;
		padding:2px;
		display:none;
	}
	</style>

<form action="<? echo getBackendUrl("updateMember")?>" method="post"  id="update_form" >
    <div class="contentForm">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">

		<? if(tryGetArrayValue('sn', $edit_data, 0) > 0)
		{ ?>
			
		  <tr>
            <td class="left"><?php echo $this->lang->line('field_account');?>： </td>
            <td>
				<? echo tryGetArrayValue('email',$edit_data, NULL)?>
				<input id="email" name="email" type="hidden" class="inputs" value="<? echo tryGetArrayValue('email',$edit_data, NULL)?>" />
			</td>
          </tr>
          <?php
          /*
          <tr>
            <td class="left"><?php echo $this->lang->line('field_member_password');?>： </td>
            <td><input id="password" name="password" type="password" class="inputs" value="" /><? echo  form_error('password');   ?>
			</td>
          </tr>


          <tr>
            <td class="left"><?php echo $this->lang->line('field_member_passconf');?>： </td>
            <td><input id="passconf" name="passconf" type="password" class="inputs" value="" />
			</td>
          </tr>
		   * 
		   */
		   ?>

		<?php
		} else { ?>
			
		  <tr>
            <td class="left"><span class="require">* </span><?php echo $this->lang->line('field_account');?>： </td>
            <td>
				<input id="email" name="email" type="text" class="inputs" value="<? echo tryGetArrayValue('email',$edit_data, NULL)?>" />
				<?php echo form_error('email');?>
			</td>
          </tr>

          <tr>
            <td class="left"><span class="require">* </span><?php echo $this->lang->line('field_member_password');?>： </td>
            <td><input id="password" name="password" type="password" class="inputs" value="" /><? echo  form_error('password');   ?>
			</td>
          </tr>


          <tr>
            <td class="left"><span class="require">* </span><?php echo $this->lang->line('field_member_passconf');?>： </td>
            <td><input id="passconf" name="passconf" type="password" class="inputs" value="" />
			</td>
          </tr>

		<?php } ?>
          <tr>
            <td class="left"><span class="require">* </span><?php echo $this->lang->line('field_member_chinese_name');?>：</td>
            <td><input id="name" name="name" type="text" class="inputs" value="<?php echo tryGetArrayValue('name',$edit_data)?>" /><?php echo form_error('name');?></td>
          </tr>
          <tr>
            <td class="left"><?php echo $this->lang->line('field_member_sex');?>：</td>
            <td>
				<?php echo formArraySet(array(1=>'男',0=>'女'),'sex','radio',tryGetArrayValue('sex',$edit_data)); echo form_error('sex');?>
            	<?php echo form_error("sex");?>
            </td>
          </tr>
          <tr>
            <td class="left"><span class="require">* </span><?php echo $this->lang->line('field_member_address');?>：</td>
            <td>
            	<?php
				echo formArraySet($countries,'location_county_sn','select',tryGetArrayValue('location_county_sn',$edit_data),NULL,'請選擇縣市');
				
				if(tryGetArrayValue('location_county_sn',$edit_data))
				{
					echo formArraySet($area,'location_area_sn','select',tryGetArrayValue('location_area_sn',$edit_data),NULL,'-- 鄉鎮市 --');	
				}
				else
				{
				?>
				<select name="location_area_sn">
				<option value ="">鄉/市/鎮/區</option>
				</select>
                <?php
				}
				?>
				<input name="zip_code" type="text" value="郵遞區號" size="8" style="color:#b4b4b4;">
				<input name="address" maxlength="300" size="30" value="<?php echo tryGetArrayValue('address',$edit_data); ?>">
                <?php echo form_error('zip_code');?>
                <?php echo form_error('address');?>
            </td>
          </tr>
          <tr>
            <td class="left"><span class="require">* </span><?php echo $this->lang->line('field_member_mobile');?>：</td>
            <td><input id="mobile" name="mobile" type="text" class="inputs" value="<? echo tryGetArrayValue('mobile',$edit_data)?>" /><?php echo form_error('mobile');?></td>
          </tr>
          <tr>
            <td class="left"><?php echo $this->lang->line('field_member_tel');?>：</td>
            <td><input id="tel" name="tel" type="text" class="inputs" value="<? echo tryGetArrayValue('tel',$edit_data)?>" /><?php echo form_error('tel');?></td>
          </tr>
          <tr>
            <td class="left">
                <span class="require">* </span><?php echo $this->lang->line('field_start_date');?>：
            </td>
            <td>            	
                <input name="start_date" type="text" class="inputs2" value="<? echo  showDateFormat(tryGetArrayValue( 'start_date',$edit_data))?>" onclick="WdatePicker()" />
                <? echo  form_error('start_date')  ?>
            </td>
          </tr>
		    <tr>
		        <td class="left">
		            <span class="require">* </span><?php echo $this->lang->line('field_end_date');?>：
		        </td>
		        <td>
		            <input name="end_date" type="text" class="inputs2" value="<? echo tryGetArrayValue('end_date',$edit_data)?>" onclick="WdatePicker()" />                    
		            <input name="forever" id="forever" value="1" type="checkbox" class="middle" <? echo tryGetArrayValue('forever',$edit_data)=='1'?"checked":"" ?>  /><label for="forever" class="middle">永久發佈</label>
		            <? echo  form_error('end_date');   ?>            
		        </td>
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
                <td class="left">
                    獲得資訊管道：
                </td>
                <td>
                    <?php echo formArraySet($source,'source','radio',tryGetArrayValue('source',$edit_data)); ?>
                    <div style="clear:both"></div>
                    <label><input name="source" type="radio" <?php echo tryGetArrayValue('source_web',$edit_data)==''?'':'checked';?>>網站</label><input name="source_web" maxlength="50" size="15" value="<?php echo tryGetArrayValue('source_web',$edit_data); ?>">
                    <label><input name="source" type="radio" <?php echo tryGetArrayValue('source_other',$edit_data)==''?'':'checked';?>>其他</label><input name="source_other" maxlength="50" size="15" value="<?php echo tryGetArrayValue('source_other',$edit_data); ?>" />                    
                </td>
            </tr>
            <tr>
			<td class="left">運動方式<br><span class="glay">(可複選)</span>
			</td>
			<td>
                <?php
				echo formArraySet($sport_method,'sport_method[]','checkbox',tryGetArrayValue('sport_method',$edit_data));
				?>
			</td>
			</tr><tr>
			<td class="left">喜愛的運動方式：<br><span class="glay">(可輸入50個中文字)</span></td>
			<td><textarea rows="2" cols="40" name="sport_note"><?php echo tryGetArrayValue('sport_note',$edit_data); ?></textarea></td>
			</tr><tr>
			<td class="left">運動頻率：</td>
			<td><label style="float:left">每周運動次數</label><span class="radio"><?php echo formArraySet($sport_rate,'sport_rate','radio',tryGetArrayValue('sport_rate',$edit_data)); ?></span></td>
			</tr><tr>
			<td class="left">運動長度：</td>
			<td><label style="float:left">每次運動時間</label><span class="radio"><?php echo formArraySet($sport_period,'sport_period','radio',tryGetArrayValue('sport_period',$edit_data)); ?></span></td>
			</tr><tr>
			<td class="left">運動時段：</td>
			<td><label style="float:left">常運動時段點</label><span class="radio"><?php echo formArraySet($sport_time,'sport_time','radio',tryGetArrayValue('sport_time',$edit_data)); ?></span></td>
			</tr><tr>
          <tr>
            <td class="left">&nbsp;</td>
            <td>
            	<input value="<?php echo $this->lang->line('common_save');?>"   type="submit" class="btn" />
            	<input value="<?php echo $this->lang->line('common_cancel');?>" type="button" class="btn" onclick="window.location='<? echo getBackendUrl("members") ?>'" />
            </td>
          </tr>
        </table>
    </div>
    <input type="hidden" name="sn" value="<? echo tryGetArrayValue( 'sn',$edit_data)?>" />
</form>        
   