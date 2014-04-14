<?php

header("Content-type:application/vnd.ms-excel"); 
header("Content-Disposition: attachment; filename=orders_".date("YmdHi").".xls;");
header("Content-Transfer-Encoding: binary");
header("Cache-Control: cache, must-revalidate");
header("Pragma: public");
header("Pragma: no-cache");
header("Expires: 0");

echo '<HTML xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40">'."\n";
echo '<head><meta http-equiv="content-type" content="application/vnd.ms-excel; charset=UTF-8"></head>'."\n";
echo "<body><table border=1>\n";
?>
<tr>
	<th>訂單編號</th>
	<th>訂購日期</th>
	<th>訂單狀態</th>
	<th>會員姓名</th>
	<!-- <th>會員手機</th> -->
	<!-- <th>會員E-mail</th> -->
	<th>收件人姓名</th>
	<th>收件人手機</th>
	<th>收件人E-mail</th>
	<th>收件人地址</th>

	<th>付款人姓名</th>
	<th>付款人手機</th>
	<th>付款人E-mail</th>
	<th>付款人地址</th>
	
	<th>付款方式</th>
	<th>欲送達時間</th>
	<th>發票資訊</th>
	<th>發票寄送地址</th>
	<th>商品小計</th>
	<th>運費</th>
	<th>訂單總金額</th>
</tr>
<?php

foreach($orders as $order)
{
/*	$sport_method = explode(",",$order['sport_method']);
	$sport_method_str = '';
	foreach($this->config->item('sport_method') as $key=>$val)
	{
		if(in_array($key, $sport_method))
		{
			if($sport_method_str != '') $sport_method_str .= ',';
			 $sport_method_str .= $val;
		}
	}
	
	switch ($order["source"]) {
		case '888':
			$source = "網站:".$order["source_web"];
			break;
		case '999':
			$source = "其他:".$order["source_other"];
			break;
		default:
			$source = $this->config->item($order["source"],'source');
			break;
	}
*/
	echo '
	<tr>
		<td>'.tryGetValue($order->order_number).'</td>
		<td>'.tryGetValue($order->ordered_on).'</td>
		<td>'.$this->config->item(tryGetValue($order->status),'order_statuses').'</td>
		<td>'.tryGetValue($order->member_name).'</td>'.
		//<td>'.tryGetValue($order->member_mobile).'</td>
		//<td>'.tryGetValue($order->member_email).'</td>
		'<td>'.tryGetValue($order->ship_name).'</td>
		<td>'.tryGetValue($order->ship_mobile).'</td>
		<td>'.tryGetValue($order->ship_email).'</td>
		<td>'.tryGetValue($order->ship_county).tryGetValue($order->ship_area).tryGetValue($order->ship_zip_code).tryGetValue($order->ship_address).'</td>

		<td>'.tryGetValue($order->bill_name).'</td>
		<td>'.tryGetValue($order->bill_mobile).'</td>
		<td>'.tryGetValue($order->bill_email).'</td>
		<td>'.tryGetValue($order->bill_county).tryGetValue($order->bill_area).tryGetValue($order->bill_zip_code).tryGetValue($order->bill_address).'</td>

		<td>'.$this->config->item(tryGetValue($order->payment),'payment').'</td>
		<td>'.$this->config->item(tryGetValue($order->delivery_time),'delivery_time').'</td>
		<td>'.$this->config->item(tryGetValue($order->invoice_type),'invoice_type_array');

	if (tryGetValue($order->invoice_type) == 'business')
	{
		echo '<br>發票抬頭: '.tryGetValue($order->invoice_title).' 統一編號: '.tryGetValue($order->invoice_id);
	}
	echo '</td>';
	echo '<td>';

	if (tryGetValue($order->invoice_addr) == 'bill')
	{
		echo '同付款人地址';
	} else {
		echo '同收件人地址';
	}


	echo '</td>
		<td style="text-align:right">$'.format_currency(tryGetValue($order->subtotal)).'</td>
		<td align="right">$'.format_currency(tryGetValue($order->shipping_fee)).'</td>
		<td align="right">$'.format_currency(tryGetValue($order->total)).'</td>
	</tr>
	';

	foreach (tryGetValue($order->items) as $item) {



		$name = tryGetValue($item['name']);
		$price = format_currency(tryGetValue($item['price']));
		$quantity = $item['quantity'];					// 此處 tryGetValue($item['quantity']); 值為 float，會使得 isNotNull() 傳回 false
		$subtotal = format_currency($item['subtotal']);	// 此處 tryGetValue($item['subtotal']); 值為 float，會使得 isNotNull() 傳回 false

		echo '
		<tr><td colspan="15"></td>
		<td>'.$name.'</td>
		<td align="right">$'.$price.'</td>
		<td align="center">'.$quantity.'</td>
		<td align="right">$'.$subtotal.'</td>
		</tr>';
	}
	echo '<tr><td colspan="19">&nbsp;</td></tr>';
}

echo '</table></body></html>';
?>