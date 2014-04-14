	
		<!-- 左側區塊 -->
		<div id='secondary'>
			<div id='sub_title' class='sub_nav_sprite'><? echo $data['title']?></div>
			<!-- 左側選單 -->
			<ul id='sub_navi' class='sub_nav_sprite'>				
					
			</ul>
			<div id='sub_list_foot' class='sub_nav_sprite'></div>

			<!-- Banners -->
			<ul id='links'>
				<? echo $activity_btn ?>
				
			</ul>
		</div>
	
		<!-- 主要內容區塊 -->
		<div id='primary'>
			<div id='breadCrumb'>
				<span id='home_icon'></span> / <span><? echo $data['title']?></span>
			</div>
			
			<div id='title'>
				<span></span><? echo $data['title']?>
			</div>
			
			<div>
			<? echo $data['content']?>
			
			</div>
			
		<div class='clear'></div>
			
 </div>
