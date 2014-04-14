	
		<!-- 左側區塊 -->
		<div id='secondary'>
			<div id='sub_title' class='sub_nav_sprite'> 國際優質評論</div>
			<!-- 左側選單 -->
			<ul id='sub_navi' class='sub_nav_sprite'>				
				<li>
				<a href='<?php echo getFrontendUrl('review/')?>'><span class='sub_nav_sprite'></span>國際優質評論</a>
					<div class='sub_nav_sprite'></div>					
				</li>			
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
				<span id='home_icon'></span> / <span>國際優質評論</span>
			</div>
			
			<div id='title'>
				<span></span>國際優質評論
			</div>
			<?php
			foreach($data as $key=>$value){
			?>
			<div class="review_list">
				<a href="<?php echo $value['url']?>" target='_blank'><img src="<? echo base_url();?>upload/website/normal/<?php echo $value['filename']?>"></a>
				<h3><?php echo $value['title']?></h3>
				<div class="review_contact">
				<?php echo $value['content']?>
				</div>
			</div>
			<?php
				if($key==2){
			?>
			<div class="news_line" style="clear:both"><img src="<? echo base_url();?>template/images/review/review_line.jpg"></div>	
			<?php
				}
			?>
			<?php
			}
			?>
		<div class='clear'></div>
			<div id="pages">
			<div id="page">			
			<?php	
			if($page>1){
				$pre=$page-1;
				$pre=getFrontendUrl('review/'.$pre);
			}else{
				$pre="#";	
			}
			
			if($page<$pageCount){
				$next=$page+1;	
				$next=getFrontendUrl('review/'.$next);
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
					echo "<a href='".getFrontendUrl('review/'.$i)."'>".$i."</a>";					
				}
				
			}
			
			echo "<a class='btn Next' href='".$next."'></a>";
			?>		
			
			</div>
			</div>
 </div>
