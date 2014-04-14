    <div id='secondary'>
                <div id='sub_title' class='sub_nav_sprite'> SiteMap </div>
                <!-- 左側選單 -->
                <ul id='sub_navi' class='sub_nav_sprite'>
                   
                  
                    
                </ul>
                <div id='sub_list_foot' class='sub_nav_sprite'></div>
    
                <!-- Banners -->
                <ul id='links'>
                    <? echo $activity_btn ?>
                </ul>
            </div>
            
    <div id='primary'>
      <div id='breadCrumb'> <span id='home_icon'></span> / <span>網站導覽</span> </div>
      <div id='title'> <span></span>網站導覽 </div>
      <table width="100%" id="content">
      	<tr>
      		<td valign="top" width="33%">
      			<div class='stitle'>關於SOLE</div>
		        <ul>
					<?php
					foreach($about_type as $val)
					{
					?>
					<li>-<a href='<?php echo getFrontendControllerUrl('about', 'about/' . $val['sn']); ?>'><?php echo $val['title']; ?></a></li>
					<?php
					}
					?>
					<li>
						-<a href='<?php echo getFrontendControllerUrl('about', 'map'); ?>'>全球版圖</a>
					</li>
				</ul>
      		</td>
      		<td valign="top" width="33%">
				<div class='stitle'>產品介紹</div>
				<ul>
					<?php
					foreach($categories as $val)
					{
					?>
					<li>-<a href='<?php echo getFrontendControllerUrl('products', 'index/' . $val['id']); ?>'><?php echo $val['name']; ?></a></li>
					<?php
					}
					?>
				</ul>
      		</td>
      		<td valign="top" width="33%">
      			<div class='stitle'>活動訊息</div>
				<ul>
					<?php
					foreach($news_type as $val)
					{
					?>
					<li>-<a href='<?php echo getFrontendControllerUrl('news', 'news/' . $val['sn']); ?>'><?php echo $val['title']; ?></a></li>
					<?php
					}
					?>
				</ul>
      		</td>
      	</tr>
      	<tr>
      		<td valign="top" width="33%">
      			<div class='stitle'>常見問題</div>
				<ul>
					<?php
					foreach($faq_type as $val)
					{
					?>
					<li>-<a href='<?php echo getFrontendControllerUrl('faq', 'faq/' . $val['sn']); ?>'><?php echo $val['title']; ?></a></li>
					<?php
					}
					?>
				</ul>
      		</td>
      		<td valign="top" width="33%">
      			<div class='stitle'>銷售服務</div>
				<ul>
					<li>-<a href='<?php echo getFrontendControllerUrl('service', 'index'); ?>'>文件下載</a></li>
					<li>-<a href='<?php echo getFrontendControllerUrl('service', 'company'); ?>'>銷售據點</a></li>
				</ul>
      		</td>
      		<td valign="top" width="33%">
      			<div class='stitle'>聯絡我們</div>
				<ul>
					<?php
					foreach($contact as $val)
					{
					?>
					<li>-<a href='<?php echo getFrontendControllerUrl('contact', 'contact/' . $val['sn']); ?>'><?php echo $val['title']; ?></a></li>
					<?php
					}
					?>
				</ul>
      		</td>
      	</tr>
      </table>
      <div class='clear'></div>
    </div>