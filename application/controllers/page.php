<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Page extends Frontend_Controller {
	
	function __construct() 
	{
		parent::__construct();
		
		$this->addCss("css/dir/forum.css");
		$this->addCss("css/data_table.css");
			
	}

	public function index($page_id = '')
	{	
		
        //$this->addJs("js/string.js");     
		
		$page_list = $this->it_model->listData( "html_page" , "page_id  = '".$page_id."' and ".$this->it_model->eSql('html_page'));
		$data["list"] = $page_list["data"];
		

		if($page_list["count"]>0)
		{
			$data["html_page"] = $page_list["data"][0];
		}
		else 
		{
			header("Location:".frontendUrl());
			exit;
		}		
	
		$this->display('page_view', $data);
	}
	
	
	
	
	
	
	
}

