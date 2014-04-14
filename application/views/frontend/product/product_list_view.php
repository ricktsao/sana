<ul id="product_list">
<?php 
	foreach ($ps_list as $key => $item) 
	{
?>
		<li>
			<a href="<?php echo fUrl("item/".$item["sn"]); ?>" class="img">
				<img src="<?php echo $item["img_filename"]; ?>"/>								
			</a>
			<div class="title"><?php echo $item["title"]; ?><a href="<?php echo fUrl("item/".$item["sn"]); ?>" class="more"></a></div>
		</li>
<?php 
	}
?>

</ul>



<?php 	
	//dprint($pageInfo);
	if($pageInfo["pageCount"] > 1) 
	{
		$pre_page = $page - 1;
		
	
		echo '<div id="pager">';
		if($page > 1)
		{
			echo '<a href="'.fUrl("index/".$cat_sn."/".($page-1)).'" class="arrow" id="pre_btn">';
		}
		for($i=0;$i<$pageInfo["pageCount"];$i++)
		{
			if($page == ($i+1))
			{
				echo '<div>'.($i+1).'</div>';
			}
			else
			{
				//echo '<a href="'..'">'.($i+1).'</a>';
				echo '<a href="'.fUrl("index/".$cat_sn."/".($i+1)).'" >'.($i+1).'</a>';
			}
		}
		if($page < $pageInfo["pageCount"])
		{
			echo '<a href="'.fUrl("index/".$cat_sn."/".($page+1)).'" class="arrow" id="next_btn">';
		}
		echo '</div>';
	}
	
?>
