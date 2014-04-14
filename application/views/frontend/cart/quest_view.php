<script>
	$(function(){
		init();		
		sub_navi();
		
		var textGender="<tr><td class='gray'><span>主要使用者</span>的性別</td><td><label><input type='radio' name='gender' value='1' />男</label><label><input type='radio' name='gender' value='0' />女</label></td></tr>";
		
		$('input[name=self]').click(function(){
			if($(this).val()=='1'){
				$('#detail_area #gender').html('');	
				$('#detail_area span').text('您');
				$(".user_title").text('您');
				$("#sport_data").css("display","");
			}else{
				$('#detail_area #gender').html(textGender);	
				$('#detail_area span').text('主要使用者');
				$(".user_title").text('主要使用者');
				$("#sport_data").css("display","none");
			}
		})
		
		$('.check_group').click(function(){
			if($(this).children('input').is(':checked')){
				var rel=$(this).children('input').val();
				$(this).parent().children('span').html("男性<input type='text' name='family["+rel+"][m]'/>位,女性<input type='text' name='family["+rel+"][f]'/>位");
			}else{
				$(this).parent().children('span').html("");
			}
		})
		
		$("#btn_c").click(function(){
			$("#quest_form").submit();
			return false;
		});
		
		$("input[name=sport_injuries]").click(function(){
			if($(this).val() == '1')
			{
				$("#sport_injuries_content").css("display","");
			}
			else
			{
				$("#sport_injuries_content").css("display","none");
			}
		});
		
	})
