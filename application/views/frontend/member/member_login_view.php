<script language="javascript">

	//重新產生驗證碼
	function RebuildVerifyingCode( obj_verifying_code_img )
	{
		var verifying_code_url = obj_verifying_code_img.src.split( "?" );
		verifying_code_url = verifying_code_url[0];		
		obj_verifying_code_img.src = verifying_code_url + "?" + Math.random();
	}



	function CheckField()
	{	
		var is_valid = true;
	
		if( trim($('#account').val()).length < 1 )
		{
			is_valid = false;
			$('#errMessage').text('<?php echo $this->lang->line("error_account_required");?>');
			$('#account').focus();
		}
		else if( trim($('#password').val()).length < 1 )
		{
			is_valid = false;
			$('#errMessage').text('<?php echo $this->lang->line("error_password_required");?>');
			$('#password').focus();
		}	
		else if( trim($('#vcode').val()).length < 1 )
		{	
			is_valid = false;
			$('#errMessage').text('<?php echo $this->lang->line("error_verify_code_required");?>');
			$('#vcode').focus();
		}
		else
		{
			is_valid = true;
			$('#errMessage').text('');			
		}
	
		if( is_valid )
		{		
			document.getElementById( 'login_form' ).submit();
		}
	}


</script>
<div id="loginCaption">Please Login</div>
<div id="loginBlock">
	<div id="login">
        <div id="memberLogin">
            <form id="login_form" action="<?=getFrontendControllerUrl("member", "confirmLogin")?>" method="post">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td class="left">Email</td>
                      <td><input id="account" name="account" type="text" class="inputs" autocomplete="off" value="<?php echo tryGetArrayValue("account",$edit_data); ?>" /></td>
                    </tr>
                    <tr>  
                      <td class="left">Paswward</td>
                      <td><input id="password" name="password" type="password" class="inputs" autocomplete="off" value="<?php echo tryGetArrayValue("password",$edit_data); ?>" /></td>
                    </tr>
                    <tr>  
                      <td class="left">Verification</td>
                      <td><input id="vcode" name="vcode" type="text" class="inputs" autocomplete="off" " /></td>
                    </tr>
                    <tr>  
                      <td class="left">&nbsp;</td>
                      <td><img id="img_verifying_code" align="absmiddle" src="<? echo base_url();?>verifycodepic" style="cursor:pointer" onclick="RebuildVerifyingCode(this)"></td>	
                    </tr>
                    <tr>
                      <td colspan="2">
                   	  <div class="submit">
                            <input value="Submit" type="button" class="btn" onclick="CheckField();" />
                            <input value="Cancel" type="button" class="btn" onclick="location.href='<?php echo getFrontendControllerUrl();?>'" />
                            <div class="clear"></div>
                        </div>
                      </td>	
                    </tr>
                </table>                    
            </form>
        </div>
        <div id="rightBlcok">
            <a href="#" class="forgetEmail">Forgot Email</a>
            <a href="#" class="forgetPW">Forgot Password</a>
        </div>
        <div id='errMessage'><?php echo tryGetArrayValue("error_message",$edit_data) ?></div>
    </div>
</div>
<div id="textBlock">  	
    <p>歡迎<a href="#" title="加入試用會員">加入試用會員</a>，填表就送美語體驗課程一個月!</p>
    <p>若您有任何問題歡迎<a href="#" title="線上預約諮詢">線上預約諮詢</a> ，或是與客服洽詢，聯絡電話 03-1234567。</p>
</div>    
<div class="clear"></div>
