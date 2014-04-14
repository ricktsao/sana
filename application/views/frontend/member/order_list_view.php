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
					<div class='sub_nav_sprite' style="display:none"></div>
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
<form method="post" action='<?php echo  getFrontendControllerUrl('cart','favorite_to_cart')?>'>
<div id='primary'>
	<div id='breadCrumb'> <span id='home_icon'></span> / 交易紀錄 / <span><?php echo $page_title; ?></span> </div>
	<div id='title'> <span></span><?php echo $page_title; ?></div>
	<?php echo "<div style='text-align:center; font-size:12pt; margin: 5px'>".$this->session->flashdata('message')."</div>";?>
	<div id='order_info'><?php echo $list_remark;?><span>(共有<?php echo $total_rows;?>筆訂單)</span></div>
	<table border="0" cellspacing="0" cellpadding="0" id="dataTable">
		<tr id='first'>
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
	
	
	 </div>
	</form>
<div class='clear'></div>
	<div id="pages">
		<div id="page">			
			<?php	
			if($page>1){
				$pre=$page-1;
				//$pre=getFrontendUrl('orderList/'.$month.'/'.$pre);
				$pre=getFrontendUrl('orderList/'.$type.'/'.$pre);
			}else{
				$pre="#";	
			}
			
			if($page<$pageCount){
				$next=$page+1;	
				//$next=getFrontendUrl('orderList/'.$month.'/'.$next);
				$next=getFrontendUrl('orderList/'.$type.'/'.$next);
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
					//echo "<a href='".getFrontendUrl('orderList/'.$month.'/'.$i)."'>".$i."</a>";					
					echo "<a href='".getFrontendUrl('orderList/'.$type.'/'.$i)."'>".$i."</a>";
				}
				
			}
			
			echo "<a class='btn Next' href='".$next."'></a>";
			?>		
			
		</div>
	</div>