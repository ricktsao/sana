<script>
	
	$(function(){
		
		sub_navi();
		
	})
	
	//重新產生驗證碼
	function RebuildVerifyingCode( obj_verifying_code_img )
	{
		var verifying_code_url = obj_verifying_code_img.src.split( "?" );
		verifying_code_url = verifying_code_url[0];		
		obj_verifying_code_img.src = verifying_code_url + "?" + Math.random();
	}
</script>

		<!-- 左側區塊 -->
		<div id='secondary'>
			<div id='sub_title' class='sub_nav_sprite'> 會員區 </div>
			<!-- 左側選單 -->
			<ul id='sub_navi' class='sub_nav_sprite'>
                <li><a href="<?php echo getFrontendControllerUrl('member','login');?>"><span class="sub_nav_sprite"></span>會員登入</a>
                    <div class="sub_nav_sprite"></div>
                </li>
                <li><a href="<?php echo getFrontendControllerUrl('member','register');?>"><span class="sub_nav_sprite"></span>註冊會員</a>
                    <div class="sub_nav_sprite"></div>
                </li>
			</ul>
            <div id='sub_list_foot' class='sub_nav_sprite'></div>

			<!-- Banners -->
			<ul id='links'>
				<? echo $activity_btn ?>
			</ul>
		</div>
	
		<!-- 主要內容區塊 -->
		<div id='primary'>
		  <div id='breadCrumb'>
		    <span id='home_icon'>
		    </span>
		    / 
		    <span>
		      忘記密碼
		    </span>
		  </div>
		  <form action="<?php echo getFrontendControllerUrl('member','confirmForgetPassword');?>" method="post">
		  <div id="login">
		    <h2>
		      忘記密碼
		    </h2>
		    <div id="login1">
		      <table width="100%" cellpadding="0" cellspacing="0">
			<tr>
			  <td class="login_td_frist">
			    電子信箱
			  </td>
			  <td class="login_td_sercond">
			    <input name="email" type="text" class="loginInputs" value="" />
			  </td>
			</tr>
			<tr>
			  <td class="login_td_frist">
			    驗證碼
			  </td>
			  <td class="login_td_sercond">
			    <input name="vcode" class="loginVerification" />
                <img id="img_verifying_code" align="absmiddle" onclick="RebuildVerifyingCode(this)" style="cursor:pointer" src="<?php echo base_url();?>verifycodepic">
			    <span>
			      <a href="#" onclick="RebuildVerifyingCode(document.getElementById('img_verifying_code')); return false;">更新驗證碼</a>
			    </span>
			  </td>
			</tr>
			<tr>
			  <td class="login_td_frist">&nbsp;
			    
			  </td>
			  <td class="login_td_sercond">
			    <span>
			      請輸入圖片中的英文或數字，不分大小寫
			    </span>
			  </td>
			</tr>
		      </table>
              <div id='errMessage'><?php echo tryGetArrayValue("error_message",$edit_data) ?></div>
		    </div>
		    <input value="送出" type="submit" class="btn"/>
		  </div>
		  </form>
		</div>
		<div class='clear'>
		</div>
