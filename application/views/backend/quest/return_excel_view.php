<?php
header("Content-Disposition: attachment; filename=quest_".date("YmdHi").".xls;");

echo '<HTML xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40">'."\n";
echo '<head><meta http-equiv="content-type" content="application/vnd.ms-excel; charset=UTF-8"></head>'."\n";
echo "<body><table border=1>\n";
?>
<tr>
	<th>會員姓名</th>
	<th>居住市</th>
	<th>居住地區</th>
	<th>郵遞區號</th>
	<th>地址</th>
	<th>是否為使用者</th>
	<th>生日</th>
	<th>性別</th>
	<th>身高</th>
	<th>體重</th>
	<?php
	foreach($this->config->item('quest_family') as $val)
	{
		?>
	<th>家人(<?php echo $val;?>-男)</th>
	<th>家人(<?php echo $val;?>-女)</th>
		<?php
	}
	?>
	<th>是否發生運動傷害</th>
	<th>運動傷害原因</th>
	<?php
	foreach($this->config->item('quest_case_history') as $val)
	{
		?>
	<th><?php echo $val; ?></th>
		<?php
	}
	?>
	<th>體重過重</th>
	<th>建單日期</th>
</tr>
<?php

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
	
	echo '
<tr>
	<td>'.$row['member_name'].'</td>
	<td>'.$row['counyt_name'].'</td>
	<td>'.$row['area_name'].'</td>
	<td>'.$row['code'].'</td>
	<td>'.$row['address'].'</td>
	<td>'.($row['user_self']=='0'?'否':'是').'</td>
	<td>'.$row['birthday'].'</td>
	<td>'.($sex=='0'?'女':'男').'</td>
	<td>'.$row['height'].'</td>
	<td>'.$row['weight'].'</td>';
	
	foreach($family_data as $val)
	{
		echo '<td>'.$val['m'].'</td><td>'.$val['f'].'</td>';
	}
	
	echo '
	<td>'.($row['sport_injuries']=='0'?'否':'是').'</td>
	<td>'.$row['sport_injuries_content'].'</td>';
	
	foreach($case_history as $val)
	{
		echo '<td>'.($val=='0'?'否':'是').'</td>';
	}
	
	echo '
	<td>'.($row['overweight']=='0'?'否':'是').'</td>
	<td>'.$row['create_date'].'</td>
</tr>
	';
}

echo '</table></body></html>';
?>