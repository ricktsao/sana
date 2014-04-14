<div>
	<a href="<?php echo fUrl("editProduct");?>">新增</a>
</div>
<table class='data_table' width="95%">
	<tr class='first_row'>
		<td width="10%">商品分類</td>
		<td>商品名稱</td>
		<td width="20%">管理</td>
	</tr>
	<?php
	foreach($list as $key=>$val)
	{
		?>
		<tr <?php echo $key==0?'class="high_line"':'';?>>
			<td><?php echo $categorys[$val["category_sn"]];?></td>
			<td><?php echo $val["title"];?></td>
			<td><a href="<?php echo fUrl("editProduct/".$val["sn"]);?>">編輯</a></td>
		</tr>
		<?php
	}
	?>
</table>