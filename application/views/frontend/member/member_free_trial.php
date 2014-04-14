    <script language="JavaScript" type="text/javascript" src="<?php echo base_url();?>template/js/jquery.chainedSelects.js"></script>
    <script language="JavaScript" type="text/javascript">
	$(function()
	{
		
		$('#edu_level, #birthday_year, #birthday_month, #birthday_day').sp_select();

	    $('#country_sn').chainSelect('#location_county_sn',"<?php echo site_url('zh-tw/member/country_state_chained_selection') ?>",
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
	    $('#location_county_sn').chainSelect('#location_area_sn',"<?php echo site_url('zh-tw/member/country_state_chained_selection') ?>",
	    { 
	        before:function (target) 
	        { 
	            $("#loading").css("display","block");
	            $(target).css("display","none");
	        },
	        after:function (target) 
	        { 
	            $("#loading").css("display","none");
	            $(target).css("display","inline");
	        }
	    });
	});
    </script>

<style type="text/css">

#loading
{
    position:absolute;
    top:30px;
    right:0px;
    background:#ffbfbf;
    color:#fff;
    font-size:12px;
    font-familly: Arial;
    padding:2px;
    display:none;
}
</style>

		<?php
		$attributes = array('id' => 'form');
		echo form_open('zh-tw/member/free_trial_process', $attributes); 
		///  autocomplete="off" autocomplete="off"
		?>
        <div id="trial" class="form">
        	<div id="trialCaption">
            	<table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td class="img"><img src="<? echo base_url();?>template/images/trial/img_trial.jpg" alt="Free Trial" title="Free Trial"/></td>
                      <td><div class="content">First-time users who sign up online are entitled to one Free Trial. The Free Trial allows you to try all the Wells features at absolutely no charge.</div></td>
                    </tr>
				</table>                              
            </div>
            <div id="trialFrom">
            	<table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                    	<td class="col_1"><span class="require">* </span><?php echo $this->lang->line('field_member_chinese_name');?></td> 
                    	<td class="col_2">
		                <input class="inputs" id="chinese_name" name="chinese_name" type="text" value='<?php echo tryGetArrayValue('chinese_name', $edit_data);?>' />
				        <?php echo form_error('chinese_name');   ?>
						</td> 
                    	<td class="col_3"><?php echo $this->lang->line('field_member_sex');?></td> 
                    	<td class="col_4">
                        	<label for="male"><input type="radio" class="radio" name="gender" value="1" <?php echo set_radio('gender', "1", TRUE); ?> />&nbsp;&nbsp;<span class="gray fontSize_13">男</span></label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <label for="woman"><input type="radio" class="radio" name="gender" value="0" <?php echo set_radio('gender', "0"); ?> />&nbsp;&nbsp;<span class="gray fontSize_13">女</span></label>
							<?php echo form_error('gender');?>
                        </td> 
                    </tr>
                    <tr>
                    	<td class="col_1"><?php echo $this->lang->line('field_member_first_name');?></td> 
                    	<td class="col_2">
						<input class="inputs" id="first_name" name="first_name" type="text" value='<?php echo tryGetArrayValue('first_name', $edit_data);?>' autocomplete="off" />
						<?php echo form_error('first_name');?>
						</td> 
                    	<td class="col_3"><?php echo $this->lang->line('field_member_last_name');?></td> 
                    	<td class="col_4">
						<input class="inputs" id="last_name" name="last_name" type="text" value='<?php echo tryGetArrayValue('last_name', $edit_data);?>'  autocomplete="off" />
						<?php echo form_error('last_name');?>
						</td> 
                    </tr>
                    <tr>
                    	<td class="col_1"><span class="require">* </span><?php echo $this->lang->line('field_member_email');?></td> 
                    	<td colspan="3" class="col_noline">
						<input class="inputs" id="email" name="email" type="text" value='<?php echo tryGetArrayValue('email', $edit_data);?>' />
						<?php echo form_error('email');?>
						</td> 
                    </tr>
                    <tr>
                    	<td class="col_1"><span class="require">* </span><?php echo $this->lang->line('field_member_location');?></td> 
                    	<td colspan="3" class="col_noline" style="position:relative;z-index:25000;">
                            <?php
							//$js = 'id="location_country_sn"';
							//echo form_dropdown('location_country_sn', tryGetArrayValue('countries', $edit_data, array()), tryGetArrayValue('location_country_sn', $edit_data), $js);
							$countries = tryGetArrayValue('countries', $edit_data, array());
							$location_country_sn = tryGetArrayValue('location_country_sn', $edit_data, 0);
								echo "<SELECT name='location_country_sn' id='country_sn'>";
								foreach ($countries as $key=>$country) {
									if ($key == $location_country_sn) {
										echo "<option class='droplist' value=".$key." selected>".$country."</option>";
									} else {
										echo "<option class='droplist' value=".$key.">".$country."</option>";
									}
								}
								echo "</select>";
							?>
							<?php
							$default_location_county_sn = tryGetArrayValue('location_county_sn', $edit_data, 0);
							$default_location_county = tryGetArrayValue('default_location_county', $edit_data, array());
							if ( sizeof($default_location_county)>0 ){
								echo "<select name='location_county_sn' id='location_county_sn'>";
								foreach ($default_location_county as $key=>$county) {
									if ($county['sn'] == $default_location_county_sn) {
										echo "<option class='droplist' value=".$county['sn']." selected>".$county['name']."</option>";
									} else {
										echo "<option class='droplist' value=".$county['sn'].">".$county['name']."</option>";
									}
								}
								echo "</select>";
							} else {
								echo "<select name='location_county_sn' id='location_county_sn'><option class='droplist' value=0 selected>-- 城市 --</option></select>";
							}
							?>
							<?php
							$default_location_area_sn = tryGetArrayValue('location_area_sn', $edit_data, array());
							$default_location_area = tryGetArrayValue('default_location_area', $edit_data, array());
							if ( sizeof($default_location_area)>0 ){
								echo "<select name='location_area_sn' id='location_area_sn'>";
								foreach ($default_location_area as $key=>$area) {
									if ($area['sn'] == $default_location_area_sn) {
										echo "<option class='droplist' value=".$area['sn']." selected>".$area['name']."</option>";
									} else {
										echo "<option class='droplist' value=".$area['sn'].">".$area['name']."</option>";
									}
								}
								echo "</select>";
							} else {
								echo "<select name='location_area_sn' id='location_area_sn'><option class='droplist' value=0 selected>-- 鄉鎮市 --</option></select>";
							}
							?>
							<?php echo form_error('country_sn');?>
							<?php echo form_error('location_county_sn');?>
                        </td> 
                    </tr>
                    <tr>
                    	<td class="col_1"><?php echo $this->lang->line('field_member_birthday');?></td> 
                    	<td colspan="3" class="col_noline" style="position:relative;z-index:20000;">
						<?php
						// 生日-年
						$year_dropdown = form_dropdown('birthday_year', $years, tryGetArrayValue('birthday_year', $edit_data), 'id="birthday_year"');
						$year_dropdown = str_ireplace('<option ', '<option class="droplist" ', $year_dropdown);
						echo $year_dropdown.'<div style="float:left"></div>';//
						
						// 生日-月
						$month_dropdown = form_dropdown('birthday_month', $months, tryGetArrayValue('birthday_month', $edit_data), 'id="birthday_month"');
						$month_dropdown = str_ireplace('<option ', '<option class="droplist" ', $month_dropdown);
						echo $month_dropdown.'<div style="float:left"></div>';//
						
						// 生日-日
						$day_dropdown = form_dropdown('birthday_day', $days, tryGetArrayValue('birthday_day', $edit_data), 'id="birthday_day"');
						$day_dropdown = str_ireplace('<option ', '<option class="droplist" ', $day_dropdown);
						echo $day_dropdown.'<div style="float:left"></div>';//
						?>
						<? echo  form_error('birthday');?>
                        </td> 
                    </tr>
                    <tr>
                    	<td class="col_1"><?php echo $this->lang->line('field_member_education');?></td> 
                    	<td colspan="3" class="col_noline">
						<?php
						$edu_dropdown = form_dropdown('edu_level', $edus, tryGetArrayValue('edu_level', $edit_data), 'id="edu_level"');
						$edu_dropdown = str_ireplace('<option ', '<option class="droplist" ', $edu_dropdown);
						echo $edu_dropdown;
						?>
						<? echo  form_error('edu_level');?>
                        </td> 
                    </tr>
                    <tr>
                    	<td class="col_1"><span class="require">* </span><?php echo $this->lang->line('field_member_mobile');?></td> 
                    	<td class="col_2">
						<input class="inputs" id="mobile" name="mobile" type="text" value='<?php echo tryGetArrayValue('mobile', $edit_data);?>' />
						<?php echo form_error('mobile');?>
						</td> 
                    	<td class="col_3"><?php echo $this->lang->line('field_member_tel');?></td> 
                    	<td class="col_4">
						<input class="inputs" id="tel" name="tel" type="text" value='<?php echo tryGetArrayValue('tel', $edit_data);?>' />
						<?php echo form_error('tel');?> 
						</td> 
                    </tr>
                    <tr>
                    	<td class="col_1"><?php echo $this->lang->line('field_member_other_tel');?></td> 
                    	<td colspan="3" class="col_noline">
						<input class="inputs" id="tel_other" name="tel_other" type="text" value='<?php echo tryGetArrayValue('tel_other', $edit_data);?>' />
						<?php echo form_error('tel_other');?>
						</td> 
                    </tr>
                    <tr>
                    	<td class="col_1 last"><?php echo $this->lang->line('field_member_affiliate_email');?></td> 
                    	<td colspan="3" class="col_noline last">
						<input class="inputs" id="affiliate_email" name="affiliate_email" type="text" value='<?php echo tryGetArrayValue('affiliate_email', $edit_data);?>' />
						<?php echo form_error('affiliate_email');?>
						</td> 
                    </tr>
				</table> 
            </div>
            <div class="submit">
            	<input type="submit" name="submit" class="btn" value="<?php echo $this->lang->line('common_submit');?>">
            	<input value="Cancel" type="submit" class="btn" />
                <div class="clear"></div>
            </div> 
        </div>  
      	</form>