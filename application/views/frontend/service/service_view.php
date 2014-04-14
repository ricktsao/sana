	
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
			<div id='breadCrumb'> <span id='home_icon'></span> / 銷售服務 / <span>文件下載</span> </div>

			
			<div id='title'><span></span>文件下載</div>
			<div id='content'>
				<?php
				foreach($data as $key=>$value)
				{
					echo '<a name="'.$value["sn"].'"></a>';
					echo $value['content'];
				}
				?>
			</div>		
			<div class="clear"></div>
		</div>