<style>

	#news_date {
		color:#ffac00;
		font-size:13px;
		font-weight:bold;
		margin-bottom:5px;
	}
	
	#news_title{
		color:#0094d7;
		font-size:21px;
		margin-bottom:20px;
		
	}

</style>
<div id="news_date"><?php echo date("Y-m-d",strtotime($news_info['start_date']))?></div>
<div id="news_title"> <?php echo $news_info["title"];?> </div>
<div class="html_edit">
	<?php echo $news_info["content"];?>
</div>

	<div style="padding-top:10px;"><a href="<?php echo fUrl("news");?>" id="back_btn">返回上一頁</a></div>