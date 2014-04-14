<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>DYACO交易介面</title>
</head>

<body>

交易進行中，請稍候
<FORM NAME="FROM1" id="send_atm" ACTION="https://trustlink.hitrust.com.tw/TrustLink/TrxReqForJava" METHOD="POST" >
<INPUT TYPE="HIDDEN" name="Type" value="VIRTUAL">
<INPUT TYPE="HIDDEN" NAME="storeid" SIZE=9 value="15033">
<INPUT TYPE="HIDDEN" NAME="ordernumber" SIZE=9 value="<?php echo $order_number;?>">
<INPUT TYPE="HIDDEN" NAME="amount" SIZE=20 value="<?php echo $total*100;?>">     
<INPUT TYPE="HIDDEN" NAME="orderdesc" SIZE=20 value="SOLE">
<INPUT TYPE="HIDDEN" NAME="name" SIZE=20 value="<?php echo $bill_name;?>">
<INPUT TYPE="HIDDEN" NAME="email" SIZE=20 value="<?php echo $bill_email;?>">
<INPUT TYPE="HIDDEN" NAME="e17" SIZE=10 value="<?php echo date("Ymd", mktime(23,59,59,date("m"),date("d")+7,date("Y")));?>">
<INPUT TYPE="HIDDEN" NAME="merUpdateURL" VALUE="<?php echo getFrontendControllerUrl('cart', 'creditcard/save_db');?>">
</TR>                                                       
</TABLE>                                                         
</FORM>
<script>
document.getElementById('send_atm').submit();
</script>

</body>
</html>