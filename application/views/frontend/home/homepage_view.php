<script>
$(function() {
				$('.hs_wheel').hs_wheel({					
					liWidth:90,
					liWidthTuning:15,
					loop:true,				
					showCount: 7				
				});				
			});
</script>
<div id="kv"></div>

<div id="product">
	<div>
	<div id="product_title">產品介紹</div>
		<div class='hs_wheel'>
			<div class="wheel_viewport">
				<ul>
				<?php foreach ($gallery_list as $key => $item){  ?>				
					<li>				
						<a <?php echo getHref(tryGetData('url',$item), tryGetData('target',$item)); ?> class="img">
							<img src="<?php echo $item["filename"]; ?>" />
						</a>
						<div class="title">
							<?php echo tryGetData('title',$item); ?>
						</div>
					</li>
				<? } ?>
				</ul>
			</div>		
		</div>
	</div>
</div>



<?php echo tryGetData('content',$addr_info); ?>

