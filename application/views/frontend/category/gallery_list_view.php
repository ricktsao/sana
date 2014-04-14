<script>
	$(function(){
		$('#pic_area a').fancybox({
			   helpers:  {
					title : {
						type : 'inside'
					}
				}	
		});
	})
</script>

<div id='title'><?php echo $category_info["title"]?> <img src='<?php echo base_url().$templateUrl;?>images/list_icon.png'/> </div>
<div id='pic_area'>
	<ul>
	<?php foreach ($gallery_list as $key => $item) { ?>		
		<li>
			<a href='<?php echo $item["img_filename"];?>' rel="group" title='<?php echo $item["title"];?>'><img src='<?php echo $item["img_filename"];?>'/></a>
			<div class='title'><?php echo $item["title"];?></div>		
		</li>
	<?php } ?>	
	</ul>

</div>
<div id='spec_area'>
	<?php echo $product_info["description"]; ?>
	

</div>

<div class='clear'></div>



