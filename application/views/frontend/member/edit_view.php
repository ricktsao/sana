<script>
	
	$(function(){
				
		sub_navi();
	
	
		$('.pimg_area').find('img').each(function(){
												  
				var nSrc=$(this).attr('src')+"?"+new Date().getTime();
				$(this).attr('src',nSrc);
				$(this).load(function(){
					var px=$(this).parent().width()/2-$(this).width()/2;				
					var py=$(this).parent().height()/2-$(this).height()/2;
					
					$(this).css({'top':py+"px",
								'left':px+"px"});				  
				})			
				
		});
		
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
		
	})
	
</script>
		<!-- 左側區塊 -->
		<div id='secondary'>
			<div id='sub_title' class='sub_nav_sprite'> 會員區 </div>
			<!-- 左側選單 -->
			<ul id='sub_navi' class='sub_nav_sprite'>
            	<li><a href='javascript:void(0)'><span class='sub_nav_sprite'></span>會員資料</a>
					<div class='sub_nav_sprite'></div>
                        <ul>
							<?php
							foreach($left_side["is_login"] as $key=>$val)
							{
							?>
							<li><a href="<?php echo getFrontendControllerUrl('member',$key);?>" class='sub_nav_sprite'><span class="sub_nav_sprite"></span><?php echo $val;?></a></li>
							<?php
							}
							?>
						</ul>
					<div class='sub_nav_sprite'></div>
				</li>
                <li><a href='javascript:void(0)'><span class='sub_nav_sprite'></span>交易紀錄</a>
                    <div class='sub_nav_sprite'></div>
                        <ul style="display:none">
                        	<?php
							foreach($left_side["sale"] as $key=>$val)
							{
							?>
                            <li><a href='<?php echo getFrontendControllerUrl('member',$key);?>' class='sub_nav_sprite'><span class='sub_nav_sprite'></span><?php echo $val;?></a></li>
                            <?php
							}
							?>
                        </ul>
                    <div class='sub_nav_sprite'></div>
                </li>
			</ul>
            <div id='sub_list_foot' class='sub_nav_sprite'></div>

			<!-- Banners -->
			<ul id='links'>
				<? echo $activity_btn ?>
			</ul>
		</div>
	
		<!-- 主要內容區塊 -->
        <form action="<?php echo getFrontendControllerUrl('member','update');?>" method="post">
        <input type="hidden" name="sn" value="<?php echo tryGetArrayValue('sn',$edit_data);?>" />
		<div id='primary'>
			<div id='breadCrumb'>
				<span id='home_icon'></span> / <span>會員專區</span>
			</div>
			<div id='title'>
				<span></span>會員資料修改
			</div>
			<div id="register">
			<table width="100%" cellpadding="0" cellspacing="0">
			<tr>
			<td>&nbsp;</td>
			<td>『<span>*</span>』為必填欄位</td>
			</tr>
            <tr>
                <td class="register_first"><span>*</span>email帳號</td>
                <td class="register_sercond"><?php echo tryGetArrayValue('email',$edit_data); ?></td>
			</tr>
            <tr>
                <td class="register_first"><span>*</span>姓名(您的本名)</td>
                <td class="register_sercond"><?php echo tryGetArrayValue( 'name',$edit_data); ?></td>
			</tr>
            <tr>
			<td class="register_first"><span>*</span>性別</td>
			<td class="register_sercond"><?php echo tryGetArrayValue('sex',$edit_data)=='1'?'男':'女';?></td>
			</tr><tr>
			<td class="register_first"><span>*</span>居住地</td>
			<td class="register_sercond">
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
			</tr><tr>
			<td class="register_first">聯絡電話</td>
			<td class="register_sercond"><input name="tel" maxlength="30" value="<?php echo tryGetArrayValue('tel',$edit_data); ?>"></td>
			</tr><tr>
			<td class="register_first"><span>*</span>行動電話</td>
			<td class="register_sercond"><input name="mobile" maxlength="30" value="<?php echo tryGetArrayValue('mobile',$edit_data); ?>"><?php echo form_error('mobile');?></td>
			</tr><tr>
			<td class="register_first"><span>*</span>您經由何種管道得到Sole的資訊</td>
			<td class="register_sercond">
            	<?php echo formArraySet($source,'source','radio',tryGetArrayValue('source',$edit_data)); ?>
                <div style="clear:both"></div>
                <label><input name="source" type="radio" <?php echo tryGetArrayValue('source_web',$edit_data)==''?'':'checked';?>>網站</label><input name="source_web" maxlength="50" size="15" value="<?php echo tryGetArrayValue('source_web',$edit_data); ?>">
                <label><input name="source" type="radio" <?php echo tryGetArrayValue('source_other',$edit_data)==''?'':'checked';?>>其他</label><input name="source_other" maxlength="50" size="15" value="<?php echo tryGetArrayValue('source_other',$edit_data); ?>">
			</td>
			</tr><tr>
			<td class="register_first">&nbsp;</td>
			<td class="register_glay">定期規律的運動能改善體態、避免新血管疾病與強化肌耐力，更可以達成紓壓、
			養成積極人生觀與生活規律化等心理層面，可謂好處多多，但需配合正確的運動習慣。
			運動處方是基於考量整體環境與個人狀況而設計的運動訓練或身體活動計劃的過程，
			SOLE邀請您將以下資料完整填寫，擁抱健康生活。
			</td>
			</tr><tr>
			<td class="register_first">您的(主要使用者)運動方式<br><span class="glay">(可複選)</span>
			</td>
			<td class="register_sercond">
                <?php
				echo formArraySet($sport_method,'sport_method[]','checkbox',tryGetArrayValue('sport_method',$edit_data));
				?>
			</td>
			</tr><tr>
			<td class="register_first">您(主要使用者)喜愛的運動方式<br><span class="glay">(可輸入50個中文字)</span></td>
			<td class="register_sercond"><textarea rows="2" cols="40" name="sport_note"><?php echo tryGetArrayValue('sport_note',$edit_data); ?></textarea></td>
			</tr><tr>
			<td class="register_first">您的(主要使用者)運動頻率</td>
			<td class="register_sercond"><label style="float:left">每周運動次數</label><span class="radio"><?php echo formArraySet($sport_rate,'sport_rate','radio',tryGetArrayValue('sport_rate',$edit_data)); ?></span></td>
			</tr><tr>
			<td class="register_first">您的(主要使用者)運動長度</td>
			<td class="register_sercond"><label style="float:left">每次運動時間</label><span class="radio"><?php echo formArraySet($sport_period,'sport_period','radio',tryGetArrayValue('sport_period',$edit_data)); ?></span></td>
			</tr><tr>
			<td class="register_first">您的(主要使用者)運動時段</td>
			<td class="register_sercond"><label style="float:left">常運動時段點</label><span class="radio"><?php echo formArraySet($sport_time,'sport_time','radio',tryGetArrayValue('sport_time',$edit_data)); ?></span></td>
			</tr><tr>
			<td class="register_first">&nbsp;</td>
			<td class="register_button"><input value="確 認" type="submit" class="btn"/><input value="取 消" type="reset" class="btn_glay"/></td>
			</tr>
			</table>



			</div>
		</div>
        </form>
		<div class='clear'></div>
		
