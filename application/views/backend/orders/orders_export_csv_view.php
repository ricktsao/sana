<?php

header("Content-type:application/vnd.ms-excel"); 
header("Content-Disposition: attachment; filename=orders_".date("YmdHi").".csv;");
header("Content-Transfer-Encoding: binary");
header("Cache-Control: cache, must-revalidate");
header("Pragma: public");
header("Pragma: no-cache");
header("Expires: 0");


$title = '訂單編號,訂購日期,訂單狀態,會員姓名,收件人姓名,收件人手機,收件人E-mail,收件人地址,付款人姓名,付款人手機,付款人E-mail,付款人地址,付款方式,欲送達時間,發票資訊,發票寄送地址,商品小計,運費,訂單總金額';

echo iconv('utf-8','big5',$title);
echo '
';

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
	echo iconv('utf-8','big5',tryGetValue($order->order_number).','.tryGetValue($order->ordered_on).','.$this->config->item(tryGetValue($order->status),'order_statuses').','.tryGetValue($order->member_name).
		//','.tryGetValue($order->member_mobile).
		//','.tryGetValue($order->member_email).
		','.tryGetValue($order->ship_name).',="'.tryGetValue($order->ship_mobile).'",'.tryGetValue($order->ship_email).','.tryGetValue($order->ship_county).tryGetValue($order->ship_area).tryGetValue($order->ship_zip_code).tryGetValue($order->ship_address).
		','.tryGetValue($order->bill_name).',="'.tryGetValue($order->bill_mobile).'",'.tryGetValue($order->bill_email).','.tryGetValue($order->bill_county).tryGetValue($order->bill_area).tryGetValue($order->bill_zip_code).tryGetValue($order->bill_address).
		','.$this->config->item(tryGetValue($order->payment),'payment').','.$this->config->item(tryGetValue($order->delivery_time),'delivery_time').','.$this->config->item(tryGetValue($order->invoice_type),'invoice_type_array'));

	if (tryGetValue($order->invoice_type) == 'business')
	{
		echo iconv('utf-8','big5','\r發票抬頭: '.tryGetValue($order->invoice_title).' 統一編號: '.tryGetValue($order->invoice_id));
	}
	echo ',';

	if (tryGetValue($order->invoice_addr) == 'bill')
	{
		echo iconv('utf-8','big5','同付款人地址');
	} else {
		echo iconv('utf-8','big5','同收件人地址');
	}


	//echo ',$'.format_currency(tryGetValue($order->subtotal)).',$'.format_currency(tryGetValue($order->shipping_fee)).',$'.format_currency(tryGetValue($order->total)).'
	echo ',$'.tryGetValue($order->subtotal).',$'.($order->shipping_fee).',$'.tryGetValue($order->total).'
	';

	foreach (tryGetValue($order->items) as $item) {



		$name = tryGetValue($item['name']);
		$price = tryGetValue($item['price']);//format_currency(tryGetValue($item['price']));
		$quantity = $item['quantity'];					// 此處 tryGetValue($item['quantity']); 值為 float，會使得 isNotNull() 傳回 false
		$subtotal = $item['subtotal'];//format_currency($item['subtotal']);	// 此處 tryGetValue($item['subtotal']); 值為 float，會使得 isNotNull() 傳回 false
		
		for($i=0; $i<15; $i++)
		{
			echo ',';
		}
		echo iconv('utf-8','big5',$name.',$'.$price.','.$quantity.',$'.$subtotal.'
		');
		
	}
	echo '
';
}

?>