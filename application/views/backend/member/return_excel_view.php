<?php
header("Content-Disposition: attachment; filename=member_".date("YmdHi").".xls;");

echo '<HTML xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40">'."\n";
echo '<head><meta http-equiv="content-type" content="application/vnd.ms-excel; charset=UTF-8"></head>'."\n";
echo "<body><table border=1>\n";
?>
<tr>
	<th>會員姓名</th>
	<th>email帳號</th>
	<th>性別</th>
	<th>居住市</th>
	<th>居住地區</th>
	<th>郵遞區號</th>
	<th>地址</th>
	<th>行動電話</th>
	<th>住家電話</th>
	<th>獲得資訊管道</th>
	<th>運動方式</th>	
	<th>喜愛的運動方式</th>
	<th>運動頻率</th>
	<th>運動長度</th>
	<th>運動時段</th>
	<th>加入日期</th>
</tr>
<?php

foreach($data as $row)
{
	$sport_method = explode(",",$row['sport_method']);
	$sport_method_str = '';
	foreach($this->config->item('sport_method') as $key=>$val)
	{
		if(in_array($key, $sport_method))
		{
			if($sport_method_str != '') $sport_method_str .= ',';
			 $sport_method_str .= $val;
		}
	}
	
	switch ($row["source"]) {
		case '888':
			$source = "網站:".$row["source_web"];
			break;
		case '999':
			$source = "其他:".$row["source_other"];
			break;
		default:
			$source = $this->config->item($row["source"],'source');
			break;
	}

	echo '
<tr>
	<td>'.$row['member_name'].'</td>
	<td>'.$row['email'].'</td>
	<td>'.($row['sex']=='1'?'男':'女').'</td>
	<td>'.$row['counyt_name'].'</td>
	<td>'.$row['area_name'].'</td>
	<td>'.$row['code'].'</td>
	<td>'.$row['address'].'</td>
	<td>'.$row['mobile'].'</td>
	<td>'.$row['tel'].'</td>
	<td>'.$source.'</td>
	<td>'.$sport_method_str.'</td>
	<td>'.$row['sport_note'].'</td>
	<td>'.$this->config->item($row['sport_rate'],'sport_rate').'</td>
	<td>'.$this->config->item($row['sport_period'],'sport_period').'</td>
	<td>'.$this->config->item($row['sport_time'],'sport_time').'</td>
	<td>'.$row['create_date'].'</td>
</tr>
	';
}

echo '</table></body></html>';
?>