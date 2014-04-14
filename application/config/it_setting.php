<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Pager Setting
|--------------------------------------------------------------------------
|
| Set the default pager 
|
*/



$CI	=& get_instance();

$language_value = "zh-tw";

date_default_timezone_set('Asia/Taipei');

if($CI->uri->segment(2) !== FALSE && in_array($CI->uri->segment(2), array("zh-tw","zh-ch","en-global")) )
{
	$language_value = $CI->uri->segment(2);	
}


$config['admin_folder'] = '/backend';

$CI->lang->load('common', $language_value);

$config['pager']['per_page_rows'] = 10; //每頁筆數

$config['enable_box_cache'] = TRUE; //開啟box cache

$config['gender_list'] = array("1" => $CI->lang->line('common_male')
							,"0" => $CI->lang->line('common_female')
							);
							
$config['link_target_list'] = array(  "0" => $CI->lang->line('common_orig_window')
									, "1" => $CI->lang->line('common_orig_window')
									);

$lang['common_orig_window']	= "原視窗";		
$lang['common_orig_window'] = "新視窗";


$config['max_size'] = "200";


// 預設SEO
$config['seo_title'] = 'Sole Fitness';
$config['seo_keywords'] = '專業健身器材';
$config['seo_description'] = '提供您完善的健身選擇';

//前後台路徑
$config['backend_name'] = "backend";
$config['template_backend_path']="template/backend/";
$config['template_frontend_path']="template/frontend/";


//upload image設定
//------------------------------------------------------
$config['image']['upload_tmp_path'] = './upload/tmp';
$config['image']['allowed_types'] = 'gif|jpg|png';
$config['image']['upload_max_size'] = '204800';

//------------------------------------------------------

//郵件設定
//------------------------------------------------------
$config['mail']['host'] = 'localhost'; 
$config['mail']['port'] = '25';
$config['mail']['sender_mail'] = 'service@printwind.com.tw';
$config['mail']['sender_name'] = '風華喜帖';
$config['mail']['charset'] = 'utf-8';
$config['mail']['encoding'] = 'base64';
$config['mail']['is_html'] = TRUE;
$config['mail']['word_wrap'] = 50;//每50自斷行
$config['mail']['word_wrap'] = 50;//每50自斷行

//------------------------------------------------------