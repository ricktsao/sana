<script>
	
	$(function(){
		sub_navi();
	})
	
</script>
	<div id='secondary'>
			<div id='sub_title' class='sub_nav_sprite'> 會員區 </div>
			<!-- 左側選單 -->
			<ul id='sub_navi' class='sub_nav_sprite'>
            	<li><a href='javascript:void(0)'><span class='sub_nav_sprite'></span>會員資料</a>
					<div class='sub_nav_sprite'></div>
                        <ul style="display:none">
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
                        <ul>
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
		<div id='primary'>
			<div id='breadCrumb'> <span id='home_icon'></span> / 交易紀錄 / 訂單查詢 /<span>訂單明細</span> </div>
			<div id='title'> <span></span>訂單明細 </div>

			<?php
			if (isset($order) === false) {
				echo "<div style='text-align:center'>".$this->session->flashdata('msg')."</div>";

			} else {
				$subtotal = tryGetValue($order->subtotal);
				$shipping_fee = tryGetValue($order->shipping_fee);
				$total = tryGetValue($order->total);
				$content = tryGetValue($order->contents);


				?>
				<table border="0" cellspacing="0" cellpadding="0" id='infoTable'>
					<tr>
						<td>訂單編號：<?php echo tryGetValue($order->order_number); ?></td>
						<td>訂購日期：<?php echo tryGetValue($order->ordered_on); ?></td>
						<td>處理狀態：
						<span>
						<?php
						$status =  tryGetValue($order->status);
						echo $this->config->item($status, 'order_statuses');
						?>
						</span></td>
					</tr>
				</table>
				<table border="0" cellspacing="0" cellpadding="0" id='dataTable'>
					<tr id='first'>
						<td width="30%">商品名稱</td>
						<td width="23%">單價</td>
						<td width="28%">數量</td>
						<td width="19%">商品小計</td>
					</tr>
					<?php				
					foreach ($content as $cartkey=>$product)
					{
					?>
					<tr>
						<td><?php echo $product['name'];?></td>
						<td><?php echo '$ '.format_currency($product['price']);?></td>
						<td><?php echo $product['quantity'];?></td>
						<td><?php echo '$ '.format_currency($product['price']*$product['quantity']);?></td>
					</tr>
					<?
					}
					?>
				</table>
				<table border="0" cellspacing="0" cellpadding="0" id='totalTable'>
					<tr>
						<td width="81%">商品小計</td>
						<td width="19%"><?php echo '$ '.format_currency($subtotal);?>元</td>
					</tr>
					<tr id='underLine'>
						<td>運費</td>
						<td><?php echo '$ '.format_currency($shipping_fee);?>元</td>
					</tr>
					<tr>
						<td><span class='coin'></span>訂單總額</td>
						<td><span class='blackFont'><?php echo '$ '.format_currency($total);?></span>元</td>
					</tr>
				</table>
				<div class='sub_title'>
					<div></div>
					付款方式</div>
				<div class='marginLeft'>
						<?php
						$payment = tryGetValue($order->payment);
						echo $this->config->item($payment, 'payment');

						$payment_note = tryGetValue($order->payment_note, NULL);
						if (isNotNull($payment_note)) {
							echo '，'.$payment_note;
						}

						if ($payment == 'creditcard' && in_array($status, array(1, 4)) == true) 
						{
							echo '<a href="'.getFrontendControllerUrl('cart','sendCreditCard/'.tryGetValue($order->order_number)).'" class="cancel">重新刷卡</a>';
						}
						?>
				</div>
				
				<?php
				if ($payment == 'atm' && in_array($status, array(1)) == true) {
				?>
				<div id='title'> <span></span>ATM轉帳通知 </div>
				<form id="atmForm" method="post" action="<?php echo getFrontendUrl('atmPaid');?>">
				<input type="hidden" name='order_id' value='<?php echo $order->id;?>' />
				<table border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td width="21%" class='grayFont'>轉出帳號後五碼：</td>
						<td width="79%">
						<input type="text" name='payment_note' onkeyup="this.value = this.value.slice(0, 5)" />
						</td>
					</tr>
				</table>
				<div class='clear'></div>
				<a href='#' class='cancel' onclick="$('#atmForm').submit();">確定送出</a>
				</form>
				<div id='dotLine' class='clear'></div>
				<?php
				}
				elseif($payment == 'atm' && in_array($status, array(2)) == true)
				{
				?>
				<div class='marginLeft'>
				轉帳末五碼無法修改，若輸入資料有誤請與服務人員聯絡，客服專線：886-2-2501-1815
				</div>
				<?php
				}
				?>

				<div class='sub_title'><div></div>收件資訊</div>
				<table border="0" cellspacing="0" cellpadding="0" class='marginLeft'>
					<tr class='odd'>
						<td width="150px">收件人姓名</td>
						<td width="81%"><?php echo tryGetValue($order->ship_name);?></td>
					</tr>
					<tr >
						<td>居住地</td>
						<td>
						<?php echo tryGetValue($order->ship_county);?>
						<?php echo tryGetValue($order->ship_area);?>
						<?php echo tryGetValue($order->ship_zip_code);?>
						<?php echo tryGetValue($order->ship_address);?>
						</td>
					</tr>
					<tr class='odd'>
						<td>手機號碼</td>
						<td><?php echo tryGetValue($order->ship_mobile);?></td>
					</tr>
					<tr>
						<td>聯絡電話：</td>
						<td><?php echo tryGetValue($order->ship_phone);?></td>
					</tr>
					<tr class='odd'>
						<td>E-mail：</td>
						<td><?php echo tryGetValue($order->ship_email);?></td>
					</tr>
				</table>

				<div class='sub_title'><div></div>付款資訊</div>
				<table border="0" cellspacing="0" cellpadding="0" class='marginLeft'>
					<tr class='odd'>
						<td width="150px">付款人姓名</td>
						<td width="81%"><?php echo tryGetValue($order->bill_name);?></td>
					</tr>
					<tr >
						<td>居住地</td>
						<td>
						<?php echo tryGetValue($order->bill_county);?>
						<?php echo tryGetValue($order->bill_area);?>
						<?php echo tryGetValue($order->bill_zip_code);?>
						<?php echo tryGetValue($order->bill_address);?>
						</td>
					</tr>
					<tr class='odd'>
						<td>手機號碼</td>
						<td><?php echo tryGetValue($order->bill_mobile);?></td>
					</tr>
					<tr>
						<td>聯絡電話：</td>
						<td><?php echo tryGetValue($order->bill_phone);?></td>
					</tr>
					<tr class='odd'>
						<td>E-mail：</td>
						<td><?php echo tryGetValue($order->bill_email);?></td>
					</tr>
				</table>

				<div class='sub_title'><div></div>發票資訊</div>
				<table border="0" cellspacing="0" cellpadding="0" class='marginLeft'>
					<tr class='odd'>
						<td width="150px">發票類型</td>
						<td width="80%">
						<?php
						$invoice_type =  tryGetValue($order->invoice_type);
						echo $this->config->item($invoice_type, 'invoice_type_array');
						?>
						</td>
					</tr>
					<tr >
						<td>受買人</td>
						<td>
						<?php
						$invoice_addr =  tryGetValue($order->invoice_addr);
						if ($invoice_addr == 'bill') 
						{
							echo '同付款人';
						}
						else
						{
							echo '同收件人';
						}					
						?>
						</td>
					</tr>
					<tr class='odd'>
						<td colspan="2">電子發票說明，核准文號：財北國稅松山營業字第0960211565號</td>
					</tr>
				</table>

				<?php
				if ($payment == 'atm' && in_array($status, array(1)) == true) {
				?>

				<div id='title'> <span></span>訂單取消 </div>
				<form id="cancelForm" method="post" action="<?php echo getFrontendUrl('orderCancel');?>">
				<input type="hidden" name='return' value='latest' />
				<input type="hidden" name='order_id' value='<?php echo $order->id;?>' />
				<table border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td width="21%" class='grayFont'>請選擇取消因素</td>
						<td width="79%">
						<label><input type="radio" name='reason' />價格考量</label>
						<label><input type="radio" name='reason' />已無需要</label>
						<label><input type="radio" name='reason' checked />其它</label>
						</td>
					</tr>
					<tr>
						<td class='grayFont'>請說明取消原因
							<div>(可輸入100個中文字)</div></td>
						<td><textarea name="content" cols="60" rows="5" onkeyup="this.value = this.value.slice(0, 100)"></textarea></td>
					</tr>
				</table>
				<div class='clear'></div>
				<a href='#' class='cancel' onclick="alert('您確定取消此張訂單？'); $('#cancelForm').submit();">確定取消</a>
				</form>
				<?php
				}
				?>
			<?php
			}
			?>
			<div id='dotLine' class='clear'></div>
			<ul id='ps'>
				<li>
					<div></div>
					Sole台灣官方網站線上購物的消費者，都可以依照消費者保護法的規定，享有商品貨到日起（收迄日的計算以宅配簽收單或郵戳日期為憑），七天猶豫期(七天包含假日)的權益。但請注意猶豫期並非試用期，所以，您所退回的商品必須是為全新、未經拆除吊牌，並保留原始完整包裝，本公司可再次轉賣或退還原廠之狀態。請注意保持商品本體完整之外，如商品有附配件、贈品、保證書、發票或文件資料等都必須完整性退還，切勿缺漏任何配件或損毀原廠外盒。為保障您的權益，請務必於商品 猶豫期間(七天內)內提出申請，Sole台灣官方網站在接到顧客的退換貨要求後，會立刻進行處理事宜。</li>
				<li>
					<div></div>
					下列情形Sole台灣官方網站恕無法接受退換貨：
