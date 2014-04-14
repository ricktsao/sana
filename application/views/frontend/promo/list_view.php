<table>
	<?php foreach ($promo_list as $key => $item){  ?>		
	<tr>	
		<td class="img"><div><img src="<?php echo $item["img_filename"]; ?>"/></div></td>
		<td>
			<div class="content">
				<div class="date"><?php echo date('Y-m-d',strtotime($item['start_date']))?></div>
				<h2><?php echo tryGetData('title',$item); ?></h2>
				<div class="text"><?php echo tryGetData('brief',$item); ?></div>
				<a href="<?php echo fUrl("detail/".tryGetData('sn',$item)); ?>">more info</a>
			</div>
		</td>
	</tr>
	<? } ?>	
</table>
