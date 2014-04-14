
		<script type="text/javascript">
		<!--
		jQuery(document).ready(function(){
			$('.invoice_type').click(function(){
				var itp = $('.invoice_type:checked').val();

				if (itp == 'personal')
				{
					$('.invoice').attr('disabled', true);
				}
				else
				{
					$('.invoice').attr('disabled', false);
				}

			});

			// 收件
			$('select[name=ship_county_sn]').chainSelect('select[name=ship_area_sn]',"<?=base_url()?>member/country_state_chained_selection",
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

			$('select[name=ship_area_sn]').change(function()
			{
				$.ajax({
					'method':'get',
					'url':'<?=base_url()?>member/location_area_selection',
					'data':'sn='+$(this).val(),
					'success':function(data){
						if(data!=''){
							$("input[name=ship_zip_code]").val(data);
						}
						else
						{
							$("input[name=ship_zip_code]").val('郵遞區號');
						}
					}
				});
			}).trigger('change');

			// 付款
			$('select[name=bill_county_sn]').chainSelect('select[name=bill_area_sn]',"<?=base_url()?>member/country_state_chained_selection",
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

			$('select[name=bill_area_sn]').change(function()
			{
				$.ajax({
					'method':'get',
					'url':'<?=base_url()?>member/location_area_selection',
					'data':'sn='+$(this).val(),
					'success':function(data){
						if(data!=''){
							$("input[name=bill_zip_code]").val(data);
						}
						else
						{
							$("input[name=bill_zip_code]").val('郵遞區號');
						}
					}
				});
			}).trigger('change');

			$("#ship_to_bill_address").click(function(){
				toggle_billing_address_form($(this).attr("checked"));
			});


			<?php
			if (tryGetArrayValue('ship_to_bill_address', $edit_data) == 'yes')
			{
				echo '$("#ship_to_bill_address").attr("checked",true);';
				echo 'toggle_billing_address_form(true);';
			}
			?>
			$("input[name=invoice_type][value=<?php echo tryGetArrayValue('invoice_type', $edit_data);?>]").attr("checked",true);
			$("input[name=invoice_addr][value=<?php echo tryGetArrayValue('invoice_addr', $edit_data);?>]").attr("checked",true);
			
			// 分期付款設定
			$("select[name=payment]").change(function()
			{
				if($(this).val() == 'installment')
				{
					var bank = '<select name="payment_bankcode">';
					var installment = new Array();
					<?php
					foreach($this->config->item('payment_installment') as $key=>$val)
					{
						?>
						var bank_<?php echo $key;?> = '<select name="payment_bankcode">';
						bank += '<option value="<?php echo $key;?>"><?php echo $val['name'];?></option>';
						installment[<?php echo $key;?>] = '<select name="payment_installment">';
						<?php
						foreach($val['installment'] as $num)
						{
							?>
							installment[<?php echo $key;?>] += '<option value="<?php echo $num;?>"><?php echo $num;?>期</option>';
							<?php
						}
					}
					?>
					bank += '</select>';
					$("#payment_td").append(bank);
					$("#payment_td").find("select[name=payment_bankcode]").change(function(){
						$("#payment_td").find("select[name=payment_installment]").remove();
						$("#payment_td").append(installment[$(this).val()]);
					}).trigger('change');
				}
				else
				{
					$("#payment_td").find("select[name=payment_bankcode]").remove();
					$("#payment_td").find("select[name=payment_installment]").remove();
				}
			}).trigger('change');
			
		});

		function toggle_billing_address_form(checked)
		{
			if(!checked)
			{
				clear_billing_info();
				$('.bill').attr('disabled', false);
				$('.bill').removeClass('disabled');
			}
			else
			{
				copy_shipping_info();
				$('.bill').attr('disabled', true);
				$('.bill').addClass('disabled');
			}
		}


		function clear_billing_info()
		{
			$('.bill').val('');
			$('#bill_city_id option:first-child').attr('selected', true);
			$('#bill_zone_id option:first-child').attr('selected', true);
		}

		function copy_shipping_info()
		{
			$('#bill_company').val($('#ship_company').val());
			$('#bill_name').val($('#ship_name').val());
			$('#bill_lastname').val($('#ship_lastname').val());
			$('#bill_address1').val($('#ship_address1').val());
			$('#bill_address2').val($('#ship_address2').val());
			$('#bill_address').val($('#ship_address').val());
			$('#bill_phone').val($('#ship_phone').val());
			$('#bill_mobile').val($('#ship_mobile').val());
			$('#bill_email').val($('#ship_email').val());

			$('select[name=bill_county_sn]').val($('select[name=ship_county_sn]').val());
			$('input[name=bill_zip_code]').val($('input[name=ship_zip_code]').val());

			// repopulate and set zone field
			$('select[name=bill_area_sn]').html($('select[name=ship_area_sn]').html());
			$('select[name=bill_area_sn]').val($('select[name=ship_area_sn]').val());
		}
		//-->
		</script>
		<style type="text/css">
			.error {color:red; font-size:10pt}
		</style>
		<div id='primary'>
			<div id='breadCrumb'> <span id='home_icon'></span> / 購物車 / <span>購物明細</span> </div>
			<div style="height:30px;"> </div>
			<div id='step'></div>
			<div id="register">
			<form name='checkout' action="<?php echo getFrontendControllerUrl('checkout','confirmation');?>" method="post">
			<?php
			// 加入加購選項
			if(isset($_POST["plus"]) && is_array($_POST["plus"]) && count($_POST["plus"]) > 0)
			{
				foreach($_POST["plus"] as $val):
				echo '<input type="hidden" name="plus[]" value="'.$val.'" />';
				endforeach;
			}
			?>
			<input type="hidden" name="confirmation" value="false">
			<input type="hidden" name="member_sn" value="<?php echo tryGetArrayValue('member_sn', $edit_data);?>">
			<input type="hidden" name="member_name" value="<?php echo tryGetArrayValue('member_name', $edit_data);?>">
			<input type="hidden" name="member_email" value="<?php echo tryGetArrayValue('member_email', $edit_data);?>">
			<input type="hidden" name="member_mobile" value="<?php echo tryGetArrayValue('member_mobile', $edit_data);?>">
				<table width="100%" cellpadding="0" cellspacing="0">
					<tr>
						<td>&nbsp;</td>
						<td><span class='title'>收件人資料</span></td>
					</tr>
					<tr>
						<td class="register_first"><span>*</span>收件人姓名</td>
						<td class="register_sercond">
						<?php
						$attributes = array('class' => 'bill');
						$data	= array('id'=>'ship_name', 'name'=>'ship_name', 'value'=>set_value('ship_name', tryGetArrayValue('ship_name', $edit_data)), 'class'=>'ship');
						echo form_input($data);
						echo form_error('ship_name');
						?>
						</td>
					</tr>
					<tr>
						<td class="register_first"><span>*</span>居住地</td>
						<td class="register_sercond">
						<?php
						echo formArraySet(tryGetArrayValue('countries', $edit_data),'ship_county_sn','select', tryGetArrayValue('ship_county_sn', $edit_data), NULL, '請選擇縣市');
						if( tryGetArrayValue('ship_county_sn', $edit_data) > 0)
						{
							echo formArraySet(tryGetArrayValue('area', $edit_data),'ship_area_sn','select', tryGetArrayValue('ship_area_sn', $edit_data), NULL, '-- 鄉市鎮 --');	
						}
						else
						{
						?>
							<select name="ship_area_sn" class='ship'>
							<option value ="">鄉市鎮</option>
							</select>
						<?php
						}
						?>
						<input name="ship_zip_code" type="text" value="郵遞區號" size="8" style="color:#b4b4b4;" class='ship'>
						<?php
						$data	= array('id'=>'ship_address', 'name'=>'ship_address', 'value'=>set_value('ship_address', tryGetArrayValue('ship_address', $edit_data)), 'class'=>'ship');
						echo form_input($data);
						echo form_error('ship_county_sn');
						echo form_error('ship_area_sn');
						echo form_error('ship_zip_code');
						echo form_error('ship_address');
						?>
						</td>
					</tr>
					<tr>
						<td class="register_first"><span>*</span>手機號碼</td>
						<td class="register_sercond">
						<?php
						$data	= array('id'=>'ship_mobile', 'name'=>'ship_mobile', 'value'=>set_value('ship_mobile', tryGetArrayValue('ship_mobile', $edit_data)), 'class'=>'ship');
						echo form_input($data);
						echo form_error('ship_mobile');
						?>
						</td>
					</tr>
					<tr>
						<td class="register_first">聯絡電話</td>
						<td class="register_sercond">
						<?php
						$data	= array('id'=>'ship_phone', 'name'=>'ship_phone', 'value'=>set_value('ship_phone', tryGetArrayValue('ship_phone', $edit_data)), 'class'=>'ship');
						echo form_input($data);
						?>
						</td>
					</tr>
					<tr>
						<td class="register_first"><span>*</span>E-mail</td>
						<td class="register_sercond">
						<?php
						$data	= array('id'=>'ship_email', 'name'=>'ship_email', 'value'=>set_value('ship_email', tryGetArrayValue('ship_email', $edit_data)), 'class'=>'ship');
						echo form_input($data);
						echo form_error('ship_email');
						?>
						</td>
					</tr>
					<tr>
						<td class="register_first">&nbsp;</td>
						<td><span class='title'>付款人資料</span>
							<label id='theSame'>
							<?php
							$js = 'id="ship_to_bill_address"';
							echo form_checkbox('ship_to_bill_address', 'yes', FALSE, $js);?> 同收件人
							</label>
						</td>
					</tr>
					<tr>
						<td class="register_first"><span>*</span>付款人姓名</td>
						<td class="register_sercond">
						<?php
						$data	= array('id'=>'bill_name', 'name'=>'bill_name', 'value'=>set_value('bill_name', tryGetArrayValue('bill_name', $edit_data)), 'class'=>'bill');
						echo form_input($data);
						echo form_error('bill_name');
						?>
						</td>
					</tr>
					<tr>
						<td class="register_first"><span>*</span>居住地</td>
						<td class="register_sercond">

						<?php
						echo formArraySet(tryGetArrayValue('countries', $edit_data),'bill_county_sn','select', tryGetArrayValue('bill_county_sn', $edit_data), NULL, '請選擇縣市', "class='bill'");
						if(tryGetArrayValue('bill_county_sn', $edit_data) > 0)
						{
							echo formArraySet(tryGetArrayValue('area', $edit_data),'bill_area_sn','select', tryGetArrayValue('bill_area_sn', $edit_data), NULL, '-- 鄉/市/鎮/區 --', "class='bill'");
						}
						else
						{
						?>
						<select name="bill_area_sn" class='bill'>
						<option value ="">鄉/市/鎮/區</option>
						</select>
						<?php
						}
						?>
						<input name="bill_zip_code" type="text" value="郵遞區號" size="8" style="color:#b4b4b4;" class='bill'>		
						<?php
						$data	= array('id'=>'bill_address', 'name'=>'bill_address', 'value'=>set_value('bill_address', tryGetArrayValue('bill_address', $edit_data)), 'class'=>'bill');
						echo form_input($data);
						echo form_error('bill_county_sn');
						echo form_error('bill_area_sn');
						echo form_error('bill_zip_code');
						echo form_error('bill_address');
						?>
							</td>
					</tr>
					<tr>
						<td class="register_first"><span>*</span>手機號碼</td>
						<td class="register_sercond">
						<?php
						$data	= array('id'=>'bill_mobile', 'name'=>'bill_mobile', 'value'=>set_value('bill_mobile', tryGetArrayValue('bill_mobile', $edit_data)), 'class'=>'bill');
						echo form_input($data);
						echo form_error('bill_mobile');
						?>
						</td>
					</tr>
					<tr>
						<td class="register_first">聯絡電話</td>
						<td class="register_sercond">
						<?php
						$data	= array('id'=>'bill_phone', 'name'=>'bill_phone', 'value'=>set_value('bill_phone', tryGetArrayValue('bill_phone', $edit_data)), 'class'=>'bill');
						echo form_input($data);
						?>
						</td>
					</tr>
					<tr>
						<td class="register_first"><span>*</span>E-mail</td>
						<td class="register_sercond">
						<?php
						$data	= array('id'=>'bill_email', 'name'=>'bill_email', 'value'=>set_value('bill_email', tryGetArrayValue('bill_email', $edit_data)), 'class'=>'bill');
						echo form_input($data);
						echo form_error('bill_email');
						?>
						</td>
					</tr>
					<tr>
						<td class="register_first">&nbsp;</td>
						<td><span class='title'>付款資料</span>	</td>
					</tr>
					<tr>
						<td class="register_first"><span>*</span>付款方式</td>
						<td class="register_sercond" id="payment_td">
						<?php
						echo form_dropdown('payment', tryGetArrayValue('payment_array', $edit_data));
						echo form_error('payment');
						?>
						</td>
					</tr>
					<!-- <tr>
						<td class="register_first"><span></span>ATM帳號後五碼</td>
						<td class="register_sercond">
						<?php
						//$data	= array('id'=>'atm_number', 'name'=>'atm_number', 'value'=>set_value('atm_number', tryGetArrayValue('atm_number', $edit_data)));
						//echo form_input($data);
						?>
						</td>
					</tr> -->
					<tr>
						<td class="register_first"><span>*</span>欲送達時間</td>
						<td class="register_sercond">
						<?php
						echo form_dropdown('delivery_time', tryGetArrayValue('delivery_time_array', $edit_data));
						?>
						(實際可送達時間將有專人電話通知)
						<?php echo form_error('delivery_time'); ?>
						</td>
					</tr>
					<tr>
						<td class="register_first"><span>*</span>發票資料</td>
						<td class="register_sercond"><input class="invoice_type" name="invoice_type" type="radio" value="personal" />
						二聯式發票<br><input class="invoice_type" name="invoice_type" type="radio" value="business" />
						三聯式發票，發票抬頭 <input type="text" class='invoice' name="invoice_title" />
						統一編號 <input type="text" class='invoice' name="invoice_id" />
						<?php
						echo form_error('invoice_type');
						echo form_error('invoice_addr');
						echo form_error('invoice_id');
						echo form_error('invoice_title');
						?>
						</td>
					</tr>
						<tr>
						<td class="register_first"><span>*</span>發票寄送地址</td>
						<td class="register_sercond">
						<label><input type="radio" class='invoice_addr' name="invoice_addr" value="ship" /> 同收件人地址</label> <!-- -->
						<label><input type="radio" class='invoice_addr' name="invoice_addr"  value="bill" /> 同付款人地址</label> <!-- onclick="copy_for_invoice()" -->
						<?php echo form_error('invoice_addr'); ?>
						</td>
					</tr>
					<tr style='display:none'>
						<td >&nbsp;</td>
						<td class="register_sercond">
						<?php
						/*
						echo formArraySet($countries,'invoice_county_sn','select', @$invoice_county_sn, NULL, '請選擇縣市', "class='invoice'");
						if(@$invoice_county_sn > 0)
						{
							echo formArraySet($area,'invoice_area_sn','select', @$invoice_area_sn, NULL, '-- 發票鄉鎮市 --', "class='invoice'");	
						}
						else
						{
						?>
							<select name="invoice_area_sn" class='invoice'>
							<option value ="">發票鄉/市/鎮/區</option>
							</select>
						<?php
						}
						*/
						?>
						<input name="invoice_zip_code" type="text" value="郵遞區號" size="8" style="color:#b4b4b4;" class='invoice'>
						<input type="text" id='invoice_address' name='invoice_address' class='invoice' size="20">
						</td>
					</tr>
					<tr>
						<td class="register_first">備註欄</td>
						<td class="register_sercond"><label>
							<textarea cols="70" rows="5" id="textfield" name="memo"><?php echo tryGetArrayValue('memo', $edit_data, '');?></textarea>
						</label></td>
					</tr>
				</table>
			</div>
			<div id='function_btn'> <a href='<?php echo getFrontendControllerUrl('cart','view_cart');?>' class='sprite_btns' id="btn_a">上一頁</a>
			<a href='#' onclick='javascript:checkout.submit();' class='sprite_btns' id="btn_c">確認完成</a></div>
			</form>
		</div>
		<div class='clear'></div>
