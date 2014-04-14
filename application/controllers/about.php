<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class About extends Frontend_Controller {

	function __construct() 
	{
		parent::__construct();
		$this->addNavi("關於協鈦", fUrl("about"));			
	}
	
	public function index()
	{	
		$this->addCss("css/main.css");	
		$this->addCss("css/dir/product.css");	
		$this->setSubTitle("關於協鈦");
		
		$data = array();
		$this->getHtmlPageInfo($data,"aboutus");
		$this->loadBanner($data,"aboutus");
		
		//dprint($data);
		
		
		$this->display("page_view", $data, "page");	
	}
	
}

