<script>
	$(function(){
		init();		
		sub_navi();
	})
</script>

		<!-- 主要內容區塊 -->
		<div id='primary'>
			<!-- 麵包屑 -->
			<div id='breadCrumb'> <span id='home_icon'></span> / 購物車 / <span>完成訂購</span> </div>
			<div style="height:30px;"> </div>
			<div id='step'></div>
			<div id='tip'> 謝謝您的訂購您的訂購，你的訂單已經成立。訂單編號為：<?php echo $order_number;?> </div>
			<div class='sub_title' STYLE='DISPLAY:NONE'> 購物明細 <span class='sprite_btns'></span> </div>
			<table border="0" cellspacing="0" cellpadding="0" STYLE='DISPLAY:NONE'>
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
				<?php endforeach; ?>
				<?php
				$total_items = tryGetArrayValue('total_items', $edit_data);
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
			<a href='<?php echo getFrontendControllerUrl('cart', 'quest/'.$order_number); ?>' id='quest_btn'>敬邀您填寫健康諮詢問卷，SOLE關心您</a>
			<div class='sub_title'> 注意事項 <span class='sprite_btns'></span> </div>
			<div id="attention">
				<ul>
					<li>
						<div class='sprite_btns'></div>
						謝謝您的惠顧，岱宇仍保有決定是否接受訂單及出貨與否之權利。<br />
						我們將在24小時內寄一份完整的訂購需求至 service@solefitness.com.tw 供您留存。</li>
					<li>
						<div class='sprite_btns'></div>
						如果您有任何疑問，請來函至<a href="mailto:info@dyaco.com">客服中心</a>或來電至 02-25011815，客服專員將竭誠為您服務。<br />
						您也可以至<a href="<?php echo getFrontendControllerUrl('member','orderList/latest');?>">會員專區</a>中，查詢或修改您的訂單。</li>
					<li>
						<div class='sprite_btns'></div>
						我們的轉帳帳戶資訊如下：<br />
						<table border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td class='font_bold'>轉入銀行：</td>
								<td>兆豐國際商業銀行</td>
							</tr>
							<tr>
								<td class='font_bold'>銀行代號：</td>
								<td>017</td>
							</tr>
							<tr>
								<td class='font_bold'>帳號：</td>
								<td>015-09-03452-5</td>
							</tr>
							<tr>
								<td class='font_bold'>戶名：</td>
								<td>岱宇國際股份有限公司</td>
							</tr>
						</table>
					</li>
					<li STYLE='DISPLAY:NONE'>
						<div class='sprite_btns'></div>
						此訂單內的商品庫存數量，岱宇將以實際收到款項之後，決定訂單商品的出貨優先順序。</li>
					<li>
						 <font color="#F00">*請於匯款後兩日內至本網站 登入會員，於訂單查詢中填入 您的銀行帳號後5碼。</font>
					</li>
					<li>
						<div class='sprite_btns'></div>
						如訂購之商品無法順利出貨或缺貨，我們將主動通知您並取消該訂購品項。</li>
				</ul>
			</div>
			<div id='function_btn' STYLE='DISPLAY:NONE'> <a href='#' class='sprite_btns' id="btn_a">繼續購物</a> <a href='#' class='sprite_btns' id="btn_c">確認完成</a> </div>
		</div>
		<div class='clear'></div>