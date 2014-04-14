<?php
	if( ! isset($cat_sn))
	{
		$cat_sn = 0;
	}
?>

<div id="left"> 
	<img src="<?php echo base_url().$templateUrl;?>images/sub_navi_img.png"/>
	<ul id="sub_navi">
	<?php 
	
		## 商品分類選單
		foreach ($p_cat_list as $key => $item) 
		{
	?>
	
		<li class="<?php echo $cat_sn==$item["sn"]?"this":"";?>"> 
			<div class="top_bg"></div>
			<a href="<?php echo frontendUrl("service","index/".$item["sn"])?>"><div>-</div><?php echo $item['title'];?><div class="bottom_bg"></div></a>			
		</li>
	<?php

		}

	?>	
	</ul>
</div>






