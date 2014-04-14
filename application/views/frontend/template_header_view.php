<div id="header">
	<a href="<?php echo frontendUrl()?>">
		<img src="<?php echo base_url().$templateUrl;?>images/logo.png">
	</a>
	<ul id="resident">
		<li><a href="http://www.printwind.com.tw/" >Home</a></li>
		<li>|</li>
		<li><a href="https://www.facebook.com/printwind" target="_blank" >風華喜帖FB</a></li>
		<li>|</li>
		<li><a href="http://blog.xuite.net/printwind/wretch" target="_blank" >風華喜帖Blog</a></li>
	</ul>
	<ul id="navi">
		<li> <a href="<?php echo frontendUrl("news")?>" id="btn_1"></a><img src="<?php echo base_url().$templateUrl;?>images/header_line.png"/></li>
		<li> <a href="<?php echo frontendUrl("service")?>" id="btn_2"></a><img src="<?php echo base_url().$templateUrl;?>images/header_line.png"/></li>
		<li> <a href="<?php echo frontendUrl("sample")?>" id="btn_3"></a> <img src="<?php echo base_url().$templateUrl;?>images/header_line.png"/></li>
		<li> <a href="<?php echo frontendUrl("flow")?>" id="btn_4"></a><img src="<?php echo base_url().$templateUrl;?>images/header_line.png"/> </li>
		<li> <a href="<?php echo frontendUrl("faq")?>" id="btn_5"></a><img src="<?php echo base_url().$templateUrl;?>images/header_line.png"/> </li>
		<li> <a href="<?php echo frontendUrl("contact")?>" id="btn_6"></a> </li>
	</ul>
</div>

<div id="kv">
	<div id="slide"> 
		<!-- 958 * 230  --> 	
	<?php foreach ($banner_list as $key => $item){  ?>	
		<a <?php echo getHref(tryGetData('url',$item), tryGetData('target',$item)); ?>>
			<img src="<?php echo $item["filename"]; ?>" />
		</a>
	<? } ?>	
	</div>
	<div id="slide_btn"></div>
</div>


