<div id='breadcrumb'><a href='#'>首頁</a>&gt;<a href='#'>產品類別</a>&gt;<span>產品</span></div>

<?php
if ($member_role == 'buyer') {
?>

<div id='message' style='background-color:#ffffcc; color:#0000ff; padding:5px; margin: 10px auto; font-size: 16px; line-height:200%'>
恭喜你！你贏得了這次的競標。
<span style="font-size: 16px; color:#8c8c8c">
愛限量已經寄送了電子郵件通知你和賣方，確認你是這項拍賣的得標者。<br>
建議您主動聯絡賣方，參考 商品描述 或 關於我，依賣家指示完成交易。
</span>
</div>

<div id='seller_info' style='margin: 10px auto; font-size: 16px'>
	<table class='data_table' width="100%">
	<tr>
		<th>賣方資訊</th>
		<th>付款方式</th>
		<th>商品運送方式</th>
		<th>金額</th>
		<th>運費</th>
		<th>應付金額共計</th>
	</tr>
	<tr style='padding: 20px'>
		<td class='first_row' style='padding: 20px;text-align:center; font-size:15px'><?php echo tryGetArrayValue("seller_member_nickname", $deal_data); ?></td>
		<td class='first_row' style='text-align:center; font-size:15px'>當面付款</td>
		<td class='first_row' style='text-align:center; font-size:15px'>相約面交</td>
		<td class='first_row' style='text-align:center; font-size:15px'><?php echo '$ '.tryGetArrayValue("bid_amount", $deal_data).' 元'; ?></td>
		<td class='first_row' style='text-align:center; font-size:15px'><?php echo '$ '.tryGetArrayValue("shipping_fee", $prod_data, 0).' 元'; ?></td>
		<td class='first_row' style='text-align:center; font-size:15px'><?php echo '$ '.tryGetArrayValue("bid_amount", $deal_data).' 元'; ?></td>
	</tr>
	</table>
</div>
<?php
} elseif ($member_role == 'seller') {
?>
<div id='message' style='background-color:#ffffcc; color:#0000ff; padding:5px; margin: 10px auto; font-size: 16px; line-height:200%'>
恭喜你！你的商品已經由買家 <?php echo tryGetArrayValue("buyer_member_nickname", $deal_data); ?> 得標!!
<span style="font-size: 16px; color:#8c8c8c">愛限量已經寄送了電子郵件通知你和買家，請盡速確認是否接受此項交易。
</span>
</div>

<div id='seller_info' style='margin: 10px auto; font-size: 16px'>

	<form action="<?=getFrontendControllerUrl("bid", "confirm")?>" method="post">
	<input type="text" name="deal_sn" value="<?php echo tryGetArrayValue("sn", $deal_data);?>">
	<input type="text" name="seller_sn" value="<?php echo tryGetArrayValue("seller_member_sn", $deal_data);?>">
	<input type="text" name="product_sn" value="<?php echo tryGetArrayValue("product_sn", $deal_data);?>">
	<table class='data_table' width="100%">
	<tr>
		<th>買方資訊</th>
		<th>付款方式</th>
		<th>商品運送方式</th>
		<th>金額</th>
		<th>運費</th>
		<th>應付金額共計</th>
	</tr>
	<tr style='padding: 20px'>
		<td class='first_row' style='padding: 20px;text-align:center; font-size:15px'><?php echo tryGetArrayValue("seller_member_nickname", $deal_data); ?></td>
		<td class='first_row' style='text-align:center; font-size:15px'>當面付款</td>
		<td class='first_row' style='text-align:center; font-size:15px'>相約面交</td>
		<td class='first_row' style='text-align:center; font-size:15px'><?php echo '$ '.tryGetArrayValue("bid_amount", $deal_data).' 元'; ?></td>
		<td class='first_row' style='text-align:center; font-size:15px'><?php echo '$ '.tryGetArrayValue("shipping_fee", $prod_data,0).' 元'; ?></td>
		<td class='first_row' style='text-align:center; font-size:15px'><?php echo '$ '.tryGetArrayValue("bid_amount", $deal_data).' 元'; ?></td>
	</tr>
	<tr>
		<td colspan="6" align="center" style='font-size:15px; text-align:left; padding-left:200px'>
		<input type="radio" name="deal_status" value="2">確定接受，交易成立<br>
		<input type="radio" name="deal_status" value="9">拒絕交易
		<input type="text" style='font-size:12px; color:#8c8c8c' value="(請輸入您拒絕交易的原因...)" size=30><br><br>
		<input type="submit" value="確定送出">
		
		</td>
	</tr>
	</table>
	</form>
</div>


<?php
}
?>
<div id='product'>
		<div id='slide'>
		<a href='#' id='zoom'></a>
		<div id='slider_area'>
			<?php
			foreach($img as $val)
			{
			?>
			<img src='<?php echo base_url().$file_path."preview/".$val;?>'/>
			<?php
			}
			?>	 
		</div>
		<div id='slide_btn'>
			<div id='mask'>
				<ul>
				</ul>
			</div>
			<div class='slide_btn' id='slide_left_btn'></div>
			<div class='slide_btn' id='slide_right_btn'></div>
		</div>
	</div>
		<table id='product_info'>
				<tr id='title_row'>
					<td colspan='2'><?php echo tryGetArrayValue("title", $prod_data);?></td>
					
				</tr>
				<tr>
					<td  class='align_right'>目前出價：</td>
					<td><span class='cost'><?php echo tryGetArrayValue("price_buy_now", $prod_data);?></span>元
					<?php
					if (isNotNull($deal_data)) echo '<font style="border:1px solid #f00; color: #f00;padding:5px">已成交!!</font>';?>
					</td>
				</tr>
					<tr>
					<td  class='align_right'>剩餘時間：</td>
					<td>內容</td>
				</tr>
				<tr>
					<td  class='align_right'>物品狀況：</td>
					<td><?php echo tryGetArrayValue("condition", $prod_data);?></td>
				</tr>
					<tr>
					<td  class='align_right'>付款方式：</td>
					<td><?php echo tryGetArrayValue("payment_title", $prod_data);?></td>
				</tr>
				<tr>
					<td class='align_right'>運送方式：</td>
					<td><?php echo tryGetArrayValue("shipping_title", $prod_data);?></td>
				</tr>
				<tr>
					<td  class='align_right'>物品所在地：</td>
					<td><?php echo tryGetArrayValue("prod_in", $prod_data);?></td>
				</tr>
					<tr>
					<td  class='align_right'>開始時間：</td>
					<td><?php echo tryGetArrayValue("start_date", $prod_data);?></td>
				</tr>
				
				<?php
				if ( isNotNull(tryGetArrayValue("purchased_date_time", $prod_data, NULL)) ) {
				?>
					<tr>
						<td class='align_right'>得標者：</td>
						<td>
						<?php echo tryGetArrayValue("buyer_member_nickname", $deal_data); ?>
						</td>
					</tr>

					<tr>
						<td class='align_right'>成交時間：</td>
						<td>
						<?php
							echo tryGetArrayValue("purchased_date_time", $prod_data);
						?>
						</td>
					</tr>


				<?php
				} elseif (tryGetArrayValue("end_date", $prod_data) != '0000-00-00') {
				?>
					<tr>
						<td class='align_right'>結束時間：</td>
						<td>
						<?php
							echo tryGetArrayValue("end_date", $prod_data);
						?>
						</td>
					</tr>
				<?php
				}
				?>

				<?php
				if(tryGetArrayValue('purchased_status', $prod_data) == 0)
				{
					?>
					<tr>
						<td colspan='2' class='align_right' style='border-bottom:none;'>
							<a href='<?php echo frontendUrl("bid", "index/".tryGetArrayValue("sn", $prod_data));?>' id='buy_btn'>
								我要購買
							</a>
						</td>
					</tr>
					<?php
				}
				?>
			</table>
		<div id='sales'>
			<table>
				<tr>
					<td style='text-align:center;' colspan='2'><img src='<?php echo base_url().$templateUrl;?>images/product/pic.jpg'/>
					<div id='name'><?php echo tryGetArrayValue("member_nickname", $prod_data);?></div></td>
					
				</tr>
				<tr>
					<td style='text-align:right'>評價：</td>
					<td><div class='star this'></div>
						<div class='star'></div>
						<div class='star'></div>
						<div class='star'></div>
						<div class='star'></div></td>
				
				</tr>
				
				<tr>
					<td colspan='2'>
						<div id='sale_content'>
						賣家簡介賣家簡介賣家簡介賣家簡介賣家簡介賣家簡介賣家簡介賣家簡介賣家簡介賣家簡
						</div>
					</td>
				</tr>
				
				<tr>
					<td colspan='2' id='sale_link'>
						<a href='#'>評價與意見(777)</a>
						<a href='#'>賣家所有商品(5)</a>
						<a href='#'>商品問與答</a>						
					</td>
				
				</tr>
				
			</table>
		</div>
		<div class='clear'></div>
	</div>
