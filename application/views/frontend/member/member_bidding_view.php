您下標的商品記錄：
<table class='data_table' width="95%">
	<tr class='first_row'>
		<td width="10%">下標時間</td>
		<td width="15%">拍賣編號</td>
		<td width="10%" style='display:none'>商品分類</td>
		<td>商品名稱</td>
		<td width="8%">賣家</td>
		<td width="10%">下標金額</td>
		<td width="6%" style='display:none'>數量</td>
		<td width="10%" style='display:none'>金額總計</td>
		<td width="10%">下標狀態</td>   <!-- 最高出價者 	剩餘時間 -->
		<!--  bid, deal的狀態要再三思 --><!--  bid, deal的狀態要再三思 --><!--  bid, deal的狀態要再三思 -->
	</tr>
	<?php
	foreach($list as $key=>$bid)
	{
		?>
		<tr <?php echo $key==0 ? 'class="high_line"':'';?>>
			<td><?php echo $bid["bid_date"];?></td>
			<td><?php echo $bid["product_auction_id"];?></td>
			<td style='display:none'><?php echo $bid["category_title"];?></td>
			<td><?php echo '<a href="'.frontendUrl('products', 'view/'.$bid["product_sn"]).'">'.$bid["product_title"].'</a>';?></td>
			<td><?php echo '<a href="#'.$bid["seller_member_account"].'">'.$bid["seller_member_nickname"];?></td>
			<td>$<?php echo $bid["bid_price"];?></td>
			<td style='display:none'><?php echo $bid["bid_qty"];?></td>
			<td style='display:none'>$<?php echo $bid["bid_amount"];?></td>
			<td>
			<?php
			if ($bid["deal_sn"] > 0 ) {
				if ($bid["buyer_account"] == $this->session->userdata("member_account") ) {
					echo '您已得標!';
				} else {
					echo '已結標，得標者為'.$bid["buyer_nickname"];
				}
			} else {
					echo '尚未結標';
			}
			?>
			</td>
		</tr>
		<?php
	}
	?>
</table>

