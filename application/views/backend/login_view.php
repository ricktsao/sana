<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>login</title>

<link href="<? echo $templateUrl?>css/login.css" rel="stylesheet" type="text/css" />
<script language="javascript">

	//重新產生驗證碼
	function RebuildVerifyingCode( obj_verifying_code_img )
	{
		var verifying_code_url = obj_verifying_code_img.src.split( "?" );
		verifying_code_url = verifying_code_url[0];		
		obj_verifying_code_img.src = verifying_code_url + "?" + Math.random();
	}

</script>
</head>
<body>
<div id="loginFrame">
	<form action="<?=bUrl("conformAccountPassword",FALSE)?>" method="post">
	
	<table>
		<tr>
		<td rowspan="4" id='img'><img  style="width:180px" src="<? echo base_url();?>template/<?php echo $this->config->item('backend_name');?>/images/logo.png"/></td>
		<td>帳號</td>
		<td><input name="id" type="text" class="loginInputs" value="<? echo tryGetArrayValue('id',$edit_data)?>" /></td>
		</tr>
		<tr>
			<td>密碼</td>
			<td><input name="password" type="password" class="loginInputs" value="<? echo tryGetArrayValue('password',$edit_data)?>" /></td>
		</tr>
		<tr>
			<td>驗證碼</td>
			<td><input name="vcode" class="loginVerification" />&nbsp;&nbsp;            	
            	<img id="img_verifying_code" align="absmiddle" src="<? echo base_url()?>verifycodepic" style="cursor:pointer" onclick="RebuildVerifyingCode(this)"></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>	<input value="登入" type="submit" class="btn"/>
            	<?php echo form_error('id');?>
            	<?php echo form_error('password');?>
            	<?php echo form_error('vcode');?>
            	<div class="error"><?php echo tryGetArrayValue('error_message',$edit_data);?></div></td>
		</tr>
		
	</table>

    </form>
</div>
</body>
</html>
