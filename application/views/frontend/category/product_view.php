<script>
	function imgResize(){
		var px=$('#photo').width()/2-$('#photo > img').width()/2;
		var py=$('#photo').height()/2-$('#photo > img').height()/2;
		$('#photo > img').css({'top':py,
							  'left':px});
	}
	
	$(function(){
		
		sub_navi();
		//tab();
		
		var sldeUlWidth=$('#slide_mask li').length*58+($('#slide_mask li').length-1)*5;
		$('#slide_mask ul').width(sldeUlWidth);		
		
		$('#right_btn').click(function(){											
			$('#slide_mask').scrollTo({'top':'0','left':'+=295'},500);					
		})
		
		$('#left_btn').click(function(){											
			$('#slide_mask').scrollTo({'top':'0','left':'-=295'},500);				
		})
		
		
		$('.f_media')
				.attr('rel', 'media-gallery')
				.fancybox({
					openEffect : 'none',
					closeEffect : 'none',
					prevEffect : 'none',
					nextEffect : 'none',

					arrows : false,
					helpers : {
						media : {},
						buttons : {}
					}
				});
		$('#zoom').fancybox();
		$('#zoom_area').fancybox();

		
		$('.product_img').click(function(){
			
				var targetHref=$(this).attr('href')+"?"+new Date().getTime();
				$('#photo').html("<img src='"+targetHref+"'/>").ready(function(){
																		$("#photo").children('img').load(function(){
																			imgResize();
																			
																		})			
																		$('#zoom').attr('href',targetHref.replace('/medium/','/full/'));
																		$('#zoom_area').attr('href',targetHref.replace('/medium/','/full/'));
																				});
				
				
				return false;
		})		
		
		
		//處理第一章圖片
		var imgObj=$('#photo').children('img');
		var nsrc=imgObj.attr('src')+"?"+new Date().getTime();
		imgObj.attr('src',nsrc);		
		imgObj.load(function(){							
							$('#zoom').attr('href',$(this).attr('src').replace('/medium/','/full/'));
							$('#zoom_area').attr('href',$(this).attr('src').replace('/medium/','/full/'));
							imgResize();
							
		})
		
		// Ted update 增加頁籤樣板並套入版面
		var tab_name = new Array();
		var tab_content = new Array();
		
		function get_tab_data(tab_class_name,tab_div_id){
			for(var i=0; i<$("."+tab_class_name).length; i++)
			{
				if(i >= 6) break;
				tab_name[i] = $("."+tab_class_name+":eq("+i+")").find(".name").html();
				tab_content[i] = $("."+tab_class_name+":eq("+i+")").find(".content").html();
			}
			
			$("."+tab_class_name).next("br").remove();
			$("."+tab_class_name).remove();
			
			$("#"+tab_div_id).append('<ul id="tab_btn"></ul>');
			$("#"+tab_div_id).append('<div id="tab_line_bg"></div>');
			$("#"+tab_div_id).append('<ul id="tab_content"></ul>');
			
			$.each(tab_name,function(key,val)
			{
				$("#tab_btn").append('<li class="tab_btn_'+key+'"><div class="left"></div><div class="middle">'+val+'</div><div class="right"></div></li>');
			});
			$.each(tab_content,function(key,val)
			{
				$("#tab_content").append('<li class="tab_content_'+key+'">'+val+'</li>');
			});
			$("li[class^=tab_content]").css("display","none");
		}	
		//get_tab_data('tab_row','tab_div');
		tab();
		$("li[class^=tab_btn]:eq(0)").click();
		
		
		$('#product').find('img').each(function(){
												  
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
			<!--
			<ul id='sub_navi999' class='sub_nav_sprite'>
				<li><a href='javascript:void(0)'><span class='sub_nav_sprite'></span>電動跑步機</a>
					<div class='sub_nav_sprite'></div>
					<ul style="display:none">
						<li><a href='#' class='sub_nav_sprite'><span class='sub_nav_sprite'></span>F63</a></li>
						<li><a href='#' class='sub_nav_sprite'><span class='sub_nav_sprite'></span>F63</a></li>
					</ul>
				</li>
				<li><a href='javascript:void(0)'><span class='sub_nav_sprite'></span>電動跑步機</a>
					<div class='sub_nav_sprite'></div>
					<ul style="display:none">
						<li><a href='#' class='sub_nav_sprite'><span class='sub_nav_sprite'></span>F63</a></li>
						<li><a href='#' class='sub_nav_sprite'><span class='sub_nav_sprite'></span>F63</a></li>
					</ul>
				</li>
			</ul>
			-->

			<ul id='sub_navi' class='sub_nav_sprite'>
			<?php
			function display_categories($cats)
			{
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
			}
			display_categories($this->categories);
			?>
			</ul>


			<div id='sub_list_foot' class='sub_nav_sprite'></div>

			<!-- Banners -->
			<ul id='links'>
				<? echo $activity_btn ?>
			</ul>
			<!-- plus product -->
			<div>
				<?php
				if(count($plus_list) > 0 || count($gift_list) > 0)
				{
				?>
				<div class="sub_list_deitail_left">
					<p class="sub_list_p"><b><?php echo (count($plus_list) > 0 || count($gift_list) > 0)?'提供豐富的贈品與超值優惠品<br />加購商品及贈品選購於確認購物後勾選':'';?></b></p>
					<?php
					if(count($gift_list) > 0)
					{
					?>
						<div class="sub_list_title"><?php echo count($gift_list) > 0?"贈品挑選區":''; ?></div>
						<?php
						foreach ($gift_list as $plus_product)
						{
							$img_url = '';
							$images = (array)json_decode($plus_product["images"]);
							foreach ($images as $image) {
								if (isset($image->primary) && $image->primary == true) {
									$image = (string) $image->filename;
									//dprint($image); die;
									$img_url = base_url()."upload/products/full/".form_decode($image);
								}
							}
							if($img_url != '')
							{
							?>
							<div class="sub_list_pic"><img src="<?php echo $img_url;?>" width="190" height="170"></div>
							<?php
							}
							?>
							<p class="sub_list_buy_title">
								<span><?php echo $plus_product["name"];?></span><br />
							</p>
						<?php
						}
						?>
					
					<hr class="sub_list_hr"></hr>
					<?php
					}
					if(count($plus_list) > 0)
					{
					?>
						<div class="sub_list_title"><?php echo count($plus_list) > 0?"加購優惠區":'';?></div>
						<?php
						foreach ($plus_list as $plus_product)
						{
							$img_url = '';
							$images = (array)json_decode($plus_product["images"]);
							foreach ($images as $image) {
								if (isset($image->primary) && $image->primary == true) {
									$image = (string) $image->filename;
									//dprint($image); die;
									$img_url = base_url()."upload/products/full/".form_decode($image);
								}
							}
							if($img_url != '')
							{
							?>
							<div class="sub_list_pic">
								<?php
								if($plus_product["plus_only"] == 0)
								{
									echo '<a href="'.getFrontendUrl('product/'.$plus_product['id']).'"><img src="'.$img_url.'" width="190" height="170"></a>';
								}
								else
								{
									echo '<img src="'.$img_url.'" width="190" height="170">';
								}
								?>
							</div>
							<?php
							}
							?>
						<p class="sub_list_buy_title">
							<span>
								<?php
								if($plus_product["plus_only"] == 0)
								{
									echo '<a href="'.getFrontendUrl('product/'.$plus_product['id']).'">'.$plus_product["name"].'</a>';
								}
								else
								{
									echo $plus_product["name"];
								}
								?>
							</span><br />
							<div class="sub_list_buy">原價 <b><?php echo $plus_product["price"];?></b> 元<span>加購價 <b><?php echo $plus_product["plus_price"];?></b> 元</span></div>
						</p>
						<?php
						}
					}
					?>
				</div>
				<?php 
				}
				/*
				<ul id="sub_plus_product">
					<?php echo (count($plus_list) > 0 || count($gift_list) > 0)?'<li class="plus_name">'.form_decode($product->name).'提供豐富的贈品與超值優惠品</li><li class="plus_memo">加購商品及贈品選購於確認購物後勾選</li>':'';?>
					<?php
					echo count($gift_list) > 0?"<li class='plus_title'>贈品挑選區</li>":'';
					foreach ($gift_list as $plus_product)
					{
					?>
						<li>
						<div class='ptitle'>
						<span class='tips_sprite'></span><?php echo $plus_product["name"];?></div>
						<div class='pimg_area'>
						<?php
						$images = (array)json_decode($plus_product["images"]);
						foreach ($images as $image) {
							if (isset($image->primary) && $image->primary == true) {
								$image = (string) $image->filename;
								//dprint($image); die;
								echo "<img src='".base_url()."upload/products/full/".form_decode($image)."' />";
							}
						}
						?>
						</div>
						</li>
					<?php
					}
					echo count($plus_list) > 0?"<li class='plus_title'>加購優惠區</li>":'';
					foreach ($plus_list as $plus_product)
					{
					?>
						<li>
						<div class='ptitle'>
						<span class='tips_sprite'></span><?php echo $plus_product["name"];?></div>
						<div class='pimg_area'>
						<?php
						$images = (array)json_decode($plus_product["images"]);
						foreach ($images as $image) {
							if (isset($image->primary) && $image->primary == true) {
								$image = (string) $image->filename;
								//dprint($image); die;
								echo "<img src='".base_url()."upload/products/full/".form_decode($image)."' />";
							}
						}
						?>
						</div>
						原價:<?php echo $plus_product["price"];?> 加購價:<?php echo $plus_product["plus_price"];?>
						</li>
					<?php
					}
					?>
				</ul>
				 * */
				 ?>
			</div>
		</div>
	
		<!-- 主要內容區塊 -->
		<div id='primary'>
			<!-- 麵包屑 -->
			<div id='breadCrumb'> <span id='home_icon'></span> / 產品介紹 / <span><?php echo form_decode($category->name);?></span> </div>

			<div style='height:30px'></div>
			<div id='slide'>
				<div id='slide_area'>
					<div id='flag'><?php if(empty($product->flag_img)===false){ echo '<img src="'.$product->flag_img.'" width="83px" height="94px" />'; } ?></div>
					<a id='zoom_area' href='javascript:void(0)'></a>
					<a id='zoom' class='product_sprite_img' href='javascript:void(0)'>
					</a>
					<div id='photo'>
						<?php
						$images = (array)json_decode($product->images);
						foreach ($images as $image) {
							if (isset($image->primary) && $image->primary == true) {
								echo "<img alt='photo' src='".base_url()."upload/products/medium/".form_decode($image->filename)."'>";
							}
						}
						?>
					</div>
				</div>
				<div id='slide_scroll'>
					<div class='product_sprite_img slide_btn' id='left_btn'></div>
					<div class='product_sprite_img slide_btn' id='right_btn'></div>
					<div id='slide_mask'>
						<ul>
						<?php
						if (empty($product->video)===false) {
						?>
							<li><a href='<?php echo form_decode($product->video); ?>' class='f_media'><img src='<? echo base_url();?>template/images/product/icon_media.png'/></a></li>
						<?
						}
						?>
				<?php
				$images = (array)json_decode($product->images);
				foreach ($images as $image) {
					if (true) {//(isset($image->primary) && $image->primary !== true) {

						echo "<li><a href='".base_url()."upload/products/medium/".form_decode($image->filename)."' class='product_img'><img src='".base_url()."upload/products/thumbnails/".form_decode($image->filename)."' width='53px' height='53px'/></a></li>";
					}
				}
				?>
						</ul>
					</div>
				</div>
			</div>
			<div id='product_info'>
				<div id='p_title'><?php echo form_decode($product->name); ?>
					<div class="fb-like" data-href="<?php echo current_url(); ?>" data-send="false" data-layout="button_count" data-width="92" data-show-faces="true" style="float:right;"></div>
				</div>
				<div id='p_text'> <?php echo $product->spec; ?></div>
				<table border="0" cellspacing="0" cellpadding="00">
					<tr>
						<td rowspan="2"><div class='product_sprite_img' id='icon_golden'></div></td>
						<td id='cost_1'>NT$<?php echo format_currency($product->saleprice); ?></td>
						<!-- 預購按鈕 新增 preOrder類別 -->
						<td rowspan="2">
			<?php
			$attributes = array('id'=>'shopping1');
			echo form_open(getFrontendControllerUrl('cart','add_to_cart'), $attributes); 
			?>
			<input type="hidden" name="id" value='<?php echo $product->id?>'>
			<input type="hidden" name="cartkey" value=''>
			<input type="hidden" name="quantity" value='1'>
			<?php
			if(format_currency($product->saleprice) > 0 && form_decode($product->quantity) > 0)
			{
			?>
			<a href='#' onclick="shopping1.submit();" id='btn_buy' class='product_sprite_img'></a>
			<?php
			}
			else
			{
				echo '<img src="'.base_url().'template/images/dis_buy.png" />';
			}
			?>
			</form>
						</td>
						<td rowspan="2"><a href='#' id='addToList' title='' STYLE="DISPLAY:NONE;"></a> 尚有庫存：<span><?php echo form_decode($product->quantity)<0?0:form_decode($product->quantity); ?></span></td>
					</tr>
					<tr>
						<td  id='cost_2'>原價 NT$<del><?php echo format_currency($product->price); ?></del></td>
					</tr>
				</table>
				<ul STYLE="DISPLAY:NONE;">
					<!-- <li style="margin-right:3px"> <a href='#' title=''><img src='<? //echo base_url();?>template/images/img_mainproj.png' alt=''/></a> </li>
					<li> <a href='#' title=''><img src='<? //echo base_url();?>template/images/img_promo.png' alt=''/></a> </li> -->
				</ul>

				<?php echo form_decode($product->excerpt); ?>

			</div>
			<div class='clear'></div>

			<?php
			//echo $product->description;
			?>
			<div id='btn_area'>
            <div id="tab_div">
				<ul id="tab_btn">
					<?php
					for($i=1; $i<7; $i++)
					{
						$tab_title_name = 'tab_title_0'.$i;
						if($product->$tab_title_name == '') continue;
						echo '<li class="tab_btn_'.$i.'"><div class="left"></div><div class="middle">'.$product->$tab_title_name.'</div><div class="right"></div></li>';
					}
					?>
				</ul>
				<div id="tab_line_bg"></div>
				<ul id="tab_content">
					<?php
					for($i=1; $i<7; $i++)
					{
						$tab_content_name = 'tab_content_0'.$i;
						echo '<li class="tab_content_'.$i.'">'.$product->$tab_content_name.'</li>';
					}
					?>
				</ul>
			</div>
			
			<?php
			$attributes = array('id'=>'shopping2');
			echo form_open(getFrontendControllerUrl('cart','add_to_cart'), $attributes); 
			?>
			<input type="hidden" name="id" value='<?php echo $product->id?>'>
			<input type="hidden" name="cartkey" value=''>
			<input type="hidden" name="quantity" value='1'>
			<?php
			if(format_currency($product->saleprice) > 0 && form_decode($product->quantity) > 0)
			{
			?>
			<a href='#' onclick="shopping2.submit();" id='btn_buy' class='product_sprite_img' style="float: right;"></a>
			<div style="clear: both"></div>
			<?php
			}
			?>
			</form>
			<?php
			/*
			<hr />
			
			<ul id='product'>
				<div id="plus_title">
					<?php echo (count($plus_list) > 0 || count($gift_list) > 0)?'<span class="plus_name">'.form_decode($product->name).'提供豐富的贈品與超值優惠品</span><br /><span class="plus_memo">加購商品及贈品選購於確認購物後勾選</span>':'';?>
				</div>
				<?php
				$i = 1;
				echo count($gift_list) > 0?"<li class='plus_title'>贈品挑選區</li>":'';
				foreach ($gift_list as $plus_product)
				{
				?>
							<li>
							<div class='ptitle'>
							<span class='tips_sprite'></span><?php echo $plus_product["name"];?></div>
							<div class='pimg_area'>
							<?php
							$images = (array)json_decode($plus_product["images"]);
							foreach ($images as $image) {
								if (isset($image->primary) && $image->primary == true) {
									$image = (string) $image->filename;
									//dprint($image); die;
									echo "<img src='".base_url()."upload/products/full/".form_decode($image)."' />";
								}
							}
							?>
							</div>
							</li>
			
				<?php
					if ($i % 3 == 0)
					{
						echo "<li class='line'></li>";
					}
					$i++;
				}
				echo count($plus_list) > 0?"<li class='plus_title'>加購優惠區</li>":'';
				$i = 1;
				foreach ($plus_list as $plus_product)
				{
				?>
							<li>
							<div class='ptitle'>
							<span class='tips_sprite'></span><?php echo $plus_product["name"];?></div>
							<div class='pimg_area'>
							<?php
							$images = (array)json_decode($plus_product["images"]);
							foreach ($images as $image) {
								if (isset($image->primary) && $image->primary == true) {
									$image = (string) $image->filename;
									//dprint($image); die;
									echo "<img src='".base_url()."upload/products/full/".form_decode($image)."' />";
								}
							}
							?>
							</div>
							原價:<?php echo $plus_product["price"];?> 加購價:<?php echo $plus_product["plus_price"];?>
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
			 * 
			 */
			?>
			</div>
		</div>
		<div class='clear'></div>
	</div>