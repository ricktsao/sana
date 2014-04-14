<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function tryGetFieldValue($data_ary, $field_name, $default_vlaue ='')
{
	$return_value = $default_vlaue;
	
	if(isNull($data_ary))
	{
		if(array_key_exists($field_name,$data_ary))
		{
			$return_value = $data_ary[$field_name];
		}	
	}
	return $return_value;
}



/**
 * 密碼加密
 */
function prepPassword($password)
{
	$CI	=& get_instance();
     return sha1($password.$CI->config->item('encryption_key'));
}



function doPostRequest($url, $data, $optional_headers = null)
{
  $params = array('http' => array(
              'method' => 'POST',
              'content' => $data
            ));
  if ($optional_headers !== null) {
    $params['http']['header'] = $optional_headers;
  }
  $ctx = stream_context_create($params);
  $fp = @fopen($url, 'rb', false, $ctx);
  if (!$fp) {
    throw new Exception("Problem with $url, $php_errormsg");
  }
  $response = @stream_get_contents($fp);
  if ($response === false) {
    throw new Exception("Problem reading data from $url, $php_errormsg");
  }
  return $response;
}

function country_dropdown ($name="country", $top_countries=array(), $selection=NULL, $show_all=TRUE)
{
	// You may want to pull this from an array within the helper
	$countries = config_item('country_list');

	$html = "<select name='{$name}'>";
	$html .= "<option disabled selected>--</option>";
	$selected = NULL;
	if(in_array($selection,$top_countries))
	{
		$top_selection = $selection;
		$all_selection = NULL;
	}
	else
	{
		$top_selection = NULL;
		$all_selection = $selection;
	}

	if(!empty($top_countries))
	{
		foreach($top_countries as $value)
		{
			if(array_key_exists($value, $countries))
			{
				if($value === $top_selection)
				{
					$selected = "SELECTED";
				}
				$html .= "<option value='{$value}' {$selected}>{$countries[$value]}</option>";
				$selected = NULL;
			}
		}
		$html .= "<option>----------</option>";
	}

	if($show_all)
	{
		foreach($countries as $key => $country)
		{
			if($key === $all_selection)
			{
				$selected = "SELECTED";
			}
			$html .= "<option value='{$key}' {$selected}>{$country}</option>";
			$selected = NULL;
		}
	}

	$html .= "</select>";
	return $html;
}

function sign_dropdown ($name="sign", $selection=NULL)
{
	// You may want to pull this from an array within the helper
	$signs = config_item('sign_list');

	$html = "<select name='{$name}'>";
	$html .= "<option disabled selected>--</option>";
	$selected = NULL;

		foreach($signs as $sign)
		{
			if($sign === $selection)
			{
				$selected = "SELECTED";
			}
			$html .= "<option value='{$sign}' {$selected}>{$sign}</option>";
			$selected = NULL;
		}
		
	$html .= "</select>";
	return $html;
}


function gender_radio ($name="gender", $checked_value=NULL)
{
	// You may want to pull this from an array within the helper
	$gender_list = config_item('gender_list');

	$html = '';
	
	foreach($gender_list as $key => $value)
	{
		$check_str = $key === $checked_value? 'checked':'';

		$html.='<input name="'.$name.'" '.$check_str.'  value="'.$key.'" id="radio_'.$key.'" value="'.$key.'" type="radio" class="middle"><label for="radio_'.$key.'" class="middle">'.$value.'</label>';
	}

	return $html;
}


function link_target_radio ($name="target", $checked_value=NULL)
{
	// You may want to pull this from an array within the helper
	$link_target_list = config_item('link_target_list');

	$html = '';
	
	foreach($link_target_list as $key => $value)
	{
		$check_str = $key === $checked_value? 'checked':'';

		$html.='<input name="'.$name.'" '.$check_str.'  value="'.$key.'" id="radio_'.$key.'" value="'.$key.'" type="radio" class="middle"><label for="radio_'.$key.'" class="middle">'.$value.'</label>';
	}

	return $html;
}

function week_start_date($wk_num, $yr, $first = 1, $format = 'Y-m-d')
{
    $wk_ts  = strtotime('+' . $wk_num . ' weeks', strtotime($yr . '0101'));
    $mon_ts = strtotime('-' . date('w', $wk_ts) + $first . ' days', $wk_ts);
    return date($format, $mon_ts);
}


function myInArray($array, $value, $key)
{
    //loop through the array
	foreach ($array as $val)
	{
		//if $val is an array cal myInArray again with $val as array input
		if(is_array($val))
		{
			if (myInArray($val, $value, $key))
			{
				return true;
			}
		}
		else
		{
			//else check if the given key has $value as value

			if($array[$key]==$value)
			{
				return true;
			}
		}
	}
	return false;
}

