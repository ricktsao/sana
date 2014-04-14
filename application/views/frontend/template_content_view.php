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
<script>
	$(function(){
		$("#sub_navi a > span").click(function(){
			var target_obj=$(this).parent().siblings('ul');
			if(target_obj.is(":hidden")){
				target_obj.show();
				$(this).parents('li').eq(0).addClass('this');
			}else{
				target_obj.hide();
				$(this).parents('li').eq(0).removeClass('this');
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

	<?php echo $header;?>
	
	<?php 
		$banner_url = "";
		if($banenr_info != null)
		{
			$banner_url = $banenr_info["filename"];
		}
	?>
	<div id="kv" style="background:url(<?php echo $banner_url; ?>) center top no-repeat;"></div>
	<div id="primary">
		<?php echo $left_menu;?>
		<div id="right">			
			<div id="breadcrumb">
				<?php echo $navi_path;?>
			</div>
			<h1><?php echo $sub_title;?></h1>
			<?php echo $content;?>
			
		</div>
		<br clear="all"/>
	</div>
	<?php echo $footer;?>	
	
</body>
</html>

