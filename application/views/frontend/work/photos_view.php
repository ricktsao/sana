<script>
	

	

	$(function(){
		
		
			$('#photo_list img').sp_imgAlignCenter({effect:true,//是否要有淡入的效果 true | false
 								   overflow:true,// 當圖片超出框架式否要置中 true | false
								   img_delay:false,//是否依序延遲載入 true | false
								   delay_time:200, //延遲時間
								   full_size:true
								   });
		
		$("#photo_list a").fancybox();

				
		
	})
</script>

<div id="date"><?php echo date('Y-m-d',strtotime($cat_info['create_date']))?></div>
		
<ul id="photo_list">
	<?php foreach ($photo_list as $key => $item){  ?>
	<li>
		<a href="<?php echo $item["img_filename"]?>" rel="group">			
			<img Src="<?php echo $item["img_filename"]?>" style="max-width:170px"  />
		</a>
	</li>
	<?php } ?>
</ul>