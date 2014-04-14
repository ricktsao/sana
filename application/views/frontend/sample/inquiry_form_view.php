<script>
	
//重新產生驗證碼
function RebuildVerifyingCode( obj_verifying_code_img )
{
	var verifying_code_url = obj_verifying_code_img.src.split( "?" );
	verifying_code_url = verifying_code_url[0];		
	obj_verifying_code_img.src = verifying_code_url + "?" + Math.random();
}

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



	if (trim($('#tel').val()).length == 0) {
            alert('請填寫電話!!');
            $('#tel').focus();
            is_valid = false;
            return;
    }
	
    if (trim($('#email').val()).length == 0) {
            alert('請填寫電子信箱');
            $('#email').focus();
            is_valid = false;
            return;
    }
    else if (!ValidEmail($('#email').val())) {
             alert('電子信箱格式不正確');
             $('#email').focus();
             is_valid = false;
             return;
    }

	
	if (trim($('#addr').val()).length == 0) {
            alert('請填寫收件地址!!');
            $('#addr').focus();
            is_valid = false;
            return;
    }
	

    if (trim($('#vcode').val()).length == 0) {
        alert('請輸入驗證碼!!');
        $('#vcode').focus();
        is_valid = false;
        return;
    }
   
    checkVcode();

    if ($('#vcodecheck').val() == '0') {

        alert('驗證碼錯誤!!');
        $('#vcode').focus();
        is_valid = false;
        return;
    }


    if (is_valid) {
        $('#inquiry_form').submit();
    }

}


    function checkVcode() {	
        $.ajax({
            url: '<?php echo fUrl("ajaxCheckVcode");?>',
        type: "get",
        cache: false,
        async: false,
        data: { vcode: $("#vcode").val()},
		datatype: "json",
		error: function (xhr) { $('#vcodecheck').val('0'); },
		success: function (data) 
		{
			
			//若是回傳為真，則刪除			
			if(data == 1)
			{			
				$('#vcodecheck').val('1');
			}
			else
			{
				$('#vcodecheck').val('0');
			}
			
		}
	});
   }	
	
</script>
<?php echo $setting_info["form_header"];?>

<form id="inquiry_form" method="post" action="<?php echo fUrl("updateInquiry");?>">
	<table>
		<tr>
			<td colspan="2">&nbsp;</td>
		</tr>
		<tr>
			<td>姓&nbsp;&nbsp;名</td>
			<td><input type="text"  id="name" name="name" /></td>
		</tr>
		<tr>
			<td>婚&nbsp;&nbsp;期</td>
			<td><input type="text"  id="mdate" name="mdate" /></td>
		</tr>
		<tr>
			<td>電&nbsp;&nbsp;話</td>
			<td><input type="text" id="tel" name="tel" /></td>
		</tr>		
		<tr>
			<td>電子信箱</td>
			<td><input type="text" id="email" name="email" /></td>
		</tr>
		<tr>
			<td>收件地址(需有人可簽收)</td>
			<td><input type="text" id="addr" name="addr" /></td>
		</tr>
		<tr>
			<td>轉帳金額</td>
			<td><input type="text" id="taccount" name="taccount" /></td>
		</tr>
		<tr>
			<td>轉帳日期</td>
			<td><input type="text" id="tdate" name="tdate" /></td>
		</tr>
		<tr>
			<td>您帳號的後五碼</td>
			<td><input type="text" id="five_code" name="five_code" /></td>
		</tr>
		
		
		<tr>
			<td>索取樣本內容</td>
			<td><textarea name="memo"></textarea></td>
		</tr>
		<tr>
			<td>驗&nbsp;證&nbsp;碼</td>
			<td>
				<table>
					<tr>
						<td><input type="text" id="vcode"  name="vcode" style="width:150px"/></td>
						<td><img  id="alert_vcode" align="absmiddle" src="<? echo base_url()?>verifycodepic" style="float:left;cursor:pointer;margin-left:10px;height:27px;" onclick="RebuildVerifyingCode(this)" /> </td>
					</tr>
				</table>
			
			
			</td>
		</tr>
		<tr>
			<td colspan="2" style="text-align:center;"><button type="reset">清除</button>
				<button onclick="CheckField()" type="button">送出</button>				
			</td>
		</tr>
	</table>
	<input type="hidden" id="vcodecheck" value="0" />
	<input type="hidden" id="inquery_session" value="0" />
</form>

