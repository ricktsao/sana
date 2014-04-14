<script>
	$(function(){
		init();		
		sub_navi();
		tab();
		
		$('.area_title').click(function(){
			var obj=$(this).parent().children('.show_area');
			if(obj.is(':hidden')){				
				obj.show();	
				$(this).parent().addClass('this');
			}else{				
				obj.hide();	
				$(this).parent().removeClass('this');
			}
		
		})
		
	})
</script>	
		<!-- 左側區塊 -->
		<div id='secondary'>
			<div id='sub_title' class='sub_nav_sprite'> 銷售服務 </div>
			<!-- 左側選單 -->
			<ul id='sub_navi' class='sub_nav_sprite'>
				<?php
				foreach($side_list as $key=>$value){
				?>
				<li><a href='<?php echo getFrontendUrl($key)?>'><span class='sub_nav_sprite'></span><?php echo $value?></a>
					<div class='sub_nav_sprite'></div>					
				</li>
				<?php
				}
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
			<div id='breadCrumb'> <span id='home_icon'></span> / 銷售服務 / <span>銷售據點</span> </div>

			
			<div id='title'><span></span>銷售據點</div>
			<div id='content'>
                <ul id='tab_btn'>
                	<?php
					foreach($tab_list as $key=>$val){
					?>
                    <li <?php echo $key==0?"class='this'":""; ?>><?=$val["title"]?><span></span></li>
                    <?php
					}
					?>
                </ul>
                <ul id='tab_content'>
                	<?php
					foreach($tab_list as $key=>$val)
					{
					?>
                    <li <?php echo $key==0?'':'style="display:none"'; ?>>
                        <ul>
                        	<?php
							foreach($tab_content[$val["sn"]] as $content)
							{
								if(trim($content["content"]) == '') continue;
							?>
                            <li class='this'>
                                <div class='area_title'><span class='service_sprite'></span><?=$content["title"]?></div>
                                <div class="show_area">
                                <?php echo $content["content"];?>
                                </div>
                            </li>
                            <?php
							}
							?>
                        </ul>
                    </li>
                    <?php
					}
					?>
                    
                </ul>
			</div>		
			<div class="clear"></div>
		</div>