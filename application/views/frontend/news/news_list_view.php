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
<div id="hot_area">
	<div id="img"> <a href="<?php echo fUrl("detail/".$top_news["sn"]); ?>"> <img src="<?php echo $top_news["img_filename"]; ?>"/> </a> </div>
	<div id="hot_contnet">
		<div id="hot_news_title"> <?php echo $top_news["title"]; ?> </div>
		<div id="hot_news_date"><?php echo date("Y-m-d",strtotime($top_news['start_date']))?></div>
		<div id="hot_news_text"><?php echo $top_news["content"]; ?></div>
		<a href="<?php echo fUrl("detail/".$top_news["sn"]); ?>">More Info</a> </div>
</div>

<table border="0" cellpadding="0" cellspacing="0" id="news_list">
	<tr id="title_row">
		<td>日期</td>
		<td>內容</td>
	</tr>
<?php 	
	$i_count = 0;
	foreach ($news_list as $key => $item) 
	{
?>
	<tr>
		<td><?php echo date("Y-m-d",strtotime($item['start_date']))?></td>
		<td><a href="<?php echo fUrl("detail/".$item["sn"]); ?>"><?php echo $item["title"]; ?></a></td>
	</tr>
<?php 
	$i_count++;	
	}
?>
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

