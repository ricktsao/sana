		<div id='primary'>
			<div id='breadCrumb'> <span id='home_icon'></span> / 購物車 / <span>購物明細</span> </div>
			<div style="height:30px;"> </div>
			<div id='step'></div>


			<div class='sub_title'> 購物明細 <span class='sprite_btns'></span> </div>
			<table border="0" cellspacing="0" cellpadding="0">
				<tr id='first'>
					<td>&nbsp;</td>
					<td>商品明細</td>
					<td>優惠價</td>
					<td>數量</td>
					<td>小計</td>
				</tr>
				<tbody id='item_list'>
				<?php
				//$subtotal = 0;
				
				foreach ($this->go_cart->contents() as $cartkey=>$product):
				?>


						<tr>
							<td><div class='item_img'>
							<?php
							if (empty($product['image']) === false)
							{
								echo "<img src='".base_url()."upload/products/small/".form_decode($product['image'])."'>";
							}
							?>
							</div></td>
							<td><?php echo $product['name']; ?></td>
							<td>NT$<?php echo format_currency($product['price']); ?></td>
							<td><label><?php echo format_currency($product['quantity']); ?></td>
							<td>NT$<?php echo format_currency($product['price']*$product['quantity']); ?></td>
						</tr>
				<?php 
				endforeach;
				// 有加購時顯示
				if(count($edit_data['plus_list']) > 0)
				{
					echo '<tr><td colspan="5">超值加購區</td></tr>';
					foreach($edit_data['plus_list'] as $product)
					{
						?>
						<tr>
							<td><div class='item_img'>
							<?php
							$images = (array)json_decode($product["images"]);
							foreach ($images as $image) {
								if (isset($image->primary) && $image->primary == true) {
									$image = (string) $image->filename;
									echo "<img src='".base_url()."upload/products/small/".form_decode($image)."' />";
								}
							}
							?>
							</div></td>
							<td><?php echo $product['name']; ?></td>
							<td>NT$<?php echo format_currency($product['plus_price']); ?></td>
							<td><label>1</td>
							<td>NT$<?php echo format_currency($product['plus_price']); ?></td>
						</tr>
						<?php
					}
				}
				$total_items = tryGetArrayValue('total_items', $edit_data) + count($edit_data['plus_list']);
				$subtotal = tryGetArrayValue('subtotal', $edit_data);
				$shipping_fee = tryGetArrayValue('shipping_fee', $edit_data, 0);
				$shipping_method = tryGetArrayValue('shipping_method', $edit_data, 0);
				$total = tryGetArrayValue('total', $edit_data);
				?>
				</tbody>
				<tr id='second' class='bg'>
					<td colspan="6" class='alignRight'>購物車內合計有<span class='red'><?php echo $total_items;?></span> 項商品，商品總金額<span class='gray'>NT <?php echo format_currency($subtotal);?></span>元</td>
				</tr>
				<tr class='bg '>
					<td colspan="6" class='alignRight'>運費<span class='red'>NT <?php echo format_currency($shipping_fee);?></span>元</td>
				</tr>
				<tr>
					<td colspan="6" class='alignRight'><span id='coin' class='sprite_btns'></span>訂單金額總計<span class='orange'>NT <?php echo format_currency($total);?></span>元</td>
				</tr>
			</table>
			


			<div class='sub_title'> 收件與付款資料 <span class='sprite_btns'></span> </div>
			<div id="register">

			<form name='checkout' id='confirmation_form' action="<?php echo getFrontendControllerUrl('checkout','confirmation');?>" method="post">
			<input type="hidden" id='confirmation' name="confirmation" value="true">
			<?php
			// 加入加購選項
			if(isset($_POST["plus"]) && is_array($_POST["plus"]) && count($_POST["plus"]) > 0)
			{
				foreach($_POST["plus"] as $val):
				echo '<input type="hidden" name="plus[]" value="'.$val.'" />';
				endforeach;
			}
			foreach ($edit_data as $key=>$value) {
				if (in_array($key, array('countries', 'area', 'payment_array', 'delivery_time_array', 'confirmation', 'plus')) === false)
				echo "<input type='hidden' name='".$key."' value='".$value."'>\n";
			}

			echo "<input type='hidden' name='subtotal' value='".$subtotal."'>\n";
			echo "<input type='hidden' name='shipping_fee' value='".$shipping_fee."'>\n";
			echo "<input type='hidden' name='shipping_method' value='".$shipping_method."'>\n";
			echo "<input type='hidden' name='total' value='".$total."'>\n";
			?>
				<table width="100%" cellpadding="0" cellspacing="0">
					<tr>
						<td>&nbsp;</td>
						<td><span class='title'>收件人資料</span></td>
					</tr>
					<tr>
						<td class="register_first"><span>*</span>收件人姓名</td>
						<td class="register_sercond">
						<?php echo tryGetArrayValue('ship_name', $edit_data); ?>
						</td>
					</tr>
					<tr>
						<td class="register_first"><span>*</span>居住地</td>
						<td class="register_sercond">
						<?php
						//echo tryGetArrayValue('ship_county_sn', $edit_data);
						//echo tryGetArrayValue('ship_area_sn', $edit_data);
						echo tryGetArrayValue('ship_county', $edit_data);
						echo tryGetArrayValue('ship_area', $edit_data);
						echo tryGetArrayValue('ship_zip_code', $edit_data);
						echo tryGetArrayValue('ship_address', $edit_data);
						?>
						</td>
					</tr>
					<tr>
						<td class="register_first"><span>*</span>手機號碼</td>
						<td class="register_sercond">
						<?php echo tryGetArrayValue('ship_mobile', $edit_data); ?>
						</td>
					</tr>
					<tr>
						<td class="register_first">聯絡電話</td>
						<td class="register_sercond">
						<?php echo tryGetArrayValue('ship_phone', $edit_data); ?>
						</td>
					</tr>
					<tr>
						<td class="register_first"><span>*</span>E-mail</td>
						<td class="register_sercond">
						<?php echo tryGetArrayValue('ship_email', $edit_data); ?>
						</td>
					</tr>
					<tr>
						<td class="register_first">&nbsp;</td>
						<td><span class='title'>付款人資料</span>
							<label id='theSame'>
							<?php
							//echo tryGetArrayValue('ship_name', $edit_data);
							if (@$ship_to_bill_address == 'yes') {
								echo '<label id="theSame"><input type="checkbox" id="different_address" name="ship_to_bill_address" value="yes" checked />同收件人</label>';
							}
							?>
							</td>
					</tr>
					<tr>
						<td class="register_first"><span>*</span>付款人姓名</td>
						<td class="register_sercond">
						<?php
						echo tryGetArrayValue('bill_name', $edit_data);
						?>
						</td>
					</tr>
					<tr>
						<td class="register_first"><span>*</span>居住地</td>
						<td class="register_sercond">
						<?php
						//echo tryGetArrayValue('bill_county_sn', $edit_data);
						//echo tryGetArrayValue('bill_area_sn', $edit_data);
						echo tryGetArrayValue('bill_county', $edit_data);
						echo tryGetArrayValue('bill_area', $edit_data);
						echo tryGetArrayValue('bill_zip_code', $edit_data);
						echo tryGetArrayValue('bill_address', $edit_data);
						?>
						</td>
					</tr>
					<tr>
						<td class="register_first"><span>*</span>手機號碼</td>
						<td class="register_sercond">
						<?php
						echo tryGetArrayValue('bill_mobile', $edit_data);
						?>
						</td>
					</tr>
					<tr>
						<td class="register_first">聯絡電話</td>
						<td class="register_sercond">
						<?php
						echo tryGetArrayValue('bill_phone', $edit_data);
						?>
						</td>
					</tr>
					<tr>
						<td class="register_first"><span>*</span>E-mail</td>
						<td class="register_sercond">
						<?php
						echo tryGetArrayValue('bill_email', $edit_data);
						?>
						</td>
					</tr>
					<tr>
						<td class="register_first">&nbsp;</td>
						<td><span class='title'>付款資料</span>	</td>
					</tr>
					<tr>
						<td class="register_first"><span>*</span>付款方式</td>
						<td class="register_sercond">
						<?php
						$payment = tryGetArrayValue('payment', $edit_data);
						$payment_array = tryGetArrayValue('payment_array', $edit_data);
						echo $payment_array[$payment];
						if($payment == 'installment')
						{
							echo '(';
							echo tryGetArrayValue('payment_bank', $edit_data);
							echo tryGetArrayValue('payment_installment', $edit_data)."期";
							echo ')';
						}
						?>
						</td>
					</tr>
					<!-- <tr>
						<td class="register_first">ATM帳號後五碼</td>
						<td class="register_sercond">
						<?php
						//echo tryGetArrayValue('atm_number', $edit_data);
						?>
						</td>
					</tr> -->
					<tr>
						<td class="register_first"><span>*</span>欲送達時間</td>
						<td class="register_sercond">
						<?php
						$delivery_time = tryGetArrayValue('delivery_time', $edit_data);
						$delivery_time_array = tryGetArrayValue('delivery_time_array', $edit_data);
						echo $delivery_time_array[$delivery_time];
						?>
						(實際可送達時間將有專人電話通知)</td>
					</tr>
					<tr>
						<td class="register_first"><span>*</span>發票資料</td>
						<td class="register_sercond">						
						<?php
						$invoice_type = tryGetArrayValue('invoice_type', $edit_data);
						if ($invoice_type == 'personal')
						{
							echo '二聯式發票';
						} else {
							$invoice_title = tryGetArrayValue('invoice_title', $edit_data);
							$invoice_id = tryGetArrayValue('invoice_id', $edit_data);
							echo '三聯式發票，發票抬頭 '.$invoice_title.'<br>統一編號 '.$invoice_id;
						}
						?>
						</td>
					</tr>
					
					<?php
					if ($invoice_type != 'personal')
					{
					?>
						<tr>
						<td class="register_first"><span>*</span>發票寄送地址</td>
						<td class="register_sercond">
						<?php
						$invoice_addr = tryGetArrayValue('invoice_addr', $edit_data);
						if ($invoice_addr == 'bill') {
							echo "同付款人地址";
						}
						else
						{
							echo "同收件人地址";
						}
						?>
						</td>
					</tr>
					<?php
					}
					?>
					<tr>
						<td class="register_first">備註欄</td>
						<td class="register_sercond"><label>
						<?php
						$memo = tryGetArrayValue('memo', $edit_data	);
						echo $memo;
						?>
						</label></td>
					</tr>
				</table>
			</div>
			<div id='function_btn'>
			<a href='#' onclick="$('#confirmation_form').attr('action', '<?php echo getFrontendControllerUrl('checkout','index');?>').submit();" class='sprite_btns' id="btn_a">上一頁</a>
			<a href='#' onclick="$('#confirmation_form').submit();" class='sprite_btns' id="btn_c">確認完成</a>
			</div>
		</div>
		<div class='clear'></div>
