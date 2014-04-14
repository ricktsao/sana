<script>
	$(function(){
		$("#btn_c").click(function(){
			var gift_check = $("input[type=radio][class=gift_product]").length;
			var check_num = parseInt($("input[type=radio][class=gift_product]:checked").val());
			if(gift_check > 0 && (isNaN(check_num) || check_num<1))
			{
				alert('請選擇您要的贈品');
			}
			else
			{
				$("#update_cart_form").attr("action", "<?php echo getFrontendControllerUrl('checkout');?>").submit();
			}
			return false;
		});
		
		function getSubTotal()
		{
			var gift_count = parseInt($("input[type=radio][class=gift_product]:checked").val())>0?1:0;
			var cart_items = <?php echo $total_items;?>;
			var cart_total = <?php echo $subtotal;?>;
			var plus_items = 0 + gift_count;
			var plus_total = 0;
			for(var i=0; i<$("input[type=checkbox][class=plus_product]").length; i++)
			{
				if($("input[type=checkbox][class=plus_product]:eq("+i+")").attr("checked"))
				{
					plus_items ++;
					plus_total += parseInt($("input[type=checkbox][class=plus_product]:eq("+i+")").next("input[class=plus_subtotal]").val());
				}
			}
			var box_count = $("#item_count");
			var box_total = $("#item_cost");
			
			box_count.html(cart_items+plus_items);
			//var total = cart_total+plus_total;
			//var total_format = total.priceFormat();
			//alert(total_format);
			
			box_total.html(cart_total+plus_total).formatCurrency({
				roundToDecimalPlace	: 0
			});
		}
		function sendSession(obj)
		{
			var type = obj.attr("type")=='checkbox'?'plus':'gift';
			var id = obj.val();
			var set = obj.attr("checked")=='checked'?1:0;
			$.ajax({
				url	:'<?php echo getFrontendUrl('savePlus');?>',
				type:'post',
				data:'type='+type+'&id='+id+'&set='+set
			});
		}
		getSubTotal();
		
		$("input[class$=_product]").click(function(){
			// 計算品項與小記
			getSubTotal();
			// 計入session
			sendSession($(this));
		});
	})
