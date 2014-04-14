<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class News extends Frontend_Controller {
	
	function __construct() 
	{
		parent::__construct();	
		
		//$this->addNavi("最新消息", fUrl("index"));			
	}

	public function index($page=1)
	{
		$this->setSubTitle("最新消息 News");
		$this->getHtmlPageInfo($data,"news");
	
		$this->display("page_view", $data, "page");	
	
		//$this->display('page_view', $data);	
	}
	
}

