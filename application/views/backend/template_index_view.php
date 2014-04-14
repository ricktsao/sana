<!-- saved from url=(0022)http://internet.e-mail -->
<!DOCTYPE html>
<html >
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=8" />
<title>後端管理介面</title>
<link href="<?php echo site_url()."/".$templateUrl?>css/layout.css" rel="stylesheet" type="text/css" />
<!--jquery-->
<script src="<?php echo site_url()."/".$templateUrl?>js/jquery.js" ></script>
<!--jquery ui-->
<script src="<?php echo site_url()."/".$templateUrl?>js/jquery-ui-1.8.18.custom.min.js"></script>
<link href="<?php echo site_url()."/".$templateUrl?>js/ui-themes/smoothness/jquery-ui-1.8.18.custom.css" rel="stylesheet" type="text/css" />
<!--elfinder-->
<link rel="stylesheet" type="text/css" media="screen" href="<?php echo site_url()."/".$templateUrl?>js/elfinder/css/elfinder.min.css">
<link rel="stylesheet" type="text/css" media="screen" href="<?php echo site_url()."/".$templateUrl?>js/elfinder/css/theme.css">
<script type="text/javascript" src="<?php echo site_url()."/".$templateUrl?>js/elfinder/elfinder.min.js"></script>
<script type="text/javascript" src="<?php echo site_url()."/".$templateUrl?>js/elfinder/i18n/elfinder.zh_CN.js"></script>
<!--tiny mce-->
<script type="text/javascript" src="<?php echo site_url()."/".$templateUrl?>js/tiny_mce/tiny_mce.js"></script>

<script type="text/javascript" src="<?php echo site_url()."/".$templateUrl?>js/form.js"></script>
<script type="text/javascript" src="<?php echo site_url()."/".$templateUrl?>js/datePicker/WdatePicker.js"></script>
<script type="text/javascript" src="<?php echo site_url()."/".$templateUrl?>js/init.js"></script>
<script type="text/javascript" src="<?php echo site_url()."/".$templateUrl?>js/jquery.liteuploader.min.js"></script>
</head>
<body>

<div id="wrapper">
	<div id="header"> <?php echo  $header_area?> </div>
	<div id="container">
		<div id="secondary">
			<div class="content"> <?php echo  $left_menu?> </div>
		</div>
		<div id="primary">
			<h1 id="title"><?php echo $module_info["title"]?></h1>
			<div id="bg">
				<div id="contentTagFrame">
					<div id="tags">
						<?php foreach ($top_menu_list as $item): ?>
						<div <?php echo  in_array($this->router->fetch_method(), $item["items"])?'class="this"':''  ?>  onclick="location.href='<?php echo $item["url"]?>'">
							<table cellpadding="0" cellspacing="0">
								<tr>
									<td class="left"></td>
									<td class="center"><?php echo $item["title"]?></td>
									<td class="right"></td>
								</tr>
							</table>
						</div>
						<?php endforeach; ?>
					</div>
				</div>
				<!-- 項目設定 -->
				<div class="contentPrimary" id="contentPrimary">
					<div class="box">
						<div class="box_title">
							<table width="100%" cellpadding="0" cellspacing="0">
								<tr>
									<td class="title_left"></td>
									<td class="title_center"><?php echo $this->sub_title?></td>
									<td class="title_right"></td>
								</tr>
							</table>
						</div>
						<div class="box_content">
							<table width="100%" cellpadding="0" cellspacing="0">
								<?php echo $backend_message?>
								<tr>
									<td class="content_left"></td>
									<td class="content_center">
										<div class="main_content"> <?php echo $content?> </div>
									</td>
									<td class="content_right"></td>
								</tr>
								<tr>
									<td class="bottom_left"></td>
									<td class="bottom_center"></td>
									<td class="bottom_right"></td>
								</tr>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="clear"></div>
	</div>
	<div id="footer">
		<div id="copyright">Design By Orista Team</div>
	</div>
</div>
</body>
</html>
