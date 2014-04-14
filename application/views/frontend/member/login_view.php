
<script language="javascript">

function CheckLoginField()
{   

    var is_valid = true;

    if( trim($('#login_account').val()).length < 1 )
    {
        is_valid = false;
        alert('<?php echo $this->lang->line("error_account_required");?>');
        $('#login_account').focus();
    }
    else if( trim($('#login_password').val()).length < 1 )
    {
        is_valid = false;
        alert('<?php echo $this->lang->line("error_password_required");?>');
        $('#login_password').focus();
    }   
    else
    {
        is_valid = true;
    }

    if( is_valid )
    {       
        document.getElementById( 'user_login_form' ).submit();
    }
}

</script>
<div id="memberInfo">
    
<form id="user_login_form" action="<?=getFrontendControllerUrl("member", "login")?>" method="post">    
    <table class='data_table' width="100%">
        <tr>
            <td class='first_row' width="10%">帳號：</td>
            <td><input id="login_account" name="login_account" type="text" class="memberData"/></td>
        </tr>
        <tr class='high_line'>
            <td class='first_row'>密碼：</td>
            <td><input id="login_password" name="login_password" type="password" class="memberData"/></td>                
        </tr>  
        <tr>
            <td colspan='1'><input name="" type="button" value='會員註冊' onclick="location.href='<?php echo getFrontendControllerUrl("member", "open_register")?>'"/></td>
            <td colspan='2'><input name="" type="button" value='Login' onclick="location.href='javascript:CheckLoginField();'"/></td>
        </tr>                     
    </table>
    <div id='errMessage'><?php echo tryGetArrayValue("error_message",$edit_data) ?></div>
    <input type="hidden" name="url" value="profile" />  
    <input type="hidden" name="last_url" value="<?php echo $last_url;?>" />
    
</form>      
</div> 