超過七天的商品鑑賞期。商品包裝不完全(沒吊牌、缺配件、缺贈品、污損、故障、損毀、磨損、擦傷、刮傷、髒污、發票不齊、包裝破損等)，或是明顯人為造成的毀損。產品所附之相關贈品及相關物品遺失或毀損，將會影響退換貨權限。 外包裝紙盒輕微的摺痕或因搬運過程中嚴重之碰撞，影響產品本身品質。 任由宅配單直接粘貼在商品原廠外盒上或書寫文字，識為毀損商品，將會影響退換貨權限。  </li>
				<li>
					<div></div>
					若是規格不合的情況下，七日內(包含假日)提出，Sole台灣官方網站可負擔退換尺寸的運費郵資，並更換給您，煩請您與Sole台灣官方網站客服人員聯繫，單筆訂單僅限一次。 若購買已超過七日鑑賞期的時間，Sole台灣官方網站無法接受任何退換貨。</li>
				<li>
					<div></div>
					※ 請注意    
如因Sole台灣官方網站的疏失(送錯商品、運送毀損、商品有瑕疵等)造成您須 退換貨，請於七日內(包含假日)提出，Sole台灣官方網站會負擔退回商品的運費郵資，並更換新商品給您。</li>
			</ul>
			<div class='clear'></div>
		</div>