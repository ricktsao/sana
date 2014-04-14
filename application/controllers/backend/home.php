<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends Backend_Controller{

	public function index()
	{
		
		//$this->profiler();	
		//$this->load->helper('path');
		//echo set_realpath('upload');
		//echo site_url('upload').'/';		
		//$this->display("/backend/home/index_view");
		//$this->display("index_view");
		$this->display("index_view");
	}
		
	
	
	function utf16urlencode($str)
	{
	    $str = mb_convert_encoding($str, 'UTF-16', 'UTF-8');
	    $out = '';
	    for ($i = 0; $i < mb_strlen($str, 'UTF-16'); $i++)
	    {
	        $out .= '%u'.bin2hex(mb_substr($str, $i, 1, 'UTF-16'));
	    }
	    return $out;
	}
	
	public function generateTopMenu()
	{		
		//$this->addTopMenu("群組管理 ","");
		//$this->addTopMenu("帳號管理 ","");
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */