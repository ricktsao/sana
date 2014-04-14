<script>
	

	$(function(){
		var work_area=$("#work_area");
		
		if (!$.browser.msie ) {
			$('.vivid').adipoli({
				startEffect : "grayscale"	
			});
		}
		
		$("#up_btn").click(function(){
			work_area.scrollTo({'top':'-=188','left':'0'},500);
			return false;

		})

		$("#down_btn").click(function(){
			work_area.scrollTo({'top':'+=188','left':'0'},500);
			return false;
		})		
		
	})
</script>

<ul id="sub_navi">
	<?php foreach ($category_list as $key => $item){  ?>
	<li class="<?php echo  tryGetData('sn',$cat_info)==tryGetData('sn',$item)?"this":""; ?>">
		<a href="<?php echo fUrl("category/".tryGetData('sn',$item)); ?>"><?php echo tryGetData('title',$item); ?></a>
	</li>
	<?php } ?>
	
</ul>


<div id="btn_area">
	<a href="#" id="up_btn"></a>
	<a href="#" id="down_btn"></a>
</div>
<div id="work_area" class="tree_item">
	<ul id="work_list">
	<?php foreach ($album_list as $key => $item){  ?>	
		<li>
			<a href="<?php echo fUrl("items/".tryGetData('sn',$item)); ?>">				
				<div class="title"><?php echo tryGetData('title',$item); ?></div>
				<img src="<?php echo $item["img_filename"]; ?>" class="vivid"/>
			</a>
		</li>
	<?php } ?>
	</ul>

</div>
		
<br clear="all"/>