</script>
		<!-- 主要內容區塊 -->
		<div id='primary'>
			<!-- 麵包屑 -->
			<div id='breadCrumb'> <span id='home_icon'></span> / 購物車 / <span>購物明細</span> </div>

			<div style="height:30px;"> </div>
			<div id='step'></div>
			<div style='text-align:center'><?php echo $msg?></div>
			<div class='sub_title'> 購物明細 <span class='sprite_btns'></span> </div>
			<table border="0" cellspacing="0" cellpadding="0">
			<?php echo form_open('cart/update_cart', array('id'=>'update_cart_form'));?>
				<tr id='first'>
					<td>&nbsp;</td>
					<td>商品明細</td>
					<td>優惠價</td>
					<td>數量</td>
					<td>小計</td>
					<td>庫存</td>
					<td>變更明細</td>
				</tr>
				<tbody id='item_list'>
		<?php
		//$subtotal = 0;
		//var_dump($this->go_cart->contents());
		
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
					<td><label>
						<input type="text" id="textfield" size="4" maxlength="4" name="cartkey[<?php echo $cartkey;?>]" value="<?php echo $stock[$product['id']]>$product['quantity']?$product['quantity']:$stock[$product['id']]; ?>" />
					</label></td>
					<td>NT$<?php echo format_currency($product['price']*$product['quantity']); ?></td>
					<td><?php echo $stock[$product['id']]==0?'無庫存':$stock[$product['id']];?></td>
					<td>
					<?php
					if($login){
					?>
					<a href='<?php echo getFrontendUrl('add_favorite/'.$product['id']);?>'>下次購買</a><br />
					<?php
					}
					?>
					<a href='<?php echo getFrontendUrl('remove_item/'.$cartkey);?>'>取消</a>
					&nbsp;</td>
				</tr>
		<?php endforeach;
		?>

				</tbody>
				<!-- 加購&贈品區 -->
				<tbody>
					<?php
					if(count($gift_list) > 0)
					{
						echo "<tr id='first'>
					<td>贈品挑選區</td>
					<td>贈品名稱</td>
					<td>原價</td>
					<td>數量</td>
					<td>小計</td>
					<td>&nbsp;</td>
					<td>贈品選擇</td>
				</tr>";
						foreach ($gift_list as $product)
						{
							if($product['id'] == $plus_check['gift'])
							{
								$checked = 'checked';
							}
							else
							{
								$checked = '';
							}
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
							<td>NT$<?php echo format_currency($product['price']); ?></td>
							<td>1</td>
							<td>NT$ 0</td>
							<td><?php echo $product['quantity'];?></td>
							<td><input type="radio" name="plus[]" class="gift_product" value="<?php echo $product['id'];?>" <?php echo $checked;?> /></td>
						</tr>
						<?php
						}
					}
					if(count($plus_list) > 0)
					{
						echo "<tr id='first'>
					<td>加購優惠區</td>
					<td>優惠品名稱</td>
					<td>優惠價</td>
					<td>數量</td>
					<td>小計</td>
					<td>&nbsp;</td>
					<td>加購品選擇</td>
				</tr>";
						foreach ($plus_list as $product)
						{
							if(in_array($product['id'], array_keys($plus_check['plus'])))
							{
								$checked = 'checked';
							}
							else
							{
								$checked = '';
							}
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
							<td>NT$<?php echo format_currency($product['plus_price']); ?><br />
								<font color="#F00">原價<?php echo format_currency($product['price']); ?></font>
							</td>
							<td>1</td>
							<td>NT$<span><?php echo format_currency($product['plus_price']); ?></span></td>
							<td><?php echo $product['quantity'];?></td>
							<td>
								<input type="checkbox" name="plus[]" class="plus_product" value="<?php echo $product['id'];?>" <?php echo $checked;?> />
								<input type="hidden" class="plus_subtotal" value="<?php echo $product["plus_price"];?>" />
							</td>
						</tr>
						<?php
						}
					}
					?>
				</tbody>
			</table>
			
			<div id='checkout'>
				購物車內合計有 <span id='item_count'><?php echo $total_items;?></span> 項商品，商品總計 <span>NT </span><span id='item_cost'><?php echo format_currency($subtotal);?></span> 元
				<div>(商品數量若有變動，請點選網頁下方變更商品數量變更)</div>
			
			</div>
			
			<div class='sub_title' style="display: none"> 加購商品 <span class='sprite_btns'></span> </div>
			<ul style="display: none">
			<li>
				<div class='img'></div>	
				<div class='title'><input name="" type="checkbox" value="" />商品名稱</div>
				<div class='cost'>特惠價：<span>NT 600</span></div>		
			</li>
			<li>
				<div class='img'></div>	
				<div class='title'><input name="" type="checkbox" value="" />商品名稱</div>
				<div class='cost'>特惠價：<span>NT 600</span></div>		
			</li>
			<li>
				<div class='img'></div>	
				<div class='title'><input name="" type="checkbox" value="" />商品名稱</div>
				<div class='cost'>特惠價：<span>NT 600</span></div>		
			</li>
			<li>
				<div class='img'></div>	
				<div class='title'><input name="" type="checkbox" value="" />商品名稱</div>
				<div class='cost'>特惠價：<span>NT 600</span></div>		
			</li>
			<li class='last'>
				<div class='img'></div>	
				<div class='title'><input name="" type="checkbox" value="" />商品名稱</div>
				<div class='cost'>特惠價：<span>NT 600</span></div>		
			</li>
			<li>
				<div class='img'></div>	
				<div class='title'><input name="" type="checkbox" value="" />商品名稱</div>
				<div class='cost'>特惠價：<span>NT 600</span></div>		
			</li>
			<li>
				<div class='img'></div>	
				<div class='title'><input name="" type="checkbox" value="" />商品名稱</div>
				<div class='cost'>特惠價：<span>NT 600</span></div>		
			</li>
			
			
			</ul>
			<div id='function_btn'>
				<a href='#' onclick='javascript:update_cart_form.submit();' class='sprite_btns' id="btn_b">更新購物車</a>
				<a href='<?php echo getFrontendControllerUrl('cart','destroy_cart');?>' class='sprite_btns' id="btn_a">清空購物車</a>
				<a href='<?php echo getFrontendControllerUrl('products');?>' class='sprite_btns' id="btn_a">繼續購物</a>				
				<a href='#' class='sprite_btns' id="btn_c">確認完成</a>
			</div>
		</div>
		</form>

		<div class='clear'></div>
	</div>
</div>