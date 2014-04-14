<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<META content="Orista" name="Author"> 
<meta name="keywords" lang="zh-TW" content="<? echo tryGetData("meta_keyword",$webSetting);?>"/>
<meta name="description" content="<? echo tryGetData("meta_description",$webSetting);?>">
<title><? echo tryGetData("website_title",$webSetting);?></title>
<link href="<?php echo base_url().$templateUrl;?>css/default.css" rel="stylesheet" type="text/css">
<script src="<?php echo base_url().$templateUrl;?>js/jquery-1.8.3.min.js"></script>
<script src="<?php echo base_url().$templateUrl;?>js/jquery.cycle.all.js"></script>
<script>
	$(function(){
		$('#slide').cycle({
			pager:  '#slide_btn',      
			// callback fn that creates a thumbnail to use as pager anchor 
			pagerAnchorBuilder: function(idx, slide) { 
				return '<a href="#"></a>'; 
			} 	
		})
	
	})
</script>
<!-- 本頁使用-->
<?php echo $style_css;?>
<!-- 本頁使用-->
<?php echo $style_js;?>
</head>

<body>
<div id="primary">
	<?php echo $header;?>
	<div id="middle_area">
		<?php echo $left_menu;?>		
		<div id="content">
			<div id="btns">
				<a class="<?php echo $sub_title=="新人推薦"?"this":"";  ?>" href="<?php echo frontendUrl("recommend")?>" id="btns_1"></a> 
				<a href="https://docs.google.com/forms/d/17CqecgOQJ8JbKh9TYRz4c5jdwXd8zQllg7LXrHOTFKs/viewform" target="_blank" id="btns_2"></a> 
				<a class="<?php echo $sub_title=="內文範例"?"this":"";  ?>" href="<?php echo frontendUrl("example")?>" id="btns_3"></a> 
			</div>
			<div id="title">
				<div id="title_icon"></div><?php echo $sub_title;?>
				<div class="fb-like" data-href="http://printwind.com.tw/wind" data-layout="standard" data-action="like" data-show-faces="true" data-share="true"></div>
			</div>
			<?php echo $content;?>
		</div>
		<br clear="all"/>
	</div>
</div>
<?php echo $footer;?>

<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/zh_TW/all.js#xfbml=1";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

</body>
</html>

