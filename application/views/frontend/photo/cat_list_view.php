<script>
	$(function(){
			
		if (!$.browser.msie ) {
			$('.vivid').adipoli({
				startEffect : "grayscale"	
			});		
		}
	})
</script>


<div id="photo_gallery_area">
	<ul id="photo_gallery">
	<?php foreach ($category_list as $key => $item){  ?>
		<li>
			<a href="<?php echo fUrl("category/".tryGetData('sn',$item)); ?>">				
				<div class="title"><?php echo tryGetData('title',$item); ?></div>						
				<img src="<?php echo $item["img_filename"]; ?>" class="vivid"/>
				
			</a>
		</li>
	<?php } ?>	
	</ul>		
</div>


