<script language="javascript">

function CheckRegisterField()
{   
    var is_valid = true;

    if( trim($('#register_account').val()).length < 1 )
    {
        is_valid = false;
        alert('<?php echo $this->lang->line("error_account_required");?>');
        $('#register_account').focus();
    }
    else if( trim($('#register_account').val()).length > 50 )
    {
        is_valid = false;
        alert('<?php echo $this->lang->line("error_account_length");?>');
        $('#register_nickname').focus();
    }    
    else if( trim($('#register_nickname').val()).length < 1 )
    {
        is_valid = false;
        alert('<?php echo $this->lang->line("error_nickname_required");?>');
        $('#register_nickname').focus();
    }
    else if( trim($('#register_password').val()).length < 1 )
    {
        is_valid = false;
        alert('<?php echo $this->lang->line("error_password_required");?>');
        $('#register_password').focus();
    }
    else if( trim($('#register_repassword').val()).length < 1 )
    {
        is_valid = false;
        alert('<?php echo $this->lang->line("error_password_required");?>');
        $('#register_repassword').focus();
    }
    else if( trim($('#register_password').val()) != trim($('#register_repassword').val()) )
    {
        is_valid = false;
        alert('<?php echo $this->lang->line("error_repassword");?>');
        $('#register_repassword').focus();
    }                   
    else
    {
        is_valid = true;
    }

    if( is_valid )
    {       
        document.getElementById( 'register_form' ).submit();
    }
}
function CheckAccount()
{
     
}
</script>
<div id="memberInfo">
<form id="register_form" action="<?=getFrontendControllerUrl("member", "register")?>" method="post">    
    <table class='data_table'>
        <tr>
            <td class='first_row'><span class='red_mark'>*</span>帳號：</td>
            <td><input id="register_account" name="register_account" type="text" class="memberData"/></td>
            <td><input id="check_account" name="check_account" type="button" value="檢查帳號是否可用" class="btn" onclick="CheckAccount();"/><td>                  
        </tr>
        <tr class='high_line'>
            <td class='first_row'><span class='red_mark'>*</span>暱稱：</td>
            <td><input id="register_nickname" name="register_nickname" type="text" class="memberData"/></td>                
        </tr>
        <tr>
            <td class='first_row'><span class='red_mark'>*</span>密碼：</td>
            <td><input id="register_password" name="register_password" type="password" class="memberData"/></td>                
        </tr>
        <tr class='high_line'>
            <td class='first_row'><span class='red_mark'>*</span>再次確認密碼：</td>
            <td><input id="register_repassword" name="register_repassword" type="password" class="memberData"/></td>                
        </tr>                  
        <tr>
            <td class='first_row'>聯絡電話：</td>
            <td><input id="register_tel" name="register_tel" type="text" class="memberData"/></td>
        </tr>         
        <tr class='high_line'>
            <td class='first_row'>通訊地址：</td>
            <td><input id="register_address" name="register_address" type="text" class="memberData"/></td>    
        </tr>
        <tr>
            <td><input id="register_btn" name="register_btn" type="button" value="送出" class="btn" onclick="CheckRegisterField();"/></td>  
        </tr>                           
    </table>
</form>           
</div> 