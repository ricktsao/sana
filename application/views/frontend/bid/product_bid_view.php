
	<style type="text/css">
	.confirm-div{display:none; border: 1px solid #ffccff; color:#cc0000; padding: 10px; margin:10px auto;}
	</style>
	<script>
	// assumes you're using jQuery
	$(document).ready(function() {
	$('.confirm-div').hide();
	<?php if(isNotNull(tryGetData('msg', $edit_data, NULL))){ ?>
	$('.confirm-div').html('<?php echo tryGetData("msg", $edit_data); ?>').show();
	});
	<?php } ?>
	</script>

	<div class='confirm-div'></div>

		<fieldset style='border:1px solid #ccc; margin: 20px auto; padding:10px'>
		<legend style='border:1px solid #ccc; padding: 5px'>商品資訊</legend>

			<div style='font-size:11pt;padding:10px 60px; background-color:#f9f9f9; border-bottom: 1px dashed #ff0000'>
			<p>請詳加檢視底下商品資訊以及您的出價是否正確無誤：
			<table style='width: 100%;'>
			<tr>
				<?php
						if(tryGetData("show_img", $edit_data, FALSE))
						{
							?>
							<td valign='middle' align='left' style='font-size:11pt; line-height:200%'>
								<img src='<?php echo tryGetArrayValue("show_img", $edit_data, FALSE);?>' alt='<?php echo tryGetArrayValue("show_img", $edit_data, FALSE);?>' />
							</td>
							<?php
						}
				?>
				<td style='font-size:11pt; line-height:250%'>						
				<p>商品名稱：<?php echo tryGetData('product_title', $edit_data, NULL);?>
				<p>割愛價：<?php echo tryGetData('price_buy_now', $edit_data, NULL);?>元
				<p>拍賣編號：<?php echo tryGetData('product_auction_id', $edit_data, NULL);?>
				<p>賣家暱稱：<?php echo tryGetData('seller_member_nickname', $edit_data, NULL);?>
				<p>起始日期：<?php echo tryGetData('start_date', $edit_data, NULL);?>
				<p>截止日期：<?php echo tryGetData('end_date', $edit_data, NULL);?>

				</td>
				
				<td align='center' style='width:50%;font-size:11pt; line-height:250%'>
<?php
//$bidded_result = tryGetData('bidded_result', $edit_data, NULL);
//if ( isNotNull($bidded_result) ) {
if (empty($bidded_result) == false) {
	echo '<div style="color: #ff0000; font-size:12pt">'.$bidded_result.'<br>';
	echo '<a style="border:1px solid #ccc; background-color:#f2f2f2" href="'.fUrl('index/'.tryGetData('product_sn', $edit_data, 0)).'">返回</a>';
} else {
?>
				<form method="post" action="<?php echo fUrl('bidProduct/'.tryGetData('product_sn', $edit_data, 0))?>">
				<p><p style="color: #0000ff;">您確定要以 <b><?php echo tryGetData('price_buy_now', $edit_data, NULL);?></b> 元 購買 <b><?php echo tryGetData('product_title', $edit_data, NULL);?></b>??
				<p>會員密碼：<input type='password' name='login_password' size=12>
				<input type='hidden' name='checksum' value='<?php echo tryGetData('checksum', $edit_data, 0);?>'>
				<input type='hidden' name='product_sn' value='<?php echo tryGetData('product_sn', $edit_data, 0);?>'>
				<input type='hidden' name='product_title' value='<?php echo tryGetData('product_title', $edit_data, '');?>'>
				<input type='hidden' name='product_id' value='<?php echo tryGetData('product_id', $edit_data, '');?>'>
				<input type='hidden' name='product_auction_id' value='<?php echo tryGetData('product_auction_id', $edit_data, NULL);?>'>
				<input type='hidden' name='price_buy_now' value='<?php echo tryGetData('price_buy_now', $edit_data, NULL);?>'>
				<input type='hidden' name='seller_member_sn' value='<?php echo tryGetData('seller_member_sn', $edit_data, NULL);?>'>
				<input type='hidden' name='seller_member_account' value='<?php echo tryGetData('seller_member_account', $edit_data, NULL);?>'>
				<input type='hidden' name='seller_member_nickname' value='<?php echo tryGetData('seller_member_nickname', $edit_data, NULL);?>'>
				<input type='hidden' name='qty' value='1'>
				<?php 
				if (isNotNull(tryGetData('price_buy_now', $edit_data, NULL)) ) {
					// 第一階段都採用直接購買價! 
				?>
					<input type='hidden' name='bid_price' value='<?php echo tryGetData('price_buy_now', $edit_data);?>'>
				<?php
				} else {
					// 第二階段之後才會接受讓買家輸入競標價
				?>
					<input type='hidden' name='bid_price' value='999999999'>
				<?php
				}
				?>
				
				<input type='hidden' name='product_auction_id' value='<?php echo tryGetData('product_auction_id', $edit_data, NULL);?>'>
				<p><input type="button" value="取消返回">&nbsp;<input type="submit" value="確認購買">


<?php
}
?>
				</form>
				</td>
			</tr>
			</table>

		
		</div>

		<div style='clear:both;font-size:12pt; line-height:200%;color:#ca0000'>
		按下「確認購買」 之前，請確定你已經讀過<a href="#" style="color:#0000ff">使用規範</a>且同意遵守這些規範。如果你不同意，請按「取消返回」。<br>
		請注意：一旦確認購買成功，您將無法取消；您下訂後仍須等待賣家接受您的訂單，賣家若不接受您的下訂，則代表交易失敗。
		</div>

		</fieldset>
