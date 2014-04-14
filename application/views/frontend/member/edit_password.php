<script>
	
	$(function(){
		
		sub_navi();
	
	
		$('.pimg_area').find('img').each(function(){
												  
				var nSrc=$(this).attr('src')+"?"+new Date().getTime();
				$(this).attr('src',nSrc);
				$(this).load(function(){
					var px=$(this).parent().width()/2-$(this).width()/2;				
					var py=$(this).parent().height()/2-$(this).height()/2;
					
					$(this).css({'top':py+"px",
								'left':px+"px"});				  
				})			
				
		});
		
	})
	
</script>
		<!-- 左側區塊 -->
		<div id='secondary'>
			<div id='sub_title' class='sub_nav_sprite'> 會員區 </div>
			<!-- 左側選單 -->
			<ul id='sub_navi' class='sub_nav_sprite'>
            	<li><a href='javascript:void(0)'><span class='sub_nav_sprite'></span>會員資料</a>
					<div class='sub_nav_sprite'></div>
                        <ul>
							<?php
							foreach($left_side["is_login"] as $key=>$val)
							{
							?>
							<li><a href="<?php echo getFrontendControllerUrl('member',$key);?>" class='sub_nav_sprite'><span class="sub_nav_sprite"></span><?php echo $val;?></a></li>
							<?php
							}
							?>
						</ul>
					<div class='sub_nav_sprite'></div>
				</li>
                <li><a href='javascript:void(0)'><span class='sub_nav_sprite'></span>交易紀錄</a>
                    <div class='sub_nav_sprite'></div>
                        <ul style="display:none">
                        	<?php
							foreach($left_side["sale"] as $key=>$val)
							{
							?>
                            <li><a href='<?php echo getFrontendControllerUrl('member',$key);?>' class='sub_nav_sprite'><span class='sub_nav_sprite'></span><?php echo $val;?></a></li>
                            <?php
							}
							?>
                        </ul>
                    <div class='sub_nav_sprite'></div>
                </li>
			</ul>
			<div id='sub_list_foot' class='sub_nav_sprite'></div>

			<!-- Banners -->
			<ul id='links'>
				<? echo $activity_btn ?>
			</ul>
		</div>
	
		<!-- 主要內容區塊 -->
        <form action="<?php echo getFrontendControllerUrl('member','updatePassword');?>" method="post">
		<div id='primary'>
			<div id='breadCrumb'>
				<span id='home_icon'></span> / <span>會員專區</span>
			</div>
			<div id='title'>
				<span></span>會員密碼修改
			</div>
			<div id="register">
			<table width="100%" cellpadding="0" cellspacing="0">
			<tr>
			<td>&nbsp;</td>
			<td>『<span>*</span>』為必填欄位</td>
			</tr>
            <?php
			/*
            <tr>
                <td class="register_first"><span>*</span>帳號</td>
                <td class="register_sercond"><input name="account" maxlength="50" value="<?php echo tryGetArrayValue( 'account',$edit_data); ?>"><?php echo form_error('account');?></td>
			</tr>
			*/
			?>
            <tr>
                <td class="register_first" width="30%"><span>*</span>email帳號</td>
                <td class="register_sercond" width="70%"><?php echo $email; ?></td>
			</tr>
            <tr>
                <td class="register_first"><span>*</span>原密碼</td>
                <td class="register_sercond"><input type="password" name="old_password" maxlength="50"></td>
			</tr>
            <tr>
                <td class="register_first"><span>*</span>密碼</td>
                <td class="register_sercond"><input type="password" name="password" maxlength="50"><?php echo form_error('password');?></td>
			</tr>
            <tr>
                <td class="register_first"><span>*</span>密碼確認</td>
                <td class="register_sercond"><input type="password" name="passconf" maxlength="50"></td>
			</tr>
            <tr>
                <td class="register_first">&nbsp;</td>
                <td class="register_button"><input value="確 認" type="submit" class="btn"/><input value="取 消" type="reset" class="btn_glay"/></td>
			</tr>
			</table>



			</div>
		</div>
        </form>
		<div class='clear'></div>
		
