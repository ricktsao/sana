<div id="memberInfo">
	<a href='#' class='page_arrow' id='left_page_arrow'></a>
	<a href='#' class='page_arrow' id='right_page_arrow'></a>	
	<ul id='teacher_list'>
		
		<?php
		
		if(count($arr_teacher)>0){
			foreach($arr_teacher as $key=>$value){		
		?>
		<li>
			<a href='#' class='photos' title='name'> <img src='<?php echo base_url()."upload/website/teacher/".$value['teacher_picture']?>'/> <!--
			性別icon 是sex_mark這個div
			如果是男的 給他類別 male，女的則是female
			-->
			<div class='teacher_detail'>
				<?php echo $value['teacher_english_name']?><div class='sex_mark <?php echo $arr_gender[$value['teacher_gender']] ?>'></div>
			</div> </a>
			<div class='teacher_data'>
				<span>Gender : </span><?php echo $arr_gender[$value['teacher_gender']] ?>
			</div>
			<div class='teacher_data'>
				<span>Sign : </span><?php echo $value['teacher_sign']?>
			</div>
		</li>
		<?php
				}
		}
		?>
	</ul>
</div>