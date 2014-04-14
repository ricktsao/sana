<?php
header("Content-type:application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=member_".date("YmdHi").".csv;");
header("Pragma: no-cache");
header("Expires: 0");

foreach($title as $key=>$val)
{
	echo iconv('utf-8','big5',$val);
	if($key < count($title)-1)
	{
		echo ',';
	}
	else
	{
		echo '
';
	}
}

foreach($data as $row)
{
	$sport_method = explode(",",$row['sport_method']);
	$sport_method_str = '';
	foreach($this->config->item('sport_method') as $key=>$val)
	{
		if(in_array($key, $sport_method))
		{
			if($sport_method_str != '') $sport_method_str .= '，';
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

	echo iconv('utf-8','big5',$row['member_name'].','.$row['email'].','.($row['sex']=='1'?'男':'女').','.$row['counyt_name'].','.$row['area_name'].',="'.$row['code'].'",'.$row['address'].',="'.$row['mobile'].'",="'.$row['tel'].'",'.$source.','.$sport_method_str.','.$row['sport_note'].','.$this->config->item($row['sport_rate'],'sport_rate').','.$this->config->item($row['sport_period'],'sport_period').','.$this->config->item($row['sport_time'],'sport_time').','.$row['create_date']);
	echo ' 
';
}
?>