function xss_clean($data)
{
        // Fix &entity\n;
        $data = str_replace(array('&amp;','&lt;','&gt;'), array('&amp;amp;','&amp;lt;','&amp;gt;'), $data);
        $data = preg_replace('/(&#*\w+)[\x00-\x20]+;/u', '$1;', $data);
        $data = preg_replace('/(&#x*[0-9A-F]+);*/iu', '$1;', $data);
        $data = html_entity_decode($data, ENT_COMPAT, 'UTF-8');
 
        // Remove any attribute starting with "on" or xmlns
        $data = preg_replace('#(<[^>]+?[\x00-\x20"\'])(?:on|xmlns)[^>]*+>#iu', '$1>', $data);
 
        // Remove javascript: and vbscript: protocols
        $data = preg_replace('#([a-z]*)[\x00-\x20]*=[\x00-\x20]*([`\'"]*)[\x00-\x20]*j[\x00-\x20]*a[\x00-\x20]*v[\x00-\x20]*a[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu', '$1=$2nojavascript...', $data);
        $data = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*v[\x00-\x20]*b[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu', '$1=$2novbscript...', $data);
        $data = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*-moz-binding[\x00-\x20]*:#u', '$1=$2nomozbinding...', $data);
 
        // Only works in IE: <span style="width: expression(alert('Ping!'));"></span>
        $data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?expression[\x00-\x20]*\([^>]*+>#i', '$1>', $data);
        $data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?behaviour[\x00-\x20]*\([^>]*+>#i', '$1>', $data);
        $data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:*[^>]*+>#iu', '$1>', $data);
 
        // Remove namespaced elements (we do not need them)
        $data = preg_replace('#</*\w+:\w[^>]*+>#i', '', $data);
 
        do
        {
                // Remove really unwanted tags
                $old_data = $data;
                $data = preg_replace('#</*(?:applet|b(?:ase|gsound|link)|embed|frame(?:set)?|i(?:frame|layer)|l(?:ayer|ink)|meta|object|s(?:cript|tyle)|title|xml)[^>]*+>#i', '', $data);
        }
        while ($old_data !== $data);
 
        // we are done...
        return $data;
}



/**
 * Ted add
 * 
 * 顯示 HTML 的 radio,checkbox,select 三種 input模式
 * $ary 輸入資料 請提供一個ARRAY = $key(value)=>$val(text)
 * $opt_name 請輸入input name
 * $type radio || checkbox || select
 * $set_str 預設項目 格式:x,x,x,x,x.....
 * $er_str 若傳遞的$ary有誤顯示文字
 * $clear_option 是否提供一個無的選項在第一格的位置
 */
if ( ! function_exists('formArraySet'))
{
	function formArraySet($ary, $opt_name, $type, $set_str='', $er_str='', $clear_option=false, $attr=null, $array_val_name='title')
	{
		if( !is_array($ary) || count($ary)==0 ) return $er_str;
		$return = '';
		$checked = explode(',',$set_str);
		switch ($type){
			case 'radio':
			case 'checkbox':
				if($clear_option){
					$return .= '<label style="float:left; white-space: nowrap;"><input type="'.$type.'" name="'.$opt_name.'" value="">'.$clear_option.'</label>';
				}
				foreach($ary as $key=>$val){
					if( in_array($key,$checked) ){
						$checked_str = "CHECKED";
					}else{
						$checked_str = "";
					}
					$text = $val;
					if(is_array($val))
					{
						$text = tryGetArrayValue($array_val_name, $val);
					}
					$return .= '<label style="float:left; white-space: nowrap;"><input type="'.$type.'" name="'.$opt_name.'" value="'.$key.'" '.$checked_str.'>'.$text."</label>";
				}
				break;
			case 'select':
				if (is_null($attr) === false) {
					$return .= '<select name="'.$opt_name.'" '.$attr.'>';
				} else {
					$return .= '<select name="'.$opt_name.'">';
				}
				if($clear_option){
					$return .= '<option value="" >'.$clear_option.'</option>';
				}
				foreach($ary as $key=>$val){
					if( in_array($key,$checked) ){
						$checked_str = "SELECTED";
					}else{
						$checked_str = "";
					}
					$text = $val;
					if(is_array($val))
					{
						$text = tryGetArrayValue($array_val_name, $val);
					}
					$return .= '<option value="'.$key.'" '.$checked_str.'>'.$text.'</option>';
				}
				$return .= '</select>';
		}
		return $return;
	}
}
