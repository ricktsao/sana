<?php
	$this->lang->load("member",$this->language_value);
?>

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
		alert('<?php echo $this->lang->line("error_account_required");?>');
		$('#account').focus();
	}
	else if( trim($('#password').val()).length < 1 )
	{
		is_valid = false;
		alert('<?php echo $this->lang->line("error_password_required");?>');
		$('#password').focus();
	}	
	else if( trim($('#vcode').val()).length < 1 )
	{	
		is_valid = false;
		alert('<?php echo $this->lang->line("error_verify_code_required");?>');
		$('#vcode').focus();
	}
	else
	{
		is_valid = true;
	}

	if( is_valid )
	{		
		document.getElementById( 'login_form' ).submit();
	}
}


</script>


<?php 

	if($is_login)	
	{
		$member_info = $this->session->userdata("member_info");
?>
<div id="login_on" >
    <div id="loginCaption">Member Area</div>
    <div id="loginContent">
        Dear <span class="bold"><?php echo tryGetArrayValue("first_name", $member_info)." ".tryGetArrayValue("last_name", $member_info) ?></span>,<br />
Your current Level is <span class="red">11</span><br />
You don’t have any lesson today.
				<div id="btnBlcok" style="margin-top:50px;">
            <a href="<?=getFrontendControllerUrl("member", "profile")?>" class="learning">Go to E-learning</a>
            <a href="<?=getFrontendControllerUrl("member", "logout")?>" class="loginBtn">Logout</a>
        </div>
    </div>
</div>
   
<?php	
	}
	else 
	{
?>
<div id="login" >
	<div id="loginCaption">Member Login</div>
	<div id="message" style="display:none;"></div>
	<div id="loginContent">
	    <form id="login_form" action="<?=getFrontendControllerUrl("member", "confirmLogin")?>" method="post">
	        <table width="100%" border="0" cellspacing="0" cellpadding="0">
	            <tr>
	              <td class="left">Email</td>
	              <td><input id="account" name="account" type="text" class="inputs" autocomplete="off" onkeyup="if( event.keyCode == 13 ) { CheckField() }" /></td>
	            </tr>
	            <tr>  
	              <td class="left">Password</td>
	              <td><input id="password" name="password" type="password" class="inputs" autocomplete="off" onkeyup="if( event.keyCode == 13 ) { CheckField() }"/></td>
	            </tr>
	            <tr>  
	              <td class="left">Verification</td>
	              <td><input id="vcode" name="vcode" type="text" class="inputs" autocomplete="off" onkeyup="if( event.keyCode == 13 ) { CheckField() }"/></td>
	            </tr>
	            <tr>  
	              <td class="left">&nbsp;</td>
	              <td><img id="img_verifying_code" align="absmiddle" src="<? echo base_url();?>verifycodepic" style="cursor:pointer" onclick="RebuildVerifyingCode(this)"></td>	
	            </tr>
	        </table>   
	        <div id="btnBlcok">
	            <a href="forget_1.html" class="forgetPW">Forgot PW.</a>
	            <div class="separator">|</div>
	            <a href="forget_2.html" class="forgetEmail">Forgot Email</a>
	            <a href="javascript:CheckField();"  class="loginBtn">Login</a>
	        </div> 
	    </form>
	</div>
</div>
<?php
	}
?>







