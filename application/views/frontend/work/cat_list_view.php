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

<div id="btn_area">
	<a href="#" id="up_btn"></a>
	<a href="#" id="down_btn"></a>
</div>
<div id="work_area">
	<ul id="work_list">
		<?php foreach ($category_list as $key => $item){  ?>	
		<li>
			<a href="<?php echo fUrl("photos/".tryGetData('sn',$item)); ?>">				
				<div class="title"><?php echo tryGetData('title',$item); ?></div>
				<img src="<?php echo $item["img_filename"]; ?>" class="vivid"/>
			</a>
		</li>
		<?php } ?>	
	</ul>

</div>

