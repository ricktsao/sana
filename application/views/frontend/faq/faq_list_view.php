<style>
#pager {
	padding-top:20px;
	text-align:center;	
}


#pager a,
#pager div {
	margin:0px 3px;
	display:inline-block;
	*display:inline;
	zoom:1;
}

#pager a{
	
	color:#666;
	
}

#pager a:hover,
#pager div{
	color:#0094d7;
	text-decoration:underline;
	
	
}

</style>
<table border="0" cellpadding="0" cellspacing="0" id="faq_table">
	<tr class="first_row">
		<td>序號</td>
		<td>|</td>
		<td style="width:90%">項目</td>
	</tr>
	<tbody id="data_row">
<?php 	
	$i_count = 0;
	foreach ($faq_list as $key => $item) 
	{
	$i_count++;	
?>
	<tr>
		<td style="border-right:none;width:25px"><?php echo str_pad($i_count,2,'0',STR_PAD_LEFT) ;?></td>
		<td style="border-right:none;border-left:none;">&nbsp;</td>
		<td style="border-left:none;"><a href="<?php echo fUrl("detail/".$item["sn"]); ?>"><?php echo $item["title"]; ?></a></td>
	</tr>
<?php 
	
	}
?>

	</tbody>
</table>

<?php 	
	//dprint($pageInfo);
	if($pageInfo["pageCount"] > 1) 
	{
		echo '<div id="pager">';
		for($i=0;$i<$pageInfo["pageCount"];$i++)
		{
			if($page == ($i+1))
			{
				echo '<div>'.($i+1).'</div>';
			}
			else
			{
				//echo '<a href="'..'">'.($i+1).'</a>';
				echo '<a href="'.fUrl("index/".($i+1)).'" >'.($i+1).'</a>';
			}
		}
		echo '</div>';
	}
	
?>