</script>

		<!-- 主要內容區塊 -->
		<form action="<?php echo getFrontendControllerUrl('cart', 'saveQuest');?>" method="post" id="quest_form">
		<div class='clear'></div><div id='primary'>
			<div id='breadCrumb'> <span id='home_icon'></span> / 購物車 / <span>問卷調查</span> </div>
			<div style="height:30px;"> </div>
			<div class='sub_title'> 健康諮詢問卷<span class='sprite_btns'></span> </div>
			<div >您寶貴的意見，能讓您(使用者)重新檢視自己的身體健康狀況，SOLE將依您的問卷內容，於SOLE Facebook粉絲團提供相關健康資訊。</div>
			<div id="register">
				<table width="100%" cellpadding="0" cellspacing="0"  >
					
					<tr>
						<td class="register_first"><span>*</span>付款人姓名</td>
						<td class="register_sercond"><?php echo tryGetArrayValue("name", $user_data); ?></td>
					</tr>
					<tr>
						<td class="register_first"><span>*</span>居住地</td>
						<td class="register_sercond"><?php echo tryGetArrayValue("address", $user_data); ?></td>
					</tr>
					<tr>
						<td class="register_first"><span>*</span>手機號碼</td>
						<td class="register_sercond"><?php echo tryGetArrayValue("mobile", $user_data); ?></td>
					</tr>
					<tr>
						<td class="register_first">聯絡電話</td>
						<td class="register_sercond"><?php echo tryGetArrayValue("tel", $user_data); ?></td>
					</tr>
					<tr>
						<td class="register_first"><span>*</span>E-mail</td>
						<td class="register_sercond"><?php echo tryGetArrayValue("email", $user_data); ?></td>
					</tr>					
					<tr>
						<td class="register_first">欲購買的健身器材主要是否為您本人使用</td>
						<td class="register_sercond"><label><input type="radio"  name='self' value='1' checked="checked"/>是</label><label><input type="radio"  name='self' value='0'/>否</label></td>
					</tr>
					<tr>
						<td class="register_first">&nbsp;</td>
						<td class="register_sercond"><table id='detail_area'>
							<tr><td class='gray'><span>您</span>的生日</td>
                            	<td>
                                	<?php echo formArraySet($this->config->item('years'),"year",'select',NULL,NULL,'西元年'); ?>
                                    <?php echo formArraySet($this->config->item('months'),"month",'select',NULL,NULL,'月份'); ?>
                                    <?php echo formArraySet($this->config->item('days'),"day",'select',NULL,NULL,'日期'); ?>
                                </td>
							</tr>
							<tbody id='gender'>
							
							</tbody>
							<tr><td class='gray'><span>您</span>的身高</td><td><input type="text" name="height" />cm,體重<input type="text" name="weight" />kg</td></tr>
						</table></td>
					</tr>
					
					<tr>
						<td class="register_first">家中成員</td>
						<td class="register_sercond">
                        	<ul style="margin:0; padding-left:0px;">
                            	<?php
								foreach($this->config->item('quest_family') as $key=>$val)
								{
								?>
                            	<li style="list-style:none"><label class='check_group' ><input type="checkbox" value='<?php echo $key;?>'/><?php echo $val;?></label><span></span></li>
                                <?php
								}
								?>
                            </ul>
						</td>
					</tr>
                    <tr>
						<td class="register_first"><label class="user_title" style="margin-right:0px;">您</label>是否發生過運動傷害？</td>
						<td class="register_sercond"><label><input name="sport_injuries" value="1" type="radio" />是</label><label><input name="sport_injuries" value="0" type="radio" checked="checked" />否</label></td>
					</tr>
					<tr id="sport_injuries_content" style="display:none">
						<td class="register_first">何種運動傷害？
						<div>(可輸入100個中文字)</div></td>
						<td class="register_sercond"><textarea name="sport_injuries_content"></textarea></td>
					</tr>
                    <?php
					foreach($this->config->item('quest_case_history') as $key=>$val)
					{
					?>
					<tr>
						<td class="register_first"><label class="user_title" style="margin-right:0px;">您</label>是否有<?php echo $val;?>？</td>
						<td class="register_sercond"><?php echo formArraySet(array(1=>'是',0=>'否'),"case_history[".$key."]",'radio'); ?></td>
					</tr>
                    <?php
					}
					?>
					<tr>
						<td class="register_first"><label class="user_title" style="margin-right:0px;">您</label>的體重是否有過重？</td>
						<td class="register_sercond"><label><input name="overweight" value="1" type="radio" />是</label><label><input name="overweight" value="0" type="radio" checked="checked" />否</label></td>
					</tr>
					<tbody id="sport_data">
					<?php
					if($sport_data_view)
					{
					?>
					<input type="hidden" name="sport_data" value="1" />
					<tr>
						<td class="register_first">&nbsp;</td>
						<td class="register_glay">定期規律的運動能改善體態、避免新血管疾病與強化肌耐力，更可以達成紓壓、
						養成積極人生觀與生活規律化等心理層面，可謂好處多多，但需配合正確的運動習慣。
						運動處方是基於考量整體環境與個人狀況而設計的運動訓練或身體活動計劃的過程，
						SOLE邀請您將以下資料完整填寫，擁抱健康生活。
						</td>
					</tr>
					<tr>
						<td class="register_first"><label class="user_title" style="margin-right:0px;">您</label>的運動方式<br><span class="glay">(可複選)</span></td>
						<td class="register_sercond">
			                <?php
							echo formArraySet($sport_method,'sport_method[]','checkbox',tryGetArrayValue('sport_method',$user_data));
							?>
						</td>
					</tr>
					<tr>
						<td class="register_first"><label class="user_title" style="margin-right:0px;">您</label>喜愛的運動方式<br><span class="glay">(可輸入50個中文字)</span></td>
						<td class="register_sercond"><textarea rows="2" cols="40" name="sport_note"><?php echo tryGetArrayValue('sport_note',$user_data); ?></textarea></td>
					</tr>
					<tr>
						<td class="register_first"><label class="user_title" style="margin-right:0px;">您</label>運動頻率</td>
						<td class="register_sercond"><label style="float:left">每周運動次數</label><span class="radio"><?php echo formArraySet($sport_rate,'sport_rate','radio',tryGetArrayValue('sport_rate',$user_data)); ?></span></td>
					</tr>
					<tr>
						<td class="register_first"><label class="user_title" style="margin-right:0px;">您</label>運動長度</td>
						<td class="register_sercond"><label style="float:left">每次運動時間</label><span class="radio"><?php echo formArraySet($sport_period,'sport_period','radio',tryGetArrayValue('sport_period',$user_data)); ?></span></td>
					</tr>
					<tr>
						<td class="register_first"><label class="user_title" style="margin-right:0px;">您</label>運動時段</td>
						<td class="register_sercond"><label style="float:left">常運動時段點</label><span class="radio"><?php echo formArraySet($sport_time,'sport_time','radio',tryGetArrayValue('sport_time',$user_data)); ?></span></td>
					</tr>
					<?php
					}
					else
					{
						echo '<input type="hidden" name="sport_data" value="0" />';
					}
					?>
					</tbody>
				</table>
			</div>
			<div id='function_btn'> <a href='#' class='sprite_btns' id="btn_a">上一頁</a> <a href='#' class='sprite_btns' id="btn_c">確認完成</a> </div>
		</div>
        <input type="hidden" name="order_number" value="<?php echo $order_number;?>" />
        <input type="hidden" name="member_sn" value="<?php echo tryGetArrayValue("member_sn", $user_data);?>" />
        </form>
		<div class='clear'></div>
