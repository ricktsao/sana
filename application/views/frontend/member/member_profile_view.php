<script language="javascript">

function CheckField()
{   
    var is_valid = true;
   
    if( trim($('#profile_nickname').val()).length < 1 )
    {
        is_valid = false;
        alert('<?php echo $this->lang->line("error_nickname_required");?>');
        $('#profile_nickname').focus();
    }
    else if( trim($('#profile_password').val()).length < 1 )
    {
        is_valid = false;
        alert('<?php echo $this->lang->line("error_password_required");?>');
        $('#profile_password').focus();
    }
    else if( trim($('#profile_repassword').val()).length < 1 )
    {
        is_valid = false;
        alert('<?php echo $this->lang->line("error_password_required");?>');
        $('#profile_repassword').focus();
    }
    else if( trim($('#profile_password').val()) != trim($('#profile_repassword').val()) )
    {
        is_valid = false;
        alert('<?php echo $this->lang->line("error_repassword");?>');
        $('#profile_password').focus();
    }                   
    else
    {
        is_valid = true;
    }

    if( is_valid )
    {       
        document.getElementById( 'update_form' ).submit();
    }
}
</script>
<div id="memberInfo">
    <form id="update_form" action="<?=getFrontendControllerUrl("member", "update_profile")?>" method="post"> 
        <table class='data_table' width="100%">
            <tr>
                <td class='first_row' width="20%">帳號：</td>
                <td><?php echo tryGetArrayValue("account", $member_data) ?></td>
            </tr>
            <tr class='high_line'>
                <td class='first_row'>暱稱：</td>
                <td><input id="profile_nickname" name="profile_nickname" type="text" class="memberData" value="<?php echo tryGetArrayValue("nickname", $member_data) ?>" /></td>                
            </tr>
            <tr>
                <td class='first_row'>密碼：</td>
                <td><input id="profile_password" name="profile_password" type="password" class="memberData" value="<?php echo tryGetArrayValue("password", $member_data) ?>"/></td>                
            </tr>
            <tr class='high_line'>
                <td class='first_row'>再次確認密碼：</td>
                <td><input id="profile_repassword" name="profile_repassword" type="password" class="memberData" value="<?php echo tryGetArrayValue("password", $member_data) ?>"/></td>                
            </tr>               
            <tr>
                <td class='first_row'>聯絡電話：</td>
                <td><input id="profile_tel" name="profile_tel" type="text" class="memberData" value="<?php echo tryGetArrayValue("tel", $member_data) ?>" /></td>
            </tr>         
            <tr class='high_line'>
                <td class='first_row'>通訊地址：</td>
                <td><input id="profile_address" name="profile_address" type="text" class="memberData" value="<?php echo tryGetArrayValue("address", $member_data) ?>" /></td>    
            </tr>
            <tr>
                <td class='first_row'>最後更新日期：</td>
                <td><?php echo tryGetArrayValue("update_date", $member_data) ?></td>
            </tr>                
            <tr class='high_line'>
                <td class='first_row'>創建日期：</td>
                <td><?php echo tryGetArrayValue("create_date", $member_data) ?></td>
            </tr>
            <tr>
                <td><input id="update_btn" name="update_btn" type="button" value="確認修改" class="btn" onclick="CheckField();"/></td>  
            </tr>                                   
        </table>
    </form>           
</div>       