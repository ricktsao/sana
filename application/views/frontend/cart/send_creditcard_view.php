<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>DYACO交易介面</title>
</head>

<body>

交易進行中，請稍候
<FORM NAME="FROM1" id="send_creditcard" ACTION="https://trustlink.hitrust.com.tw/TrustLink/TrxReqForJava" METHOD="POST" >
<INPUT TYPE="HIDDEN" name="Type" value="Auth">
<INPUT TYPE="HIDDEN" NAME="storeid" SIZE=9 value="50940">
<INPUT TYPE="HIDDEN" NAME="ordernumber" SIZE=9 value="<?php echo $order_number;?>">
<INPUT TYPE="HIDDEN" NAME="amount" SIZE=20 value="<?php echo $total*100;?>">
<INPUT TYPE="HIDDEN" NAME="orderdesc" SIZE=20 value="">
<INPUT TYPE="HIDDEN" NAME="pan" SIZE=20>
<INPUT TYPE="HIDDEN" NAME="expiry" SIZE=6>
<INPUT TYPE="HIDDEN" name="depositflag" value="1">
<INPUT TYPE="HIDDEN" name="queryflag" value="0">
<INPUT TYPE="HIDDEN" NAME="ticketno" SIZE=20> 
<INPUT TYPE="HIDDEN" NAME="returnURL" VALUE="<?php echo getFrontendControllerUrl('cart', 'creditcard');?>">
<INPUT TYPE="HIDDEN" NAME="merUpdateURL" VALUE="<?php echo getFrontendControllerUrl('cart', 'creditcard/save_db');?>">
</FORM>
<script>
document.getElementById('send_creditcard').submit();
</script>

</body>
</html>