<div id='product_content_title'>
	商品說明
</div>
<div id='html_area' class="unreset">
	<?php echo tryGetArrayValue("description", $prod_data);?>
</div>
<div id='product_content_title'>
	商品問與答 
	<?
	if(count($qa_reply_list)>0){echo '('.count($qa_reply_list).')';}
	?>
</div>
<table class='data_table' width="100%">
	<?php for($i=0; $i<count($qa_reply_list); $i++) {?>
	<tr>	
		<td class='first_row' width="50px">問題<?php echo ($i+1)?>:</td>
		<td><?php echo $qa_reply_list[$i]["question"]?>... by <?php echo $qa_reply_list[$i]["nickname"]?></td>
	</tr>
	<tr class='high_line'>	
		<td class='first_row'>答覆:</td>
		<td><?php echo $qa_reply_list[$i]["answer"]?></td>
	</tr>
	<?php } ?>
</table>

<?php if ($is_login && tryGetData("member_sn", $prod_data) != $this->session->userdata("member_sn")){?>
<form id="user_login_form" action="<?=fUrl("updateQuestion")?>" method="post">    
    <table class='data_table' width="100%">
    	<tr class='high_line'>
            <td >您提出的問題，只有賣家看得到，賣家可選擇是否回答，賣家回答後，才會於頁面公開顯示( 最多 250 中文字 )</td>			         
        </tr>  
        <tr class='high_line'>           
			<td><textarea name="question" style="width:100%; height:100px "></textarea></td>             
        </tr>  
        <tr>            
            <td ><input name="submit" type="submit" value='提出問題'/></td>
        </tr>                     
    </table>
    <input type="hidden" name="product_sn" value="<?php echo tryGetData("sn", $prod_data);?>" />
</form>
<?php }else if ($is_login && tryGetData("member_sn", $prod_data) == $this->session->userdata("member_sn")){?>
  
    <table class='data_table' width="100%">
    	<tr class='high_line'>
            <td >尚未回覆的問題( 最多 250 中文字 )</td>			         
        </tr>  
        <?php foreach ($not_reply_list as $key => $item) {?>
        <form id="user_login_form" action="<?=fUrl("updateAnswer")?>" method="post"> 
        <tr class='high_line'>           
			<td><?php echo tryGetData("question", $item);?></td>             
        </tr> 
        <tr class='high_line'>           
			<td><textarea name="answer" style="width:100%; height:100px "></textarea></td>             
        </tr>  
        <tr>            
            <td ><input name="submit" type="submit" value='回覆問題'/></td>
        </tr>  
        <input type="hidden" name="qa_sn" value="<?php echo tryGetData("sn", $item);?>" />
        <input type="hidden" name="product_sn" value="<?php echo tryGetData("sn", $prod_data);?>" />
        </form>   
        <?php }?>	                
    </table>
    

<?php }else {?>	
	<input type="button" onclick="jUrl('<?php echo frontendUrl("member","profile")?>')" value="提出問題" />
<?php }?>

<script>
	var product_img=Array();
	var product_img_path='';//'upload/product/';
	//["大圖","小圖"]
	<?php
	foreach($img as $key=>$val)
	{
	?>
	product_img[<?php echo $key;?>]=["<?php echo base_url().$file_path."view/".$val;?>","<?php echo base_url().$file_path."icon/".$val;?>"];
	<?php
	}
	?>


	$(function(){
		$('#slider_area').cycle({
			fx:'fadeout',
			pager:  '#mask  ul',    
			pagerAnchorBuilder: function(idx, slide) { 
				return '<li><a href="#"><img src="'+product_img_path+product_img[idx][1]+'" /></a></li>'; 
			},
			after:function(){
				var pagerIndex=$('#mask  ul .activeSlide').index();
				if(pagerIndex<0){
					pagerIndex=0;	
				}
				
				$('#zoom').attr('href',product_img_path+product_img[pagerIndex][0]);				
			}
		}).queue(function(){			
			$('#mask').sp_wheel({
				  preBtn:'#slide_left_btn',
				  nextBtn:'#slide_right_btn',
				  showCount:4,
				  liWidthTuning: 0
			});				
		});
		
		$('#zoom').fancybox();
		
	})
</script>