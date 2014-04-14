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
	<div id='breadCrumb'> <span id='home_icon'></span> / 交易紀錄 / <span>最愛商品</span> </div>
	<div id='title'> <span></span>最愛商品</div>
	<form method="post" action='<?php echo  getFrontendControllerUrl('cart','favorite_to_cart')?>'>
	<table border="0" cellspacing="0" cellpadding="0">
		<tr id='first'>
			<td width="30"><input type='checkbox' id='allCheck'/></td>
			<td >(全選)</td>
			<td>商品名稱</td>
			
			<td>庫存</td>
			<td width="140px">變更</td>
		</tr>
		<?php
		if(isset($item_list) && count($item_list)>0){
		foreach($item_list as $key=>$value){
		?>
		<tr>
			<td><input type='checkbox' name='p_id[]' value='<? echo $value['id']?>'/></td>
			<td><?php
					if (empty($value['images']) === false)
					{
						echo "<img src='".base_url()."upload/products/small/".form_decode($value['images'])."'>";
					}
					?></td>
			<td><? echo $value['name']?></td>
			
			<td>1</td>
			<td><a href='<?php echo  getFrontendControllerUrl('cart','favorite_to_cart/'.$value['id'])?>' class='order_favoitem_sprite' id='add'>放入購物車</a><a href='<?php echo  getFrontendControllerUrl('cart','remove_favorite/'.$value['id'])?>' id='remove' class='order_favoitem_sprite'>移除</a></td>
		</tr>
		<?php
			}
		}
		?>
	</table>
	</form>
	
	
	<a href='#' id='allIn' class='order_favoitem_sprite'>整批放入購物車</a>
	<script>
	$('input[id=allCheck]').click(function(){
		if($(this).is(":checked")){
			$('input[type=checkbox]').attr("checked",true);	
		}else{
			$('input[type=checkbox]').attr("checked",false);	
		}
	})
	
	$('#allIn').click(function(){
		$('form').submit();						   
	})
	
	</script>
	 </div>
<div class='clear'></div>
