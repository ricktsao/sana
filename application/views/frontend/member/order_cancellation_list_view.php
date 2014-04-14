<script>
	
	$(function(){
		sub_navi();
		
		$("#cancel_btn").click(function(){
			if( typeof($('#cancelForm').find("input[type=radio][name=order_id]:checked").val()) == 'undefined' )
			{
				alert('您尚未選擇要取消的訂單喔');
			}
			else
			{
				var check_submit = confirm('您確定取消此張訂單?');
				if(check_submit)
				{
					$('#cancelForm').submit();
				}
			}
			return false;
		});
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
<form id="cancelForm" method="post" action="<?php echo getFrontendUrl('orderCancel');?>">
<div id='primary'>
	<div id='breadCrumb'> <span id='home_icon'></span> / 交易紀錄 / <span><?php echo $page_title; ?></span> </div>
	<div id='title'> <span></span><?php echo $page_title; ?></div>
	<?php echo "<div style='text-align:center; font-size:12pt; margin: 5px'>".$this->session->flashdata('message')."</div>";?>
	<div id='order_info'><?php echo $list_remark;?><span>(共有<?php echo $total_rows;?>筆訂單)</span></div>
	<table border="0" cellspacing="0" cellpadding="0" id="dataTable">
		<tr id='first'>
			<td></td>
			<td></td>
			<td>訂單編號</td>
			<td>訂購時間</td>
			<td>付款方式</td>
            <td>訂單金額</td>
            <td>處理狀態</td>
            <td>&nbsp;</td>
		</tr>
		<?php
		if(isset($order_list) && count($order_list)>0){
			$i = 1;
			foreach($order_list as $key=>$value){
			?>
			<tr>
				<td>
				<label><input type="radio" name="order_id" id="radio" value="<?php echo $value['id']; ?>"></label>
				</td>
				<td><div><?php echo $i;?></div></td>
				<td><?php echo $value['order_number']; ?></td>
				<td><?php echo $value['ordered_on']; ?></td>
				<td><?php echo $this->config->item($value["payment"], 'payment'); ?></td>
				<td><?php echo '$ '.format_currency($value['total']); ?></td>
				<td><?php echo $this->config->item($value['status'], 'order_statuses'); ?></td>
				<td><a href="<?php echo getFrontendUrl('orderDetail/'.$value['id']);?>">看完整內容</a></td>
			</tr>
			<?php
			$i++;
			}
		}
		?>
	</table>

	<div class='clear'></div>
	<div id="pages">
		<div id="page">			
			<?php	
			if($page>1){
				$pre=$page-1;
				$pre=getFrontendUrl('orderList/'.$month.'/'.$pre);
			}else{
				$pre="#";	
			}
			
			if($page<$pageCount){
				$next=$page+1;	
				$next=getFrontendUrl('orderList/'.$month.'/'.$next);
			}else{
				$next="#";	
			}
			
			echo "<a class='btn Previous' href='".$pre."'></a>";
			
			for($i=1;$i<$pageCount+1;$i++){
				if($i!=1){
					echo "<span>|</span>";
				}
				if($page==$i){
					echo "<div class='btn_this'>".$i."</div>";
				}else{
					echo "<a href='".getFrontendUrl('orderList/'.$month.'/'.$i)."'>".$i."</a>";					
				}
				
			}
			
			echo "<a class='btn Next' href='".$next."'></a>";
			?>		
			
		</div>
	</div>
				<!-- <div id='title'> <span></span>訂單取消 </div> -->
				<div id="dotLine" class="clear"></div>
				<input type="hidden" name='return' value='cancellation' />
				<table border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td width="21%" class='grayFont'>請選擇取消因素</td>
						<td width="79%">
						<label><input type="radio" name='reason' value="價格考量" />價格考量</label>
						<label><input type="radio" name='reason' value="已無需要" />已無需要</label>
						<label><input type="radio" name='reason' value="其它" checked />其它</label>
						</td>
					</tr>
					<tr>
						<td class='grayFont'>請說明取消原因
							<div>(可輸入100個中文字)</div></td>
						<td><textarea name="content" cols="60" rows="5" onkeyup="this.value = this.value.slice(0, 100)"></textarea></td>
					</tr>
				</table>
				<div class='clear'></div>
				<a href='#' class='cancel' id="cancel_btn">確定取消</a>
				<div id="dotLine" class="clear"></div>
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
				</form>
			<div class='clear'></div>