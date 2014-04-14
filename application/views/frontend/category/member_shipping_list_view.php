<div>
	<a href="<?php echo fUrl("editShipping");?>">新增</a>
</div>
<table class='data_table' width="95%">
	<tr class='first_row'>
		<td>出貨方式</td>
		<td>管理</td>
	</tr>
	<?php
	foreach($list as $key=>$val)
	{
		?>
		<tr <?php echo $key==0?'class="high_line"':'';?>>
			<td><?php echo $val["title"];?></td>
			<td><a href="<?php echo fUrl("editShipping/".$val["sn"]);?>">編輯</a></td>
		</tr>
		<?php
	}
	?>
</table>