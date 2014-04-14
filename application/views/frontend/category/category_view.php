<script>
	
	$(function(){
		
		sub_navi();	
		$('.pimg_area').find('img').each(function(){
												  
				var nSrc=$(this).attr('src')+"?"+new Date().getTime();
				$(this).attr('src',nSrc);
				$(this).load(function(){
					var px=$(this).parent().width()/2-$(this).width()/2;				
					var py=$(this).parent().height()/2-$(this).height()/2;
					
					$(this).css({'top':py+"px",
								'left':px+"px"});				  
				})			
				
				
		})
		
	})
	
</script>

		<!-- 左側區塊 -->
		<div id='secondary'>
			<div id='sub_title' class='sub_nav_sprite'> 產品介紹 </div>
			<!-- 左側選單 -->
			<ul id='sub_navi' class='sub_nav_sprite'>
			<?php
			function display_categories($cats, $layer, $first='')
			{
				if($first)
				{
					echo '<ul'.$first.'>'."\n";
				}
				
				foreach ($cats as $cat)
				{
					echo '<li><a href="javascript:void(0)"><span class="sub_nav_sprite"></span>'.$cat['category']->name.'</a>'."\n";

					if (sizeof($cat['children']) > 0)
					{
						echo '<div class="sub_nav_sprite"></div><ul style="display:none">'."\n";
						foreach ($cat['children'] as $prod)
						{
							echo '<li><a href="'.getFrontendUrl('product/'.$prod->product_id).'" class="sub_nav_sprite"><span class="sub_nav_sprite"></span>'.$prod->name.'</a>'."\n";
						}
						echo '</ul>';
					}
					echo "<div class='sub_nav_sprite'></div>";
					echo '</li>';
				}
				if($first)
				{
					echo '</ul>';
				}	
			}
				
			display_categories($this->categories, 1);
			?>
			</ul>
			<div id='sub_list_foot' class='sub_nav_sprite'></div>

			<!-- Banners -->
			<ul id='links'>
				<? echo $activity_btn ?>
			</ul>
		</div>
	
		<!-- 主要內容區塊 -->
		<div id='primary'>
			<!-- 麵包屑 -->
			<div id='breadCrumb'> <span id='home_icon'></span> / 產品介紹 / <span><?php echo form_decode($category->name);?></span> </div>

			<!-- 產品類別介紹 -->
			<div id='title'><span></span>產品介紹 - <?php echo form_decode($category->name);?></div>
			<div id='content'>
			<?php echo form_decode($category->description);?>
			</div>
			<div id='category_title' class='tips_sprite '>
			<div id='left' class='tips_sprite'></div>
			<div id='right' class='tips_sprite'></div>
			<div id='arrow' class='tips_sprite'></div>
			<div id='middle'><?php echo form_decode($category->name);?></div>
			</div>

			<!-- 產品清單 -->
			<div class="clear"></div>
			<ul id='product'>
	<?php echo (count($products) < 1)?'<tr><td style="text-align:center;" colspan="6">'.lang('no_products').'</td></tr>':''?>
	<?php
	$i = 1;
	foreach ($products as $product)
	{


	?>
				<li>
				<div class='ptitle'>
				<span class='tips_sprite'></span><?php echo form_decode($product->name);?></div>
				<div class='pimg_area'>
				<?php
				$images = (array)json_decode($product->images);
				foreach ($images as $image) {
					if (isset($image->primary) && $image->primary == true) {
						$image = (string) $image->filename;
						//dprint($image); die;
						echo "<a href='".getFrontendUrl('product/'.$product->id)."'><img src='".base_url()."upload/products/full/".form_decode($image)."' /></a>";
					}
				}
				?>
				
				
				</div>
				<div class='function_area'>
					<a href='<?php echo getFrontendUrl('product/'.$product->id);?>' class='buy_btn' title='<?php echo form_decode($product->name);?>'></a>
					<a STYLE="DISPLAY:NONE;" href='#<?php echo form_decode($product->id);?>' class='compare_btn' title='<?php echo form_decode($product->name);?>'></a>
				</div>
				</li>

	<?php
		if ($i % 3 == 0)
		{
			echo "<li class='line'></li>";
		}
		$i++;
	}
	?>
			</ul>
		</div>