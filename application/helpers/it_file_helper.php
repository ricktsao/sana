<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 

if ( ! function_exists('file_core_name'))
{
	function file_core_name($file_name)
	{
		$exploded = explode('.', $file_name);
 
		// if no extension
		if (count($exploded) == 1)
		{
			return $file_name;
		}
 
		// remove extension
		array_pop($exploded);
 
		return implode('.', $exploded);
	}
}
 
/* 
  file extension 
  ex: file_extension('toto.jpg') -> 'jpg'
*/
 
if ( ! function_exists('file_extension'))
{
	function file_extension($path)
	{
		$extension = substr(strrchr($path, '.'), 1);
		return $extension;
	}
}
 
/* 
  file size 
  ex: file_size('toto.jpg') -> '3.3 MB'
*/
if ( ! function_exists('file_size'))
{
	function file_size($path)
	{
		$num = filesize($path);
 
		// code from byte_format()
		$CI =& get_instance();
		$CI->lang->load('number');
 
		$decimals = 1;
 
		if ($num >= 1000000000000) 
		{
			$num = round($num / 1099511627776, 1);
			$unit = $CI->lang->line('terabyte_abbr');
		}
		elseif ($num >= 1000000000) 
		{
			$num = round($num / 1073741824, 1);
			$unit = $CI->lang->line('gigabyte_abbr');
		}
		elseif ($num >= 1000000) 
		{
			$num = round($num / 1048576, 1);
			$unit = $CI->lang->line('megabyte_abbr');
		}
		elseif ($num >= 1000) 
		{
			$decimals = 0; // decimals are not meaningful enough at this point
 
			$num = round($num / 1024, 1);
			$unit = $CI->lang->line('kilobyte_abbr');
		}
		else
		{
			$unit = $CI->lang->line('bytes');
			return number_format($num).' '.$unit;
		}
 
		$str = number_format($num, $decimals).' '.$unit;
 
		$str = str_replace(' ', '&nbsp;', $str);
		return $str;
	}
}
 
 	
	
