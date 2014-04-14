<div id='title'><?php echo $category_info["title"]?> <img src='<?php echo base_url().$templateUrl;?>images/list_icon.png'/> </div>
<ul id='product_list'>
<?php foreach ($product_list as $key => $item) { ?>
		<li> <div class='no'>No.<?php echo $item["product_no"]?></div><div class='title'>Title:<?php echo $item["title"]?></div><a href='<?php echo fUrl("detail/".$category_info["sn"].'/'.$item["sn"])?>'><img src='<?php echo $item["img_filename"];?>'/></a> </li>
<?php } ?>			

</ul>


<?php echo showProductpager($pager,$category_info["sn"])?> 
