<script>


function trim(strvalue) {
    ptntrim = /(^\s*)|(\s*$)/g;
    return strvalue.replace(ptntrim, "");
}

function ValidEmail(emailtoCheck) {
    emailRule = "/^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z]+$/";


    var regExp = /^[^@^\s]+@[^\.@^\s]+(\.[^\.@^\s]+)+$/;
    if (emailtoCheck.match(regExp))
        return true;
    else
        return false;
}

var check_vode = false;
function CheckField() {

    is_valid = true;


    if (trim($('#name').val()).length == 0) {
            alert('姓名必須填寫');
            $('#name').focus();
            is_valid = false;
            return;
    }

    if (trim($('#tel').val()).length == 0) {
            alert('電話必須填寫');
            $('#tel').focus();
            is_valid = false;
            return;
    }

    if (trim($('#email').val()).length == 0) {
            alert('E-mail必須填寫');
            $('#email').focus();
            is_valid = false;
            return;
    }
    else if (!ValidEmail($('#email').val())) {
             alert('E-mail格式錯誤');
             $('#email').focus();
             is_valid = false;
             return;
    }

	if (trim($('#message').val()).length == 0) {
            alert('訊息必須填寫');
            $('#message').focus();
            is_valid = false;
            return;
    }

    if (is_valid) {
        $('#contact_form').submit();
    }


}

</script>
<div id='title'>聯絡諮詢 <img src='<?php echo base_url().$templateUrl;?>images/list_icon.png'/> </div>
<form id="contact_form" action="<?php echo fUrl('mailto');?>" method="post">
	<table>
	<tbody><tr>
	  <td width="13%"  >姓名*</td>
	  <td width="87%"  ><input type="text" size="30" id="name" name="name"></td>
	</tr>
	<tr>
	  <td  >性別</td>
	  <td  ><input type="radio" value="男" id="radio" name="sex" checked>
		男 
		  <input type="radio" value="女" id="radio2" name="sex"> 
		  女</td>
	</tr>
	<tr>
	  <td  >電話*</td>
	  <td  ><input type="text" size="30" id="tel" name="tel"></td>
	</tr>
	<tr>
	  <td  >E-mail*</td>
	  <td  ><input type="text" size="30" id="email" name="email"></td>
	</tr>
	<tr>
	  <td  >地址</td>
	  <td  ><input type="text" size="30" id="add" name="add"></td>
	</tr>
	<tr>
	  <td  >訊息*</td>
	  <td  ><textarea id="message" rows="5" cols="30" name="message"></textarea></td>
	</tr>
	<tr>
	  <td >&nbsp;</td>
	  <td ><input type="button" value="送出" id="button" name="button" onclick='CheckField();'>
	  <input type="reset" value="清除" id="button2" name="button2"></td>
	</tr>
  </tbody></table>

</form>