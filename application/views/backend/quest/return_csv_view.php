<?php
header("Content-type:application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=quest_".date("YmdHi").".csv;");
header("Pragma: no-cache");
header("Expires: 0");

$title = array('會員姓名','居住市','居住地區','郵遞區號','地址','是否為使用者','生日','性別','身高','體重');
foreach($this->config->item('quest_family') as $val)
{
	array_push($title,'家人('.$val.'-男)','家人('.$val.'-女)');
}
array_push($title,'是否發生運動傷害','運動傷害原因');
foreach($this->config->item('quest_case_history') as $val)
{
	array_push($title,$val);
}
array_push($title,'體重過重','建單日期');

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
	$family = json_decode($row['family_members'], TRUE);
	$family_data = array();
	foreach($this->config->item('quest_family') as $key=>$val)
	{
		if(isset($family[$key]))
		{
			$family_data[$key]['m'] = $family[$key]['m']==''?'0':$family[$key]['m'];
			$family_data[$key]['f'] = $family[$key]['f']==''?'0':$family[$key]['f'];
		}
		else
		{
			$family_data[$key]['m'] = '0';
			$family_data[$key]['f'] = '0';
		}
	}
	
	$case_history = json_decode($row['case_history'], TRUE);
	
	if($row['user_self'] == '1')
	{
		$sex = $row['sex'];
	}
	else
	{
		$sex = $row['user_sex'];
	}
	
	echo iconv('utf-8','big5',$row['member_name'].','.$row['counyt_name'].','.$row['area_name'].','.$row['code'].','.$row['address'].','.($row['user_self']=='0'?'否':'是').','.$row['birthday'].','.($sex=='0'?'女':'男').','.$row['height'].','.$row['weight'].',');
	
	foreach($family_data as $val)
	{
		echo iconv('utf-8','big5',$val['m'].','.$val['f'].',');
	}
	
	echo iconv('utf-8','big5',($row['sport_injuries']=='0'?'否':'是').','.$row['sport_injuries_content'].',');
	
	foreach($case_history as $val)
	{
		echo iconv('utf-8','big5',($val=='0'?'否':'是').',');
	}
	
	echo iconv('utf-8','big5',($row['overweight']=='0'?'否':'是').','.$row['create_date'].'
');
}

?>