/*
縮圖專用 by Ted
*/
if ( ! function_exists('get_resize_img'))
{
	function get_resize_img($path,$new_width,$new_height,$r=255,$g=255,$b=255,$new_path='',$new_file_name='',$new_ext=''){
		$allow_ext = array('jpg','jpeg','png','gif');
		if( is_array($path) ){
			$filename = explode("/", basename($path["type"]));
			$file_ext = strtolower($filename[count($filename)-1]);
			$path = $path["tmp_name"];
		}else{
			$filename = explode(".", basename($path));
			$file_ext = strtolower($filename[count($filename)-1]);
		}
		if( !is_file($path) && !in_array($file_ext,$allow_ext) ) return false;
		switch($file_ext)
		{
			case "jpg":
			case "jpeg":
				$src_img = imagecreatefromjpeg($path);
				break;
			case "png":
				$src_img = imagecreatefrompng($path);
				break;
			case "gif":
				$src_img = imagecreatefromgif($path);
				break;
		}
		$width=imagesx($src_img);
		$height=imagesy($src_img);
		
		// Build the thumbnail
		if( $new_height && $new_width ){
			$new_ratio = $new_width / $new_height;
			$img_ratio = $width / $height;
			if ($new_ratio > $img_ratio && $height>$new_height ) {
				$img_height = $new_height;
				$img_width = $img_ratio * $new_height;
			} elseif( $new_ratio < $img_ratio && $width>$new_width ) {
				$img_height = $new_width / $img_ratio;
				$img_width = $new_width;
			}else{
				if( $width>$new_width ){
					$img_height = $new_height;
					$img_width = $new_width;
				}else{
					$img_height = $height;
					$img_width = $width;
				}
			}
		}elseif( !$new_height && !$new_width ){
			$new_height = $height;
			$new_width = $width;
			$img_height = $new_height;
			$img_width = $new_width;
		}else{
			if( !$new_height ){
				if( $width>$new_width ){
					$new_height = $height * ($new_width/$width);
				}else{
					$new_height = $height;
				}
			}else{
				if( $height>$new_height ){
					$new_width = $width * ($new_height/$height);
				}else{
					$new_width = $width;
				}
			}
			$img_height = $new_height;
			$img_width = $new_width;
		}
		
		$new_img = ImageCreateTrueColor($new_width, $new_height);
		$bg = imagecolorallocate($new_img, $r, $g, $b);
		imagefilledrectangle($new_img, 0, 0, $new_width-1, $new_height-1, $bg);
		imagecopyresampled($new_img, $src_img, ($new_width-$img_width)/2, ($new_height-$img_height)/2, 0, 0, $img_width, $img_height, $width, $height);
		
		if( !$new_ext ){
			$new_ext = $file_ext;
		}
		if( !$new_file_name ){
			unset($filename[count($filename)-1]);
			$new_file_name = implode(".",$filename);
		}
		$path = explode("/",$path);
		if( !$new_path ){
			unset($path[count($path)-1]);
			$new_path = implode("/",$path);
		}
		$dst = $new_path."/".$new_file_name.".".$new_ext;
		
		switch($new_ext)
		{
			case "jpg":
			case "jpeg":
				imagejpeg($new_img,$dst,80);
				break;
			case "png":
				imagepng($new_img,$dst);
				break;
			case "gif":
				imagegif($new_img,$dst);
				break;
		}
		return true;
	}
}


	/**
	 * 將DB圖片file name 轉成url 路徑
	 */	
	function img_show_list(&$list = array(),$img_name = "img_filename",$folder = "product")
	{
		if(isNotNull($list) && count($list) > 0)
		for($i=0; $i<count($list); $i++)
		{
			$list[$i]["orig_".$img_name] = $list[$i][$img_name];
			$list[$i][$img_name] = isNotNull($list[$i][$img_name])?base_url()."upload/website/".$folder."/".$list[$i][$img_name]:"";
		}
	}
 
	/**
	 * 圖片處理 
	 */
	function deal_content_img(&$arr_data = array(),$img_config = array(), $filename='img_filename',$folder = "product")
	{  
		$del_filename = tryGetData("del_".$filename,$arr_data);
		$new_filename = tryGetData($filename,$arr_data);
		$orig_filename = tryGetData("orig_".$filename,$arr_data);
		
		
		if($del_filename == "1")
		{
			$arr_data[$filename] = NULL;
			unlink(set_realpath("upload/website/".$folder).$orig_filename);
		}
		else if( $del_filename != "1")
		{
			$CI	=& get_instance();
			$CI->load->library('upload',$img_config);		
			
		
			if ( ! $CI->upload->do_upload($filename))
			{	
				//$arr_data["error"] = $CI->upload->display_errors();				
				//$arr_data[$filename] = "";
				//是否需log
			}
			else
			{
				$upload_data = $CI->upload->data();
				
				//dprint($upload_data);
				//exit;
				$arr_data[$filename] =  resize_img($upload_data['full_path'],$img_config['resize_setting']);				
				//$arr_data[$filename] = $upload_data["file_name"];
			}			
		}
	}
 
 
	/**
	 * 圖片處理 
	 */
	function deal_single_img(&$arr_data = array(),$img_config = array(), $edit_data = array(),$filename='img_filename',$folder = "product")
	{  
		$del_filename = tryGetData("del_".$filename,$edit_data);
		$new_filename = tryGetData($filename,$edit_data);
		$orig_filename = tryGetData("orig_".$filename,$edit_data);
		
		
		if($del_filename == "1")
		{
			$arr_data[$filename] = NULL;
			unlink(set_realpath("upload/website/".$folder).$orig_filename);
		}
		else if( $del_filename != "1")
		{
			$CI	=& get_instance();
			$CI->load->library('upload',$img_config);		
			
		
			if ( ! $CI->upload->do_upload($filename))
			{	
				//$arr_data["error"] = $CI->upload->display_errors();				
				//$arr_data[$filename] = "";
				//是否需log
			}
			else
			{
				$upload_data = $CI->upload->data();
				
				//dprint($upload_data);
				//exit;
				$arr_data[$filename] =  resize_img($upload_data['full_path'],$img_config['resize_setting']);				
				//$arr_data[$filename] = $upload_data["file_name"];
			}			
		}
	}
	
	
	function deal_single_img2(&$arr_data = array(),$img_config = array(), $edit_data = array(),$filename='img_filename',$folder = "product")
	{  
		
		$del_filename = tryGetData("del_".$filename,$edit_data);
		$new_filename = tryGetData($filename,$edit_data);
		$orig_filename = tryGetData("orig_img_filename2",$edit_data);
		
		
		if($del_filename == "1")
		{
			$arr_data[$filename] = NULL;
			unlink(set_realpath("upload/website/".$folder).$orig_filename);
		}
		else if( $del_filename != "1")
		{
			$CI	=& get_instance();
			$CI->load->library('upload',$img_config);		
			
		
			if ( ! $CI->upload->do_upload($filename))
			{	
				//$arr_data["error"] = $CI->upload->display_errors();				
				//$arr_data[$filename] = "";
				//是否需log
			}
			else
			{
				$upload_data = $CI->upload->data();
				
				//dprint($upload_data);
				//exit;
				$arr_data["img_filename2"] =  resize_img($upload_data['full_path'],$img_config['resize_setting']);				
				//$arr_data[$filename] = $upload_data["file_name"];
			}			
		}
	}
	
	/**
	 * 圖片處理 
	 */
	function deal_ajax_img(&$arr_data = array(),$img_config = array(),$filename='img_filename')
	{  
	
		$uploadedUrl = './upload/tmp/' . $_FILES['fileUpload2']['name'][$key];
		$arr_data[$filename] =  resize_img($uploadedUrl,$img_config['resize_setting']);		
	}
 
 
	/**
	 * 縮圖
	 20120906 Hans
	 */
	function resize_img($filename,$imgInfo)
	{      	
		
		$dest_filename = date( "YmdHis" )."_".rand( 100000 , 999999 ).".".file_extension($filename);	
		if(is_array($imgInfo)){
			
			foreach($imgInfo as $key => $value){
				
				$dest_file = set_realpath("upload/website/".$key).$dest_filename;
				//move_uploaded_file($filename,$dest_file);
				copy($filename,$dest_file);	
			
				$iw=$value[0];
				$ih=$value[1];			
				//echo $dest_file;	
				//echo $iw;	
				//echo $ih;
				if(is_numeric($iw) && is_numeric($ih) && $iw > 0 && $ih > 0)
				{
					$config['image_library']  = 'gd2';
					$config['source_image']	  = $dest_file;
					$config['create_thumb']   = FALSE;
					$config['maintain_ratio'] = TRUE;
					$config['width']	      = $iw;
					$config['height']	      = $ih;	
					
					
					$CI	=& get_instance();
					$CI->load->library('image_lib');
					$CI->image_lib->initialize($config);
					$CI->image_lib->resize();
					$CI->image_lib->clear();
				}		
			}
		}
		@unlink($filename);		
		return $dest_filename;
	}
 
 
 
 	/**
	 * 圖片處理 
	 */
	function deal_img(&$arr_data = array(),$edit_data = array(),$filename='img_filename',$folder = "product")
	{  
	
		$del_filename = tryGetData("del_".$filename,$edit_data);
		$new_filename = tryGetData($filename,$edit_data);
		$new_filename = str_replace(" ", "%20", $new_filename);//防止檔名有空白處理
		$orig_filename = tryGetData("orig_".$filename,$edit_data);
		
		if($del_filename == "1")
		{
			$arr_data[$filename] = NULL;
			unlink(set_realpath("upload/website/".$folder).$orig_filename);
		}
		else if(isNotNull($new_filename) && strrpos($new_filename, $orig_filename) === FALSE && $del_filename != "1")
		{
			if(isNotNull($orig_filename))
			{
				unlink(set_realpath("upload/website/".$folder).$orig_filename);
			}
			$dest_filename = resize_img($new_filename,"".$folder);	
			$arr_data[$filename] = $dest_filename;
		}	
	}
	
	
	
	/**
	 * 圖片刪除 
	 */
	function del_img($edit_data = array(),$filename='img_filename',$folder = "product")
	{  
		$del_filename = tryGetData("del_".$filename,$edit_data);
		$orig_filename = tryGetData("orig_".$filename,$edit_data);
		$new_filename = tryGetData($filename,$edit_data);
		$new_filename = str_replace(" ", "%20", $new_filename);//防止檔名有空白處理
		
		if($del_filename == "1" && isNotNull($orig_filename))
		{
			@unlink(set_realpath("upload/website/".$folder).$orig_filename);				
		}
		
		if(isNotNull($new_filename) && strrpos($new_filename, $orig_filename) === FALSE)
		{			
			
			@unlink(set_realpath("upload/website/".$folder).$orig_filename);		
		}
	}


/* End of file MY_file_helper.php */
/* Location: ./system/application/helpers/MY_file_helper.php */